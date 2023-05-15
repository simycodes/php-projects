<?php
// Check if the visitor is logged in and has clientLevel greater than "1" to access the 
// view If the visitor is NOT logged in,send the user to
// if ($_SESSION['clientData']['clientLevel'] < 2) {
//     header('location: /phpmotors/');
//     exit;
// }

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}

?>
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

    <title>Image Management | PHP Motors</title>

    <!-- TELLS PHONES NOT TO LIE ABOUT THEIR WIDTH & stops the font from enlarging when a phone is turned sideways-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- STYLE SHEETS -->
    <link href="../css/normalize.css" rel="stylesheet">
    <!-- phone-default -->
    <link href="../css/small.css" rel="stylesheet">
    <!-- enhance-tablet -->
    <link href="../css/medium.css" rel="stylesheet">
    <!-- enhance-desktop -->
    <link href="../css/large.css" rel="stylesheet">
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
            <h1 class="form-title">Image Management</h1>
            <p class="welcome-and-options-message">Welcome To The Image Management Page.Choose one of the options presented below.</p>

            <h2 class="form-title">Add New Vehicle Image</h2>

            <!-- form information -->
            <div class="form-information" id="contact-us-heading">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>

                <form action="/phpmotors/uploads/" method="post" enctype="multipart/form-data">

                    <fieldset class="image-admin-fieldset">
                        <legend></legend>
                        <label for="invItem" class="top">Vehicle : <?php echo $prodSelect; ?></label>
                        
                        <br>
                        <label class="top">Is this the main image for the vehicle?</label>

                        <label for="priYes" class="pImage" class="top">Yes <input type="radio" name="imgPrimary" id="priYes" class="pImage" value="1"></label>
                        <label for="priNo" class="pImage" class="top">No <input type="radio" name="imgPrimary" id="priNo" class="pImage" checked value="0"></label>

                        <br><br>
                        <label class="top">Upload Image:</label>
                        <input type="file" name="file1">
                    </fieldset>


                    <input type="submit" value="Upload Image" class="upload-image regbtn">
                    <input type="hidden" name="action" value="upload">

                </form>
            </div>

            <hr>

            <h2 class="form-title">Existing Images</h2>
            <p class="notification form-title">If deleting an image, delete the thumbnail too and vice versa.</p>

            <?php
            if (isset($imageDisplay)) {
                echo $imageDisplay;
            }
            ?>

        </main>

        <!-- FOOTER HERE -->
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>

    </div>

    <script src="/phpmotors/js/main.js"></script>

</body>

</html>

<?php unset($_SESSION['message']); ?>