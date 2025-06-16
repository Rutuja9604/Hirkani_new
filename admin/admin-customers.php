<?php
ob_start(); // Start output buffering
include("../connect/connection.php");

// PDF EXPORT
if (isset($_GET['export']) && $_GET['export'] === 'pdf') {
    require('../libs/fpdf/fpdf.php');

    if (ob_get_length()) ob_end_clean(); // clear buffer
    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename=customers_report.pdf");

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Registered Customers', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, 'ID', 1);
    $pdf->Cell(40, 10, 'Name', 1);
    $pdf->Cell(50, 10, 'Email', 1);
    $pdf->Cell(30, 10, 'Phone', 1);
    $pdf->Cell(60, 10, 'Address', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    $result = $conn->query("SELECT * FROM customers");
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 10, $row['id'], 1);
        $pdf->Cell(40, 10, $row['name'], 1);
        $pdf->Cell(50, 10, $row['email'], 1);
        $pdf->Cell(30, 10, $row['phone'], 1);
        $pdf->Cell(60, 10, $row['address'], 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'customers_report.pdf'); // force download
    exit;
}

// EXCEL EXPORT
if (isset($_GET['export']) && $_GET['export'] === 'excel') {
    if (ob_get_length()) ob_end_clean(); // clear buffer
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=customers_report.xls");

    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Address</th></tr>";
    $result = $conn->query("SELECT * FROM customers");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['address']}</td>
              </tr>";
    }
    echo "</table>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Customers</title>
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
    }

    .export-buttons {
      margin-bottom: 15px;
    }

    .export-buttons a {
      display: inline-block;
      padding: 10px 20px;
      margin-right: 10px;
      background: #6a1b9a;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-size: 14px;
    }

    .export-buttons a:hover {
      background: #4a126b;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: left;
    }

    th {
      background: #f3e5f5;
      color: #4a148c;
    }

    tr:nth-child(even) {
      background: #f9f9f9;
    }
  </style>
</head>
<body>

<h2>Registered Customers</h2>

<div class="export-buttons">
  <a href="?export=pdf"><i class="fa-solid fa-file-pdf"></i> Export to PDF</a>
  <a href="?export=excel"><i class="fa-solid fa-file-excel"></i> Export to Excel</a>
</div>

<table>
  <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Address</th></tr>
  <?php
  $result = $conn->query("SELECT * FROM customers");
  while ($row = $result->fetch_assoc()) {
    echo "<tr>
      <td>{$row['id']}</td>
      <td>{$row['name']}</td>
      <td>{$row['email']}</td>
      <td>{$row['phone']}</td>
      <td>{$row['address']}</td>
    </tr>";
  }
  ?>
</table>

</body>
</html>
