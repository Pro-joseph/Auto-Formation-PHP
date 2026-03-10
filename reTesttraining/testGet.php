<?php

    $Fruits = ["banana" => "yellow","apple" => "yellow","ananas" => "green","watermellon" => "green",];

    $colors = $_GET["color"] ?? null;
    $sort = $_GET["sort"] ?? "asc";
    $sort = $_GET["sort"] ?? "desc";

    $alwan = [];
    foreach($Fruits as $product => $color){
        if(!$colors || $colors === $color){
            $alwan[] = $product;
        }
    }

    if($sort === "asc"){
        sort($alwan);
    }else{
        rsort($alwan);
    }

    foreach($alwan as $co){
        echo $co ."<br>";
    }


?>

<a href="?color=yellow">yellow</a>
<a href="?color=green">green</a>
<a href="?">home</a>
<a href="?sort=asc">asc</a>
<a href="?sort=desc">desc</a>