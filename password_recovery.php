<?php
session_start();
include('connect/connection.php');
$step = 'email';
$message = "";

if (isset($_SESSION['step'])) {
    $step = $_SESSION['step'];
}

// === Step 1: Email submission ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $stmt = $conn->prepare("SELECT id FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $_SESSION['reset_email'] = $email;
            $_SESSION['otp'] = rand(100000, 999999);
            $_SESSION['otp_expire'] = time() + 300;
            $_SESSION['step'] = 'otp';
            $step = 'otp';
            $message = "OTP sent to your email: <strong>{$_SESSION['otp']}</strong>"; // for development only
        } else {
            $message = "Email not registered.";
        }
    }

    // === Step 2: OTP verification ===
    elseif (isset($_POST['otp'])) {
        $entered_otp = $_POST['otp'];
        if (isset($_SESSION['otp']) && time() < $_SESSION['otp_expire']) {
            if ($entered_otp == $_SESSION['otp']) {
                $_SESSION['step'] = 'reset';
                $step = 'reset';
            } else {
                $message = "Invalid OTP.";
            }
        } else {
            $message = "OTP expired. Please start over.";
            session_destroy();
        }
    }

    // === Step 3: Password reset ===
    elseif (isset($_POST['new_password'], $_POST['confirm_password'])) {
        $new = $_POST['new_password'];
        $confirm = $_POST['confirm_password'];

        if ($new !== $confirm) {
            $message = "Passwords do not match.";
        } elseif (strlen($new) < 6) {
            $message = "Password must be at least 6 characters.";
        } else {
            $hashed = password_hash($new, PASSWORD_DEFAULT);
            $email = $_SESSION['reset_email'];
            $stmt = $conn->prepare("UPDATE customers SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashed, $email);
            $stmt->execute();

            session_destroy();
            header("Location: login.php?reset=success");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Password Recovery</title>
  <style>
    .login-container {
      max-width: 400px;
      margin: 60px auto;
      background: #fefefe;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      font-family: sans-serif;
    }
    input, button {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    button {
      background-color: #d81b60;
      color: white;
      border: none;
    }
    .message { color: red; text-align: center; }
  </style>
</head>
<body>

<div class="login-container">
  <h2>Password Recovery</h2>

  <?php if ($message): ?>
    <p class="message"><?= $message ?></p>
  <?php endif; ?>

  <form method="POST">
    <?php if ($step === 'email'): ?>
      <input type="email" name="email" placeholder="Enter your registered email" required />
      <button type="submit">Send OTP</button>

    <?php elseif ($step === 'otp'): ?>
      <input type="text" name="otp" placeholder="Enter OTP" required />
      <button type="submit">Verify OTP</button>

    <?php elseif ($step === 'reset'): ?>
      <input type="password" name="new_password" placeholder="New Password" required />
      <input type="password" name="confirm_password" placeholder="Confirm Password" required />
      <button type="submit">Reset Password</button>
    <?php endif; ?>
  </form>

  <p style="text-align:center;">
    <a href="login.php">Back to Login</a>
  </p>
</div>

</body>
</html>
