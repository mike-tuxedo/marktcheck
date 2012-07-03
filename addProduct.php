<?php
include 'header.php';

$articleName = $_GET['product'];

if($_SESSION[ 'USER' ])
{
    $user = $_SESSION[ 'USER' ];
    //select the products in the basket
    $stmt = $connect -> prepare("SELECT product FROM fhs_baskets fb WHERE fb.usernme = ?");
    $stmt -> bind_param('s', $user);
    $stmt -> execute();
    $stmt -> bind_result($products);
    $stmt -> fetch();
    $stmt -> close();

    //convert result to an array of products and add the current product
    $productArray = unserialize($products);
    array_push($productArray, $articleName);
    $productString = serialize($productArray);

    //update db with new productlist
    $stmt2 = $connect->stmt_init();

    $stmt2 -> prepare("UPDATE fhs_baskets SET product = ? WHERE usernme = ? ");
    $stmt2 -> bind_param('ss', $productString, $user);
    $stmt2 -> execute();

    $stmt2 -> close();
}
header("Location: shoppingList.php");
?>
