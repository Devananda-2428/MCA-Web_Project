<?php
session_start();
include 'dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$architect_id = $_SESSION['user_id'];

// Handle Accept
if (isset($_POST['accept']) && isset($_POST['connection_id'])) {
    $connection_id = $_POST['connection_id'];
    $update_sql = "UPDATE connections SET connection_status = 'accepted' WHERE id = $connection_id";
    mysqli_query($con, $update_sql);

    // Update the architect's status to 'occupied'
    $update_architect_sql = "UPDATE architects SET status = 'occupied' WHERE id = $architect_id";
    mysqli_query($con, $update_architect_sql);
}

// Handle Reject
if (isset($_POST['reject']) && isset($_POST['connection_id'])) {
    $connection_id = $_POST['connection_id'];
    $update_sql = "UPDATE connections  SET connection_status = 'rejected' WHERE id = $connection_id";
    mysqli_query($con, $update_sql);
}

$sql = "SELECT c.id, c.user_description, u.name AS user_name, u.email, u.phone, c.connection_status
        FROM connections c
        JOIN users u ON c.user_id = u.id
        WHERE c.architect_id = $architect_id AND c.connection_status = 'pending'";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connection Requests</title>
    <link rel="stylesheet" href="arch-dashboard/arch-connections.css">
    <style>
        .request-card {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }
        .btn-accept {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-accept:hover {
            background-color: #388E3C;
        }
        .btn-reject {
            background-color: #e53935;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-reject:hover {
            background-color: #c62828;
        }
    </style>
</head>
<body style="background-image: url('homepage/assets/archimg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; font-family: sans-serif;">

<div class="top-bar">
        <a href="a_dashboard.php" class="back-button">Back to Dashboard</a>
    </div>
    <h2 style="margin: 20px 40px;color:white;">New Connection Requests</h2>

    <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="request-card">
            <p><strong>Name:</strong> <?php echo $row['user_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
            <p><strong>Description:</strong> <?php echo $row['user_description']; ?></p>

            <form method="POST" style="display: flex; gap: 10px;">
                <input type="hidden" name="connection_id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="accept" class="btn-accept"> Accept</button>
                <button type="submit" name="reject" class="btn-reject"> Reject</button>
            </form>
        </div>
    <?php endwhile; ?>
</body>
</html>
