<?php
include 'dbconnect.php';
session_start();
$architect_id = $_SESSION['user_id'];

$query = "SELECT * FROM architects WHERE id = '$architect_id'";
$result = $con->query($query);
$architect = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $qualification = $_POST['qualification'];
    $specialization = $_POST['specialization'];
    $experience = $_POST['experience'];

    $update = "UPDATE architects SET 
        name = '$name',
        email = '$email',
        phone = '$phone',
        location = '$location',
        qualification = '$qualification',
        specialization = '$specialization',
        experience = '$experience'
        WHERE id = '$architect_id'";

    if ($con->query($update)) {
        echo "<script>alert('Profile updated successfully'); window.location='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <link rel="stylesheet" href="arch-dashboard/style.css">
</head>
<body style="background-image: url('homepage/assets/archimg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; font-family: sans-serif;">

<div class="dashboard-container">
    <div class="sidebar">
        <h2>Architect Dashboard</h2>
        <a href="a_dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="projects.php">New-Projects</a>
        <a href="messages.php">Feedback</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <h2 style="color:white; font-size: 30px;">Update Your Profile</h2>

        <div class="profile-card" style="width: 600px; margin-top: 20px;">
            <form method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                Full Name:<input type="text" name="name" value="<?php echo $architect['name']; ?>" placeholder="Name" required>
                Email:<input type="email" name="email" value="<?php echo $architect['email']; ?>" placeholder="Email" required>
                Phone:<input type="text" name="phone" value="<?php echo $architect['phone']; ?>" placeholder="Phone" required>
                Location:<input type="text" name="location" value="<?php echo $architect['location']; ?>" placeholder="District" required>
                Qualification:<input type="text" name="qualification" value="<?php echo $architect['qualification']; ?>" placeholder="Qualification" required>
                Specialization:<input type="text" name="specialization" value="<?php echo $architect['specialization']; ?>" placeholder="Specialization" required>
                Experience:<input type="number" name="experience" value="<?php echo $architect['experience']; ?>" placeholder="Years of Experience" required>
                
                <button type="submit" class="update-btn">Update Profile</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
