<?php
session_start();
include '../connect/connection.php';

// Handle approve
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $conn->query("UPDATE appointments SET status = 'Approved' WHERE id = $id");
    header("Location: admin-appointments.php");
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM appointments WHERE id = $id");
    header("Location: admin-appointments.php");
    exit();
}

// Export to PDF
if (isset($_GET['export']) && $_GET['export'] == 'pdf') {
    require('../libs/fpdf/fpdf.php');
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,10,'Appointments Report',0,1,'C');
    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(10,10,'#',1);
    $pdf->Cell(50,10,'Name',1);
    $pdf->Cell(40,10,'Service',1);
    $pdf->Cell(40,10,'Date & Time',1);
    $pdf->Cell(40,10,'Status',1);
    $pdf->Ln();

    $appointments = $conn->query("SELECT * FROM appointments ORDER BY appointment_date DESC");
    $i = 1;
    $pdf->SetFont('Arial','',10);
    while ($row = $appointments->fetch_assoc()) {
        $pdf->Cell(10,10,$i++,1);
        $pdf->Cell(50,10,$row['name'],1);
        $pdf->Cell(40,10,$row['service'],1);
        $pdf->Cell(40,10,$row['appointment_date'].' '.$row['appointment_time'],1);
        $pdf->Cell(40,10,$row['status'],1);
        $pdf->Ln();
    }
    $pdf->Output();
    exit();
}

// Export to Excel
if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=appointments.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['#', 'Name', 'Email', 'Phone', 'Service', 'Date', 'Time', 'Status']);

    $appointments = $conn->query("SELECT * FROM appointments ORDER BY appointment_date DESC");
    $i = 1;
    while ($row = $appointments->fetch_assoc()) {
        fputcsv($output, [
            $i++,
            $row['name'],
            $row['email'],
            $row['phone'],
            $row['service'],
            $row['appointment_date'],
            $row['appointment_time'],
            $row['status']
        ]);
    }
    fclose($output);
    exit();
}

$appointments = $conn->query("SELECT * FROM appointments ORDER BY appointment_date DESC, appointment_time");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Appointments - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f5f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            max-width: 1200px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.07);
        }

        h2 {
            font-weight: bold;
            color: #333;
        }

        .btn-export {
            margin-bottom: 20px;
        }

        .approved-row {
            background-color: #e6ffe6;
        }

        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="text-center mb-4">
        <h2>Manage Appointments</h2>
    </div>

    <div class="d-flex justify-content-end btn-export gap-2">
        <a href="?export=pdf" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Export PDF</a>
        <a href="?export=excel" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Export Excel</a>
    </div>

    <div class="card">
        <h5 class="mb-3">Customer Appointments</h5>

        <?php if ($appointments->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Customer Info</th>
                            <th>Service</th>
                            <th>Date & Time</th>
                            <th>Notes</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; while ($row = $appointments->fetch_assoc()): ?>
                        <tr class="<?= $row['status'] === 'Approved' ? 'approved-row' : '' ?>">
                            <td class="text-center"><?= $i++ ?></td>
                            <td>
                                <strong><?= htmlspecialchars($row['name']) ?></strong><br>
                                <?= htmlspecialchars($row['email']) ?><br>
                                <?= htmlspecialchars($row['phone']) ?>
                            </td>
                            <td class="text-center"><?= htmlspecialchars($row['service']) ?></td>
                            <td class="text-center"><?= $row['appointment_date'] ?><br><?= $row['appointment_time'] ?></td>
                            <td><?= htmlspecialchars($row['notes']) ?></td>
                            <td class="text-center">
                                <?php if ($row['status'] === 'Approved'): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($row['status'] !== 'Approved'): ?>
                                    <a href="?approve=<?= $row['id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Approve this appointment?')">Approve</a>
                                <?php endif; ?>
                                <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this appointment?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">No appointments found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- FontAwesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>
</html>
