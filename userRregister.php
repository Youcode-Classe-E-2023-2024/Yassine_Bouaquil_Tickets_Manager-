<?php

include_once 'database.php';
include_once 'user.php';
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];

$user = new User($conn);
$user->register($nom, $prenom, $username, $email, $password);
header('location: login.php'); 
?>