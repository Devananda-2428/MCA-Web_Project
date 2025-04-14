<?php
session_start();
include 'dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $connection_id = $_POST['connection_id'];
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];

    // Get architect_id for this connection
    $sql = "SELECT architect_id FROM connections WHERE id = $connection_id AND user_id = $user_id";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($con)); // Improved error handling for the query
    }

    if ($row = mysqli_fetch_assoc($result)) {
        $architect_id = $row['architect_id'];

        // Check if the user has already submitted feedback for this architect
        $check_sql = "SELECT * FROM ratings WHERE architect_id = $architect_id AND user_id = $user_id";
        $check_result = mysqli_query($con, $check_sql);

        if (!$check_result) {
            die("Query failed: " . mysqli_error($con)); // Handle failure of the check query
        }

        if (mysqli_num_rows($check_result) > 0) {
            // Display alert if feedback already exists
            echo "<script>alert('You have already submitted feedback for this architect.'); window.location.href='your_redirect_page.php';</script>";
        } else {
            // Insert the rating and feedback into the rating table
            $insert_sql = "INSERT INTO ratings (architect_id, user_id, rating, feedback) 
                           VALUES ($architect_id, $user_id, $rating, '$feedback')";
            
            if (mysqli_query($con, $insert_sql)) {
                // Display success message as alert
                echo "<script>alert('Your feedback and rating have been submitted successfully.'); window.location.href='userpage.php';</script>";
            } else {
                // Display error message as alert
                echo "<script>alert('Error submitting feedback and rating: " . mysqli_error($con) . "'); window.location.href='userpage.php';</script>";
            }
        }
    } else {
        // Display error message for invalid project connection
        echo "<script>alert('Invalid project connection.'); window.location.href='your_redirect_page.php';</script>";
    }
}
?>
