<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $age = 90;

    if($age <= 12 ){
        echo "the price is 20 DH"."<br>";
        echo "Special: Children's Menu included!";
    }elseif($age = range(12, 18)){
        echo "the price is 40 DH";
    }elseif($age >= 60){
        echo "the price is 30 DH (Senior discount)";
    }else{
        echo "the price is 60 DH";
    }


    ?>
</body>
</html>