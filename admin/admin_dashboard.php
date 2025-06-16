<?php
include("../connect/connection.php");

// Counts
function getCount($query) {
    global $conn;
    $result = $conn->query($query);
    return $result ? $result->fetch_assoc()['total'] : 0;
}

$customerCount = getCount("SELECT COUNT(*) AS total FROM customers");
$appointmentCount = getCount("SELECT COUNT(*) AS total FROM appointments");
$servicesCount = getCount("SELECT COUNT(*) AS total FROM services");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Hirkani</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
     * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f2f4f8;
      color: #333;
    }

    .sidebar {
      width: 230px;
      background:rgb(231, 52, 106);
      color: white;
      height: 100vh;
      position: fixed;
      padding-top: 30px;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 22px;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 15px 25px;
      transition: background 0.3s;
      font-size: 16px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .sidebar a:hover {
      background:rgb(214, 27, 86);
    }

    .main {
      margin-left: 230px;
      padding: 40px;
    }

    h1 {
      font-size: 28px;
      margin-bottom: 20px;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
      gap: 20px;
    }

    .card {
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      text-align: center;
      position: relative;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .card i {
      font-size: 28px;
      color: #6a1b9a;
      margin-bottom: 10px;
    }

    .card h3 {
      margin: 10px 0 5px;
      font-size: 18px;
      color: #444;
    }

    .card .number {
      font-size: 30px;
      font-weight: 600;
      color: #333;
    }

    .reports {
      margin-top: 50px;
    }

    .reports h2 {
      font-size: 22px;
      margin-bottom: 20px;
    }

    .reports a {
      display: inline-block;
      background:rgb(79, 7, 58);
      color: white;
      padding: 12px 20px;
      margin: 10px 15px 0 0;
      text-decoration: none;
      border-radius: 6px;
      font-size: 15px;
      transition: background 0.3s;
    }

    .reports a:hover {
      background:rgb(206, 25, 88);
    }

    @media (max-width: 768px) {
      .main {
        margin-left: 0;
        padding: 20px;
      }

      .sidebar {
        display: none;
      }
    }
  </style>
</head>
<body>

<div class="sidebar">
  <h2><i class="fa-solid fa-gauge"></i> Hirkani</h2>
  <a href="#" onclick="loadPage('dashboard-home.php')"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
  <a href="#" onclick="loadPage('admin-appointments.php')"><i class="fa-solid fa-calendar-check"></i> Manage Appointments</a>
  <a href="#" onclick="loadPage('admin-services.php')"><i class="fa-solid fa-scissors"></i> Manage Services</a>
  <a href="#" onclick="loadPage('admin-customers.php')"><i class="fa-solid fa-users"></i> View Customers</a>
  <a href="#" onclick="loadPage('daywise_report.php')"><i class="fa-solid fa-file-lines"></i> Day-wise Report</a>
  <a href="#" onclick="loadPage('customer_report.php')"><i class="fa-solid fa-user-check"></i> Customer Report</a>
  <a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="main" id="main-content">
  <!-- Default dashboard content (moved to a partial file below) -->
  <?php include("dashboard-home.php"); ?>
</div>

<script>
function loadPage(page) {
  const container = document.getElementById('main-content');
  container.innerHTML = "<p>Loading...</p>";

  fetch(page)
    .then(res => {
      if (!res.ok) throw new Error("Network response was not ok");
      return res.text();
    })
    .then(html => {
      container.innerHTML = html;
    })
    .catch(err => {
      container.innerHTML = `<p>Error loading page: ${err.message}</p>`;
    });
}
</script>

</body>
</html>
