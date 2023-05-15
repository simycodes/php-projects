<?php
// MAIN PHP MOTORS MODEL - DYNAMIC NAVIGATION MODEL AND DROP DOWN NAVIGATION 

// Function to get car classification names from the database
function getClassifications(){
    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect();     // phpmotorsConnect(); defined in library/connections.php

    // The SQL statement to be used with the database
    //$sql = 'SELECT classificationName FROM carclassification ORDER BY classificationName ASC';
    $sql = 'SELECT classificationName FROM carclassification ORDER BY classificationName';
    // Create the prepared statement using the phpmotors connection
    //This also sends the SQL statement to the database server where it is checked for 
    //correctness, and if it is, a PDO Prepared Statement object is created and stored into
    // the $stmt variable.
    $stmt = $db->prepare($sql);
    // Run the prepared statement
    $stmt->execute();

    // The next line gets the data from the database and
    // stores it as an array in the $classifications variable
    $classifications = $stmt->fetchAll();
    // The next line closes the interaction with the database
    $stmt->closeCursor();
    // The next line sends the array of data back to where the function
    // was called (this should be the controller)
    return $classifications;

    // NOTE
    // The object operator, ->, is used in object scope to access methods and properties
    // of an object.It represents a call to a method of an object.
    // A statement($stmt) is an instance created from a PDO connection instance, that is
    // used to access the database.
}

// Function to get car classification name and id from the database to use drop now menu 
// for adding vehicle page, as each vehicle will belong to a given car classification
function getClassificationsDetails(){
    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect();     // phpmotorsConnect(); defined in library/connections.php

    // The SQL statement to be used with the database
    $sql = 'SELECT classificationId, classificationName FROM carclassification ORDER BY classificationName ASC';

    // Create the prepared statement using the phpmotors connection
    //This also sends the SQL statement to the database server where it is checked for 
    //correctness, and if it is, a PDO Prepared Statement object is created and stored into
    // the $stmt variable.
    $stmt = $db->prepare($sql);
    // Run the prepared statement
    $stmt->execute();

    // The next line gets the data from the database and
    // stores it as an array in the $classifications variable
    $classifications = $stmt->fetchAll();
    // The next line closes the interaction with the database
    $stmt->closeCursor();
    // The next line sends the array of data back to where the function
    // was called (this should be the controller)
    return $classifications;

    // NOTE
    // The object operator, ->, is used in object scope to access methods and properties
    // of an object.It represents a call to a method of an object.
    // A statement($stmt) is an instance created from a PDO connection instance, that is
    // used to access the database.
}

?>