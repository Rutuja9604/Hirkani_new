<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!-- Customer Navbar -->
<nav class="customer-navbar">
  <div class="navbar-brand">Hirkani Beauty Parlour</div>
  <div class="navbar-links">
  
  <a href="customer_dashboard.php?page=services.php">services</a>
  <a href="customer_dashboard.php?page=edit_profile">Edit Profile</a>
  <a href="logout.php" class="logout-btn">Logout</a>

  </div>
</nav>
<style>
.customer-navbar {
  background-color: #d81b60;
  padding: 15px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: white;
}

.customer-navbar .navbar-brand {
  font-size: 20px;
  font-weight: bold;
}

.customer-navbar .navbar-links a {
  color: white;
  text-decoration: none;
  margin-right: 20px;
  transition: color 0.3s ease;
}

.customer-navbar .navbar-links a:hover {
  color: #ffe4ec;
}

.customer-navbar .logout-btn {
  background-color: #c2185b;
  padding: 5px 10px;
  border-radius: 5px;
}
</style>