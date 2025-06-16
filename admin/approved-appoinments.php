<?php
session_start();
include '../connect/connection.php';

// Export to PDF
if (isset($_GET['export']) && $_GET['export'] === 'pdf') {
    require('../libs/fpdf/fpdf.php');

    if (ob_get_length()) ob_end_clean();

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Approved Appointments', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, '#', 1);
    $pdf->Cell(50, 10, 'Customer', 1);
    $pdf->Cell(40, 10, 'Service', 1);
    $pdf->Cell(50, 10, 'Date & Time', 1);
    $pdf->Cell(40, 10, 'Notes', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    $result = $conn->query("SELECT * FROM appointments WHERE status = 'Approved' ORDER BY appointment_date DESC, appointment_time");
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 10, $i++, 1);
        $pdf->Cell(50, 10, $row['name'] . "\n" . $row['email'], 1);
        $pdf->Cell(40, 10, $row['service'], 1);
        $pdf->Cell(50, 10, $row['appointment_date'] . ' ' . $row['appointment_time'], 1);
        $pdf->Cell(40, 10, $row['notes'], 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'approved_appointments.pdf');
    exit;
}

// Export to Excel
if (isset($_GET['export']) && $_GET['export'] === 'excel') {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=approved_appointments.xls");

    echo "<table border='1'>";
    echo "<tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Service</th><th>Date</th><th>Time</th><th>Notes</th></tr>";
    $result = $conn->query("SELECT * FROM appointments WHERE status = 'Approved' ORDER BY appointment_date DESC, appointment_time");
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$i}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['phone']}</td>
            <td>{$row['service']}</td>
            <td>{$row['appointment_date']}</td>
            <td>{$row['appointment_time']}</td>
            <td>{$row['notes']}</td>
        </tr>";
        $i++;
    }
    echo "</table>";
    exit;
}

// Default display
$appointments = $conn->query("SELECT * FROM appointments WHERE status = 'Approved' ORDER BY appointment_date DESC, appointment_time");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approved Appointments - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            margin: 20px;
        }

        h2 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #2e7d32;
        }

        .export-buttons {
            margin-bottom: 15px;
        }

        .export-buttons a {
            display: inline-block;
            padding: 10px 20px;
            margin-right: 10px;
            background: #388e3c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .export-buttons a:hover {
            background: #2e7d32;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #c8e6c9;
            color: #1b5e20;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .approved-row {
            background-color: #e6ffe6;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #777;
        }
    </style>
</head>
<body>

<h2>Approved Appointments</h2>

<div class="export-buttons">
    <a href="?export=pdf"><i class="fa-solid fa-file-pdf"></i> Export to PDF</a>
    <a href="?export=excel"><i class="fa-solid fa-file-excel"></i> Export to Excel</a>
</div>

<div class="card">
    <?php if ($appointments->num_rows > 0): ?>
        <table>
            <thead>
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
                    <tr class="approved-row">
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
    <?php else: ?>
        <p class="text-muted">No approved appointments found.</p>
    <?php endif; ?>
</div>

</body>
</html>
