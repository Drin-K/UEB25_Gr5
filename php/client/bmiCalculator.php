<?php
include("../general/header.php");
include("../general/sidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BMI Calculator</title>
  <link rel="stylesheet" href="../../css/bmiCalculator.css">

</head>
<body>
<div class="container">
  <div class="mbajtsi">
    <h2>Calculate Your BMI</h2>
    <form class="form" method="POST" action="">

      <label for="weight">Weight (kg):</label>
      <input type="number" name="weight" placeholder="Enter your weight" step="0.01" required>

      <label for="height">Height (m):</label>
      <input type="number" name="height" placeholder="Enter your height" step="0.01" required>

      <button class="btn1" type="submit" name="calculateBMI">Calculate BMI</button>
    </form>

    <div id="bmiResult">
      <?php
      if (isset($_POST['calculateBMI']) && isset($_SESSION['user_id']) && isset($_SESSION['name'])) {
          $name    = $_SESSION['name'];
          $user_id = $_SESSION['user_id'];
          $weight  = (float)$_POST["weight"];
          $height  = (float)$_POST["height"];

          if ($weight > 0 && $height > 0) {
              $bmi = round($weight / ($height * $height), 2);
              $category = ($bmi < 18.5) ? "Underweight" :
                          (($bmi < 25) ? "Normal weight" :
                          (($bmi < 30) ? "Overweight" : "Obesity"));

              echo "Hello {$name}, your BMI is {$bmi} ({$category}).";

              $line = date("Y-m-d H:i:s") . "|$user_id|$name|$weight|$height|$bmi|$category\n";
              $file = fopen("../../bmihistory/bmi_logs.txt", "a");
              fwrite($file, $line);
              fclose($file);
          } else {
              echo "<span style='color:red;'>Please enter valid weight and height.</span>";
          }
      }
      ?>
    </div>
  </div>

  <div class="bmi-history">
    <h2>Your BMI History</h2>
    <table>
      <tr>
        <th>Date</th>
        <th>Name</th>
        <th>Weight (kg)</th>
        <th>Height (m)</th>
        <th>BMI</th>
        <th>Category</th>
      </tr>
      <?php
      if (isset($_SESSION['user_id'])) {
          $filePath = "../../bmihistory/bmi_logs.txt";
          if (file_exists($filePath)) {
              $rows = file($filePath, FILE_IGNORE_NEW_LINES| FILE_SKIP_EMPTY_LINES);
              foreach (array_reverse($rows) as $row) {
                  list($date, $uid, $name, $w, $h, $bmi, $cat) = explode("|", $row);
                  if ($uid == $_SESSION['user_id']) {
                      echo "<tr>
                          <td>$date</td>
                          <td>$name</td>
                          <td>$w</td>
                          <td>$h</td>
                          <td>$bmi</td>
                          <td>$cat</td>
                      </tr>";
                  }
              }
          }
      } else {
          echo "<tr><td colspan='6'>Login to view your BMI history.</td></tr>";
      }
      ?>
    </table>
  </div>
</div>
</body>
</html>
