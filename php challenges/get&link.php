<?php

        $list = [
            "Laptop"=>"tech","PC Bureau"=>"tech","Router"=>"tech","Potato"=>"legume","Tomato"=>"legume","Bossailo"=>"legume"];

        $category = $_GET['category'] ?? null;
        $sort     = $_GET['sort'] ?? 'asc';

        $filtered = [];

        foreach($list as $product => $cat){
            if(!$category || $cat === $category){
                $filtered[] = $product;
            }
        }

        if($sort === 'asc'){
            sort($filtered);
        }else{
            rsort($filtered);
        }

        foreach($filtered as $produit){
            echo $produit . "<br>";
        }

?>


<a href="?category=tech">Tech</a>
<a href="?category=legume">Legume</a>
<a href="?">Home</a>

<br><br>

<a href="?sort=asc">A-Z</a>
<a href="?sort=desc">Z-A</a>
