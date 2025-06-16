<?php
require_once '../vendor/autoload.php'; // Path to Dompdf autoload
use Dompdf\Dompdf;
use Dompdf\Options;

include("../connect/connection.php");

date_default_timezone_set('Asia/Kolkata');
$today = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Fetch accepted appointments for the selected date
$sql = "
    SELECT name, service, appointment_time 
    FROM appointments 
    WHERE appointment_date = '$today' AND status = 'accepted'
";
$result = $conn->query($sql);

// For demonstration, let’s assume a flat service price map:
$servicePrices = [
    "Hair Cut" => 200,
    "Facial" => 500,
    "Makeup" => 1500,
    "Spa" => 800,
    "Massage" => 600
];

$total_income = 0;
$rows = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $price = isset($servicePrices[$row['service']]) ? $servicePrices[$row['service']] : 0;
        $total_income += $price;
        $row['price'] = $price;
        $rows[] = $row;
    }
}

// Handle PDF download
if (isset($_GET['download']) && $_GET['download'] === 'pdf') {
    $html = "
    <h2 style='text-align:center;'>Hirkani - Day-wise Report</h2>
    <p style='text-align:center;'>Date: <strong>$today</strong></p>
    <p style='text-align:center; font-weight: bold;'>Total Income: ₹" . number_format($total_income, 2) . "</p>
    <br>
    <table style='width: 100%; border-collapse: collapse;' border='1' cellpadding='8'>
        <thead>
            <tr style='background-color: #eee;'>
                <th>Customer</th>
                <th>Service</th>
                <th>Price (₹)</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>";

    foreach ($rows as $r) {
        $html .= "<tr>
            <td>" . htmlspecialchars($r['name']) . "</td>
            <td>" . htmlspecialchars($r['service']) . "</td>
            <td>₹" . number_format($r['price'], 2) . "</td>
            <td>" . date('h:i A', strtotime($r['appointment_time'])) . "</td>
        </tr>";
    }

    $html .= "</tbody></table>";

    if (empty($rows)) {
        $html .= "<p style='text-align:center;'>No accepted appointments for this date.</p>";
    }

    $options = new Options();
    $options->set('defaultFont', 'DejaVu Sans');
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("daywise_report_$today.pdf", ["Attachment" => false]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Day-wise Report</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fdf2f8;
      margin: 0;
      padding: 20px;
    }
    h2 {
      text-align: center;
      color: #c2185b;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
    }
    th, td {
      padding: 12px;
      text-align: center;
      border: 1px solid #ddd;
    }
    th {
      background-color: #f48fb1;
      color: white;
    }
    .total {
      margin-top: 20px;
      text-align: center;
      font-size: 18px;
      font-weight: bold;
    }
    .download-btn {
      display: block;
      width: 200px;
      margin: 20px auto;
      text-align: center;
      background: #ec407a;
      color: white;
      padding: 12px;
      text-decoration: none;
      border-radius: 8px;
    }
    .download-btn:hover {
      background: #c2185b;
    }
    .date-form {
      text-align: center;
      margin-bottom: 20px;
    }
    input[type="date"] {
      padding: 8px;
      font-size: 16px;
    }
    input[type="submit"] {
      padding: 8px 12px;
      background: #ec407a;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
  </style>
</head>
<body>

<h2>Hirkani - Day-wise Report</h2>

<div class="date-form">
  <form method="GET">
    <label for="date">Select Date:</label>
    <input type="date" name="date" id="date" value="<?= $today ?>">
    <input type="submit" value="View Report">
  </form>
</div>

<p style="text-align:center;">Date: <strong><?= $today ?></strong></p>

<?php if (count($rows) > 0): ?>
  <table>
    <thead>
      <tr>
        <th>Customer</th>
        <th>Service</th>
        <th>Price (₹)</th>
        <th>Time</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['name']) ?></td>
          <td><?= htmlspecialchars($r['service']) ?></td>
          <td>₹<?= number_format($r['price'], 2) ?></td>
          <td><?= date('h:i A', strtotime($r['appointment_time'])) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <p class="total">Total Income: ₹<?= number_format($total_income, 2) ?></p>
  <a href="?download=pdf&date=<?= $today ?>" class="download-btn" target="_blank">Download PDF Report</a>
<?php else: ?>
  <p style="text-align:center;">No accepted appointments found for this date.</p>
<?php endif; ?>

</body>
</html>
