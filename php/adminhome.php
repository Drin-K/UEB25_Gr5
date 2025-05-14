<?php
session_start();
if(!isset($_SESSION['username'])){
header("location:login.php");
}elseif($_SESSION['usertype']=='user'){
header("location:login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: #000; /* Sfondi i zi */
      color: #00ffaa;
      display: flex;
      height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      background: rgba(0, 255, 170, 0.05);
      border-right: 1px solid rgba(0, 255, 170, 0.2);
      box-shadow: 0 0 10px rgba(0, 255, 170, 0.2);
      backdrop-filter: blur(12px);
      padding-top: 80px;
      position: fixed;
      height: 100%;
    }

    .sidebar ul {
      list-style: none;
      padding: 20px;
    }

    .sidebar li {
      padding: 15px;
      margin-bottom: 10px;
      border-radius: 8px;
      cursor: pointer;
      color: #00ffaa;
      transition: background 0.3s, transform 0.2s;
    }

    .sidebar li:hover {
      background: rgba(0, 255, 170, 0.15);
      box-shadow: 0 0 8px #00ffaa;
      transform: translateX(5px);
    }

    /* Header */
    .header {
      position: fixed;
      top: 0;
      left: 250px;
      right: 0;
      height: 60px;
      background: rgba(0, 255, 170, 0.05);
      backdrop-filter: blur(12px);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 30px;
      box-shadow: 0 2px 10px rgba(0, 255, 170, 0.15);
      z-index: 1000;
    }

    .header h1 {
      font-size: 24px;
      color: #00ffaa;
      text-shadow: 0 0 10px #00ffaa;
    }

    .logout-btn {
      background: #00ffaa;
      border: none;
      padding: 8px 16px;
      border-radius: 6px;
      color: #000;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    .logout-btn:hover {
      background: #00e6b8;
      box-shadow: 0 0 10px #00ffaa;
    }

    /* Main Content */
    .main-content {
      margin-left: 250px;
      padding: 100px 30px 30px 30px;
      color: #ccffee;
    }

    .main-content h2 {
      font-size: 28px;
      color: #00ffaa;
      margin-bottom: 20px;
      text-shadow: 0 0 8px #00ffaa;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <ul>
      <li>Users Management</li>
      <li>Membership Plans</li>
      <li>Workouts</li>
      <li>Diets & Foods</li>
      <li>Services</li>
      <li>Reviews</li>
      <li>BMI Logs</li>
    </ul>
  </div>

  <!-- Header -->
  <div class="header">
    <h1>Admin Dashboard</h1>
    <form action="logout.php" method="POST">
      <button type="submit" class="logout-btn">Logout</button>
    </form>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <h2>Welcome to the Admin Panel</h2>
    <p>Select an option from the sidebar to manage content.</p>
  </div>

</body>
</html>
