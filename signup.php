<?php
session_start();
include("connect/connection.php");
include("includes/header.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $address  = trim($_POST['address']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirmPassword'];
    $role     = 'customer'; // fixed role

    // Validations
    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($password) || empty($confirm)) {
        $message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif (!preg_match('/^\d{7,15}$/', $phone)) {
        $message = "Phone number must be 7 to 15 digits.";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm) {
        $message = "Passwords do not match.";
    } else {
        // Check for duplicate email
        $checkStmt = $conn->prepare("SELECT id FROM customers WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $message = "Email already registered. Please login.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO customers (name, email, phone, address, password, role) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $name, $email, $phone, $address, $hashedPassword, $role);

            if ($stmt->execute()) {
               echo "<script>
                   alert('Registration successful! Please login.');
                   window.location.href = 'login.php';
                   </script>";
             exit;
            }

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up - Hirkani Beauty Parlour</title>
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
      background-color: rgb(65, 7, 30);
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
<div class="login-container">
  <h2>Sign Up</h2>

  <?php if (!empty($message)): ?>
    <p class="message error"><?= htmlspecialchars($message) ?></p>
  <?php endif; ?>

  <form id="registerForm" method="post" action="">
    <div class="input-box">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" required />
    </div>
    <div class="input-box">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required />
    </div>
    <div class="input-box">
      <label for="phone">Phone Number</label>
      <input type="tel" id="phone" name="phone" required />
    </div>
    <div class="input-box">
      <label for="address">Address</label>
      <input type="text" id="address" name="address" required />
    </div>
    <div class="input-box">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required />
    </div>
    <div class="input-box">
      <label for="confirmPassword">Confirm Password</label>
      <input type="password" id="confirmPassword" name="confirmPassword" required />
    </div>
    <button type="submit">Register</button>

    <p style="text-align:center; margin-top: 10px;">
      Already have an account? <a href="login.php">Login here</a>
    </p>
  </form>
</div>
</body>
</html>
