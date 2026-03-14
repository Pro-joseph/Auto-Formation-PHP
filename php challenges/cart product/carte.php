<?php
    session_start();

//     foreach($_SESSION['carti'] as $carta){
//      $carta;
// }

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
    <h4 class="text-center ">products in carts are : <?php foreach($_SESSION['cartw'] as $key){ echo $key . ' - '  ; }  " - ";?></h4>
</body>
</html>