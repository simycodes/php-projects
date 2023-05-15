<?php
//THIS IS THE VEHICLES CONTROLLER OF THE WEBSITE

// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model - dynamic navigation model for use as needed
require_once '../model/main-model.php';
// Get the accounts model - registration model
require_once '../model/vehicles-model.php';
// Get the library functions 
require_once '../library/functions.php';
// Get the uploads model - image uploading model
require_once '../model/uploads-model.php';
// Get the reviews model 
require_once '../model/reviews-model.php';

// Get the array of classifications - getClassifications() defined in model/main-model.php
// to be used in the dynamic navigation
$classifications = getClassifications();

// Create the main dynamic navigation bar for the website
$navList = createNavigation($classifications);

// Get the array of entire classifications to be used in the dynamic dropdown navigation
$classificationsDetails = getClassificationsDetails();

// Build a build a dynamic drop-down select list using the $classificationsDetails array
// $dropdownList = '<select name="classificationId" required>';
// $dropdownList .= "<option value=''>&#9662; Choose Car Classification</option>";
// foreach ($classificationsDetails as $classificationDetail) {
//     $dropdownList .= "<option value='$classificationDetail[classificationId]'>$classificationDetail[classificationName]</option>";
// }

// $dropdownList .= '</select>';
// echo $dropdownList;
// exit;

