<?php
// REVIEWS MODEL

// ADD NEW REVIEW CLASSIFICATION TO THE DATABASE
function addReview($reviewText, $invId, $clientId) {
    // $db is an db instance of new PDO - has several PDO methods and attributes used in
    $db = phpmotorsConnect();

    // The SQL statement - :clientFirstname is a named parameter
    $sql = 'INSERT INTO reviews (reviewText, invId, clientId)
     VALUES (:reviewText, :invId, :clientId)';

    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);

    // The next nine lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    // $stmt->bindValue(':reviewDate', $reviewDate, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);

    // Insert the data
    $stmt->execute();

    // Ask how many rows changed as a result of our insert,the number should be 1 meaning
    // 1 new record was added to the database
    $rowsChanged = $stmt->rowCount();

    // Close the database interaction
    $stmt->closeCursor();

    // Return the indication of success (rows changed)
    return $rowsChanged;
}

// GET REVIEW INFORMATION FROM DATABASE FOR DISPLAYING, UPDATING AND DELETION PURPOSES
function getReviewInfo($reviewId) {
    $db = phpmotorsConnect();
    // $sql = 'SELECT * FROM reviews WHERE reviewId = :reviewId';
    $sql = 'SELECT reviews.reviewId, reviews.reviewText, reviews.reviewDate, reviews.invId, 
    reviews.clientId, inventory.invMake, inventory.invModel FROM reviews JOIN inventory 
    ON reviews.invId = inventory.invId WHERE reviewId = :reviewId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    
    $reviewInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviewInfo;
}

// THIS FUNCTION GETS ALL THE REVIEWS OF A GIVEN CLIENT
function getReviewInfoByClient($clientId) {
    $db = phpmotorsConnect();
    // $sql = 'SELECT * FROM reviews WHERE clientId = :clientId';
    $sql = 'SELECT reviews.reviewId, reviews.reviewText, reviews.reviewDate, reviews.invId, 
    reviews.clientId, inventory.invMake, inventory.invModel FROM reviews JOIN inventory 
    ON reviews.invId = inventory.invId WHERE clientId = :clientId ORDER BY reviewDate DESC';

    // $sql = 'SELECT * FROM reviews WHERE clientId = :clientId IN (SELECT clientId FROM reviews GROUP BY clientId HAVING COUNT(*) > 1)';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();

    // $reviewInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $reviewInfo  = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->closeCursor();
    return $reviewInfo;
}

// THIS FUNCTION UPDATES A REVIEW
function updateReview($reviewText, $reviewId) {
    // $db is an db instance of new PDO - has several PDO methods and attributes used in
    $db = phpmotorsConnect();

    // The update SQL statement
    $sql = 'UPDATE reviews SET reviewText = :reviewText WHERE reviewId = :reviewId';

    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);

    // The next nine lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    
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

// THIS FUNCTION DELETES A REVIEW IN THE DATABASE
function deleteReview($reviewId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

// THIS FUNCTION GETS A REVIEW FOR A SINGLE VEHICLE
function getReviewsForASingleVehicle($invId) {
    $db = phpmotorsConnect();
    // $sql = 'SELECT * FROM reviews WHERE invId = :invId';

    $sql = 'SELECT  reviews.reviewText, reviews.reviewDate, clients.clientFirstname, 
    clientLastname FROM reviews JOIN clients 
    ON reviews.clientId = clients.clientId WHERE invId = :invId ORDER BY reviewDate DESC';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    
    $reviewInfo  = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt->closeCursor();
    return $reviewInfo;
}

// THIS FUNCTION GETS ALL REVIEWS FOR THE ADMIN
function getAllClientReviews() {
    $db = phpmotorsConnect();

    $sql = 'SELECT reviews.reviewId, reviews.reviewDate, 
    inventory.invMake, inventory.invModel, clients.clientFirstName,
    clients.clientLastName FROM reviews JOIN inventory 
    ON reviews.invId = inventory.invId JOIN clients ON clients.clientId = reviews.clientId
    ORDER BY reviewDate DESC';

    $stmt = $db->prepare($sql);
    // $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();

    // $reviewInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $allClientsReviewInfo  = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->closeCursor();
    return $allClientsReviewInfo;
}


?>