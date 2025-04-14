<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'dbconnect.php';

// Fetch architects with average rating
$sql = "SELECT a.id, a.name, a.location, a.status, a.photo, 
               ROUND(AVG(r.rating), 1) AS avg_rating
        FROM architects a
        LEFT JOIN ratings r ON a.id = r.architect_id
        GROUP BY a.id, a.name, a.location, a.status, a.photo";

$result = $con->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - User Dashboard</title>
    <link rel="stylesheet" href="user/user-dashboard.css">
</head>
<body style="background-image: url('homepage/assets/user.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; font-family: sans-serif;">



<div class="top-bar">
    <div class="welcome-msg">
        Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!
    </div>
    <div class="button-group">
        <a href="search.php" class="header-btn">🔍 Search</a>
        <a href="myproject.php" class="header-btn">📁 My Projects</a>
        <a href="logout.php" class="header-btn">🚪 Logout</a>
    </div>
</div>




<div class="architect-list">
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="card">
            <img src="<?php echo $row['photo']; ?>" alt="Architect Photo">
            <h3><?php echo $row['name']; ?></h3>
            <p>📍 <?php echo $row['location']; ?></p>
            <p>⭐ Rating: <?php echo $row['avg_rating'] ?? 'Not Rated'; ?></p>
            <p>Status: <?php echo $row['status']; ?></p>
            <a href="view_architect.php?id=<?php echo $row['id']; ?>"><button>View Profile</button></a>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
