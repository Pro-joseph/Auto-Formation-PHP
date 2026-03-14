<?php
    session_start();
    if(isset($_POST['finish'])){
                session_destroy();
                header("location: session1.php");
            }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>servey</title>
</head>
<body>

        <div class="mb-3 mt-3">
            <h2 class="text-primary text-center" >Thank You For Participating</h2>
            <p class="text-center">Hi <b><?php echo $_SESSION['Username']; ?></b>, Thank you for sharing your Favorit Programming language <b><?php echo $_SESSION["Favorite Programming Language"]; ?></b> with us.</p>
        </div> 
        <form action="" class="m-5 b-1" method="POST">
        <div class="mb-3 mt-3 d-grid gap-2">
            <button type="submit" class="btn btn-primary m-1 " name="finish">Finish</button>
        </div>    
    </form>   
</body>
</html>