// $action variable stores the type of content being requested,home page,registration page
// login page.
$action = trim(filter_input(INPUT_POST,'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

if ($action == NULL) {
    $action = trim(filter_input(INPUT_GET,'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
}

switch ($action) {
    // GO TO THE ADD VEHICLE VIEW-PAGE
    case 'addVehicle':
        include '../view/addVehicle.php';
        break;

    // GO TO THE ADD CLASSIFICATION VIEW-PAGE
    case 'addClassification':
        include '../view/addClassification.php';
        break;

    // ADD A VEHICLE CLASSIFICATION TO THE DATABASE
    case 'classificationName':
        // HANDLING USER DATA WHILE FOLLOWING THE CODE AND DATA PATTERN
        // Filter and store the data - remove code that could do harm to website
        $classificationName = trim(filter_input(INPUT_POST,'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Check for missing data
        if (empty($classificationName)) {
            $message = "<p class='registration-failed'><i>Please Provide the Classification Name.</i></p>";
            include '../view/addClassification.php';
            exit;
        }

        // Check the classification name length
        $lengthOfClassificationName = checkClassificationName($classificationName);
        // echo "$lengthOfClassificationName";
        if($lengthOfClassificationName > 30){
            $message = "<p class='registration-failed'><i>The Classification Name Should Not Be More Than 30 Characters</i></p>";
            include '../view/addClassification.php';
            exit;
        }

        // Send the data to the model - Add classification to the db
        $addClassificationOutcome = addVehicleClassification($classificationName);

        // Check and report the result - Check if the classification was added successfully
        if ($addClassificationOutcome === 1) {
            header("location:../vehicles/");
            exit;
        } 
        else {
            $message = "<p class='registration-failed'><i>Failed to Add $classificationName Classification. Please Try Again.</i></p>";
            include '../view/addClassification.php';
            exit;
        }

        break;

    // ADD A VEHICLE TO THE DATABASE
    case 'vehicleName':
        // echo "Inside add Vehicle";
        // HANDLING USER DATA WHILE FOLLOWING THE CODE AND DATA PATTERN
        // Filter and store the data - remove code that could do harm to website
        $invMake = trim(filter_input(INPUT_POST,'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invDescription = trim(filter_input(INPUT_POST,'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invImage = trim(filter_input(INPUT_POST,'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invThumbnail = trim(filter_input(INPUT_POST,'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invPrice = trim(filter_input(INPUT_POST,'invPrice', FILTER_SANITIZE_NUMBER_FLOAT));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
        $invColor = trim(filter_input(INPUT_POST,'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
        $classificationId = trim(filter_input(INPUT_POST,'classificationId', FILTER_SANITIZE_NUMBER_INT));

        // Check for missing data
        if (empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail)|| empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)) {
            $message = '<p class="failure-message">Please Provide All The Vehicle Details</p>';
            include '../view/addVehicle.php';
            exit;
        }

        // echo "Before call to database";
        // Send the data to the model - Add classification to the db
        $addVehicleOutcome = addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

        // Check and report the result - Check if the vehicle was added successfully
        if ($addVehicleOutcome === 1) {
            $message = "<p class='registration-successful'>The $invMake $invModel was Successfully Added</p>";
            // include '../view/addVehicle.php';
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } 
        else {
            $message = "<p class='registration-failed'>Failed to Add $invMake $invModel. Please Try Again Later.</p>";
            include '../view/addVehicle.php';
            exit;
        }

        break;

    // GET VEHICLES FROM DB BASED ON THEIR CLASSIFICATIONS,THEN SEND AS JSON TO JS FOR DISPLAY
    case 'getInventoryItems':
        // Get vehicles by classificationId Used for starting Update & Delete process
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        // Fetch the vehicles by classificationId from the DB 

        // echo "Before call to database in getInventoryItems case";
        $inventoryArray = getInventoryByClassification($classificationId);
        // echo "After call to the database in getInventoryItems case";
        // echo $inventoryArray;

        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray);
        // Note the use of echo, not return to send back the JSON object.
        break;

    // FIRST STEP IN VEHICLE UPDATE PROCESS - GET VEHICLE FROM BD & GO TO VEHICLE-UPDATE VIEW
    case 'mod':
        // Getting second value pair coming from a link hence its a GET request
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        // Getting the information for that single vehicle to be updated
        $invInfo = getInvItemInfo($invId);
        // Check to see if $invInfo has received data from the database of the vehicle
        if (count($invInfo) < 1) {
            $message = 'Sorry, No Vehicle Information Could Be Found.';
        }

        // print_r($invInfo);
        // Take the user to the update page - so the vehicle can be updated
        include '../view/vehicle-update.php';

        break;

    // SECOND STEP IN VEHICLE UPDATE PROCESS - DISPLAY VEHICLE INFO & THEN UPDATE VEHICLE
    case 'updateVehicle':
        // HANDLING USER DATA WHILE FOLLOWING THE CODE AND DATA PATTERN
        // Filter and store the data - remove code that could do harm to website
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT));

        // Check for missing data
        if (empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)) {
            $message = '<p class="failure-message">Please Provide All The Vehicle Details.Double check the classification of the item.</p>';
            include '../view/vehicle-update.php';
            exit;
        }

        // echo "Before call to database";
        $updateVehicleOutcome = updateVehicle($invId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

        // Check and report the result - Check if the vehicle was added successfully
        if ($updateVehicleOutcome === 1) {
            $message = "<p class='success-message'>Congratulations.The $invMake $invModel Was Successfully Updated</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='failure-message'>Error.Failed to Update $invMake $invModel. Please Try Again Later.</p>";
            include '../view/vehicle-update.php';
            exit;
        }

        break;

    // FIRST STEP IN VEHICLE DELETION PROCESS - GET VEHICLE FROM DB & GO TO VEHICLE-DELETE VIEW
    case 'del':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = 'Sorry, No Vehicle Information Could Be Found.';
        }
        include '../view/vehicle-delete.php';
        exit;

        break;

    // SECOND STEP IN VEHICLE DELETION PROCESS - DISPLAY VEHICLE INFO & DELETE THE VEHICLE FROM DB
    case 'deleteVehicle':
        // Because we are doing a delete, we will not do any error checking.
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $deleteOutcome = deleteVehicle($invId);
        if ($deleteOutcome) {
            $message = "<p class='success-message'>Success, The $invMake $invModel Was Successfully Deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } 
        else {
            $message = "<p class='failure-message'>Error: $invMake $invModel Was Not Deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }

        break;

    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // Get vehicles from the database
        $vehicles = getVehiclesByClassification($classificationName);
        // print_r($vehicles);

        // Check if any vehicles were returned from the database
        if (!count($vehicles)) {
            $message = "<p class='notice'>Sorry, No $classificationName Vehicles Could Be Found.</p>";
        } 
        else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
            $num = count($vehicles);
            // echo $num;
        }

        // Display the vehicles to the user
        include '../view/classification.php';
        exit;

        break;

    case 'singleVehicle':
        // echo "Inside vehicle name case";
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
        
        // Get vehicle from the database
        $invInfo = getInvItemInfo($invId);
        // Get vehicle Thumbnails
        $AllSingleVehicleThumbnails = getAllSingleVehicleThumbnails($invId);
        // print_r($AllSingleVehicleThumbnails);

        // Get vehicle reviews
        $vehicleReviews = getReviewsForASingleVehicle($invId);
        // print_r($vehicleReviews);
        // Add html structure to the reviews
        if(!empty($vehicleReviews)){
            $vehicleReviewsWithHtmlStructure = buildReviewsDisplayForVehicle($vehicleReviews);
        }
        
        // Check if the vehicle is returned from the database
        if (count($invInfo) < 1) {
            $message = "<p class='notice'>Sorry, Vehicle Can Not Be found.Try Again Later</p>";
        } 
        else {
            $AllSingleVehicleThumbnailsDisplay = buildAllSingleVehicleThumbnailsDisplay($AllSingleVehicleThumbnails);
            // $singleVehicleDisplay = buildSingleVehicleDisplay($invInfo);
            $singleVehicleDisplay = buildSingleVehicleDisplay($invInfo, $AllSingleVehicleThumbnailsDisplay);
        }

        // Display the vehicles to the user
        include '../view/vehicle-detail.php';

        break;

    default:
        // Create the dynamic classification dropdown for the vehicle management page
        // print_r($classificationsDetails);
        // echo "Working - Default section";
        $classificationList = buildClassificationList($classificationsDetails);
        // $inventoryArray = getInventoryByClassification(7);
        // print_r($inventoryArray);
        // echo "Default section";
        include '../view/vehicleManagement.php';
        exit;
        
        break;
}


// NOTE
// 1.With require_once,PHP will ignore any future requests for the same code if 
// repeated in the same file, which saves time and is more efficient.
// 2.INPUT_GET and INPUT_POST are php predefined Global array constants/variables 
// which hold variables being passed through GET or POST methods.
// 3. $action = filter_input(INPUT_GET, 'action'); means check if the global array
// variable INPUT_GET contains a array element/item by the name of email, and then
// validate it


?>