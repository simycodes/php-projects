<?php
// UPLOADS MODEL - MODEL RESPONSIBLE FOR IMAGE UPLOAD AND DELETION
// In this model, the functionality is centered around the image information to be stored, 
// retrieved and removed from the database.

// THIS FUNCTION ADDS IMAGE INFORMATION TO THE DATABASE
// This creates two rows in db, one for full image and one for thumbnail image, hence the
// two execute() function calls ($stmt->execute() -- done twice in function below)
function storeImages($imgPath, $invId, $imgName, $imgPrimary) {
    $db = phpmotorsConnect();
    $sql = 'INSERT INTO images (invId, imgPath, imgName, imgPrimary) VALUES (:invId, :imgPath, :imgName, :imgPrimary)';
    $stmt = $db->prepare($sql);

    // Store the full size image information - (bind image data)
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
    $stmt->bindValue(':imgPrimary', $imgPrimary, PDO::PARAM_INT);
    $stmt->execute();

    // Make and store the thumbnail image information
    // A helper function - makeThumbnailName()  is then used to "tear apart" the image name
    // and image path and a "-tn" string is added that indicates the "thumbnail" version of the image.

    // Change name in path
    $imgPath = makeThumbnailName($imgPath); 

    // Change name in file name
    $imgName = makeThumbnailName($imgName);

    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
    $stmt->bindValue(':imgPrimary', $imgPrimary, PDO::PARAM_INT);
    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    // echo "WORKED!!";
    return $rowsChanged;
}

// THIS FUNCTION GETS AN ARRAY OF ALL IMAGE INFORMATION FROM THE IMAGES TABLE
function getImages() {
    $db = phpmotorsConnect();
    // We are using a "JOIN" in the query because we want to get the name and id from the 
    // "inventory" table along with the image information because each image is "tied" to
    // an inventory item 
    $sql = 'SELECT imgId, imgPath, imgName, imgDate, inventory.invId, invMake, invModel FROM images JOIN inventory ON images.invId = inventory.invId';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $imageArray;
}

// THIS FUNCTION DELETES IMAGE INFORMATION FROM THE IMAGES TABLE
function deleteImage($imgId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM images WHERE imgId = :imgId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':imgId', $imgId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
}

// THIS FUNCTION CHECKS IF THE NAME OF THE IMAGE TO BE UPLOADED EXISTS IN DB
function checkExistingImage($imgName) {
    $db = phpmotorsConnect();
    $sql = "SELECT imgName FROM images WHERE imgName = :name";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':name', $imgName, PDO::PARAM_STR);
    $stmt->execute();
    $imageMatch = $stmt->fetch();
    $stmt->closeCursor();
    return $imageMatch;
}

// THIS FUNCTION GETS ALL VEHICLE THUMBNAIL IMAGES (PATH INFORMATION) - FOR A SINGLE VEHICLE
function getAllSingleVehicleThumbnails($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT imgPath FROM images WHERE invId = :invId and imgPath LIKE "%-tn%"';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    // $vehicleThumbnailImages is an associate array of data from the DB
    $vehicleThumbnailImages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicleThumbnailImages;
}


?>