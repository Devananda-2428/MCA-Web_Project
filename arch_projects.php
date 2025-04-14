<?php
include 'dbconnect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$architect_id = $_SESSION['user_id'];

// Fetch projects
$query = "SELECT * FROM projects WHERE architect_id = '$architect_id'";
$result = $con->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Projects - Architect Dashboard</title>
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
        <h2 style="color:white;font-size:30px;">My Projects</h2>

        <?php if ($result->num_rows > 0): ?>
            <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                <?php while($project = $result->fetch_assoc()): ?>
                    <div class="project-card" style="background: #fff; border-radius: 10px; padding: 15px; width: 300px; box-shadow: 0 0 10px rgba(0,0,0,0.2);">
                        <img src="<?php echo $project['photo']; ?>" alt="Project Image" style="width:100%; height: 180px; object-fit: cover; border-radius: 8px;">
                        <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                        <p><strong>Category:</strong> <?php echo htmlspecialchars($project['category']); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($project['description']); ?></p>
                        <p><strong>Special Features:</strong> <?php echo htmlspecialchars($project['special_features']); ?></p>

                        <!-- Action Buttons -->
                        <div style="margin-top: 10px;">

                            <a href="delete_project.php?id=<?php echo $project['id']; ?>" onclick="return confirm('Are you sure you want to delete this project?');">
                                <button style="background-color: #dc3545; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">
                                    Delete
                                </button>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p style="color:white;">You haven't added any projects yet.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
