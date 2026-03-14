<?php
    session_start();

    if(!isset( $_SESSION['cartw'])){
         $_SESSION['cartw'] = [];
    }
     if(isset($_POST['add'])){
         $produit = $_POST['add'];
         if(!in_array($produit, $_SESSION['cartw'])){
            $_SESSION['cartw'] []= $produit;
         }
         header('location: AddtoCart.php');
        
    }

$counters = count($_SESSION['cartw']);

var_dump($_SESSION['cartw']);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cart</title>
</head>
<body>
    <div class="p-5" >
        <button class="btn btn-danger" name="cart"><a href="carte.php" class="text-decoration-none link-light">cart <?php echo $counters ?></a></button>
    </div>
    <form class="m-5 p-2 d-inline-flex" method="POST">
        <div class="card center m-2" style="width: 18rem;">
            <img class="card-img-top w-70 p-3" src="tomato.jpg" alt="Card image cap">
            <div class="card-body d-grid gap-2">
                <h5 class="card-title text-center">Tomato</h5>
                <button class="btn btn-primary " name="add" value='Tomato'>Add to cart</button>
            </div>
        </div>
        <div class="card center m-2" style="width: 18rem;">
            <img class="card-img-top w-70 p-3" src="iphone.jpg" alt="Card image cap">
            <div class="card-body d-grid gap-2" >
                <h5 class="card-title text-center">iphone 20</h5>
                <button class="btn btn-primary " name="add" value='iphone'>Add to cart</button>
            </div>
        </div>
        <div class="card center m-2" style="width: 18rem;">
            <img class="card-img-top w-70 p-3" src="tofaha.jpg" alt="Card image cap">
            <div class="card-body d-grid gap-2">
                <h5 class="card-title text-center">tofaha</h5>
                <button class="btn btn-primary " name="add" value='tofaha'>Add to cart</button>
            </div>
        </div>
</form>
</body>
</html>