<?php
// echo "$classificationId";
// Build a build a dynamic drop-down select list using the $classificationsDetails array
$dropdownList = '<select name="classificationId">';
$dropdownList .= "<option value=''>&#9662; Choose Car Classification</option>";
foreach ($classificationsDetails as $classificationDetail){
    $dropdownList .= "<option value='$classificationDetail[classificationId]'";
    if (isset($classificationId)) {
        // echo "$classificationId";
        // echo $classificationDetail['classificationId']; echo " ";
        if ($classificationDetail['classificationId'] == $classificationId) {
            $dropdownList .= ' selected ';
        }
    } 
    // Displaying the right car classification on the vehicle update process
    elseif (isset($invInfo['classificationId'])){
        if ($classificationDetail['classificationId'] == $invInfo['classificationId']) {
            $dropdownList .= ' selected ';
        }
    }

    $dropdownList .= ">$classificationDetail[classificationName]</option>";
}
$dropdownList .= '</select>';

// The only way the client data is stored to the session is if the client is "logged in".
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
}
?><!DOCTYPE html>
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
        // When the page loads, the vehicle make and model will appear in the title tab of the 
        // browser. Or, if the page is returned for error correction the vehicle name will
        // reappear from the vehicle variable.
        // $invInfo is an associate array of data from the DB with a single vehicle data
        if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
            echo "Modify $invInfo[invMake] $invInfo[invModel]";
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
                if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                    echo "Modify $invInfo[invMake] $invInfo[invModel]";
                } 
                elseif (isset($invMake) && isset($invModel)) {
                    echo "Modify $invMake $invModel";
                }
                ?>
            </h1>



            <h2 class="required-info-paragraph">*Note All Fields are Required</h2>

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
                        <label class="top">
                            <?php echo $dropdownList ?>
                        </label>

                        <label class="top">Make
                            <input type="text" name="invMake" id="invMake" required <?php if(isset($invMake)){ echo "value='$invMake'"; } elseif(isset($invInfo['invMake'])) { echo "value='$invInfo[invMake]'"; }?>>
                        </label>
                        <label class="top">Model
                            <input type="text" name="invModel" id="invModel" required <?php if(isset($invModel)){ echo "value='$invModel'"; } elseif(isset($invInfo['invModel'])) { echo "value='$invInfo[invModel]'"; }?>>
                        </label>

                        <label class="top">Description
                            <textarea rows="5" cols="30" name="invDescription" maxlength="500" placeholder="Enter further details about the car" required><?php if (isset($invDescription)) {
                                                                                                                                                                    echo $invDescription;
                                                                                                                                                                } elseif (isset($invInfo['invDescription'])) {
                                                                                                                                                                    echo "$invInfo[invDescription]";
                                                                                                                                                                } ?></textarea>
                        </label>
                        <label class="top">Image Path
                            <input type="text" name="invImage" placeholder="Enter image path" <?php if (isset($invImage)) {
                                                                                                    echo "value='$invImage'";
                                                                                                } elseif (isset($invInfo['invImage'])) {
                                                                                                    echo "value='$invInfo[invImage]'";
                                                                                                } ?> required>
                        </label>
                        <label class="top">Thumbnail Path
                            <input type="text" name="invThumbnail" placeholder="Enter thumbnail path" <?php if (isset($invThumbnail)) {
                                                                                                            echo "value='$invThumbnail'";
                                                                                                        } elseif (isset($invInfo['invThumbnail'])) {
                                                                                                            echo "value='$invInfo[invThumbnail]'";
                                                                                                        }?> required>
                        </label>
                        <label class="top">Price
                            <input type="text" name="invPrice" placeholder="Enter vehicle price here" <?php if (isset($invPrice)) {
                                                                                                            echo "value='$invPrice'";
                                                                                                        } elseif (isset($invInfo['invPrice'])) {
                                                                                                            echo "value='$invInfo[invPrice]'";
                                                                                                        }?> required>
                        </label>
                        <label class="top">Stock
                            <input type="text" name="invStock" placeholder="Enter stock details here" <?php if (isset($invStock)) {
                                                                                                            echo "value='$invStock'";
                                                                                                        } elseif (isset($invInfo['invStock'])) {
                                                                                                            echo "value='$invInfo[invStock]'";
                                                                                                        }?> required>
                        </label>
                        <label class="top">Color
                            <input type="text" name="invColor" placeholder="Enter vehicle color here" <?php if (isset($invColor)) {
                                                                                                            echo "value='$invColor'";
                                                                                                        } elseif (isset($invInfo['invColor'])) {
                                                                                                            echo "value='$invInfo[invColor]'";
                                                                                                        }?> required>
                        </label>
                    </fieldset>

                    <input type="submit" name="update-vehicle" value="Update Vehicle" class="addClassification">
                    <input type="hidden" name="action" value="updateVehicle">
                    <!-- store the primary key value for the item being updated. -->
                    <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} elseif(isset($invId)){ echo $invId; } ?>">
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