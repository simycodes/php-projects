<?php
//THIS IS THE ACCOUNTS CONTROLLER OF THE WEBSITE

// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model - dynamic navigation model for use as needed
require_once '../model/main-model.php';
// Get the accounts model - registration model
require_once '../model/accounts-model.php';
// Get the library functions - checkEmail($clientEmail) to validate email
require_once '../library/functions.php';
// Get the reviews model - registration model
require_once '../model/reviews-model.php';


// Get the array of classifications - getClassifications() defined in model/main-model.php
// to be used in the dynamic navigation
$classifications = getClassifications();

// Check if data from the database has been stored in $classifications by displaying it
// var_dump($classifications);
// exit;

// Create the main dynamic navigation bar for the website
$navList = createNavigation($classifications);

// .= appends/adds new element/item to a variable/making it a child element,in this case
// each li element created in the foreach loop is being appended to the $navList variable
///ul element as a child element

//$action variable stores the type of content being requested,home page,registration page
//login page.This request for content comes a URL request which may hold a GET or a POST
//array value/item given as key - value from the user
$action = trim(filter_input(INPUT_POST,'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

if ($action == NULL) {
    $action = trim(filter_input(INPUT_GET,'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
}

switch ($action) {
    case 'login':
        include '../view/login.php';
        break;

    case 'registration':
        include '../view/registration.php';
        break;

    case 'register':
        // HANDLING USER DATA WHILE FOLLOWING THE CODE AND DATA PATTERN
        // Filter, validate and store the data - remove code that could do harm to website
        $clientFirstname = trim(filter_input(INPUT_POST,'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST,'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST,'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST,'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Validate the email - check if it "looks" like a valid email address.
        $clientEmail = checkEmail($clientEmail);
        // Validate the passwords length,capital letter,1 number and special character.
        $checkPassword = checkPassword($clientPassword);

        // Check if an email address exists in the clients table
        $emailAlreadyExists = checkIfEmailExistsInDatabase($clientEmail);
        if($emailAlreadyExists){
            $message = '<p class="notification">The Email Address Already Exists. Do You Want to Login Instead.</p>';
            include "../view/login.php";
            exit;
        }

        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
            $message = '<p class="failure-message">Please provide information for all empty form fields.</p>';
            include '../view/registration.php';
            //stop the rest of the php code below from running
            exit;
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        // Send the data to the model - Register the user
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        // Check and report the result - Check if the user was successfully registered
        if ($regOutcome === 1) {
            // Set a registration success message
            // $message = "<p class='registration-successful'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
            $_SESSION['message'] = "<p class='registration-successful'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";

            // Set a cookie
            // using the strtotime() function and passing a value of +1 sets cookie for
            // one year. Setting the path to "/" means the cookie will be visible to the
            // entire web site.
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            
            // Include/redirect to the login page so user can login
            // include '../view/login.php';
            header('Location: /phpmotors/accounts/?action=login');
            // Using header function to direct user to login page and use of sessions to
            // message helps avoid the possibility of resubmitting forms and causing duplicate
            // entries by mistake
            exit;
        } 
        else {
            $message = "<p class='registration-failed'>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }

        break;

    case 'signIn':
        // echo "You are inside sign In";
        // HANDLING USER DATA WHILE FOLLOWING THE CODE AND DATA PATTERN
        // Filter, validate and store the data - remove code that could do harm to website
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        // Validate the email - check if it "looks" like a valid email address.
        $clientEmail = checkEmail($clientEmail);
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        // Validate the passwords length,capital letter,1 number and special character.
        $checkPassword = checkPassword($clientPassword);

        // Check for missing data
        if (empty($clientEmail) || empty($checkPassword)) {
            $message = "<p class='failure-message'>Please provide information for all empty form fields.</p>";
            include '../view/login.php';
            // stop the rest of the php code below from running
            exit;
        }

        // A valid password exists, proceed with the login process
        // Query the client data based on the email address - $clientData is an array of db records
        $clientData = getClient($clientEmail);
        if(empty($clientData)){
            $message = '<p class="failure-message">Please check your email and try again.</p>';
            include '../view/login.php';
            exit;
        }

        // Compare the password just submitted against the hashed password for the matching
        // client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);

        // If the hashes don't match - create an error and return to the login view
        if (!$hashCheck) {
            $message = '<p class="failure-message">Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }

        // A valid user exists, log them in
        if (!isset($_SESSION['loggedin'])) {
            $_SESSION['loggedin'] = TRUE;
        }
        
        // Remove the password from the array - the array_pop function removes the last
        // element from an array
        array_pop($clientData);

        // Store the array of client data into the session
        $_SESSION['clientData'] = $clientData;

        // Get the vehicles reviews of the user just logged in - if any
        $clientReviews = getReviewInfoByClient($clientData['clientId']);
        // print_r($clientReviews);
        // Check if any reviews were returned from the database
        if (count($clientReviews) >= 1) {
            $clientReviews = buildReviewsDisplay($clientReviews);
            // print_r($clientReviews);
            // Store the array of client reviews into the session
            $_SESSION['clientReviews'] = $clientReviews;
        }
        
        // Send the user to the admin view
        include '../view/admin.php';
        exit;

        break;

    case 'logOut':
        // unset($_SESSION['clientData']);
        unset($_SESSION['loggedin']);
        unset($_SESSION['clientData']);
        session_destroy();
        header('Location: /phpmotors/');
        exit();

    // FIRST STEP IN CLIENT USER UPDATE PROCESS - GET USER FROM BD & GO TO USER-UPDATE VIEW
    case 'updateAccount':
        // Getting second value pair coming from a link hence its a GET request
        $clientId = filter_input(INPUT_GET, 'clientId', FILTER_VALIDATE_INT);
        // Getting the information for that single user to be updated
        $accountInfo = getAccountItemInfo($clientId);
        // print_r($accountInfo);
        // Check to see if $invInfo has received data from the database of the vehicle
        if (count($accountInfo) < 1) {
            $message = 'Sorry, No User Client Account Information Could Be Found.';
        }

        // Take the user to the update page - so the account can be updated
        include '../view/account-update.php';

        break;

    // SECOND STEP IN CLIENT USER UPDATE PROCESS - DISPLAY CLIENT INFO & THEN UPDATE ACCOUNT
    case 'updateClientAccountInfo':
        // HANDLING USER DATA WHILE FOLLOWING THE CODE AND DATA PATTERN
        // Filter, validate and store the data - remove code that could do harm to website
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));

        // Validate the email - check if it "looks" like a valid email address.
        $clientEmail = checkEmail($clientEmail);
        // Validate the passwords length,capital letter,1 number and special character.
        // $checkPassword = checkPassword($clientPassword);

        // Check if an email address exists in the clients table
        if($clientEmail !== $_SESSION['clientData']['clientEmail']) {
            $emailAlreadyExists = checkIfEmailExistsInDatabase($clientEmail);
            if ($emailAlreadyExists) {
                $message = '<p class="notification">The Email Address Already Exists.Use Another Email or Maintain Current Email</p>';
                include "../view/account-update.php";
                exit;
            }
        }

        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)) {
            $message = '<p class="failure-message">Please provide information for all empty form fields.</p>';
            include '../view/account-update.php';
            //stop the rest of the php code below from running
            exit;
        }

        // Hash the checked password
        // $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Send the data to the model - Register the user
        $regOutcome = updateClient($clientId, $clientFirstname, $clientLastname, $clientEmail);

        // Check and report the result - Check if the user was successfully registered
        if ($regOutcome === 1) {
            // Set a registration success message
            // $message = "<p class='registration-successful'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
            $_SESSION['message'] = "<p class='success-message'>Your Account Has Been Updated Successfully</p>";
            
            // Update the client session data so all client data displayed on admin can be updated
            $clientData = getClient($clientEmail);
            array_pop($clientData);
            $_SESSION['clientData'] = $clientData;

            // Redirect user to the accounts index-home page
            header('Location: /phpmotors/accounts/');
            // Using header function to direct user to login page and use of sessions to
            // message helps avoid the possibility of resubmitting forms and causing duplicate
            // entries by mistake
            exit;
        } 
        else {
            $message = "<p class='failure-message'>Sorry, Account Update Failed. Please try again.</p>";
            include '../view/account-update.php';
            exit;
        }

        break;

    case 'updateClientPassword':
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Validate the passwords length,capital letter,1 number and special character.
        $checkPassword = checkPassword($clientPassword);

        // Ensure password is not empty
        if(empty($checkPassword)) {
            $message = '<p class="failure-message">Please Enter A New Password In Order to Change To The New Password.</p>';
            include '../view/account-update.php';
            exit;
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        echo "Before call to database";
        // Send the data to the model - change to the new password
        $passwordChangeOutcome = changePassword($clientId, $hashedPassword);

        echo "After call to database";
        // Check and report the result - Check if the user password was successfully changed
        if ($passwordChangeOutcome === 1) {
            // Create session success message
            $_SESSION['message'] = "<p class='success-message'>Your Password Has Been Changed Successfully</p>";
            // Redirect the user to the client admin home page
            header('Location: /phpmotors/accounts/');
            exit;
        } 
        else {
            $message = "<p class='registration-failed'>Sorry, Changing Password Failed. Please try again.</p>";
            include '../view/account-update.php';
            exit;
        }

        break;

    default:
        include '../view/admin.php';
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