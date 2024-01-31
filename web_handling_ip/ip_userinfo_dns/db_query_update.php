<?php
require '../db_conn.php';

try {
    global $conn;
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    // $selectedData = "mynameis";
    // $newIpAddress = "192.142.156.09";
 
    $selectedData = $_POST['selected_data'];
    $newIpAddress = $_POST['new_ip_address'];

   
    $update_query = "UPDATE dns_users_2 SET ipaddr = '$newIpAddress' WHERE host_name ='$selectedData' ";
   
    // Debugging statement to check the update query
    echo "Update Query: " . $update_query . "<br>";

    $update_result = $conn->query($update_query);

    if ($update_result) {
        echo "Number of Rows Updated: " . $conn->affected_rows . "<br>";

        echo "DNS updated successfully.";
        echo "New IP address: " . $newIpAddress;
    } else {
        echo "Failed to update DNS.";
    }

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    echo "Error occurred while updating DNS: " . $e->getMessage();
}
?>
