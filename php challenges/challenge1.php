<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $Tea_Prix = 10;
    $Tea_ordered = 9;
    $Discount = 0.20;
    $client = "Student" || "Particulier";
//oprations
    $Tea_Total = $Tea_Prix * $Tea_ordered;
    $Discount_Student = $Tea_Total * $Discount;

//student
    if($client = "Student"){
        
        $Prix_Student = $Tea_Total - $Discount_Student;
        
    }
//particuler
        $Prix_parti = $Tea_Total;

//Every 5 teas for student
    $More_five = $Tea_ordered / 5;
    
    if($Tea_ordered >= 5){
        $Total_Student = $Prix_Student - intval($More_five);
    }
// for particuler
        $Total_parti = $Prix_parti - intval($More_five);

    
    echo "Tea ordered: $Tea_Total DH"."<br>";
    echo "Discount 20%: $Discount_Student DH"."<br>";
    echo "Tea Bill: $Prix_Student DH"."<br>";
    echo "Discount For more than 5 orders:".intval($More_five) ." DH:"."<br>";
    echo "Tea Bill Total For student is: $Total_Student DH"."<br>";
    echo "Tea Bill Total For Particuler is: $Total_parti DH"."<br>";


    ?>
</body>
</html>