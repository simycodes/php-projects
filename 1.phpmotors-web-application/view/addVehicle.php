<?php
// echo "$classificationId";
// Build a build a dynamic drop-down select list using the $classificationsDetails array
$dropdownList = '<select name="classificationId">';
$dropdownList .= "<option value=''>&#9662; Choose Car Classification</option>";
foreach ($classificationsDetails as $classificationDetail) {
    $dropdownList .= "<option value='$classificationDetail[classificationId]'";
    if(isset($classificationId)){
        // echo "$classificationId";
        // echo $classificationDetail['classificationId']; echo " ";
        if($classificationDetail['classificationId'] == $classificationId){
            $dropdownList .= ' selected ';
        }
    }
    
    $dropdownList .= ">$classificationDetail[classificationName]</option>";
}
$dropdownList .= '</select>';
// echo "$classificationId";

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

    <title>Add Vehicle Page | PHP Motors</title>

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
            <h1 class="form-title">Add Vehicle</h1>
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
                            <input type="text" name="invMake" placeholder="Enter vehicle make here" <?php if (isset($invMake)) {echo "value='$invMake'";} ?> required>                                                                         
                        </label>
                        <label class="top">Model
                            <input type="text" name="invModel" placeholder="Enter vehicle model here" <?php if (isset($invModel)) {echo "value='$invModel'";} ?> required>                                                                             
                        </label>

                        <label class="top">Description
                            <textarea rows="5" cols="30" name="invDescription" maxlength="500" placeholder="Enter further details about the car" required><?php if(isset($invDescription)) {echo $invDescription;} ?></textarea>                                                                                                                                                                                                                                                                         
                        </label>
                        <label class="top">Image Path
                            <input type="text" name="invImage" placeholder="Enter image path" <?php if (isset($invImage)) {echo "value='$invImage'";} ?> required>                                                                     
                        </label>
                        <label class="top">Thumbnail Path
                            <input type="text" name="invThumbnail" placeholder="Enter thumbnail path" <?php if (isset($invThumbnail)) {echo "value='$invThumbnail'"; } ?> required>                                                                             
                        </label>
                        <label class="top">Price
                            <input type="text" name="invPrice" placeholder="Enter vehicle price here" <?php if (isset($invPrice)) { echo "value='$invPrice'";} ?> required>                                                                            
                        </label>
                        <label class="top">Stock
                            <input type="text" name="invStock" placeholder="Enter stock details here" <?php if (isset($invStock)) {echo "value='$invStock'";} ?> required>                                                                
                        </label>
                        <label class="top">Color
                            <input type="text" name="invColor" placeholder="Enter vehicle color here" <?php if (isset($invColor)) {echo "value='$invColor'"; } ?> required>                                                                                                                                                                  
                        </label>
                    </fieldset>


                    <input type="submit" name="addvehicle" value="Add Vehicle" class="addClassification">
                    <input type="hidden" name="action" value="vehicleName">
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