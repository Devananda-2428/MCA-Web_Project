<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'dbconnect.php';
$user_id = $_SESSION['user_id'];

// Fetch connection details with architect info
$sql = "SELECT c.*, a.name AS architect_name 
        FROM connections c 
        JOIN architects a ON c.architect_id = a.id 
        WHERE c.user_id = $user_id";

$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Projects</title>
    <link rel="stylesheet" href="user/user-dashboard.css">
    <style>
        .project-container {
            margin: 30px 40px;
        }

        .project-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .project-card h3 {
            margin-top: 0;
        }

        .status {
            font-weight: bold;
            color: #555;
        }

        .feedback-form textarea,
        .rating-form input {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            resize: none;
        }

        .feedback-form button,
        .rating-form button {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .feedback-form button:hover,
        .rating-form button:hover {
            background: #388E3C;
        }

        .rating input {
            margin: 0 5px;
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
<body style="background-image: url('homepage/assets/user.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; font-family: sans-serif;">

<a href="userpage.php" class="back-btn">← Back</a>
<div class="project-container">
    <h2 style="color:white">My Projects</h2>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="project-card">
            <h3>Architect: <?php echo $row['architect_name']; ?></h3>
            <p class="status">Status: <?php echo $row['connection_status'] ?? 'Request Pending'; ?></p>

            <!-- Display Project Status -->
            <p><strong>Project Status:</strong> <?php echo ucfirst($row['project_status']); ?></p>

            <!-- Feedback and Rating Form (only if status is 'ended') -->
            <?php if ($row['project_status'] === 'ended'): ?>
                <form class="feedback-form" method="POST" action="rating_feedback.php">
                    <input type="hidden" name="connection_id" value="<?php echo $row['id']; ?>">

                    <!-- Rating Section -->
                    <label for="rating">Rate this project: </label>
                    <div class="rating">
                        <input type="radio" name="rating" value="1" id="rating1" required><label for="rating1">1</label>
                        <input type="radio" name="rating" value="2" id="rating2"><label for="rating2">2</label>
                        <input type="radio" name="rating" value="3" id="rating3"><label for="rating3">3</label>
                        <input type="radio" name="rating" value="4" id="rating4"><label for="rating4">4</label>
                        <input type="radio" name="rating" value="5" id="rating5"><label for="rating5">5</label>
                    </div>

                    <!-- Feedback Textarea -->
                    <textarea name="feedback" rows="3" placeholder="Give your feedback..."></textarea>

                    <!-- Submit Button -->
                    <button type="submit">Submit Rating and Feedback</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
