<?php 
$host = "localhost"; 
$user = "EmpTrack"; 
$pass = "Navnit@4512"; 
$db   = "EmpTrack"; 

$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

echo "Connected Successfully";
?>
