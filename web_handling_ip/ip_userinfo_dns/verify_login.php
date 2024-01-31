<!-- not working.. -->
<?php
// Connect to the database
// require '../db_conn.php';
$sname="localhost";
$uname = "root";
$password= "123456";
$db_name = "test_db_hosted";

try{
    $conn = mysqli_connect("$sname", "$uname", "$password", "$db_name");
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    $inputUsername = $_POST['userone'];
    $inputPassword = $_POST['123'];

    // Prepare and execute SQL query to get the hashed password of the inputUsername
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_name = ?");
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();

    if ($hashedPassword === null) {
        // User not found in the database
        echo "Invalid login credentials";
    } else {
    // Verify input password
    if (password_verify($inputPassword, $hashedPassword)) {
        // Input data matches, do something
        echo "Login successful";
    } else {
        // Input data does not match, do something else
        echo "Invalid password";
    }
}

    // Close statement and connection
    $stmt->close();
    $conn->close();

} catch(Exception $e) {
    echo 'Error: '. $e->getMessage();
}
?>