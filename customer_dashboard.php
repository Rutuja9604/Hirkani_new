<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
  header("Location: login.php");
  exit();
}

$page = $_GET['page'] ?? 'home';

include("connect/connection.php");
$customer_id = $_SESSION['customer_id'];

// Fetch customer info
$customer = $conn->query("SELECT * FROM customers WHERE id = $customer_id")->fetch_assoc();

// Fetch appointments
$appointments = $conn->query("SELECT * FROM appointments WHERE email = '{$customer['email']}' ORDER BY appointment_date");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Customer Dashboard</title>
  <style>
    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 20px;
    }

    h2 {
      color: #d81b60;
      margin-bottom: 10px;
    }

    .welcome {
      margin-bottom: 20px;
    }

    button {
      padding: 12px 20px;
      background-color: #d81b60;
      color: white;
      border: none;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s;
    }

    button:hover {
      background-color: #c2185b;
    }

    #appointment-container {
      margin-top: 20px;
    }

    .appointment-card {
      background: white;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease;
    }

    .appointment-card:hover {
      transform: translateY(-3px);
    }

    .appointment-card p {
      margin: 10px 0;
      font-size: 16px;
      color: #333;
    }

    .status-approved {
      color: #2e7d32;
      background-color: #e8f5e9;
      padding: 4px 10px;
      border-radius: 6px;
      font-weight: bold;
      display: inline-block;
    }

    .status-pending {
      color: #f57c00;
      background-color: #fff3e0;
      padding: 4px 10px;
      border-radius: 6px;
      font-weight: bold;
      display: inline-block;
    }

    a.logout {
      float: right;
      background: #d81b60;
      color: white;
      padding: 8px 12px;
      border-radius: 6px;
      text-decoration: none;
    }
  </style>
</head>
<body>

<?php include("includes/navbar.php"); ?>

<?php if ($page === 'home'): ?>
  <h2>Welcome, <?= htmlspecialchars($customer['name']) ?></h2>
  <p class="welcome">Here are your upcoming appointments:</p>

  <div id="appointment-container" style="display:none;">
    <iframe src="appointment.php"style="width:100%; height:600px; border:none;"></iframe>
  </div>

  <button type="button" onclick="document.getElementById('appointment-container').style.display='block'; window.location.hash='appointment-container';">
    Book Appointment
  </button>

  

<?php elseif ($page === 'edit_profile'): ?>
  <?php include('edit_profile.php'); ?>
<?php elseif ($page === 'services'): ?>
  <?php include('services.php'); ?>
<?php else: ?>
  <p>Page not found.</p>
<?php endif; ?>

</body>
</html>

<?php $conn->close(); ?>
