<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="your-dashboard-style.css"> <!-- Your existing CSS -->
    <style>
        .forgot-container {
            margin-left: 240px;
            margin-top:80px;
            padding: 60px;
            max-width: 500px;
            background: #f9f9f9;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .forgot-container h2 {
            margin-bottom: 20px;
            font-size: 28px;
        }

        .forgot-container input[type="email"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .forgot-container button {
            padding: 12px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .forgot-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body style="background-image: url('homepage/assets/bg1.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; margin: 0; font-family: sans-serif;">
    <div class="dashboard-container">
        

        <div class="forgot-container">
            <h2>Forgot Password?</h2>
            <p>Enter your registered email address. We'll send you instructions to reset your password.</p>
            <form method="POST">
                <input type="email" name="email" placeholder="Your Email" required>
                <button type="submit" name="submit">Send Reset Link</button>
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        echo "<script>alert('Reset link sent to your email.');window.location.href = 'home.php';</script>";
    }
    ?>
</body>
</html>
