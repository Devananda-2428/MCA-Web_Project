<?php
include 'dbconnect.php';
session_start();
$architect_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $special_features = $_POST['special_features'];

    $photo_path = "arch-dashboard/projects/" . basename($_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);

    $sql = "INSERT INTO projects (architect_id, title, description, category, special_features, photo) 
            VALUES ('$architect_id', '$title', '$description', '$category', '$special_features', '$photo_path')";
    
    if ($con->query($sql)) {
        // Redirect to clear POST data and avoid duplicate submissions
        header("Location: projects.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects - Architect Dashboard</title>
    <link rel="stylesheet" href="arch-dashboard/style.css">
</head>
<body style="background-image: url('homepage/assets/archimg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; font-family: sans-serif;">


<div class="dashboard-container">
    <!-- Sidebar -->
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
    <h2 style="color:white;font-size:30px;">Add New Projects</h2>
        <div class="profile-card" style="width: 550px; margin-top: 20px;">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Project Title" required>
            <textarea name="description" placeholder="Project Description" required></textarea>

            <label for="category">Category</label>
            <select name="category" required>
                <option value="">-- Select Category --</option>
                <option value="Residential">Residential</option>
                <option value="Landscape Designs">Landscape Designs</option>
                <option value="Home Extension">Home Extension</option>
                <option value="Interior">Interior</option>
            </select>

            <label for="special_features">Special Features</label>
            <input type="text" name="special_features" placeholder="e.g. Eco-friendly design, Smart lighting">

            <label for="photo">Upload Project Image</label>
            <input type="file" name="photo" required>

            <button type="submit">Add Project</button>
        </form>
    </div>
</div>
</div>

</body>
</html>
