<?php
require_once 'db.php'; 

try {
    $queries = [

        "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'client') NOT NULL DEFAULT 'client',
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        )",

        "CREATE TABLE IF NOT EXISTS memberships (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            price DECIMAL(6,2) NOT NULL
        )",

        "CREATE TABLE IF NOT EXISTS workout_plans (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usage_count INT DEFAULT 0,
            user_id INT NOT NULL,
            title VARCHAR(100) NOT NULL,
            description TEXT,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )",

        "CREATE TABLE IF NOT EXISTS payments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            numri_bankes VARCHAR(15) NOT NULL,
            payment_date DATE NOT NULL,
            method VARCHAR(50) NOT NULL,
            id_membership INT NOT NULL,
            status ENUM('active','expired') NOT NULL DEFAULT 'active',
            FOREIGN KEY (id_membership) REFERENCES memberships(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )",

        "CREATE TABLE IF NOT EXISTS nutrition_plans (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            description TEXT,
            calories INT,
            protein INT,
            carbs INT,
            fats INT,
            category ENUM('weight_loss', 'muscle_gain', 'maintenance') NOT NULL
        )",

        "CREATE TABLE IF NOT EXISTS user_nutrition_preferences (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            preferred_calories INT,
            dietary_restrictions VARCHAR(255),
            favorite_meals VARCHAR(255),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )"
    ];

    foreach ($queries as $query) {
        $conn->exec($query);
    }

    echo "Tabelat u krijuan me sukses nëse nuk ekzistonin më parë!";
} catch (PDOException $e) {
    echo "Gabim në krijimin e tabelave: " . $e->getMessage();
}
?>
