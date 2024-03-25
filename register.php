<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname = $_POST['yourname'];
    $mobileno = $_POST['mobile-number'];
    // Perform basic validation (you might want to add more robust validation)
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $dbname = "urja";
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

// Function to validate username
function validateUsername($username) {
    // Check if username is empty
    if(empty($username)) {
        throw new Exception( "Username is required.");
    }
    
    // Check if username length is between 3 and 20 characters
    if(strlen($username) < 3 || strlen($username) > 20) {
        throw new Exception( "Username must be between 3 and 20 characters.");
    }
    
    // Check if username contains only alphanumeric characters and underscores
    if(!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        throw new Exception("Username can only contain letters, numbers, and underscores.");
    }
    return true;
}

// Function to validate full name
function validateFullName($fullName) {
    // Check if full name is empty
    if(empty($fullName)) {
        throw new Exception("Full name is required.");
    }
    
    // Check if full name contains only letters and spaces
    if(!preg_match('/^[a-zA-Z ]+$/', $fullName)) {
        throw new Exception( "Full name can only contain letters and spaces.");
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

// Function to validate mobile number
function validateMobileNumber($mobileNumber) {
    if(empty($mobileNumber)) {
        throw new Exception( "Mobile number is required.");
    }
    if(!preg_match('/^[0-9]{10}$/', $mobileNumber)) {
        throw new Exception("Mobile number must be exactly 10 digits long and contain only numbers.");
    }
    return true;
}

try {
    if(validateFullName($fullname) && validateMobileNumber($mobileno) && validatePassword($password) && validateUsername($username) == true)
    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO users (fullname, username, password, mobileno) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $fullname, $username, $password, $mobileno);
    if ($stmt->execute() === TRUE) {
        echo "User registered successfully!";
        header("Location: register.html");
    } else {
        echo "Error: " . $conn->error;
    }
    // Close connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Registration failed, handle the exception
    echo "Registration failed: " . $e->getMessage();
}

?>
