<?php
session_start();
include 'dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$architect_id = $_SESSION['user_id'];

// Handle project_status update
if (isset($_POST['update_status']) && isset($_POST['connection_id'])) {
    $connection_id = $_POST['connection_id'];
    $new_status = $_POST['new_status'];
    $update_sql = "UPDATE connections SET project_status = '$new_status' WHERE id = $connection_id";
    mysqli_query($con, $update_sql);
}

// Handle project "End" status update
if (isset($_POST['end_project']) && isset($_POST['connection_id'])) {
    $connection_id = $_POST['connection_id'];
    $update_sql = "UPDATE connections SET project_status = 'ended' WHERE id = $connection_id";
    mysqli_query($con, $update_sql);

    $update_architect_sql = "UPDATE architects SET status = 'available' WHERE id = $architect_id";
    mysqli_query($con, $update_architect_sql);
}

// Fetch all accepted connections
$sql = "SELECT c.id, c.project_status, u.name, u.email, u.phone, c.user_description
        FROM connections c
        JOIN users u ON c.user_id = u.id
        WHERE c.architect_id = $architect_id AND c.connection_status = 'accepted' and project_status IN ('not started','started','ongoing','completed')";

$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Current Connections</title>
    <link rel="stylesheet" href="arch-dashboard/arch-connections.css">
</head>
<body style="background-image: url('homepage/assets/archimg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; font-family: sans-serif;">

    <div class="top-bar">
        <a href="a_dashboard.php" class="back-button">Back to Dashboard</a>
    </div>

    <h2 style="color:white">Current Work!!</h2>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <?php
            $status = $row['project_status'];
            $badgeClass = 'badge-' . str_replace(' ', '-', strtolower($status));
        ?>
        <div class="card">
            <p><strong>Name:</strong> <?php echo $row['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
            <p><strong>Description:</strong> <?php echo $row['user_description']; ?></p>
            <p>
                <strong>Project Status:</strong> <?php echo ucfirst($status); ?>
                <span class="status-badge <?php echo $badgeClass; ?>"><?php echo ucfirst($status); ?></span>
            </p>

            <form method="POST">
                <input type="hidden" name="connection_id" value="<?php echo $row['id']; ?>">
                <select name="new_status">
                    <option value="started" <?php if($status == 'started') echo 'selected'; ?>>Started</option>
                    <option value="ongoing" <?php if($status == 'ongoing') echo 'selected'; ?>>On-going</option>
                    <option value="completed" <?php if($status == 'completed') echo 'selected'; ?>>Completed</option>
                </select>
                <button type="submit" name="update_status" class="update-button">Update</button>
            </form>

            <?php if ($status == 'completed'): ?>
                <form method="POST" style="margin-top: 15px;">
                    <input type="hidden" name="connection_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="end_project" class="end-button">End Project</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>

</body>
</html>
