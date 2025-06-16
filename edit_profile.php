<?php
//session_start();
include('connect/connection.php');

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Fetch current profile data
$stmt = $conn->prepare("SELECT name, email, phone FROM customers WHERE id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE customers SET name=?, email=?, phone=?, password=? WHERE id=?");
        $update->bind_param("ssssi", $name, $email, $phone, $hashedPassword, $customer_id);
    } else {
        $update = $conn->prepare("UPDATE customers SET name=?, email=?, phone=? WHERE id=?");
        $update->bind_param("sssi", $name, $email, $phone, $customer_id);
    }

    if ($update->execute()) {
        $_SESSION['customer_name'] = $name; // Update session name
        $success = "Profile updated successfully!";
    } else {
        $error = "Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <style>
        .form-container {
  max-width: 600px;
  margin: 50px auto;
  padding: 30px;
  background: #fff0f5;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.form-container h2 {
  color: #d81b60;
  text-align: center;
  margin-bottom: 20px;
}

.form-container input,
.form-container button {
  width: 100%;
  padding: 12px;
  margin-bottom: 15px;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 1rem;
}

.form-container button {
  background: #d81b60;
  color: white;
  border: none;
  cursor: pointer;
}

.form-container button:hover {
  background: #c2185b;
}
</style>
</head>
<body>


<div class="form-container">
    <h2>Edit Profile</h2>
    
    <?php if (!empty($success)) echo "<p style='color: green;'>$success</p>"; ?>
    <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>

    <form method="POST" action="">
        <input type="text" name="name" value="<?= htmlspecialchars($customer['name']) ?>" placeholder="Full Name" required>
        <input type="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" placeholder="Email" required>
        <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>" placeholder="Phone" required>
        <input type="password" name="password" placeholder="New Password (leave blank to keep current)">
        <button type="submit">Update Profile</button>
    </form>
</div>

</body>
</html>
