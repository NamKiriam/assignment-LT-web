<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'foodiness_db';

$connection = new mysqli($host, $user, $password, $database);

if($connection->connect_error)
{
    die('Connection failed: ' .$connection->connect_error);
}
?>