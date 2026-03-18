<?php
if (session_status() === PHP_SESSION_NONE) session_start(); 

require_once '../controller/auth.php';
require_once '../model/db.php';        

include('../include/header.php');
include('../controller/add_asset.php');




// fetch data category name
$sql = "SELECT a.*, c.name AS category_name
        FROM assets a
        INNER JOIN categories c ON a.category_id = c.id";

$stmt = $conn->prepare($sql);
$stmt->execute();
$assets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// fetch data category id
$sql = "SELECT * FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();

$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


// financial agregation
$sql = "SELECT SUM(price) AS total_cost FROM assets";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pricetotal = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(*) AS stock FROM assets WHERE status = 'In Stock'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stock = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(*) AS in_repair FROM assets WHERE status = 'Under Repair'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$in_repair = $stmt->fetch(PDO::FETCH_ASSOC);


$sql = "SELECT COUNT(*) AS deployed FROM assets WHERE status = 'Deployed'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$deployed = $stmt->fetch(PDO::FETCH_ASSOC);

// search bar

$search = $_GET['search'] ?? '';

if (!empty($search)) {
    $sql = "SELECT a.*, c.name AS category_name
            FROM assets a
            INNER JOIN categories c ON a.category_id = c.id
            WHERE a.device_name LIKE :search
               OR a.serial_number LIKE :search";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'search' => "%$search%"
    ]);
} else {
    $sql = "SELECT a.*, c.name AS category_name
            FROM assets a
            INNER JOIN categories c ON a.category_id = c.id";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

$assets = $stmt->fetchAll(PDO::FETCH_ASSOC);

 if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show m-3 w-25 h-100" role="alert">
        <?= $_SESSION['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show m-3 w-25 h-100" role="alert">
        <?= $_SESSION['error']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(function(alert) {
      setTimeout(function() {
        alert.classList.remove('show');
        alert.classList.add('hide');
        setTimeout(() => alert.remove(), 500);
      }, 3000); 
    });
  });
</script>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>home</title>
</head>
<body>
    <h3 class="text-center m-3 p-1">GEARLOG DASHBOARD</h3>
<!-- statistics -->
    <div class="container mt-4">

  <div class="row g-4">
    <div class="col-md-3">
      <div class="card shadow h-100">
        <div class="card-body bg-primary text-white text-center">
          <i class="bi bi-cash-coin fs-1"></i>
          <h5 class="mt-2">Total Cost</h5>
          <h4><?= $pricetotal['total_cost'] ?> DH</h4>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card shadow h-100">
        <div class="card-body bg-warning text-white text-center">
          <i class="bi bi-house-gear-fill fs-1"></i>
          <h5 class="mt-2">Stock</h5>
          <h4><?= $stock['stock'] ?></h4>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card shadow h-100">
        <div class="card-body bg-danger text-white text-center">
          <i class="bi bi-repeat fs-1"></i>
          <h5 class="mt-2">In Repair</h5>
          <h4><?= $in_repair['in_repair'] ?></h4>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card shadow h-100">
        <div class="card-body bg-success text-white text-center">
          <i class="bi bi-person-workspace fs-1"></i>
          <h5 class="mt-2">Deployment</h5>
          <h4><?= $deployed['deployed'] ?></h4>
        </div>
      </div>
    </div>

  </div>

</div>
<!-- statiscts -->
 <!-- button form and search bar -->
        <div class="container">
          <button class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#addProductModal"><i class="bi bi-laptop"></i>Add Device</button>
          <div class="modal fade" id="addProductModal">
              <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Add Product</h5>
                  <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                  <div class="m-2 text-danger"><h6>* Attention. All fieldes must be entre or nothing will be saved</h6></div>
                <div class="modal-body">

                  <form action="" method="POST">

                    <div class="mb-3">
                      <label class="form-label">Device Name</label>
                      <input type="text" name="device_name" class="form-control">
                      <!-- <span class="text-danger"><?= $device_nameErr ?></span> -->
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Serial Number</label>
                      <input type="text" name="serial_number" class="form-control">
                      <!-- <span class="text-danger"><?= $serial_numberErr ?></span> -->
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Price</label>
                      <input type="number" step="0.01" name="price" class="form-control">
                      <!-- <span class="text-danger"><?= $priceErr ?></span> -->
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Status</label>
                      <select name="status" class="form-control">
                        <option>In Stock</option>
                        <option>Deployed</option>
                        <option>Under Repair</option>
                      </select>
                      <label class="form-label">Category</label>
                      <select name="categories_id" class="form-control">
                        <?php foreach ($categories as $cat): ?>
                          <option value="<?php echo $cat['id']; ?>">
                              <?php echo htmlspecialchars($cat['name']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <button class="btn btn-success w-100">Save Device</button>
                </form>
      </div>
    </div>
  </div>
</div>
        
          
<div class="container">
  <table class="table table-hover table-striped border shadow-sm ">
          <thead>
            <tr>
              <th scope="col">id</th>   
              <th scope="col">Device name</th>
              <th scope="col">Serial number</th>
              <th scope="col">price</th>
              <th scope="col">category</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>   
            <?php foreach ($assets as $asset): ?>
            <tr>
                <td><?php echo $asset['id']; ?></td>
                <td><?php echo htmlspecialchars($asset['device_name']); ?></td>
                <td><?php echo htmlspecialchars($asset['serial_number']); ?></td>
                <td><?php echo htmlspecialchars($asset['price']. " DH"); ?></td>
                <td><?= htmlspecialchars($asset['category_name']) ?></td>
                <td><?php echo htmlspecialchars($asset['status']); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
  </table>  

            </div>




</body>
</html>