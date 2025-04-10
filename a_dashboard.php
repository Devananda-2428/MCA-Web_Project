<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Architect Dashboard - ArchiSphere</title>
    <link rel="stylesheet" href="arch-dashboard/style.css">
</head>
<body style="background-image: url('homepage/assets/archimg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; font-family: sans-serif;">

<div class="sidebar">
    <h2>Architect Dashboard</h2>
    <a href="a_dashboard.php">Dashboard</a> 
    <a href="profile.php">Profile</a>
    <a href="arch_projects.php">My Projects</a>
    <a href="projects.php">New-Projects</a>
    <a href="messages.php">Feedback</a>
    <a href="logout.php">Logout</a>
</div>

    <!-- Content Area -->
    <!-- Content Area -->
<!-- Content Area -->
<div class="content1" style="max-width: 1200px; margin: auto; margin-left: 240px; padding: 40px;">

    <h2 style="color:white;font-size:30px;">Welcome to your dashboard, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
    <p style="color:white">Select an option from the sidebar to manage your profile, projects, and communication.</p>

    <!-- Dashboard Connection Containers -->
    <div style="display: flex; gap: 20px; margin-top: 30px;">
        <!-- Current Connections -->
        <div style="flex: 1; padding: 20px; background: #f4f4f4; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h3>Current Work</h3>
            <a href="current_connections.php">
                <button style="margin-top: 10px; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    View
                </button>
            </a>
        </div>

        <!-- New Connection Requests -->
        <div style="flex: 1; padding: 20px; background: #f4f4f4; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h3>New Connection Requests</h3>
            <a href="requests.php">
                <button style="margin-top: 10px; padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    View
                </button>
            </a>
        </div>
    </div>
</div>



</div>

</body>
</html>
