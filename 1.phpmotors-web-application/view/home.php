<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Simon Mule - PHP Motors Website">
    <meta name="Author" content="Simon Mule">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Rajdhani font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Rajdhani:wght@500&display=swap" rel="stylesheet">

    <!-- Rajdhani font link - bold -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Rajdhani:wght@700&display=swap" rel="stylesheet">

    <title>Home Page | PHP Motors</title>

    <!-- TELLS PHONES NOT TO LIE ABOUT THEIR WIDTH & stops the font from enlarging when a phone is turned sideways-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <!-- STYLE SHEETS -->
    <link href="css/normalize.css" rel="stylesheet">
    <!-- phone-default -->
    <link href="css/small.css" rel="stylesheet">
    <!-- enhance-tablet -->
    <link href="css/medium.css" rel="stylesheet">
    <!-- enhance-desktop -->
    <link href="css/large.css" rel="stylesheet">

</head>

<body>

    <div class="main-container">
        <!-- HEADER HERE -->
        <header>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
        </header>

        <!-- NAVIGATION HERE -->
        <nav>
            <?php echo $navList; ?>
        </nav>


        <!-- CONTENT HERE -->
        <main>
            <h1>Welcome to PHP Motors!</h1>

            <div class="home-grid">

                <div class="banner-image-section">
                    <section class="information">
                        <h2>DMC Delorean</h2>
                        <p>
                            3 Cup Holders<br>
                            Superman Doors<br>
                            Fuzzy dice!
                        </p>
                        <a href="join.html">Own Today</a>
                    </section>
                    
                    <figure class="banner-image">
                        <img src="/phpmotors/images/vehicles/delorean.jpg" alt="Welcome main vehicle for the home page" width="908" height="463">
                    </figure>
                </div>

                <a href="#" class="btn">Own Today</a>

                <!-- REVIEWS SECTION -->
                <div class="reviews">
                    <h2>DMC Delorean Reviews</h2>

                    <ul>
                        <li>"So fast its almost like traveling in time." (4/5)</li>
                        <li>"Coolest ride on the road." (4/5)</li>
                        <li>"I am feeling Marty Mcfly!" (5/5)</li>
                        <li>"The most futuristic ride of our day." (4.5/5)</li>
                        <li>"80's living and I love it." (5/5)</li>
                    </ul>
                </div>

                <!-- UPGRADES SECTION -->
                <div class="upgrades">
                    <h2>Delorean Upgrades</h2>

                    <div class="upgrades-container">

                        <div class="each-upgrade">
                            <figure class="each-image">
                                <img src="./images/upgrades/flux-cap.png" alt="A flux upgrade part of a vehicle" width="65" height="65">
                            </figure>
                            <p><a href="#">Flux Capacitor</a></p>
                        </div>

                        <div class="each-upgrade">
                            <figure class="each-image">
                                <img src="./images/upgrades/flame.jpg" alt="A flame upgrade part of a vehicle" width="65" height="82">
                            </figure>
                            <p><a href="#">Flame Decals</a></p>
                        </div>

                        <div class="each-upgrade">
                            <figure class="each-image">
                                <img src="./images/upgrades/bumper_sticker.jpg" alt="A bumper sticker upgrade part of a vehicle" width="65" height="57">
                            </figure>
                            <p><a href="#">Bumper Stickers</a></p>
                        </div>

                        <div class="each-upgrade">
                            <figure class="each-image">
                                <img src="./images/upgrades/hub-cap.jpg" alt="A hub upgrade part of a vehicle" width="65" height="65">
                            </figure>
                            <p><a href="#">Hub Caps</a></p>
                        </div>

                    </div>
                </div>

            </div>

        </main>

        <!-- FOOTER HERE -->
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
        <!-- <script src="js/script.js"></script> -->
    </div>

    <script src="/phpmotors/js/main.js"></script>

</body>

</html>