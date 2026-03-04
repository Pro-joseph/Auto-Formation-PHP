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
        $Total = $Pris - 1 ;
    }
    

    echo "Tea ordered: $QntTea DH"."<br>";
    echo "Discount 20%: $Discou DH"."<br>";
    echo "Tea Bill: $Pris DH"."<br>";
    echo "Discount For more than 5 orders: 1 DH:"."<br>";
    echo "Tea Bill Total is: $Total DH"."<br>";

    ?>
</body>
</html>