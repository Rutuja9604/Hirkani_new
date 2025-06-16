<?php
include("../connect/connection.php");

if (!function_exists('getCount')) {
    function getCount($query) {
        global $conn;
        $result = $conn->query($query);
        return $result ? $result->fetch_assoc()['total'] : 0;
    }
}

$customerCount = getCount("SELECT COUNT(*) AS total FROM customers");
$appointmentCount = getCount("SELECT COUNT(*) AS total FROM appointments");
$servicesCount = getCount("SELECT COUNT(*) AS total FROM services");
?>

<h1>Welcome, Admin 👋</h1>

<div class="cards">
  <div class="card" onclick="loadPage('admin-customers.php')">
    <i class="fa-solid fa-users"></i>
    <h3>Total Customers</h3>
    <div class="number"><?= htmlspecialchars($customerCount) ?></div>
  </div>

  <div class="card" onclick="loadPage('admin-appointments.php')">
    <i class="fa-solid fa-calendar-check"></i>
    <h3>Total Appointments</h3>
    <div class="number"><?= htmlspecialchars($appointmentCount) ?></div>
  </div>

  <div class="card" onclick="loadPage('admin-services.php')">
    <i class="fa-solid fa-scissors"></i>
    <h3>Total Services</h3>
    <div class="number"><?= htmlspecialchars($servicesCount) ?></div>
  </div>
</div>

<div class="reports">
  <h2>📊 Generate Reports</h2>
  <a href="daywise_report.php"><i class="fa-solid fa-calendar-day"></i> Day-wise Report (PDF)</a>
  <a href="customer_report.php"><i class="fa-solid fa-user"></i> Customer-wise Report (PDF)</a>
</div>
