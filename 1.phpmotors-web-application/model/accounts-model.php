<?php
// ACCOUNTS MODEL - REGISTRATION MODEL

// REGISTER A NEW CLIENT
function regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword){
    // Create a database connection object using the phpmotors connection function
    // $db is an db instance of new PDO - has several PDO methods and attributes used in
    // creating prepared statements that are used to access the database
    $db = phpmotorsConnect();

    // The SQL statement - :clientFirstname is a named parameter, the : is necessary & used
    // when referring to a variable that stands in for the actual variable used in binding
    $sql = 'INSERT INTO clients (clientFirstname, clientLastname,clientEmail, clientPassword)
     VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)';

    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);

    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);

    // Insert the data
    $stmt->execute();

    // Ask how many rows changed as a result of our insert,the number should be 1 meaning
    // 1 new record was added to the database - the user was registered successfully
    $rowsChanged = $stmt->rowCount();

    // Close the database interaction
    $stmt->closeCursor();

    // Return the indication of success (rows changed)
    return $rowsChanged;
}


// This check if an email address exists in the clients table. If so, it will return a 
// positive indicator, if not, it will return a negative indicator.
function checkIfEmailExistsInDatabase($clientEmail) {
    // Create a database connection object using the phpmotors connection function
    $db =  phpmotorsConnect();
    // db query
    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email';
    // Prepare a db query statement
    $stmt = $db->prepare($sql);
    // Bind the actual email to the db query
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    // Execute the query
    $stmt->execute();

    // fetch() gets a single row from the database if a match is found
    // PDO::FETCH_NUM" parameter indicates that only a simple numeric array is needed
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();

    // Checking if the result array is  empty or not
    if(empty($matchEmail)){
        // The email does not exist in the db
        // echo 'Nothing found';
        return 0;
    } 
    else {
        // The email exists in the db - stop registration
        // echo 'Match found';
        return 1;
    }
}

// Get all client data based on an email address - when logging in
function getClient($clientEmail) {
    // Create a database connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // Create the sql query
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword FROM clients WHERE clientEmail = :clientEmail';
    // Prepare the db statement
    $stmt = $db->prepare($sql);
    // Bind the actual email to the query
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    // Execute the query
    $stmt->execute();
    // Get the data and return it
    // The fetch() method returns a single record 
    // PDO::FETCH_ASSOC parameter return a simple array using the database field names as
    // the "name" in the "name - value" pair of the client data
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    // print_r($clientData);
    return $clientData;

    // NOTE:The $clientData returned by fetch(PDO::FETCH_ASSOC); looks like the code below
    // Array ( [clientId] => 14 [clientFirstname] => Bill [clientLastname] => Hickock [clientEmail] => wildbill@ok.com [clientLevel] => 1 [clientPassword] => $2y$10$BhuiPAAubX... )
    
}

// Selecting a single user client account based on its id - in order to update the account
// Get user account information by invId
function getAccountItemInfo($clientId){
    $db = phpmotorsConnect();
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail FROM clients WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    // $accountInfo is an associate array of data from the DB
    $accountInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $accountInfo;

    // We are requesting an associative array of data, meaning that the database table
    // field names are used as the "name" with the elements in the array of values.
}

// THIS FUNCTION UPDATES A USER CLIENT IN THE DATABASE
function updateClient($clientId, $clientFirstname, $clientLastname, $clientEmail){
    // $db is an db instance of new PDO - has several PDO methods and attributes used in
    $db = phpmotorsConnect();

    // The update SQL statement
    $sql = 'UPDATE clients SET clientFirstname = :clientFirstname, clientLastname = :clientLastname, 
	clientEmail = :clientEmail WHERE clientId = :clientId';

    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);

    // The next nine lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);

    // Update the data
    $stmt->execute();

    // Ask how many rows changed as a result of our update,the number should be 1 meaning
    // 1 new record was updated to the database - the user vehicle was updated successfully
    $rowsChanged = $stmt->rowCount();

    // Close the database interaction
    $stmt->closeCursor();

    // Return the indication of success (rows changed)
    return $rowsChanged;
}

// THIS FUNCTION CHANGES-UPDATES CLIENT CURRENT PASSWORD TO NEW PASSWORD
function changePassword($clientId, $clientPassword) {
    $clientId = (int)$clientId;
    // echo " ";
    // echo $clientId;
    // $db is an db instance of new PDO - has several PDO methods and attributes used in
    $db = phpmotorsConnect();

    // The update SQL statement
    $sql = 'UPDATE clients SET clientPassword = :clientPassword WHERE clientId = :clientId';

    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);

    // The next nine lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    // $stmt->bindValue(':clientPassword', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);

    // Update the data
    $stmt->execute();

    // Ask how many rows changed as a result of our update,the number should be 1 meaning
    // 1 new record was updated to the database - the user vehicle was updated successfully
    $rowsChanged = $stmt->rowCount();

    // Close the database interaction
    $stmt->closeCursor();

    // Return the indication of success (rows changed)
    return $rowsChanged;
}

?>