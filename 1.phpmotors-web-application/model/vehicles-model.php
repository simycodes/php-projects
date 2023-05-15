<?php
// ACCOUNTS MODEL - REGISTRATION MODEL

// ADD NEW VEHICLE CLASSIFICATION TO THE DATABASE
function addVehicleClassification($classificationName){
    // $db is an db instance of new PDO - has several PDO methods and attributes
    $db = phpmotorsConnect();

    //Sql query to insert new car classification
    $sql = 'INSERT INTO carclassification (classificationName) 
    VALUES (:classificationName)';

    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);

    // The next line replace the placeholder in the SQL query
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);

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

// ADD A NEW VEHICLE TO THE DATABASE
function addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId)
{
    // $db is an db instance of new PDO - has several PDO methods and attributes used in
    $db = phpmotorsConnect();

    // The SQL statement - :clientFirstname is a named parameter
    $sql = 'INSERT INTO inventory (invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor, classificationId)
     VALUES (:invMake, :invModel, :invDescription, :invImage, :invThumbnail, :invPrice, :invStock, :invColor, :classificationId)';

    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);

    // The next nine lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);

    // Insert the data
    $stmt->execute();

    // Ask how many rows changed as a result of our insert,the number should be 1 meaning
    // 1 new record was added to the database - the user was vehicle was added successfully
    $rowsChanged = $stmt->rowCount();

    // Close the database interaction
    $stmt->closeCursor();

    // Return the indication of success (rows changed)
    return $rowsChanged;
}

// Get vehicles by classificationId 
function getInventoryByClassification($classificationId){
    // echo "DB function called";
    $db = phpmotorsConnect();
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
    $stmt->execute();
    // Request a multi-dimensional array of the vehicles as an associative array, then 
    // store the array in a variable.
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $inventory;
}

// Selecting a single vehicle based on its id - in order to update the vehicle
// Get vehicle information by invId
function getInvItemInfo($invId){
    $db = phpmotorsConnect();
    // $sql = 'SELECT * FROM inventory WHERE invId = :invId';

    $sql = 'SELECT images.imgPath, invMake, invModel, invDescription, invThumbnail, invImage, invPrice,
    invStock, invColor FROM images 
    JOIN inventory ON images.invId = inventory.invId WHERE inventory.invId = :invId';

    // $sql = 'SELECT * FROM images 
    // JOIN inventory ON (images.invId = inventory.invId) WHERE inventory.invId = :invId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    // $invInfo is an associate array of data from the DB
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;

    // We are requesting an associative array of data, meaning that the database table
    // field names are used as the "name" with the elements in the array of values.
}

// THIS FUNCTION UPDATES A VEHICLE IN THE DATABASE
function updateVehicle($invId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId)
{
    // $db is an db instance of new PDO - has several PDO methods and attributes used in
    $db = phpmotorsConnect();

    // The update SQL statement
    $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, 
	invDescription = :invDescription, invImage = :invImage, 
	invThumbnail = :invThumbnail, invPrice = :invPrice, 
	invStock = :invStock, invColor = :invColor, 
	classificationId = :classificationId WHERE invId = :invId';

    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);

    // The next nine lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);

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

// THIS FUNCTION DELETES A VEHICLE IN THE DATABASE
function deleteVehicle($invId){
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

// THIS FUNCTION GETS A LIST OF VEHICLES BASED ON THE CLASSIFICATION
function getVehiclesByClassification($classificationName) {
    $db = phpmotorsConnect();
    // $sql = 'SELECT * FROM inventory WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName)';

    $sql = 'SELECT images.imgPath, inventory.invId, invMake, invModel, invPrice FROM images 
    JOIN inventory ON images.invId = inventory.invId WHERE classificationId IN 
    (SELECT classificationId FROM carclassification WHERE classificationName
     = :classificationName) and ImgPrimary = 1 and imgPath LIKE "%-tn%"';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicles;

    // UNDERSTANDING SUB-QUERY
    // -- The second part, the subquery in brackets (), is where we get the value to match
    // with the classificationId: IN (SELECT classificationId FROM carclassification WHERE
    // classificationName = :classificationName)
    // The keyword "IN" refers to the value to be returned from the subquery.It comes before the subquery

    // The subquery asks for the classificationId based on a match of the classificationName
    // in the database table that will match the classificationName (e.g. :classificationName)
    // that we will send into the query as a named parameter.

    // we using the name of vehicle in order to get the vehicle id in the subquery.

}

// THIS FUNCTION GETS A SINGLE VEHICLE BASED ON THE VEHICLE ID
function getVehicle($invId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':inId', $invId, PDO::PARAM_STR);
    $stmt->execute();
    $vehicle = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    echo "db vehicle working!";
    return $vehicle;
}

// THIS FUNCTION OBTAINS INFORMATION ABOUT ALL VEHICLES IN THE INVENTORY
function getVehicles() {
    $db = phpmotorsConnect();
    $sql = 'SELECT invId, invMake, invModel FROM inventory';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}



?>