<?php
//THIS IS THE MAIN CONTROLLER OF THE WEBSITE

// Create or access a Session
session_start();

// Get the database connection file
require_once 'library/connections.php';
// Get the PHP Motors model for use as needed
require_once 'model/main-model.php';
// Get the library functions 
require_once 'library/functions.php';

// Get the array of classifications - getClassifications() defined in model/main-model.php
$classifications = getClassifications();

// Check if data from the database has been stored in $classifications by displaying it
// var_dump($classifications);
// exit;

// Create the main dynamic navigation bar for the website - (function is in library)
$navList = createNavigation($classifications);

//$action variable stores the type of content being requested,home page,registration page
//login page.This request for content comes a URL request which may hold a GET or a POST
//array value/item given as key - value from the user
$action = trim(filter_input(INPUT_POST,'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

if ($action == NULL) {
    $action = trim(filter_input(INPUT_GET,'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
}

// Check if the firstname cookie exist and get its value
if (isset($_COOKIE['firstname'])) {
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

switch ($action) {
    case 'template':
        include 'view/template.php';
        break;
    default:
        include 'view/home.php';
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