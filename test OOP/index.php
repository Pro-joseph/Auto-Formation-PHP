<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Auth Landing</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
      background: #f5f5f5;
    }

    .card {
      background: #ffffff;
      padding: 28px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      text-align: center;
      width: 320px;
    }

    .card h1 {
      margin-bottom: 16px;
      font-size: 24px;
    }

    .card a {
      display: block;
      margin: 10px 0;
      padding: 10px 14px;
      text-decoration: none;
      color: #fff;
      border-radius: 6px;
    }

    .login {
      background: #1a73e8;
    }

    .register {
      background: #34a853;
    }

    .card p {
      margin: 12px 0 0;
      color: #555;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <div class="card">
    <h1>Welcome</h1>
    <a class="login" href="login_test.php">Login</a>
    <a class="register" href="register_test.php">Register</a>
    <a class="register" style="background:#555;" href="view1.php">View Users</a>
    <p>Click an action to continue.</p>
  </div>
</body>

</html>