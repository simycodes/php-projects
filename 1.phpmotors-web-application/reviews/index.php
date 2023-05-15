<?php
//THIS IS THE REVIEWS CONTROLLER OF THE WEBSITE

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
// Get the uploads model - image uploading model
require_once '../model/reviews-model.php';

// Get the array of classifications - getClassifications() defined in model/main-model.php
// to be used in the dynamic navigation
$classifications = getClassifications();

// Create the main dynamic navigation bar for the website
$navList = createNavigation($classifications);

// Get the array of entire classifications to be used in the dynamic dropdown navigation
$classificationsDetails = getClassificationsDetails();

// $action variable stores the type of content being requested,home page,registration page
// login page.
$action = trim(filter_input(INPUT_POST,'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

if ($action == NULL) {
    $action = trim(filter_input(INPUT_GET,'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
}

switch ($action) {
    // THE REVIEW ADDITION PROCESS
    case 'addReview':
        // Filter and store the data - remove code that could do harm to website
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        // $reviewDate = trim(filter_input(INPUT_POST, 'reviewDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Check for missing data
        if (empty($reviewText) || empty($invId) || empty($clientId) ) {
            $message = '<p class="failure-message">Please Provide Your Review. Scroll to the Bottom Of The Page, Then Add a Review Before Pressing The Submit Button.</p>';
            $_SESSION['message'] = $message;
            $messageSpecific = "<p class='failure-message'>Please Provide Your Review Here</p>";
            $_SESSION['messageSpecific'] = $messageSpecific;
            // include '../view/vehicle-detail.php';
            header("location: /phpmotors/vehicles/?action=singleVehicle&invId=$invId");
            exit;
        }

        // Send the data to the model - Add classification to the db
        $addReviewOutcome = addReview($reviewText, $invId, $clientId);
        // echo "After database";

        // Check and report the result - Check if the review was added successfully
        if ($addReviewOutcome === 1) {
            $message = "<p class='registration-successful'>Thanks! Your Review was Successfully Added. Scroll to the Bottom Of The Page To See Your Review!</p>";
            // include '../view/addVehicle.php';
            $_SESSION['message'] = $message;

            // Get all the vehicles reviews of the user again so updated data can be seen
            $clientReviews = getReviewInfoByClient($_SESSION['clientData']['clientId']);
            // print_r($clientReviews);
            // Add HTML structure to the data(reviews) returned from the database
            $clientReviews = buildReviewsDisplay($clientReviews);
            // Store the array of client reviews into the session
            unset($_SESSION['clientReviews']);
            $_SESSION['clientReviews'] = $clientReviews;
            
            header("location: /phpmotors/vehicles/?action=singleVehicle&invId=$invId");
            exit;
        } 
        else {
            $message = "<p class='registration-failed'>Failed to Add Review. Please Try Again Later.</p>";
            // include '../view/vehicle-detail.php';
            header('location: /phpmotors/reviews/');
            exit;
        }
        
        break;

    // FIRST STEP IN REVIEW UPDATE PROCESS - GET REVIEW FROM BD & GO TO REVIEW UPDATE VIEW
    case 'getReviewToUpdate':
        // Getting second value pair coming from a link hence its a GET request
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
        // Getting the information for that single review to be updated
        $reviewInfo = getReviewInfo($reviewId);
        // Check to see if $reviewInfo has received data from the database of the review
        if (count($reviewInfo) < 1) {
            $message = 'Sorry, No Review Information Could Be Found.';
            header('location: /phpmotors/reviews/');
            exit;
        }
        // Make a copy of the review text incase a blank review is submitted
        $_SESSION['clientReviewText'] = $reviewInfo['reviewText'];

        // Get extra client details for Admin update and delete Display functionalities
        if (isset($_SESSION['allClientReviewsRawData'])) {
            echo "HEllo!";
            $allClientReviewsRawData = $_SESSION['allClientReviewsRawData'];
            foreach ($allClientReviewsRawData as $review) {
                if ($review['reviewId'] == $reviewId) {
                    $firstName = $review['clientFirstName'];
                    $lastName = $review['clientLastName'];
                }
            }
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
        }

        // Take the user to the review update page - so the review can be updated
        include '../view/review-update.php';

        break;

    // SECOND STEP IN REVIEW UPDATE PROCESS - DISPLAY REVIEW INFO & THEN UPDATE REVIEW
    case 'updateReview':
        // HANDLING USER DATA WHILE FOLLOWING THE CODE AND DATA PATTERN
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT));
        // echo $reviewText;
        // Data passed for stickness purposes - not entirely used in the database
        $reviewDate = trim(filter_input(INPUT_POST, 'reviewDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Check for missing data
        if (empty($reviewText) || empty($reviewId)) {
            $message = '<p class="failure-message">Please Provide Your Review Information When Updating. Update The Review Information Below Then Submit.</p>';
            $reviewText = $_SESSION['clientReviewText'];
            include '../view/review-update.php';
            exit;
        } 
        
        // Send the data to the model - Update the review
        $updateReviewOutcome = updateReview($reviewText, $reviewId);
        // echo $updateReviewOutcome;
        // echo $reviewId;
        // Check and report the result - Check if the review was added successfully
        if ($updateReviewOutcome === 1) {
            $message = "<p class='success-message'>Review Was Successfully Updated</p>";
            $_SESSION['message'] = $message;
        
            // Get all the vehicles reviews of the user again so updated data can be seen
            $clientReviews = getReviewInfoByClient($_SESSION['clientData']['clientId']);
            // Add HTML structure to the data(reviews) returned from the database
            $clientReviews = buildReviewsDisplay($clientReviews);
            // Store the array of client reviews into the session
            unset($_SESSION['clientReviews']);
            $_SESSION['clientReviews'] = $clientReviews;

            header('location: /phpmotors/reviews/');
            exit;
        } 
        else {
            $message = "<p class='failure-message'>Error.Failed to Update The Review. Please Try Again Later.</p>";
            include '../view/review-update.php';
            exit;
        }

        break;

    // FIRST STEP IN REVIEW DELETION PROCESS - GET REVIEW FROM DB & GO TO REVIEW-DELETE VIEW
    case 'getReviewToDelete':
        // Getting second value pair coming from a link hence its a GET request
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
        // Getting the information for that single review to be updated
        $reviewInfo = getReviewInfo($reviewId);
        // Check to see if $reviewInfo has received data from the database of the review
        if (count($reviewInfo) < 1) {
            $message = 'Sorry, No Review Information Could Be Found.';
            header('location: /phpmotors/reviews/');
            exit;
        }

        // Get extra client details for Admin update and delete Display functionalities
        if (isset($_SESSION['allClientReviewsRawData'])) {
            $allClientReviewsRawData = $_SESSION['allClientReviewsRawData'];
            foreach ($allClientReviewsRawData as $review) {
                if ($review['reviewId'] == $reviewId) {
                    $firstName = $review['clientFirstName'];
                    $lastName = $review['clientLastName'];
                }
            }
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
        }

        include '../view/review-delete.php';
        exit;

        break;

    // SECOND STEP IN REVIEW DELETION PROCESS - DISPLAY REVIEW INFO & DELETE THE REVIEW FROM DB
    case 'deleteReview':
        // Because we are doing a delete, we will not do any error checking.
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);

        // Send delete request to the database
        $deleteOutcome = deleteReview($reviewId);

        // Check if the deletion was successful and deliver the right message
        if ($deleteOutcome) {
            $message = "<p class='success-message'>Success, The Review Was Successfully Deleted.</p>";
            $_SESSION['message'] = $message;

            // Get all the vehicles reviews of the user again so updated data can be seen
            $clientReviews = getReviewInfoByClient($_SESSION['clientData']['clientId']);
            // print_r($clientReviews);
            // Add HTML structure to the data(reviews) returned from the database

            if (!count($clientReviews)) {
                unset($_SESSION['clientReviews']);
            }
            else {
                $clientReviews = buildReviewsDisplay($clientReviews);
                // Store the array of client reviews into the session
                unset($_SESSION['clientReviews']);
                $_SESSION['clientReviews'] = $clientReviews;
            }
            
            header('location: /phpmotors/reviews/');
            exit;
        } 
        else {
            $message = "<p class='failure-message'>Error: Review Was Not Deleted. Try Again Later.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/reviews/');
            exit;
        }

        break;

    // CLIENTS REVIEW MANAGEMENT 
    case 'getAllClientReviews':
        // Get the all vehicles reviews from the database
        $allClientReviews = getAllClientReviews();
        $_SESSION['allClientReviewsRawData'] = $allClientReviews;
        // print_r($allClientReviews);
        // Check if any reviews were returned from the database
        // print_r($allClientReviews);
        if (!count($allClientReviews)) {
            $message = "<p class='notice'>Currently There Are No Client Reviews To Show. All Client Reviews Will Be Displayed Here</p>";
            $_SESSION['message'] =  $message;
        } 
        else {
            $allClientReviews = buildReviewsDisplayForAdmin($allClientReviews);
            // Store the array of client reviews into the session
            $_SESSION['allClientReviews'] = $allClientReviews;
        }

        // Take the user to the review update page - so the review can be updated
        include '../view/reviewManagement.php';
        break;
    
    default:
        include '../view/admin.php';
        exit;

        break;
 
}