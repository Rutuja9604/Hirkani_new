<?php
session_start();
include 'connect/connection.php';

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];
$customer = $conn->query("SELECT * FROM customers WHERE id = $customer_id")->fetch_assoc();

// Handle cancellation
if (isset($_GET['cancel'])) {
    $cancel_id = intval($_GET['cancel']);
    $conn->query("DELETE FROM appointments WHERE id = $cancel_id AND email = '{$customer['email']}'");
    header("Location: appointment.php");
    exit();
}

// Fetch services
$services_query = $conn->query("SELECT name, category FROM services ORDER BY category, name");

// Handle form submission
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $customer['name'];
    $email   = $customer['email'];
    $phone   = $_POST['phone'];
    $service = $_POST['service'];
    $date    = $_POST['date'];
    $time    = $_POST['time'];
    $notes   = $_POST['notes'];

    $sql = "INSERT INTO appointments (name, email, phone, service, appointment_date, appointment_time, notes) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $email, $phone, $service, $date, $time, $notes);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success text-center'>Appointment booked successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger text-center'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Fetch user's appointments
$appointments = $conn->query("SELECT * FROM appointments WHERE email = '{$customer['email']}' ORDER BY appointment_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Customer Appointment Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        h2 {
            color: #d81b60;
        }
        .form-container {
            max-width: 800px;
            margin: 30px auto;
        }
        .card {
            border-radius: 12px;
        }
        .status-approved {
            color: green;
            font-weight: bold;
        }
        .status-rejected {
            color: red;
            font-weight: bold;
        }
        .status-pending {
            color: orange;
            font-weight: bold;
        }
        .cancel-btn {
            color: #dc3545;
            text-decoration: none;
        }
        .cancel-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container form-container">
    <h2 class="text-center mb-4">Welcome, <?= htmlspecialchars($customer['name']) ?></h2>

    <?= $message ?>

    <!-- Booking Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">Book New Appointment</div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="tel" name="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Service</label>
                    <select name="service" class="form-select" required>
                        <option value="">-- Select a Service --</option>
                        <?php
                        $currentCategory = '';
                        while ($row = $services_query->fetch_assoc()) {
                            if ($row['category'] !== $currentCategory) {
                                if ($currentCategory !== '') echo "</optgroup>";
                                $currentCategory = $row['category'];
                                echo "<optgroup label='" . htmlspecialchars($currentCategory) . "'>";
                            }
                            echo "<option value='" . htmlspecialchars($row['name']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                        }
                        if ($currentCategory !== '') echo "</optgroup>";
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Time</label>
                    <input type="time" name="time" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" rows="3" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-success w-100">Book Appointment</button>
            </form>
        </div>
    </div>

    <!-- Appointment List -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">Your Appointments</div>
        <div class="card-body">
            <?php if ($appointments->num_rows > 0): ?>
                <?php while ($row = $appointments->fetch_assoc()): ?>
                    <?php
                    $status = $row['status'];
                    $cardClass = match ($status) {
                        'Approved' => 'border-success bg-light',
                        'Rejected' => 'border-danger bg-danger-subtle',
                        default => 'border-warning bg-warning-subtle',
                    };
                    ?>
                    <div class="card mb-3 <?= $cardClass ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['service']) ?> Appointment</h5>
                            <p class="mb-1"><strong>Date:</strong> <?= $row['appointment_date'] ?> &nbsp;
                                <strong>Time:</strong> <?= $row['appointment_time'] ?></p>
                            <p class="mb-1"><strong>Notes:</strong> <?= htmlspecialchars($row['notes']) ?></p>
                            <p>
                                <strong>Status:</strong>
                                <?php
                                if ($status === 'Approved') {
                                    echo "<span class='status-approved'>Approved</span>";
                                } elseif ($status === 'Rejected') {
                                    echo "<span class='status-rejected'>Rejected</span>";
                                } else {
                                    echo "<span class='status-pending'>Pending</span>";
                                }
                                ?>
                            </p>
                            <a href="?cancel=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm"
                               onclick="return confirm('Cancel this appointment?')">Cancel</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">No appointments booked yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
