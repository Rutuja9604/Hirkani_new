<?php
session_start();
include 'connect/connection.php'; // Make sure this includes $conn

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: appointment.php");
    exit();
}
else {
  // If not logged in, go to login page with redirect note
  header("Location: login.php?redirect=appointment");
  exit();
}
 include 'includes/header.php';
// Validate required fields from POST
if (
    isset($_POST['phone'], $_POST['service'], $_POST['date'], $_POST['time'])
) {
    // Get values from POST and SESSION
    $name = $_SESSION['customer_name'];
    $email = $_SESSION['customer_email'];
    $phone = $_POST['phone'];
    $service = $_POST['service'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $notes = isset($_POST['notes']) ? $_POST['notes'] : '';

    // Prepare SQL
    $sql = "INSERT INTO appointments (name, email, phone, service, appointment_date, appointment_time, notes) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $email, $phone, $service, $date, $time, $notes);

    if ($stmt->execute()) {
        echo "<h3>Thank you, $name! Your appointment for <strong>$service</strong> on <strong>$date</strong> at <strong>$time</strong> is confirmed.</h3>";
    } else {
        echo "<h3 style='color:red;'>Error: " . $stmt->error . "</h3>";
    }

    $stmt->close();
    $conn->close();

} else {
    echo "<h3 style='color:red;'>Missing required fields. Please try again.</h3>";
}
?>
