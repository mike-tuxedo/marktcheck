<?php

include 'header.php';

$name = $_POST['nickname'];
$email = $_POST['email'];
$password = $_POST['password'];

$nameFieldLength = strlen($name);
$passwordLength = strlen($password);
$nameRegEx = '/^[a-zA-Z0-9.üäöß._-]*$/';
$emailRegEx = '/^[a-zA-Z0-9.ü._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';

//check RegEx rules
if(!preg_match($nameRegEx, $name) || !preg_match($emailRegEx, $email) || $nameFieldLength < 3 || $passwordLength < 3)
    header("Location: settingsSignup.php?regisError=wrongValues");
else
{
    //check if username or email already exists
    $sql = "SELECT COUNT(*)
            FROM fhs_members
            WHERE nme LIKE ? || email LIKE ?";

    $stmt = $connect -> prepare($sql);
    $stmt -> bind_param('ss', $name, $email);
    $stmt -> execute();
    $stmt -> bind_result($locatedUsers);
    $stmt -> fetch();
    $stmt -> close();

    if($locatedUsers > 0)
        header("Location: settingsSignup.php?regisError=alreadyInUse");
    else
    {
        $write = $connect->prepare("INSERT INTO fhs_members (nme, email, pw) VALUES (?,?,?)");
        $write -> bind_param('sss', $name, $email, $password);
        $write -> execute();
        header("Location: index.php");
    }
}

?>
