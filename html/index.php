<?php
// Definimi i konstantave dhe variablave
const SITE_NAME = "ILLYRIAN Gym";
//vargu asociativ
$menu_items = [
    "index.php" => "Home",
    "services.php" => "Services",
    "diet.php" => "Diet",
    "about.php" => "About Us",
    "plans.php" => "Pricing",
    "workouts.php" => "Workouts",
    "review.php" => "Review"
];
// Funksion për të gjeneruar menunë
function generateMenu($items, $activePage) {
    $menuHtml = "";
    foreach ($items as $link => $title) {
        $activeClass = ($link === $activePage) ? 'style="color:aquamarine; border-bottom: 3px solid var(--main-color);"' : '';
        $menuHtml .= "<li><a href='$link' $activeClass>$title</a></li>";
    }
    return $menuHtml;
}
// Klasa për të ruajtur të dhënat e faqes
class PageContent {
    public $title;
    public $welcomeMessage;
    public function __construct($title, $message) {
    $this->title = $title;
    $this->welcomeMessage = $message;
    }
    }
    $page = new PageContent("Build Your Dream Physique", "Welcome");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title><?php echo SITE_NAME?></title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script> 
</head>

<body>
    <header>
        <a href="index.php" class="logo"></a>
        <div class="bx bx-menu" id="menu-icon"></div>
        <ul class="navbar">
            <?php echo generateMenu($menu_items, basename($_SERVER['PHP_SELF']));?>
      </ul>
        <div class="top-btn">
            <a href="joinus.php" class="nav-btn">Join Us</a>
        </div>
        
    </header>

    <section id="home" class="home">
        <div class="home-content">
            <h1></h1>
            <div class="text">
                <h3> <span class="multiple-text"><b></b></span></h3>
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
            &copy; 
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
