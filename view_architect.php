<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'dbconnect.php';

$architect_id = $_GET['id'] ?? null;

if (!$architect_id) {
    echo "Invalid request.";
    exit;
}

$query = "SELECT * FROM architects WHERE id = $architect_id";
$result = mysqli_query($con, $query);
$architect = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['description'])) {
    $user_id = $_SESSION['user_id'];
    $description = mysqli_real_escape_string($con, $_POST['description']);
    
    $insert = "INSERT INTO connections (user_id, architect_id, user_description) VALUES ('$user_id', '$architect_id', '$description')";
    mysqli_query($con, $insert);
    echo "<script>alert('Your request has been sent to the architect!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Architect Profile</title>
    <link rel="stylesheet" href="user/view_architect.css">
</head>
<body style="background-image: url('homepage/assets/user.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; font-family: sans-serif;">

<a href="userpage.php" class="back-btn">← Back</a>

<div class="profile-container">
    <img src="<?php echo $architect['photo']; ?>" alt="Architect Photo" class="profile-photo">
    <div class="profile-details">
        <h2><?php echo $architect['name']; ?></h2>
        <p><strong>Location:</strong> <?php echo $architect['location']; ?></p>
        <p><strong>Email:</strong> <?php echo $architect['email']; ?></p>
        <p><strong>Phone:</strong> <?php echo $architect['phone']; ?></p>
        <p><strong>Experience:</strong> <?php echo $architect['experience']; ?></p>
        <p><strong>Qualification:</strong> <?php echo $architect['qualification']; ?></p>
        <p><strong>Specialization:</strong> <?php echo $architect['specialization']; ?></p>
        <p><strong>Status:</strong> <?php echo $architect['status']; ?></p>

        <a href="worksdone.php?architect_id=<?php echo $architect['id']; ?>" class="btn1">📁 Works Done</a>


        <form method="POST" class="connect-form">
            <h3>What are you looking for?</h3>
            <textarea name="description" rows="4" required placeholder="Describe your requirement..."></textarea>
            <button type="submit">🔗 Connect with Architect</button>
        </form>
    </div>
</div>

</body>
</html>
