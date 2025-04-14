<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'dbconnect.php';

$location = '';
$category = '';
$architects = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $category = mysqli_real_escape_string($con, $_POST['category']);

    $whereClauses = [];

    if (!empty($location)) {
        $whereClauses[] = "a.location LIKE '%$location%'";
    }

    if (!empty($category)) {
        $whereClauses[] = "p.category LIKE '%$category%'";
    }

    $whereSql = "";
    if (!empty($whereClauses)) {
        $whereSql = "WHERE " . implode(" AND ", $whereClauses);
    }

    $sql = "SELECT DISTINCT a.id, a.name, a.location, a.status, a.photo,
                   ROUND(AVG(r.rating), 1) AS avg_rating
            FROM architects a
            LEFT JOIN ratings r ON a.id = r.architect_id
            LEFT JOIN projects p ON a.id = p.architect_id
            $whereSql
            GROUP BY a.id";

    $architects = mysqli_query($con, $sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Architects</title>
    <link rel="stylesheet" href="user/user-dashboard.css">
</head>
<body style="background-image: url('homepage/assets/user.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; font-family: sans-serif;">


<div class="top-bar">
    <div class="welcome-msg">Search Architects</div>
    <div class="button-group">
        <a href="userpage.php" class="header-btn">🏠 Home</a>
        <a href="logout.php" class="header-btn">🚪 Logout</a>
    </div>
</div>

<div style="padding: 0 40px 40px;">
<form method="POST" action="search.php" style="margin-bottom: 30px; display: flex; gap: 20px; flex-wrap: wrap;">
    <select name="location" style="padding: 10px; border-radius: 8px; border: 1px solid #ccc; flex: 1;">
    <option value="">Select Location</option>
    <option value="Kochi" <?php if ($location == 'Kochi') echo 'selected'; ?>>Kochi</option>
    <option value="Mumbai" <?php if ($location == 'Mumbai') echo 'selected'; ?>>Mumbai</option>
    <option value="Chennai" <?php if ($location == 'Chennai') echo 'selected'; ?>>Chennai</option>
    <option value="Calicut" <?php if ($location == 'Calicut') echo 'selected'; ?>>Calicut</option>
    </select>


    <select name="category" style="padding: 10px; border-radius: 8px; border: 1px solid #ccc; flex: 1;">
        <option value="">-- Select Category --</option>
        <option value="Residential" <?php if($category == 'Residential') echo 'selected'; ?>>Residential</option>
        <option value="Landscape Designs" <?php if($category == 'Landscape Designs') echo 'selected'; ?>>Landscape Designs</option>
        <option value="Home Extensions" <?php if($category == 'Home Extensions') echo 'selected'; ?>>Home Extensions</option>
        <option value="Interior" <?php if($category == 'Interior') echo 'selected'; ?>>Interior</option>
    </select>

    <button type="submit" class="btn">🔍 Search</button>
</form>


    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <?php if ($architects->num_rows > 0): ?>
            <div class="architect-list">
                <?php while($row = $architects->fetch_assoc()): ?>
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
        <?php else: ?>
            <p style="color:white;font-size:30px">No architects found matching your criteria.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>