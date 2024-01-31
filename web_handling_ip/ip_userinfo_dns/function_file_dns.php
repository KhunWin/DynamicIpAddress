<?php

require '../db_conn.php';


function error422($message)
{
    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}
function add_user_2($customer_input)
{
    global $conn;

    $name = mysqli_real_escape_string($conn, $customer_input['name']);
    $user_name = mysqli_real_escape_string($conn, $customer_input['user_name']);
    $password = mysqli_real_escape_string($conn, $customer_input['password']);
    


    if (empty(trim($user_name))) {
        return error422('Enter your name');
    } elseif (empty(trim($password))) {
        return error422('Enter your password');
    } elseif(empty(trim($name))){
    }else {
        $query = "INSERT INTO users_2 (name, user_name,password) VALUES ('$name', '$user_name','$password')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $data = [
                'status' => 201,
                'message' => 'File created successfully',
            ];
            // header("HTTP/1.0 201 Created");
            // echo json_encode($data);
            echo "You may go back to login page and login now.";
            header("Location: after_signup.php");
            exit();
                        
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode($data);
        }
    }
}

