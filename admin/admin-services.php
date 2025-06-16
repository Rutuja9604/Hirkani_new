<?php
include("../connect/connection.php");

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete image file
    $res = $conn->query("SELECT image FROM services WHERE id = $id");
    $data = $res->fetch_assoc();
    if ($data && !empty($data['image']) && file_exists("../" . $data['image'])) {
        unlink("../" . $data['image']);
    }

    $conn->query("DELETE FROM services WHERE id = $id");
    header("Location: admin-services.php");
    exit();
}

// Handle addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $imgPath = '';
    if (!empty($_FILES['image']['name'])) {
        $imgName = basename($_FILES['image']['name']);
        $imgTmp = $_FILES['image']['tmp_name'];
        $imgPath = "uploads/" . $imgName;

        $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
        if (in_array($_FILES['image']['type'], $allowed_types)) {
            move_uploaded_file($imgTmp, "../" . $imgPath);
        } else {
            echo "<script>alert('Only JPG, PNG, and WEBP images are allowed.');</script>";
            $imgPath = '';
        }
    }

    $stmt = $conn->prepare("INSERT INTO services (category, name, description, price, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssds", $category, $name, $desc, $price, $imgPath);
    $stmt->execute();
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $imgPath = $_POST['existing_image'];
    if (!empty($_FILES['image']['name'])) {
        $imgName = basename($_FILES['image']['name']);
        $imgTmp = $_FILES['image']['tmp_name'];
        $imgPath = "uploads/" . $imgName;

        $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
        if (in_array($_FILES['image']['type'], $allowed_types)) {
            move_uploaded_file($imgTmp, "../" . $imgPath);
        } else {
            echo "<script>alert('Only JPG, PNG, and WEBP images are allowed.');</script>";
            $imgPath = $_POST['existing_image'];
        }
    }

    $stmt = $conn->prepare("UPDATE services SET category=?, name=?, description=?, price=?, image=? WHERE id=?");
    $stmt->bind_param("sssdsi", $category, $name, $desc, $price, $imgPath, $id);
    $stmt->execute();
}

$services = $conn->query("SELECT * FROM services");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f4f6f9; }
    .image-preview { height: 50px; }
    .form-control { font-size: 0.9rem; }
  </style>
  <script>
    function previewImage(input, previewId) {
      const file = input.files[0];
      const preview = document.getElementById(previewId);
      if (file && preview) {
        const reader = new FileReader();
        reader.onload = e => {
          preview.src = e.target.result;
          preview.style.display = "block";
        };
        reader.readAsDataURL(file);
      }
    }
  </script>
</head>
<body>

<div class="container py-4">
  <h2 class="text-center text-primary mb-4">Manage Services</h2>

  <div class="card p-4 shadow-sm mb-4">
    <h5 class="text-secondary mb-3">Add New Service</h5>
    <form method="POST" enctype="multipart/form-data" class="row g-2 align-items-center">
      <div class="col-md-2">
        <input type="text" name="category" placeholder="Category" required class="form-control">
      </div>
      <div class="col-md-2">
        <input type="text" name="name" placeholder="Name" required class="form-control">
      </div>
      <div class="col-md-3">
        <input type="text" name="description" placeholder="Description" class="form-control">
      </div>
      <div class="col-md-2">
        <input type="number" name="price" placeholder="Price" required class="form-control">
      </div>
      <div class="col-md-2">
        <input type="file" name="image" accept="image/*" class="form-control" onchange="previewImage(this, 'addPreview')">
        <img id="addPreview" src="#" style="display:none; height:50px;" class="mt-1">
      </div>
      <div class="col-md-1">
        <button type="submit" name="add" class="btn btn-success w-100">Add</button>
      </div>
    </form>
  </div>

  <div class="card p-4 shadow-sm">
    <div class="d-flex justify-content-between mb-3">
      <h5 class="text-secondary">Existing Services</h5>
      <div>
        <button class="btn btn-outline-danger btn-sm" onclick="exportPDF()">Export PDF</button>
        <button class="btn btn-outline-success btn-sm" onclick="exportExcel()">Export Excel</button>
      </div>
    </div>

    <div class="table-responsive">
      <table id="serviceTable" class="table table-bordered align-middle table-hover">
        <thead class="table-dark text-center">
          <tr>
            <th>Category</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = $services->fetch_assoc()): ?>
          <tr>
            <form method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <input type="hidden" name="existing_image" value="<?= $row['image'] ?>">
              <td><input name="category" value="<?= htmlspecialchars($row['category']) ?>" class="form-control"></td>
              <td><input name="name" value="<?= htmlspecialchars($row['name']) ?>" class="form-control"></td>
              <td><input name="description" value="<?= htmlspecialchars($row['description']) ?>" class="form-control"></td>
              <td><input type="number" name="price" value="<?= $row['price'] ?>" class="form-control"></td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <input type="file" name="image" class="form-control mb-1" onchange="previewImage(this, 'preview<?= $row['id'] ?>')">
                  <img id="preview<?= $row['id'] ?>" src="../<?= htmlspecialchars($row['image']) ?>" alt="Preview" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                </div>
              </td>
              <td class="text-center">
                <button name="update" class="btn btn-sm btn-primary">Update</button>
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this service?')" class="btn btn-sm btn-danger">Delete</a>
              </td>
            </form>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
  function exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    doc.autoTable({ html: '#serviceTable' });
    doc.save('services.pdf');
  }

  function exportExcel() {
    const table = document.getElementById("serviceTable");
    const wb = XLSX.utils.table_to_book(table, { sheet: "Services" });
    XLSX.writeFile(wb, "services.xlsx");
  }
</script>

</body>
</html>
