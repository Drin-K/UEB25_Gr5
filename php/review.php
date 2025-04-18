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
    <title><?php echo SITE_NAME?></title>
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
</div>
<div class="senvichi">
    <span class="bar"></span>
    <span class="bar"></span>
    <span class="bar"></span>
</div>

</header>

<script src="../javascj/javascript.js"></script>

<section id="review" class="review">
    <div class="review-box">
        <h2 class="heading" data-aos="zoom-in-down">Client Reviews</h2>

        <div class="wrapper" data-aos="zoom-in-up">
            <div class="review-item">

                <h2>John Depp</h2>
                <img src="../fotot1/assets/3.jpg" alt="">
                <div class="rating">
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                </div>
                <p id="1">
                <?php
                // Përdorimi i str_replace për të zëvendësuar fjalët
                $review1 = "Good service with friendly staff and super clean and comfortable gym for everyone from beginners to professional athletes to train at.";
                $review1 = str_replace("Good", "Excellent", $review1); // str_replace()
                echo $review1;
                ?> </p>

              

            </div>
            <div class="review-item">
                <h2>Çamërie Peci</h2>
                <img src="../fotot1/assets/2.jpg" alt="">

                <div class="rating">
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                </div>
                <p id="2">
                <?php
                // Përdorimi i substr për të prerë përshkrimin në një gjatësi të caktuar
                $review2 = "Kjo është një palestër e mrekullueshme e pajisur shumë mirë dhe me të gjitha mundësitë që ofron një ambient modern dhe të rehatshëm për stërvitje. Pajisjet janë të reja dhe të llojllojshme, duke përfshirë makineri për kardio, peshë dhe për trajnime të ndryshme. Përveç kësaj, ka ajër të kondicionuar në të gjithë hapësirën, që siguron një ambient të freskët dhe komod gjatë stërvitjeve. Dhomat e ndërrimit janë shumë të pastra dhe të mirëpajisura, me tualete dhe dushe të cilat janë gjithashtu shumë të rehatshme dhe ofrojnë mundësi për tu ndjerë si në shtëpinë tuaj. Ky është një vend ku çdo anëtar mund të gjejë hapësirën e tij për të stërvitur në mënyrën më të mirë dhe për të shijuar një eksperiencë të plotë të palestrës.";
                $review2 = substr($review2, 0, 200); // substr() - marrim vetëm 100 karaktere
                echo $review2;
                ?></p>


            </div>

            <div class="review-item">
                <h2>Jon Jones</h2>
                <img src="../fotot1/assets/3.jpg" alt="">
                <div class="rating">
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                </div>
                <p id="3">  <?php
                // Përdorimi i trim për të hequr hapësirat e tepërta
                $review3 = "    Plenty of weight and hell even has a climbing rope and kettle bells plus the cardio machines. All     equipment is new. it's clean and the staff friendly. Never busy and honestly I Wish gyms in Australia were to this standard!    ";
                $review3 = trim($review3); // trim() - heq hapësirat e tepërta në fillim dhe fund
                echo $review3;
                ?></p>

               

            </div>

            <div class="review-item">
                <h2>Alice Cooper</h2>
                <img src="../fotot1/assets/4.jpg" alt="">
                <div class="rating">
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                </div>
                <p id="4"> Had a wonderful experience at the gym, very clean, and great facilities!</p>

               

            </div>

            <div class="review-item">
                <h2>Mark Smith</h2>
                <img src="../fotot1/assets/5.jpg" alt="">
                <div class="rating">
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                </div>
                <p id="5">
                <?php
// Përdorimi i explode dhe implode për të krijuar një frazë të thjeshtë me viza
$review5 = "Great place to work out, friendly staff, and very clean!";
$words = explode(", ", $review5); // Përdorim explode për të ndarë fjalët me hapësirë pas çdo presje
$review5 = implode(" | ", $words); // Përdorim implode për të bashkuar fjalët me viza
echo $review5;
?>
                </p>

            </div>

            
            <div class="review-item">
                <h2>Jane Doe</h2>
                <img src="../fotot1/assets/4.jpg" alt="">
                <div class="rating">
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                    <i class='bx bxs-star' id="star"></i>
                </div>
                <p id="6"> Amazing gym with top-notch equipment, welcoming atmosphere, and super friendly trainers!</p>

                



            </div>
        </div>
    </div>
</section>

</body>
</html>
