<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Database connection
    $conn = mysqli_connect('localhost', 'root', '', 'urja') or die("Connection failed: " . mysqli_connect_error());
    
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $description = mysqli_real_escape_string($conn, $_POST['feedback']);

    // SQL query to insert data into database
    $sql = "INSERT INTO feedback (name, email, description) VALUES ('$name', '$email', '$description')";
    
    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Feedback submitted successfully!")</script>';
    } else {
        echo '<script>alert("Error occurred! Please try again.")</script>';
    }

    // Close database connection
    mysqli_close($conn);
}
?>
