<?php
// The only way the client data is stored to the session is if the client is "logged in".
if ($_SESSION['clientData']['clientLevel'] < 2) {
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
        <?php if (isset($invInfo['invMake'])) {
            echo "Delete $invInfo[invMake] $invInfo[invModel]";
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
                if (isset($invInfo['invMake'])) {
                    echo "Delete $invInfo[invMake] $invInfo[invModel]";
                }
                ?>
            </h1>

            <p class="required-info-paragraph">
            <p class="failure-message">Confirm Vehicle Deletion. The delete is permanent.</p>

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

                        <label class="top">Make
                            <input type="text" readonly name="invMake" id="invMake" <?php if (isset($invInfo['invMake'])) {
                                                                                        echo "value='$invInfo[invMake]'";
                                                                                    } ?>>
                        </label>

                        <label class="top">Model
                            <input type="text" readonly name="invModel" id="invModel" <?php if (isset($invInfo['invModel'])) {
                                                                                            echo "value='$invInfo[invModel]'";
                                                                                        } ?>>
                        </label>


                        <label class="top">Vehicle Description
                            <textarea rows="5" cols="30" readonly name="invDescription" maxlength="500"><?php if (isset($invInfo['invDescription'])) {
                                                                                                            echo "$invInfo[invDescription]";
                                                                                                        } ?></textarea>
                        </label>
                    </fieldset>

                    <input type="submit" name="submit" value="Delete Vehicle" class="addClassification">
                    <input type="hidden" name="action" value="deleteVehicle">
                    <!-- store the primary key value for the item being updated. -->
                    <input type="hidden" name="invId" value="<?php if (isset($invId)) {
                                                                    echo $invId;
                                                                } ?>">
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