<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Futuristic Login</title>
  <style>
    body {
      margin: 0;
      height: 100vh;
      background: #000; /* e zezë */
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .login-container {
      background: rgba(0, 255, 170, 0.05); /* greenish-blue glass effect */
      border: 1px solid rgba(0, 255, 170, 0.2);
      box-shadow: 0 0 15px rgba(0, 255, 170, 0.3);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 40px;
      width: 300px;
      text-align: center;
      animation: floatIn 1.2s ease-out;
    }

    h1 {
      color: #00ffaa;
      margin-bottom: 30px;
      text-shadow: 0 0 10px #00ffaa;
    }

    label {
      display: block;
      margin-bottom: 5px;
      color: #00ffaa;
      text-align: left;
      font-weight: bold;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: none;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.05);
      color: #00ffaa;
      outline: none;
      box-shadow: inset 0 0 5px #00ffaa;
    }

    input[type="submit"] {
      width: 100%;
      padding: 10px;
      background: #00ffaa;
      color: #000;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s;
    }

    input[type="submit"]:hover {
      background: #00e6b8;
      box-shadow: 0 0 10px #00ffaa, 0 0 20px #00ffaa;
    }

    @keyframes floatIn {
      from {
        opacity: 0;
        transform: translateY(50px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h1>Login Form</h1>
    <h4 style="color:#00ffaa;">
      <?php
      error_reporting(0);
      session_start();
      session_destroy();
      echo $_SESSION['loginMessage'];
      ?>
    </h4>
    <form action="login_check.php" method="POST">
      <div>
        <label for="username">Username</label>
        <input type="text" id="username" name="username">
      </div>
      <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
      </div>
      <div>
        <input type="submit" value="Login">
      </div>
    </form>
  </div>
</body>
</html>
