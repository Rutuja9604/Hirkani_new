<?php
session_start();
include('connect/connection.php');

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['customer_id'] = $user['id'];
            $_SESSION['customer_name'] = $user['name'];
            header("Location: customer_dashboard.php");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Hirkani Beauty Parlour</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: url('images/background.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, sans-serif;
    }

    .login-container {
  max-width: 500px;
  margin: 80px auto;
  background: rgba(255, 240, 245, 0.6); /* Lowered from 0.8 to 0.6 */
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

    .error { color: red; }
    .success { color: green; }

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

<?php include("includes/header.php"); ?>

<div class="login-container">
  <h2>Login</h2>
  <form method="POST" action="login.php">
  <?php if ($error): ?>
    <p class="message error"><?php echo $error; ?></p>
  <?php endif; ?>
  <input type="text" name="email" placeholder="Email" required />
  <input type="password" name="password" placeholder="Password" required />
  <button type="submit">Login</button>
  <p style="text-align:center; margin-top: 10px;">
    Don't have an account? <a href="signup.php">Sign up here</a><br>
    <a href="password_recovery.php">Forgot Password?</a>
  </p>
</form>

</div>

</body>
</html>
<?php if (isset($_GET['error']) && $_GET['error'] == 'login_required'): ?>
  <p style="color: red; text-align: center;">Please log in to book an appointment.</p>
<?php endif; ?>
