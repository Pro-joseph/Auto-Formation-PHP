<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .body{
            display: flex;
        }
       .div {
        border: solid;
        margin: 4px;
        padding: 4px;
        width: 220px;
       }
    </style>
</head>
<body class="body">

<!-- challenge 1 -->
    <div class="div">
        <?php
    echo "challenge 1. print from 1 to 10:". "<br>";
    $i = 1;
    while($i < 11){
        echo $i ."<br>";
        $i++;
    }
    ?>
    </div>
    
<!-- challenge 2 -->
     <div class="div">
        <?php
    echo "challenge 2. print from 10 to 1:". "<br>";
    $i = 10;
    while($i > 0){
        echo $i ."<br>";
        $i--;
    }
    ?>
     </div>
<!-- challenge 3 -->
     <div class="div">
        <?php
    echo "Challenge 03: Even Number Detector:". "<br>";
    $bidaya = 1;
    $nihaya = 20;
    $i = $bidaya;
    while($i <= $nihaya){
        
        if($i % 2 == 0){
           echo $i . "<br>";
        } 
        $i++;
    }

    ?>
    </div>

<!-- challenge 4 -->
     <div class="div">
        <?php
    echo "Challenge 04: Even Number Counter:". "<br>";
    $bidaya = 1;
    $nihaya = 50;
    $i = $bidaya;
    $chhal = 0;

    while($i <= $nihaya){
        
        if($i % 2 == 0){
           $chhal++;
           
        } 
        $i++;
    }
    echo "Total even numbers: " . $chhal;
    ?>
    </div>

<!-- challenge 5 -->
     <div class="div">
        <?php
    echo "Challenge 05: Star Printer: ". "<br>";
        $i = 1;
        $a = 10;
        $najma = "*";
        while($i <= $a){
            echo $najma;
            $i++;
        }
         
        ?>
        </div>

<!-- challenge 6 -->
     <div class="div">
        <?php
    echo "Challenge 06: Growing Triangle (Nested Loops):". "<br>";
       for($i = 0; $i <= 9; $i++ ){
            for($a = 0; $a <= $i;$a++){
                echo "*";
            }
            echo "<br>";
       }
         
        ?>
        </div>
</body>
</html>