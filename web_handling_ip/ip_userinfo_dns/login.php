<?php

session_start();
require '../db_conn.php';

$uname = $_POST['uname'];
$pass = $_POST['password'];


     // echo "Valid input";
     $sql = "SELECT * FROM users_2 WHERE users_2.user_name='$uname' AND users_2.password='$pass'";
     $result = mysqli_query($conn, $sql);
     if($row = mysqli_fetch_assoc($result)){
            // session_start();
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['name'] = $row['name'];
             $_SESSION['id'] = $row['id'];
            $_SESSION['user_id'] = $row['id']; 
            header("Location: home.php");
            exit();

     }
     else{
         header("Location: index.php?error=" . urlencode("Incorrect User name or password") . "&sql=" . urlencode($sql));
         exit();
     }

