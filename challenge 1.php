<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $TeaPrix = 10;
    $Teatotal = 7;
    $Discount = 0.20;
    $student = true;

    $QntTea = $TeaPrix * $Teatotal;
    $Discou = $QntTea * $Discount;


    if($student = true){
        
        $Pris = $QntTea - $Discou;
        
    }
    if($Teatotal >= 5){
        $disPertea = $Teatotal * 1 ;
    }
    $total = $Pris - $disPertea;

    echo "Tea ordered: $QntTea DH<br>";
    echo "Discount: 20%: $Discou DH <br>";
    echo "Discount Per Tea: -1 DH: $disPertea DH <br>";
    echo "Tea Bill Total is: $total DH<br>";
    ?>
</body>
</html>