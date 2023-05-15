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
// My code - same effect as above code (extra points)
// if ($_SESSION['loggedin'] != TRUE || $_SESSION['clientData']['clientLevel'] == 1) {
//     header('Location: /phpmotors/');
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

    <title>Vehicle Management Page | PHP Motors</title>

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
            <h1 class="title">Vehicle Management</h1>

            <ul class="management-options">
                <li><a href="/phpmotors/vehicles/index.php?action=addClassification">Add Classification</a></li>
                <li><a href="/phpmotors/vehicles/index.php?action=addVehicle">Add Vehicle</a></li>
            </ul>

            <?php
            if (isset($message)) {
                echo $message;
            }
            if (isset($classificationList)) {
                echo '<h2>Vehicles By Classification</h2>';
                echo '<p>Choose a classification to see those vehicles.</p>';
                echo $classificationList;
            }
            ?>

            <!-- Tell the client that JavaScript is required and needs to be enabled. -->
            <!-- If JavaScript is enabled the -noscript- element is hidden, else the element is
             displayed with its message -->
            <noscript>
                <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
            </noscript>

            <!-- All of the table interior elements and content will be created by JavaScript
             then "injected" into the table element — DOM manipulation. -->
            <table id="inventoryDisplay"></table>

        </main>

        <!-- FOOTER HERE -->
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>

    </div>
    <script src="/phpmotors/js/inventory.js"></script>
    <!-- <script src="../js/inventory.js"></script> -->
    <!-- <script src="/phpmotors/js/main.js"></script> -->

</body>

</html>

<?php 
  // Unsetting the message session variable that displays update success message
  unset($_SESSION['message']); 
?>