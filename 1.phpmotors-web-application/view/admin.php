<?php
// Check if the visitor is NOT logged in. If the visitor is NOT logged in,send the user to
// PHP Motors home view using the PHP Motors controller
// if (empty($clientData) || !isset($clientData)){} // This causes errors

if ($_SESSION['loggedin'] != TRUE) {
    header('Location: /phpmotors/');
    exit;
}

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

    <title>Admin Page | PHP Motors</title>

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
            <h1 class="title">
                <?php
                echo $_SESSION['clientData']['clientFirstname'];
                echo " ";
                echo $_SESSION['clientData']['clientLastname'];
                ?>
            </h1>

            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
            }
            ?>

            <p><b>You are logged in</b></p>
            <ul class="management-options">
                <li><b>First name:</b> <?php echo $_SESSION['clientData']['clientFirstname']; ?></li>
                <li><b>Last name:</b> <?php echo $_SESSION['clientData']['clientLastname']; ?></li>
                <li><b>Email Address:</b> <?php echo $_SESSION['clientData']['clientEmail']; ?></li>
            </ul>

            <h2>Account Management</h2>
            <p>Use This Link to Update Account Information.</p>
            <p><a href="/phpmotors/accounts/index.php?action=updateAccount&clientId=<?php echo $_SESSION['clientData']['clientId']; ?>">Update Account Information.</a></p>

            <?php
                if(isset($_SESSION['clientReviews'])) {
                    echo "<h2>Manage Your Product Reviews</h2>";
                    echo $_SESSION['clientReviews'];
                }
                else {
                    echo "<h2>Manage Your Product Reviews</h2>";
                    echo "<p>No Vehicles Reviews To Display. Your Vehicle Reviews Will Appear Here.</p>";
                }

                if ($_SESSION['clientData']['clientLevel'] == 3) {
                    echo "<h2>Client Reviews Management</h2>";
                    echo "<p>Use This Link to Manage Clients Reviews.</p>";
                    echo "<p><a href='/phpmotors/reviews/?action=getAllClientReviews'>Client Review Management</a></p>";
                }
            ?>

            <?php
            if ($_SESSION['clientData']['clientLevel'] > 1) {
                echo "<h2>Inventory Management</h2>";
                echo "<p>Use This Link to Manage The Inventory.</p>";
                echo "<p><a href='/phpmotors/vehicles/index.php'>Vehicle Management</a></p>";

                echo "<h2>Image Management</h2>";
                echo "<p>Use This Link to Manage The Vehicle Images.</p>";
                echo "<p><a href='/phpmotors/uploads/index.php'>Image Management</a></p>";
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
<?php
unset($_SESSION['message']);
?>