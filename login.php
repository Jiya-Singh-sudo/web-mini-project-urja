<?php
session_start();
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'urja';
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$secure_pass = password_hash($password, PASSWORD_BCRYPT);
$username = validateUsername($_POST["username"]);
$secure_pass = validatePassword($_POST["password"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$secure_pass'";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Check if any matching records found
        if ($result->num_rows > 0) {
            // Authentication successful
            $_SESSION['username'] = $username;
            header("Location: home.html");
        }
        // Close connection
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        // Registration failed, handle the exception
        echo "Registration failed: " . $e->getMessage();
    }
}

// Close the database connection
$conn->close();


function validateUsername($username) {
    if(empty($username)) {
        throw new Exception( "Username is required.");
    }
    // Check if username length is between 3 and 20 characters
    if(strlen($username) < 3 || strlen($username) > 20) {
        throw new Exception( "Username must be between 3 and 20 characters.");
    }
    if(!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        throw new Exception( "Username can only contain letters, numbers, and underscores.");
    }
        return true;
}

// Function to validate password
function validatePassword($password) {
    if(empty($password)) {
        throw new Exception( "Password is required.");
    }    
    if(strlen($password) < 6) {
        throw new Exception( "Password must be at least 6 characters long.");
    }
        return true;
}



?>
