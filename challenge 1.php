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
    $Teatotal = 20;
    $Discount = 0.20;
    $student = true;
//oprations
    $QntTea = $TeaPrix * $Teatotal;
    $Discou = $QntTea * $Discount;

//student
    if($student = true){
        
        $Pris = $QntTea - $Discou;
    }
//Every 5 teas
    $More_five = $Teatotal / 5;
    if($Teatotal >= 5){
        $Total = $Pris - intval($More_five) ;
    }
    

    echo "Tea ordered: $QntTea DH"."<br>";
    echo "Discount 20%: $Discou DH"."<br>";
    echo "Tea Bill: $Pris DH"."<br>";
    echo "Discount For more than 5 orders:".intval($More_five) ." DH:"."<br>";
    echo "Tea Bill Total is: $Total DH"."<br>";

    ?>
</body>
</html>