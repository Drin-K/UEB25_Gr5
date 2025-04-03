<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>ILLYRIAN Gym</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script> 
</head>

<body>
    <header>
        <a href="index.html" class="logo">ILLYRIAN <span>Gym</span></a>
        <div class="bx bx-menu" id="menu-icon"></div>
        <ul class="navbar">
            <li><a href="index.html" style="color:aquamarine;  border-bottom: 3px solid var(--main-color);">Home</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="diet.html">Diet</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="plans.html">Pricing</a></li>
            <li><a href="Workouts.html">Workouts</a></li>
            <li><a href="review.html">Review</a></li>
        </ul>
        <div class="top-btn">
            <a href="joinus.html" class="nav-btn">Join Us</a>
        </div>
        <div class="senvichi">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
    </header>

    <section id="home" class="home">
        <div class="home-content">
            <h1>Build Your</h1>
            <h1>Dream Physique</h1>
            <div class="text">
                <h3> <span class="multiple-text"><b>Welcome</b></span></h3>
            </div>
            <p>“Take care of your body. It’s the only place you have to live.” <br>
                <abbr title="High-intensity interval training">HIIT</abbr></p>
            <a href="joinus.html" class="btn">Join Us</a>
        </div>

        <div class="home-img">
            <img src="../fotot1/image.png" alt="HeroImage">
        </div>
    </section>
    <footer class="footer">
        <div class="social">
            <a href="https://www.instagram.com" target="_blank"><img src="../fotot1/instagram.jpg"></img></a>
            <a href="https://www.facebook.com" target="_blank"><img src="../fotot1/facebook.jpg"></img></a>
            <a href="https://www.linkedin.com" target="_blank"><img src="../fotot1/linkedin.jpg"></img></a>
        </div>

        <p class="copyright">
            &copy; <i>ILLYRIAN Gym 2024 - All Rights Reserved</i>
        </p>
    </footer>
    <script src="../javascj/javascript.js"></script>
    <script>
        $(document).ready(function(){
            $("h3").click(function(){
                $("p").slideToggle();
            });
            $(".social a").click(function(event){
                var link = $(this).attr("href");
                var confirmation = confirm("Would you like to continue to the site?");
                if (confirmation) {
                    alert(link);
                } else {
                    event.preventDefault();
                }
            });
            $(".btn").hover(function(){
                $(this).text("Click me!");
            });
            $(".btn").mouseleave(function(){
                $(this).text("Join Us!");
            });

            $("abbr").click(function () {
                $(this).fadeTo(2000, 0.2).fadeTo(2000, 1);
                alert("HIIT means High-intensity interval training");
            });

            $(".btn").hover(function(){
                $(this).animate({height: '35px', width: '175px',});
            }); 
            $(".btn").mouseleave(function(){
                $(this).animate({height: '35px', width: '130px',});
            });
        });
        
    </script>
    </body>
    </html>
