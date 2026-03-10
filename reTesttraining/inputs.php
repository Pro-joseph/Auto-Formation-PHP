<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketing System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body class="p-4">

    <form method="GET">
    <div class="mb-3 mt-3">
      <label for="age">Your age</label>
      <input type="number" class="form-control" id="age" placeholder="Enter age" name="age">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
    <?php
    if(isset($_GET['age'])){

    $age = $_GET['age'];

    if($age <= 12 ){
        echo "the price is 20 DH"."<br>";
        echo "Special: Children's Menu included!";
    }elseif($age > 12 && $age <= 18){
        echo "the price is 40 DH";
    }elseif($age >= 60){
        echo "the price is 30 DH (Senior discount)";
    }else{
        echo "the price is 60 DH";
    }

    }
    


    ?>
</body>
</html>