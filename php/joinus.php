
<?php include 'headers.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title><?php echo SITE_NAME?></title>
</head>
<body>
    <a href="index.php" class="logo">ILLYRIAN <span>Gym</span></a>
    
    <div class="bx bx-menu" id="menu-icon"></div>
    
    <header>
        <a href="index.php" class="logo">ILLYRIAN <span>Gym</span></a>
        <div class="bx bx-menu" id="menu-icon"></div>
    </header>
    <section class="join-form-section">
        <div class="form-container">
            <h2>Join the Gym Community</h2>
           
 <form method="POST" action="data_check.php">
<label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>
    
    <label for="surname">Surname:</label>
    <input type="text" id="surname" name="surname" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="phone">PhoneNumber:</label>
    <input type="text" id="phone" name="phone" placeholder="+38344123456"><br><br>

    <label for="birthdate">Birthdate:</label>
    <input type="date" id="birthdate" name="birthdate" required><br><br>

    <label for="bio">Bio:</label>
    <textarea id="bio" name="bio" placeholder="Përshkruaj veten..."></textarea><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="password_2">Confrim Password:</label>
    <input type="password" id="password_2" name="password2" required><br><br>

    <!-- Plani i anëtarësisë -->
    <label for="membership_plan">Choose a membership plan:</label>
    <select id="membership_plan" name="membership_plan">
        <option value="BASIC">BASIC</option>
        <option value="PRO">PRO</option>
        <option value="PREMIUM">PREMIUM</option>
    </select><br><br>

<div id="error-message" style="color: red; margin-bottom: 15px;"></div>

<button type="submit" name="apply">Apply</button>
</form>
        </div>
    </section>
    <style>
        .join-form-section {
            position: relative; 
            background-image: url('../fotot1/GYMBCG.jpg');
            background-repeat: no-repeat; 
            background-attachment: fixed; 
            background-position: center center;
            background-size: cover; 
            padding: 50px; 
            min-height: 100vh; 
        }
        
        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px; 
            padding: 30px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
            max-width: 400px; 
            margin: 0 auto; 
        }
        .radio-container{
            display: flex;
            align-items: center;
            margin-right: 110px;
            display: inline;
        }
        .radio-container input[type="radio"]{
            order: 1;
            margin-right:200px;
            margin-bottom:27px;
        }
        .radio-container label{
            order: 2;
            margin-right: 10px;
        }
        
         
        .join-form-section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
            background-color: #000; 
            min-height: 100vh;
        }
        
        .form-container {
            background-color: #111;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 90%;
            max-width: 500px;
        }
        textarea{
            width: 100%;
            height: 150px;
            padding: 10px;
            font-size: 16px;
            color: white;
            background-color: #222;
            border: 2px solid #ccc;
            border-color: #27ae60; 
            border-radius: 8px;
            box-sizing: border-box;
            transition: border-color 0.3s ease-in-out;
  
        }
        .form-container h2 {
            font-family: -apple-system, sans-serif;
            color: #27ae60; 
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        
        .form-container label {
            font-family: -apple-system, sans-serif;
            display: block;
            color: white;
            font-size: 1.7rem;
            margin: 15px 0 5px;
        }
        
        .form-container input {
            font-family: -apple-system, sans-serif;
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 1.4rem;
            border: 2px solid #359a5f; 
            border-radius: 5px;
            background-color: #222;
            color: white;
        }
        
        .form-container button {
            width: 100%;
            padding: 15px;
            font-size: 1.2rem;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .form-container button:hover {
            background-color: #185531; 
        }
        
        </style>
            
</body>
</html>