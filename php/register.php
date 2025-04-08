<?php
function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Fillimisht, inicializo gabimet
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Merr dhe pastro të gjitha fushat
    $name = validate_input($_POST["name"] ?? '');
    $surname = validate_input($_POST["surname"] ?? '');
    $email = validate_input($_POST["email"] ?? '');
    $phone = validate_input($_POST["phone"] ?? '');
    $bio = validate_input($_POST["bio"] ?? '');
    $password = $_POST["password"] ?? '';
    $password2 = $_POST["password2"] ?? '';
    $human = isset($_POST["human-check"]);
    $birthdate = validate_input($_POST["birthdate"] ?? '');

    // ======================
    // VALIDIMET ME REGEX
    // ======================

    // 1. Emri dhe Mbiemri – vetëm shkronja
    if (!preg_match("/^[a-zA-Z]+$/", $name)) {
        $errors[] = "Name must contain only letters.";
    }

    if (!preg_match("/^[a-zA-Z]+$/", $surname)) {
        $errors[] = "Surname must contain only letters.";
    }

    // 2. Email – format korrekt
    if (!preg_match("/^[\w\.-]+@[\w\.-]+\.\w+$/", $email)) {
        $errors[] = "Invalid email format.";
    }

    // 3. Numri i telefonit – format +383XXXXXXXX
    if (!preg_match("/^\+383\d{2}\d{3}\d{3}$/", $phone)) {
        $errors[] = "Phone number must be in format +383XXXXXXXX.";
    }
      // 4. Validim i fjalëkalimeve
      if (empty($password) || empty($password2)) {
        $errors[] = "Password fields cannot be empty.";
    } elseif ($password !== $password2) {
        $errors[] = "Passwords do not match.";
    }

    // 5. Kontrolli nëse është klikur "human-check"
    if (!$human) {
        $errors[] = "Please confirm you are human.";
    }

    // Validimi i datës me RegEx (YYYY-MM-DD)
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $birthdate)) {
        $errors[] = "Invalid birthdate format. Please use YYYY-MM-DD.";
    }

    // ======================
    // MANIPULIME ME REGEX
    // ======================

    // a. Ndarja e numrave në bio me '-'
    $bio = preg_replace("/\d+/", "-$0-", $bio); // shembull: 123 bëhet -123-

    // b. Pastrim nga simbolet speciale në bio (përveç pikës dhe presjes)
    $bio = preg_replace("/[^a-zA-Z0-9\s\.,\-]/", "", $bio);

    // ======================
    // NËSE KA GABIME
    // ======================
    if (!empty($errors)) {
        echo "<div class='error-messages'><h2>Please fix the following errors:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul><a href='javascript:history.back()'>Go Back</a></div>";
    } else {
        // Data aktuale për regjistrim
        $registrationDate = date("Y-m-d H:i:s");

        echo "<div class='success-message'><h2>Thank you for joining, $name $surname!</h2>";
        echo "<br><br>";
        echo "<p><strong>Email:</strong> $email</p><br>";
        echo "<p><strong>Phone:</strong> $phone</p><br>";
        echo "<p><strong>Bio:</strong> $bio</p><br>";
        echo "<p><strong>Birthdate:</strong> $birthdate</p><br>";
        echo "<p><strong>Registered on:</strong> $registrationDate</p></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>Form Submission</title>
</head>

  <style>
body {
  font-family: Arial, sans-serif;
  background-color: #000;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh; /* Përdorim të gjithë lartësinë e ekranit */
}



h2 {
  text-align: center;
  font-size:30px;
}

.error-messages {
  background-color:aquamarine;
  color: darkred;
  padding: 15px;
  height:300px;
  border-radius: 5px;
  font-size:15px;
}

.success-message {
  background-color:aquamarine;
  color: #222;
  padding: 15px;
  height:300px;
  border-radius: 5px;
}


ul {
  list-style-type: none;
  padding: 0;
}

li {
  margin: 5px 0;
}

a {
  text-decoration: none;
  color: #007bff;
  font-weight: bold;
}

a:hover {
  text-decoration: underline;
}

p {
  font-size: 16px;
}

strong {
  font-weight: bold;
}

  </style>
</head>
<body>

    <header>
        <a href="index.php" class="logo">ILLYRIAN <span>Gym</span></a>
        <div class="bx bx-menu" id="menu-icon"></div>
    </header>


</body>
</html>
