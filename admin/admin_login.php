<?php
session_start();

// Fixed admin credentials
$admin_username = 'admin';
$admin_password = 'admin@123'; // You may hash this if needed

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid admin credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login - Hirkani Beauty Parlour</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: url('./images/background.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, sans-serif;
    }

    .login-container {
      max-width: 500px;
      margin: 80px auto;
      background: rgba(255, 240, 245, 0.6);
      padding: 50px 40px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }

    .login-container h2 {
      text-align: center;
      color: #d81b60;
      margin-bottom: 30px;
    }

    .login-container input {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1.1rem;
    }

    .login-container button {
      width: 100%;
      background-color: #d81b60;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 1.1rem;
      cursor: pointer;
    }

    .login-container button:hover {
      background-color: #c2185b;
    }

    .message {
      text-align: center;
      font-size: 14px;
      margin-bottom: 10px;
    }

    .error {
      color: red;
    }

    @media (max-width: 768px) {
      .login-container {
        padding: 30px 20px;
        margin: 40px 15px;
      }
    }

    @media (max-width: 480px) {
      .login-container {
        padding: 25px 15px;
      }

      .login-container h2 {
        font-size: 1.3rem;
      }

      .login-container input,
      .login-container button {
        font-size: 1rem;
        padding: 10px;
      }
    }
  </style>
</head>
<body>

<div class="login-container">
  <h2>Admin Login</h2>
  <form method="POST" action="">
    <?php if ($error): ?>
      <p class="message error"><?php echo $error; ?></p>
    <?php endif; ?>
    <input type="text" name="username" placeholder="Username" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Login</button>
  </form>
</div>

</body>
</html>
