<?php
// Demo Mode: Mock Data
$pricetotal = ['total_cost' => 125000];
$stock = ['stock' => 45];
$in_repair = ['in_repair' => 5];
$deployed = ['deployed' => 70];

$assets = [
    ['id' => 1, 'device_name' => 'MacBook Pro 16"', 'serial_number' => 'MBP16001', 'price' => 25000, 'category_name' => 'Laptops', 'status' => 'Deployed'],
    ['id' => 2, 'device_name' => 'Dell XPS 15', 'serial_number' => 'DXPS15002', 'price' => 18000, 'category_name' => 'Laptops', 'status' => 'In Stock'],
    ['id' => 3, 'device_name' => 'iPhone 15 Pro', 'serial_number' => 'IP15P003', 'price' => 12000, 'category_name' => 'Phones', 'status' => 'In Stock'],
    ['id' => 4, 'device_name' => 'Samsung S24 Ultra', 'serial_number' => 'S24U004', 'price' => 11000, 'category_name' => 'Phones', 'status' => 'Under Repair'],
    ['id' => 5, 'device_name' => 'Logitech MX Master 3', 'serial_number' => 'LMXM3005', 'price' => 1200, 'category_name' => 'Accessories', 'status' => 'Deployed'],
    ['id' => 6, 'device_name' => 'Dell 27" Monitor', 'serial_number' => 'D27M006', 'price' => 3500, 'category_name' => 'Monitors', 'status' => 'In Stock'],
];

include('../include/header.php');
?>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Demo Mode: Alerts removed
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