<?php
// Connect to the database
require '../db_conn.php';



try{
    global $conn;


    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    // Execute the SQL query
    $query = "SELECT * FROM dns_users_2";

    $result = $conn->query($query);

    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    $conn->close();

    // Return the result as JSON
    header('Content-Type: application/json');
    echo json_encode($rows);
} catch(Exception $e) {
    echo 'Error: '. $e->getMessage();
}
?>