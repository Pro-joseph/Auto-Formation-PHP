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
<body>
<!-- challenge 1 -->
    <div class="div">
    <?php
        $name = "Joseph";
        function greetUser($name){
            return $name;
        }
        echo "Hello, $name! Ready to code?";
    ?>
    </div>
<!-- challenge 2 -->
    <div class="div">
    <?php
        
        function calculateArea($width, $height){
             return $width * $height;
        }
        $totalArea = calculateArea(10,5);
        echo "The total area is  $totalArea square units.";
    ?>
    </div>
<!-- challenge 3 -->
    <div class="div">
    <?php
        $age = 10;
        function isAdult($age){
                return $age >= 18;
                }
        if (isAdult($age)){
                echo "Access Granted";
            }else{
                echo "Access Denied.";
            }
    ?>
    </div>
<!-- challenge 4 -->
    <div class="div">
    <?php
        function multiplyNumbers($a, $b){
            
            if (is_numeric($a) && is_numeric($b)){
                echo "are numbers $a and $b";
            }else{
                echo "Error: Invalid Input.";
            }
        }
        echo multiplyNumbers(5, 10). "\n";
        echo multiplyNumbers(5, "apple");
    ?>
    </div>

<!-- challenge 5 -->
    <div class="div">
    <?php
        function manualReverse($text){

            $reverse = "";

            for($i = strlen($text) - 1; $i >= 0; $i--){
                $reverse .= $text[$i];
            }

            return $reverse;
        }

        echo manualReverse("Joseph");
    ?>
    </div>
</body>
</html>