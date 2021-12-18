<?php
$host = "127.0.0.1";
$username = "root";
$password = "doeraso387";
$database = "sttb";

try {
    $conn = new PDO("mysql:host=$host;dbname=$database",$username,$password);
}
catch (PDOException $ex) {
    die($ex->getMessage());
}
?>