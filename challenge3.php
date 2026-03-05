
    <?php
//friends with benefits
    $friends = array("hamid" => 300,"khaled" => 200,"rachid" => 60,"oussama" => 90,"said" => 50);
    $total_money_owned = 0;
    $Total_owns_them = 0;

    echo "Kantsall had khotna: " ."\n";
    foreach ($friends as $key => $value){
        if($value >= 100){
        echo  $key . " : " . $value ."DH"."\n";
        $Total_owns_them += $value;
    }
        $total_money_owned += $value;
    }

    echo "Total i own them All: ". $total_money_owned . "DH"."\n";
    echo "Total i own these: ".$Total_owns_them. "DH"."\n";

    ?>
