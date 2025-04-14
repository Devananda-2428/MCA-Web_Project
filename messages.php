<?php
session_start();
include 'dbconnect.php';

// Check if the architect is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$architect_id = $_SESSION['user_id'];

// Fetch feedbacks for the architect
$sql = "SELECT r.*, u.name AS user_name 
        FROM ratings r 
        JOIN users u ON r.user_id = u.id 
        WHERE r.architect_id = $architect_id";

$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con)); // Improved error handling for the query
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Architect - View Feedbacks</title>
    <link rel="stylesheet" href="architect/architect-dashboard.css">
    <style>
        .feedback-container {
            margin: 30px 40px;
        }

        .feedback-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .feedback-card h3 {
            margin-top: 0;
            font-size: 1.5em;
        }

        .feedback-card p {
            margin: 10px 0;
        }

        .rating {
            font-weight: bold;
            color: #f39c12;
        }

        .back-btn {
            display: inline-block;
            margin: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            text-decoration: none;
            border-radius: 25px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            transition: 0.3s ease;
        }

        .back-btn:hover {
            background-color: #388E3C;
            transform: scale(1.05);
        }
    </style>
</head>
<body style="background-image: url('homepage/assets/archimg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; font-family: sans-serif;">
    <a href="a_dashboard.php" class="back-btn">← Back to Dashboard</a>
    
    <div class="feedback-container">
        <h2 style="color:white">User Feedbacks</h2>

        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="feedback-card">
                <h3>Feedback from: <?php echo $row['user_name']; ?></h3>
                <p class="rating">Rating: <?php echo $row['rating']; ?> / 5</p>
                <p><strong>Feedback:</strong> <?php echo nl2br($row['feedback']); ?></p>
            </div>
        <?php endwhile; ?>

        <?php if (mysqli_num_rows($result) == 0): ?>
            <p>No feedback received yet.</p>
        <?php endif; ?>
    </div>

</body>
</html>
