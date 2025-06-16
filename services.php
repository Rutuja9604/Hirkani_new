<?php
include("connect/connection.php");
include("includes/header.php");
$services = $conn->query("SELECT * FROM services ORDER BY category");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Our Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .category-title {
      margin-top: 60px;
      margin-bottom: 30px;
      text-transform: uppercase;
      border-bottom: 3px solid #d81b60;
      display: inline-block;
      padding-bottom: 5px;
      color: #d81b60;
    }
    .service-card {
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .service-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    .service-card img {
      height: 200px;
      object-fit: cover;
      border-top-left-radius: 0.5rem;
      border-top-right-radius: 0.5rem;
    }
    .card-footer {
      background-color: white;
      border-top: none;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <h2 class="text-center mb-5 fw-bold text-primary">Our Services</h2>

  <?php
    $current_category = '';
    while ($row = $services->fetch_assoc()):
      if ($row['category'] !== $current_category):
        if ($current_category !== '') echo '</div>'; // Close previous row
        echo "<h3 class='category-title'>" . htmlspecialchars($row['category']) . "</h3><div class='row g-4'>";
        $current_category = $row['category'];
      endif;
  ?>

    <div class="col-md-3">
      <div class="card service-card h-100 shadow-sm">
        <?php if ($row['image']): ?>
          <img src="<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>">
        <?php endif; ?>
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
          <p class="card-text small text-muted"><?= htmlspecialchars($row['description']) ?></p>
        </div>
        <div class="card-footer text-end">
          <span class="fw-bold text-primary">₹<?= $row['price'] ?></span>
        </div>
      </div>
    </div>

  <?php endwhile; ?>
  </div> <!-- Close last row -->

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
