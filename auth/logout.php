<?php 
ob_start();
require '../Model/Database.php';
require '../Controller/Users.php';

$user = new Users();
$user->Logout();
header('location: login');