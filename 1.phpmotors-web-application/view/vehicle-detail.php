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

    <title>
        <?php
        if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
            echo "$invInfo[invMake] $invInfo[invModel]";
        }
        ?> | PHP Motors, Inc.
    </title>

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
            <h1>
                <?php
                if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                    echo "$invInfo[invMake] $invInfo[invModel]";
                }
                ?>
            </h1>
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
            }
            ?>

            <div class="vehicle-detail-grid">

                <!-- Display no vehicles available when the classification has no vehicles -->
                <?php if (isset($message)) {
                    echo $message;
                }
                ?>

                <!-- display the vehicle list returned from the database -->
                <?php if (isset($singleVehicleDisplay)) {
                    echo $singleVehicleDisplay;
                } ?>

            </div>

            <div class="reviews-container">
                <h2>Customer Reviews</h2>

                <?php
                if (isset($_SESSION['clientData']['clientLevel']) && $_SESSION['clientData']['clientLevel'] > 0) {
                    if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                        echo "<h3 class='vehicle-to-review-name'>Review The $invInfo[invMake] $invInfo[invModel]</h3>";
                    }
                ?>

                    <form method="post" action="/phpmotors/reviews/index.php" class="review-form">
                        <?php
                        if (isset($_SESSION['messageSpecific'])) {
                            echo $_SESSION['messageSpecific'];
                        }
                        ?>
                        <fieldset class="review-field-set">
                            <legend></legend>

                            <label class="top">Screen Name:
                                <input type="text" name="clientName" readonly title="You can't type in here" value="<?php echo substr($_SESSION['clientData']['clientFirstname'], 0, 1);
                                                                                                                    echo $_SESSION['clientData']['clientLastname'] ?>" required>
                            </label>

                            <label class="top">Review:
                                <textarea rows="5" cols="60" name="reviewText" maxlength="500" placeholder="Enter Your Review Here"><?php if (isset($clientReview)) {
                                                                                                                                                    echo $clientReview;
                                                                                                                                                }       
                                                                                                                                                ?></textarea>
                            </label>
                        </fieldset>

                        <input type="submit" name="add-review" value="Submit Review" class="addClassification reviewButton">
                        <input type="hidden" name="action" value="addReview">
                        <input type="hidden" name="invId" value="<?php echo $invId ?>">
                        <input type="hidden" name="clientId" value="<?php echo $_SESSION['clientData']['clientId']; ?>">
                    </form>

                <?php
                } else {
                    echo "<p>You Must <a href='/phpmotors/accounts/index.php?action=login'>Login</a> To Write a Review</p>";
                    // echo $reviews; 
                }

                ?>

                <!-- Display the vehicle reviews if there are available -->
                <?php
                if (isset($vehicleReviewsWithHtmlStructure)) {
                    echo  $vehicleReviewsWithHtmlStructure;
                } else {
                    echo "<p class='invite-message'><i>Be the First to Write a Review</i></p>";
                }
                ?>

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

<?php
if (isset($_SESSION['message'])) {
    unset($_SESSION['message']);
}

if (isset($_SESSION['messageSpecific'])) {
    unset($_SESSION['messageSpecific']);
}

?>