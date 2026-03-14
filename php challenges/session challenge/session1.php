<?php
    session_start();
    $_SESSION['Username']="";
    if(isset($_POST['next'])){
            $_SESSION['Username'] = $_POST["name"];
                header("location: session2.php");
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

    <form action="" class="m-5 b-1" method="POST">
        <div class="mb-3 mt-3">
            <label class="form-label">Enter your name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Full name">
            <button type="submit" class="btn btn-primary m-1" name="next">Next</button>
        </div>    
    </form>
</body>
</html>

