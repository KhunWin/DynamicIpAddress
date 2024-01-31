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
function add_hostname($customer_input)
{
    global $conn;
    // Retrieve the logged-in user's ID from the session
    session_start();
    $user_id = $_SESSION['user_id'];

    $host_name = mysqli_real_escape_string($conn, $customer_input['host_name']);
    $ipaddr = mysqli_real_escape_string($conn, $customer_input['ipaddr']);
    

    if (empty(trim($host_name))) {
        return error422('Enter your hostname');
    } elseif (empty(trim($ipaddr))) {
        return error422('Enter your ipaddress');
    }else {
        $query = "INSERT INTO dns_users_2 (host_name, ipaddr,user_id) VALUES ('$host_name', '$ipaddr',$user_id)";
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

