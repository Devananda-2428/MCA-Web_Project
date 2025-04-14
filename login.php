<?php
// Start session
session_start();

// Include database connection
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate required fields
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill in all fields!'); window.history.back();</script>";
        exit;
    }
    if (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters long!'); window.history.back();</script>";
        exit;
    }

    // Function to check login in a given table
    function checkLogin($con, $table, $email, $password) {
        $sql = "SELECT id, name, password FROM $table WHERE email = '$email'";
        $result = $con->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if ($password === $row['password']) {
                return $row;
            }
        }
        return null;
    }

    // Check login in each table
    $user = checkLogin($con, "users", $email, $password);
    $architect = checkLogin($con, "architects", $email, $password);

    if ($admin) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['name'] = $admin['name'];
        $_SESSION['role'] = 'admin';
        header("Location: admin_dashboard.php");
        exit();
    } elseif ($architect) {
        $_SESSION['user_id'] = $architect['id'];
        $_SESSION['name'] = $architect['name'];
        $_SESSION['role'] = 'architect';
        header("Location: a_dashboard.php");
        exit();
    } elseif ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = 'user';
        header("Location: userpage.php");
        exit();
    } else {
        echo "<script>alert('Invalid email or password!'); window.history.back();</script>";
    }

    // Close connection
    $con->close();
}
?>
