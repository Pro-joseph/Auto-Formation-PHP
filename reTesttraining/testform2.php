<?php

    $products = [
        ["name"=>"Laptop","category"=>"tech","price"=>900],
        ["name"=>"Phone","category"=>"tech","price"=>600],
        ["name"=>"Table","category"=>"furniture","price"=>150],
        ["name"=>"Chair","category"=>"furniture","price"=>80],
        ["name"=>"Headphones","category"=>"tech","price"=>120]
        ];

    $category = $_GET['category'] ?? null;
    $sort = $_GET['sort'] ?? 'asc';
    $maxprice = $_GET['maxprice'] ?? null;

    $filter_products = [];

    foreach($products as $key){
        if(!$category || $category === $key['category']){
            if(!$maxprice || $key['price'] <= $maxprice){
            $filter_products[] = $key;
        }
        }
    }

    if($sort === 'asc'){
        sort($filter_products);
    }else{
        rsort($filter_products);
    }

    // usort($filter_products, function($a,$b){
    //     return $a['price'] <=> $b['price'];
    // });

    

    foreach($filter_products as $product){
    echo $product['name'] . " - " . $product['category'] . " - $" . $product['price'] . "<br>";
}

?>
<a href=?>home</a>
<a href=?category=tech>tech</a>
<a href=?category=furniture>furniture</a>

<a href=?maxprice=200>only under 200 DH</a>
<a href=?sort=asc>A > Z</a>
<a href=?sort=desc>Z > A</a>