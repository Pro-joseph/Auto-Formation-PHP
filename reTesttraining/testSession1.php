<?php
    session_start();

    if(!session_start()){
        $_SESSION["a"] = session_start();
    }else{
        $_SESSION["a"]++;
    }

            




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>counter</title>
</head>
<body>
    <p>You ad this page <?php echo $_SESSION["a"]; ?> times</p>
</body>
</html>