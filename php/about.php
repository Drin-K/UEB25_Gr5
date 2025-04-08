<?php
include 'headers.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <title>ILLYRIAN Gym</title>
</head>

<body>
    <header>
        <a href="index.php" class="logo">ILLYRIAN <span>Gym</span></a>

        <div class="bx bx-menu" id="menu-icon"></div>

        <ul class="navbar">
        <?php echo generateMenu($menu_items, basename($_SERVER['PHP_SELF']));?>
        </ul>

        <div class="top-btn">
            <a href="joinus.php" class="nav-btn">Join Us</a>
        </div>
        <div class="senvichi">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <script src="../javascj/javascript.js"></script>
       
    </header>

    <section id="about" class="about">
        <div class="about-img" data-aos="zoom-in-down">
            <img src="../fotot1/whychooseus.jpg" alt="">
        </div>
    
        <div class="about-content" data-aos="zoom-in-up">
            <h2 class="heading">Why Choose Us?</h2>
            <p>Our diverse membership base creates a <u>friendly and supportive atmosphere</u>, where you can make friends and
                stay motivated.</p>
            <p>Unlock your potential with our expert Personal Trainers.</p>
            <p>Elevate your fitness with practice sessions.</p>
            <p>We provide Supportive management, for your fitness success.</p>
            <a href="joinus.php" class="btn">Book A Free Class</a><br><br><br><br><br><br>
            <b><p id= problem style="font-size: 3rem;">Have a problem ?</p></b>
            <p id = 'linku'style="font-size: large;">
                <a href="mailto:name@email.com" style="color: rgb(20, 145, 57);">Contact Us</a>
              </p>          
        </div>
    
        <div class="adresa">
            <address>
              <b><mark style="background-color: rgb(0, 0, 0);font-family:'Courier New', Courier, monospace;  border-radius: 0.7rem;color:rgb(113, 100, 100) ;"> Kosova</mark></b>
            </address>
        </div>
        
    </section>


    </body>
       
    
</section>
