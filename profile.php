<?php
include 'dbconnect.php';
session_start();
$architect_id = $_SESSION['user_id'];

$query = "SELECT * FROM architects WHERE id = '$architect_id'";
$result = $con->query($query);
$architect = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Architect Dashboard</title>
    <link rel="stylesheet" href="arch-dashboard/style.css">
</head>
<body style="background-image: url('homepage/assets/archimg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; font-family: sans-serif;">

<div class="dashboard-container">
<div class="sidebar">
    <h2>Architect Dashboard</h2>
    <a href="a_dashboard.php">Dashboard</a> 
    <a href="profile.php">Profile</a>
    <a href="arch_projects.php">My Projects</a>
    <a href="projects.php">New-Projects</a>
    <a href="messages.php">Feedback</a>
    <a href="logout.php">Logout</a>
</div>


    
    <div class="content">
    <h2 style="color:white;font-size:30px;">Your Profile</h2>

    <div class="profile-card" style="width:500px">
        <img src="<?php echo $architect['photo']; ?>" alt="Profile Picture" class="profile-img">

        <div class="profile-info">
            <p><strong>Name:</strong> <?php echo $architect['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $architect['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $architect['phone']; ?></p>
            <p><strong>District:</strong> <?php echo $architect['location']; ?></p>
            <p><strong>Qualification:</strong> <?php echo $architect['qualification']; ?></p>
            <p><strong>Specialization:</strong> <?php echo $architect['specialization']; ?></p>
            <p><strong>Years Of Experience:</strong> <?php echo $architect['experience']; ?></p>
        </div>

        <a href="update_profile.php" class="update-btn">Update Profile</a>
    </div>
</div>


</body>
</html>
