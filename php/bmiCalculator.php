<?php
include("header.php");
include("sidebar.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BMI Calculator</title>

  <!-- Your existing CSS -->
  <link rel="stylesheet" href="../css/bmiCalculator.css">
  </head>
  <html>
  <body>
  <div class="mbajtsi">
    <h2>Calculate Your BMI</h2>
    <form class="form" method="POST" action="">
      <label for="userName">Name:</label>
      <input type="text" name="userName" placeholder="Enter your name" required>

      <label for="weight">Weight (kg):</label>
      <input type="number" name="weight" placeholder="Enter your weight" step="0.01" required>

      <label for="height">Height (m):</label>
      <input type="number" name="height" placeholder="Enter your height" step="0.01" required>

      <button class="btn1" type="submit" name="calculateBMI">Calculate BMI</button>
    </form>

    <div id="bmiResult">
      <?php
      if (isset($_POST['calculateBMI'])) {
          $name   = htmlspecialchars($_POST["userName"]);
          $weight = (float)$_POST["weight"];
          $height = (float)$_POST["height"];

          if ($weight > 0 && $height > 0) {
              $bmi = round($weight / ($height * $height), 2);
              if      ($bmi < 18.5) $category = "Underweight";
              elseif  ($bmi < 25)   $category = "Normal weight";
              elseif  ($bmi < 30)   $category = "Overweight";
              else                  $category = "Obesity";

              echo "Hello {$name}, your BMI is {$bmi} ({$category}).";
          } else {
              echo "<span style='color:red;'>Please enter valid weight and height.</span>";
          }
      }
      ?>
    </div>
  </div>

  <!-- your other scripts -->
  <script src="path/to/sidebar.js"></script>
</body>
</html>