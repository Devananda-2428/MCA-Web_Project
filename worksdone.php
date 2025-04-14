<?php
session_start();
include 'dbconnect.php';

if (!isset($_GET['architect_id'])) {
    header("Location: userpage.php");
    exit;
}

$architect_id = $_GET['architect_id'];

$sql = "SELECT * FROM projects WHERE architect_id = $architect_id";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Projects by Architect</title>
    <link rel="stylesheet" href="user/user-dashboard.css">
    <style>
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 40px;
        }

        .project-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 20px 40px;
        }

        .project-card {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            width: 280px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }

        .project-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
        }

        .project-card h3 {
            margin: 10px 0 5px;
        }

        .project-card p {
            font-size: 14px;
            margin: 4px 0;
        }

        .back-btn {
            background: #4CAF50;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .back-btn:hover {
            background: #388E3C;
            transform: translateX(-3px) scale(1.05);
        }
    </style>
</head>
<body style="background-image: url('homepage/assets/user.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; font-family: sans-serif;">


<div class="top-bar">
    <h2>Projects by Architect</h2>
    <a href="javascript:history.back()" class="back-btn">← Back</a>
</div>

<div class="project-list">
    <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="project-card">
            <img src="<?php echo $row['photo']; ?>" alt="Project Image">
            <h3><?php echo $row['title']; ?></h3>
            <p><strong>Category:</strong> <?php echo $row['category']; ?></p>
            <p><strong>Special Features:</strong> <?php echo $row['special_features']; ?></p>
            <p><?php echo $row['description']; ?></p>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
