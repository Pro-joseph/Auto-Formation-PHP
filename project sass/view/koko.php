 // fetch data category id
$sql = "SELECT * FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();

$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
 
 
 
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
        


