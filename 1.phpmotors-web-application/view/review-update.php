<?php
// The only way the client data is stored to the session is if the client is "logged in".
if ($_SESSION['clientData']['clientLevel'] < 1) {
    header('location: /phpmotors/');
    exit;
}
?>
<!DOCTYPE html>
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
        if (isset($reviewInfo['invMake']) && isset($reviewInfo['invModel'])) {
            echo "Modify $reviewInfo[invMake] $reviewInfo[invModel]";
        } elseif (isset($invMake) && isset($invModel)) {
            echo "Modify $invMake $invModel";
        }
        ?> | PHP Motors
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
                // $invInfo is an associate array of data from the DB with a single vehicle data
                if (isset($reviewInfo['invMake']) && isset($reviewInfo['invModel'])) {
                    echo "$reviewInfo[invMake] $reviewInfo[invModel]";
                } elseif (isset($invMake) && isset($invModel)) {
                    echo "$invMake $invModel";
                }
                ?>
                Review
            </h1>


            <h2 class="required-info-paragraph">
                <?php
                if (isset($reviewInfo['reviewDate'])) {
                    $reviewDate = substr($reviewInfo['reviewDate'], 0, 10);
                    echo "Reviewed on $reviewDate";
                } 
                elseif (isset($reviewDate)) {
                    echo "Reviewed on $reviewDate";
                }
                if (isset($_SESSION['allClientReviews'])) {
                    echo " By " . $_SESSION['firstName'] . " " . $_SESSION['lastName'];
                }
                ?>
            </h2>

            <!-- form information -->

            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
            <form method="post" action="/phpmotors/reviews/index.php" class="review-form">
                <fieldset class="review-field-set">
                    <legend></legend>

                    <label class="top">Review Text:
                        <textarea rows="5" cols="60" name="reviewText" maxlength="500" placeholder="Enter Your Review Here" required><?php if (isset($reviewText)) {
                                                                                                                                            echo $reviewText;
                                                                                                                                        } elseif (isset($reviewInfo['reviewText'])) {
                                                                                                                                            echo "$reviewInfo[reviewText]";
                                                                                                                                        } ?></textarea>
                    </label>
                </fieldset>

                <input type="submit" name="update-review" value="Update Review" class="addClassification reviewButton">
                <input type="hidden" name="action" value="updateReview">
                <input type="hidden" name="reviewId" value="<?php if (isset($reviewInfo['reviewId'])) {
                                                                        echo "$reviewInfo[reviewId]";
                                                                    } elseif (isset($reviewId)) {
                                                                        echo "$reviewId";
                                                                    } ?>">

                <!-- Passing vehicle details to maintain data stickiness and dynamic change for the heading 1 -->
                <input type="hidden" name="invMake" value="<?php if (isset($reviewInfo['invMake'])) {
                                                                    echo "$reviewInfo[invMake]";
                                                                } elseif (isset($invMake)) {
                                                                    echo "$invMake";
                                                                } ?>">

                <input type="hidden" name="invModel" value="<?php  if (isset($reviewInfo['invModel'])) {
                                                                        echo "$reviewInfo[invModel]";
                                                                    } elseif (isset($invModel)) {
                                                                        echo "$invModel";
                                                                    } ?>">

                <input type="hidden" name="reviewDate" value="<?php if (isset($reviewInfo['reviewDate'])) {
                                                                    $reviewDate = substr($reviewInfo['reviewDate'], 0, 10);
                                                                    echo "Reviewed on $reviewDate";
                                                                } elseif (isset($reviewDate)) {
                                                                    echo "Reviewed on $reviewDate";
                                                                } ?>">
            </form>


        </main>

        <!-- FOOTER HERE -->
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>

    </div>
    <script src="/phpmotors/js/main.js"></script>

</body>

</html>