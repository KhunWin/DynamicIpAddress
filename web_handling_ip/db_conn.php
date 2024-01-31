<?php 

$sname="localhost";
$uname = "root";
$password= "123456";
$db_name = "test_db_hosted";

try {

$db_name = "test_db_hosted";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn){
    throw new Exception('Connection failed: ' . mysqli_connect_error());
}


} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

