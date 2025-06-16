<?php
session_start();
include '../connect/connection.php';

// Fetch only rejected appointments
$appointments = $conn->query("SELECT * FROM appointments WHERE status = 'Rejected' ORDER BY appointment_date DESC, appointment_time");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rejected Appointments - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff5f5;
        }
        .rejected-row {
            background-color: #ffe6e6;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <h2 class="text-danger text-center mb-4">Rejected Appointments</h2>

    <div class="card p-4 shadow-sm">
        <?php if ($appointments->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered align-middle table-hover">
                    <thead class="table-danger text-center">
                        <tr>
                            <th>#</th>
                            <th>Customer Info</th>
                            <th>Service</th>
                            <th>Date & Time</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; while ($row = $appointments->fetch_assoc()): ?>
                            <tr class="rejected-row">
                                <td class="text-center"><?= $i++ ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($row['name']) ?></strong><br>
                                    <?= htmlspecialchars($row['email']) ?><br>
                                    <?= htmlspecialchars($row['phone']) ?>
                                </td>
                                <td class="text-center"><?= htmlspecialchars($row['service']) ?></td>
                                <td class="text-center"><?= $row['appointment_date'] ?><br><?= $row['appointment_time'] ?></td>
                                <td><?= htmlspecialchars($row['notes']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">No rejected appointments found.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
