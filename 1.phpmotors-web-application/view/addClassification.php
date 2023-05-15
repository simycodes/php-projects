<?php
// Check if the visitor is logged in and has clientLevel greater than "1" to access the 
// view If the visitor is NOT logged in,send the user to
// PHP Motors home view using the PHP Motors controller
// if (empty($clientData) || !isset($clientData)){} // This causes errors
// echo $_SESSION['clientData']['clientLevel'];

// The only way the client data is stored to the session is if the client is "logged in".
// This ensures that only a logged in user who is an administrator can access the inventory
// management area.
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
}
// if ($_SESSION['loggedin'] != TRUE || $_SESSION['clientData']['clientLevel'] == 1) {
//     header('Location: /phpmotors/');
//     exit;
// }
?><!doctype html>
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

    <title>Add Classification | PHP Motors</title>

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
            <h1 class="form-title">Add Vehicle Classification</h1>

            <!-- form information -->
            <div class="form-information" id="contact-us-heading">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <form method="post" action="/phpmotors/vehicles/index.php">
                    <fieldset>
                        <legend></legend>
                        <span>The Classification Should Not Be More Than 30 Characters</span>
                        <!-- putting the input element makes the input field to be activated if input name is clicked or touched -->
                        <label class="top">Classification Name <input type="text" name="classificationName" placeholder="Enter car classification here" maxlength="30" required></label>
                    </fieldset>

                    <input type="submit" name="addClassification" value="Add Classification" class="addClassification">
                    <input type="hidden" name="action" value="classificationName">
                </form>
            </div>

        </main>

        <!-- FOOTER HERE -->
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>

    </div>
    <script src="/phpmotors/js/main.js"></script>

</body>

</html>