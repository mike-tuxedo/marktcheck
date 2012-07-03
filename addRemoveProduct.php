<?php

include 'header.php';

$articleName = $_GET['product'];
$action = $_GET['action'];

if($_SESSION[ 'USER' ])
{
    $user = $_SESSION[ 'USER' ];
    //take all the products in the basket from a specific user
    $stmt = $connect -> prepare("SELECT product FROM fhs_baskets WHERE usernme = ?");
    $stmt -> bind_param('s', $user);
    $stmt -> execute();
    $stmt -> bind_result($products);
    $stmt -> fetch();
    $stmt -> close();

    //convert result to an array of products and add the current product
    $productArray = unserialize($products);
    if($action == add)
        array_push($productArray, $articleName);
    else
        unset($productArray[array_search($articleName, $productArray)]);

    $productString = serialize($productArray);
    
    //update db with new productlist
    $stmt2 = $connect->stmt_init();
    $stmt2 -> prepare("UPDATE fhs_baskets SET product = ? WHERE usernme = ? ");
    $stmt2 -> bind_param('ss', $productString, $user);
    $stmt2 -> execute();
    $stmt2 -> close();
}

header("Location:shoppingList.php");

?>
