<?php

include_once 'database.php';
include_once 'user.php';
$username = $_POST["username"];
$password = $_POST["password"];

$user = new User($conn);
$user->login($username, $password);

header("location: indexuser.php");
?>