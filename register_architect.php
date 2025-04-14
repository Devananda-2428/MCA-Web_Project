<?php
// Include database connection
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $district = trim($_POST['district']); // Retrieve the district value
    $qualification= trim($_POST['qualification']);
    $specialization= trim($_POST['specialization']);
    $experience= trim($_POST['experience']);


    // Validate required fields
    if (empty($name) || empty($phone) || empty($email) || empty($password) || empty($confirm_password) || empty($district) || empty($qualification) || empty($specialization) || empty($experience)){
        echo "<script>alert('All fields are required!');</script>";
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

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo = $_FILES['photo'];
        $upload_dir = 'architect/photos/'; // Your desired directory to upload the photo
        $photo_name = basename($photo['name']);
        $photo_path = $upload_dir . $photo_name;

        // Check if the file is an image
        if (getimagesize($photo['tmp_name']) !== false) {
            // Move the uploaded file to the desired location
            if (move_uploaded_file($photo['tmp_name'], $photo_path)) {
                // File upload successful
                $photo_path = $photo_path; // Save the photo path
            } else {
                echo "<script>alert('Failed to upload the photo.');</script>";
                exit;
            }
        } else {
            echo "<script>alert('Please upload a valid image file.');</script>";
            exit;
        }
    } else {
        // If no file is uploaded, you can set a default or handle accordingly
        $photo_path = ''; // Empty or default photo path
    }

    // Insert into database
    $sql = "INSERT INTO architects (name, phone, email, password, photo, location, experience, qualification, specialization ) VALUES ('$name', '$phone', '$email', '$password', '$photo_path', '$district', '$experience', '$qualification', '$specialization')";

    if ($con->query($sql) === TRUE) {
        echo "<script>alert('Registration successful! You can now login.'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Error: " . $con->error . "');</script>";
    }

    // Close connection
    $con->close();
}
?>
