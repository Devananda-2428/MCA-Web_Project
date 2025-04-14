<?php
// Include database connection
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate required fields
    if (empty($name) || empty($phone) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "<script>alert('All fields are required!');</script>";
        exit;
    }

    // Validate phone number (must be exactly 10 digits)
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        echo "<script>alert('Invalid phone number! It must be exactly 10 digits.');</script>";
        exit;
    }

    // Validate password length
    if (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters long!');</script>";
        exit;
    }

    // Validate passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
        exit;
    }

    // Insert into database
    $sql = "INSERT INTO users (name, phone, email, password) VALUES ('$name', '$phone', '$email', '$password')";
    
    if ($con->query($sql) === TRUE) {
        echo "<script>alert('Registration successful! You can now login.'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Error: " . $con->error . "');</script>";
    }

    $con->close();
}
?>
