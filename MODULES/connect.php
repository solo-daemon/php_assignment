<?php
session_start();
$servername="localhost";
$username="phpdb";
$password="test1234";
$database="review_assignment";
$conn= new mysqli($servername,$username,$password,$database);
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
    session_destroy();
}
?> 