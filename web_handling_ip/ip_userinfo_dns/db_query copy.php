<?php
// Connect to the database
require '../db_conn.php';

// $host = 'localhost';
// $user = 'root';
// $password = '123456';
// $database = 'test_db_hosted';

try{
    global $conn;
    // $mysqli = new mysqli($host, $user, $password, $database);

    // Check connection
    // if ($mysqli->connect_error) {
    //     die("Connection failed: " . $mysqli->connect_error);
    // }

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Execute the SQL query
    $query = "SELECT * FROM dns_users";
    // $result = $mysqli->query($query);
    $result = $conn->query($query);

    // Fetch all rows from the query result
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    // Close the database connection
    // $mysqli->close();
    $conn->close();

    // Return the result as JSON
    header('Content-Type: application/json');
    echo json_encode($rows);
} catch(Exception $e) {
    echo 'Error: '. $e->getMessage();
}
?>