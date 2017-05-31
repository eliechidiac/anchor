<?php
$user = 'root'; //mySQL server username
$pass = 'root';  //mySQL server password
$connection = new PDO('mysql:host=localhost;dbname=anchor;charset=utf8', $user, $pass); //Create a new PDO connection the database
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>