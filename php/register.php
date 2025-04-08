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
?>