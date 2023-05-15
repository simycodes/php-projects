<?php
// THIS IS THE IMAGE UPLOADS CONTROLLER
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the vehicle model 
require_once '../model/vehicles-model.php';
// Get the uploads model to help upload,update and delete images
require_once '../model/uploads-model.php';
// Get the library functions 
require_once '../library/functions.php';

// Get the array of classifications - getClassifications() defined in model/main-model.php
$classifications = getClassifications();

// Create the main dynamic navigation bar for the website
$navList = createNavigation($classifications);

/* * ****************************************************
* Variables for use with the Image Upload Functionality
* **************************************************** */

// directory name where uploaded images are stored
// $image_dir = '/phpmotors/uploads/images';
$image_dir = '/phpmotors/images/vehicles';

// The path is the full path from the server root
$image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;

// Collect the "action" value from the "post" or "get" options of the "request" from 
// the browser that will lead to image upload and delete
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}


switch ($action) {
    case 'upload':
        // Store the incoming vehicle id and primary picture indicator
        $invId = filter_input(INPUT_POST, 'invId', FILTER_VALIDATE_INT);
        // The imgPrimary field will be used to indicate if a vehicle picture will be the
        // "Primary" or "Main" picture to be used with the vehicle or not - the default is "No" or "FALSE" as indicated by the zero.
        $imgPrimary = filter_input(INPUT_POST, 'imgPrimary', FILTER_VALIDATE_INT);

        // Store the name of the uploaded image
        $imgName = $_FILES['file1']['name'];

        // Check if the image name of the image to be uploaded exists in the database
        $imageCheck = checkExistingImage($imgName);

        if ($imageCheck) {
            $message = '<p class="notice">An image by that name already exists.</p>';
        } 
        elseif (empty($invId) || empty($imgName)) {
            $message = '<p class="notice">You must select a vehicle and image file for the vehicle.</p>';
        } 
        else {
            // Upload the image, store the returned path to the file
            $imgPath = uploadFile('file1');

            // Insert the image information to the database, get the result
            $result = storeImages($imgPath, $invId, $imgName, $imgPrimary);
                                    
            // Set a message based on the insert result
            if ($result) {
                $message = '<p class="success-message title">The upload succeeded.</p>';
            } else {
                $message = '<p class="failure-message title">Sorry, the upload failed.</p>';
            }
        }

        // Store message to session
        $_SESSION['message'] = $message;

        // Redirect to this controller for default action
        header('location: .');
        break;

    case 'delete':
        // Get the image name and id
        $filename = filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $imgId = filter_input(INPUT_GET, 'imgId', FILTER_VALIDATE_INT);

        // Build the full path to the image to be deleted
        $target = $image_dir_path . '/' . $filename;

        // Check that the file exists in that location
        if (file_exists($target)) {
            // Deletes the file in the folder
            $result = unlink($target);
        }

        // Remove from database only if physical file deleted
        if ($result) {
            $remove = deleteImage($imgId);
        }

        // Set a message based on the delete result
        if ($remove) {
            $message = "<p class='success-message'>$filename was successfully deleted.</p>";
        } else {
            $message = "<p class='failure-message'>$filename was NOT deleted.</p>";
        }

        // Store message to session
        $_SESSION['message'] = $message;

        // Redirect to this controller for default action
        header('location: .');

        break;

    default:
        // The default action of the controller will deliver the view where the image errors
        // and success messages and images will be displayed
        // Call function to return image info from database

        // Get a list of all images from the database table and store it as a 
        // multi-dimensional array.
        $imageArray = getImages();

        // Build the image information into HTML for display
        if (count($imageArray)) {
            $imageDisplay = buildImageDisplay($imageArray);
        } else {
            $imageDisplay = '<p class="notice">Sorry, no images could be found.</p>';
        }

        // Get vehicles information from database
        $vehicles = getVehicles();
        // Build a select list of vehicle information for the view
        $prodSelect = buildVehiclesSelect($vehicles);

        include '../view/image-admin.php';
        exit;

        break;

        // Both the insert and delete processes are using the header function to redirect 
        // back to the controller so that the default process gathers the data on the 
        // inventory vehicles and images for the view. This means that the code to do so 
        // has to exist in only one location in the controller, and doesn't have to be 
        // repeated multiple times before the view can be correctly delivered.
}











?>