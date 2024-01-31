<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('function_file_dnsuser.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "POST") {  

    $input_data = json_decode(file_get_contents("php://input"), true);
    if (empty($input_data)) {
        $update_file = add_hostname($_POST);
    } else {
        $update_file = add_hostname($input_data);
    }
    
    if ($update_file === "success") {
        header("Location: login.php");
        exit; // Stop further execution of the script
    }
    // echo $update_file;
} 
else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}

?>