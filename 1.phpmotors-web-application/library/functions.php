<?php
// This is library file of custom functions that we will use in our code to perform a 
// variety of tasks.

// This function checks the value of the $clientEmail variable, after having been sanitized,
// to see if it "looks" like a valid email address.
function checkEmail($clientEmail) {
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
 // It returns two values: 1) The actual email address will be returned if it is judged to
 // be "valid", or 2) NULL - indicating the email does not appear to be a valid address.
}

// This function checks password meets the format requirement that we added to our HTML 
// form: at least 8 characters, at least 1 capital letter, at least 1 number and at 
// least 1 special character.
function checkPassword($clientPassword) {
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
    // What is returned from the function is "1" if the password matches the format and
    //  a "0" (zero) if it doesn't.
    // Note: The regular expression above allows spaces to be treated as a
    // "special character".
}

// This function creates the main website navigation using the $classifications array
function createNavigation($classifications){
    // Build a navigation bar using the $classifications array
    $navList = '<ul>';
    $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";

    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName="
        .urlencode($classification['classificationName']).
            "' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a></li>";
    }

    $navList .= '</ul>';
    // echo $navList;
    // exit;
    // .= appends/adds new element/item to a variable/making it a child element,in this case
    // each li element created in the foreach loop is being appended to the $navList variable
    // ul element as a child element

    // The ? and the & in the path represents an indicator to the server that a name-value
    // pair is being sent as a parameter through the URL. In our case, the name is
    // "action" and the value is "classification". 

    return $navList;
}

// Function to check the length of the classification name
function checkClassificationName($classificationName) {
    $length = strlen($classificationName);
    return $length;
}

// Create the classifications select list for the dynamic classification dropdown for the
// vehicle management page 
function buildClassificationList($classifications) {
    // Begin the select element.
    $classificationList = '<select name="classificationId" id="classificationList">';
    // Creating a default option with no value.
    $classificationList .= "<option>Choose a Classification</option>";

    // Loop through the $classifications array to create a new option for each element 
    // within the array.
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
    }
    
    // End the select element.
    $classificationList .= '</select>';

    return $classificationList;
}

// THIS FUNCTION WILL BUILD A DISPLAY OF VEHICLES WITHIN AN UNORDERED LIST
function buildVehiclesDisplay($vehicles) {
    // Create unordered list element to hold all vehicles returned
    // $dv = display vehicles a ul element/variable, not div element
    $dv = '<ul id="inv-display">';
    // Loop through each vehicle and dress it up with html while inserting it in ul element
    foreach ($vehicles as $vehicle) {
        $dv .= '<li>';
        $dv .= "<figure><a href='/phpmotors/vehicles/?action=singleVehicle&invId="
        . urlencode($vehicle['invId']).
            "' title='View All $vehicle[invMake] Vehicle Details'><img src='$vehicle[imgPath]' alt='$vehicle[invMake] $vehicle[invModel] vehicle from the php motors vehicle inventory'></a></figure>";
        $dv .= '<hr>';                                                   // $vehicle[invImage]'

        $dv .= "<h2><a href='/phpmotors/vehicles/?action=singleVehicle&invId="
            .urlencode($vehicle['invId']).
            "' title='View All $vehicle[invMake] Vehicle Details'>$vehicle[invMake]</a></h2>";

        // Adding commas to the price figure from the database using number_format() function
        $vehiclePrice = number_format($vehicle['invPrice']);

        // $dv .= "<h3>$$vehicle[invPrice]</h3>";
        $dv .= "<h3>$$vehiclePrice</h3>";
        $dv .= '</li>';
    }

    $dv .= '</ul>';
    return $dv;

    // $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
    // $dv .= "<h2><a href='/phpmotors/vehicles?action=vehicleName&vehicleId=$vehicle[invId]> $vehicle[invMake] $vehicle[invModel]</a></h2>"; 
}

// THIS FUNCTION BUILDS A DISPLAY OF A SINGLE VEHICLE
function buildSingleVehicleDisplay($vehicle, $AllSingleVehicleThumbnailsDisplay) {
    // Single Vehicle Building
    // Adding commas to the price figure from the database using number_format() function
    $vehiclePrice = number_format($vehicle['invPrice']);
    
    // Building figure element
    $dv = "<figure class='vehicle-image'><img src='$vehicle[imgPath]' alt='$vehicle[invMake] $vehicle[invModel] vehicle from the php motors vehicle inventory' width='800' height='445'></figure>";

    // Building the Vehicle div element
    $dv .= "<div class='vehicle-bottom-information'><p class='vehicle-price'>$$vehiclePrice</p><p class='vehicle-description'>$vehicle[invDescription]</p><p class='vehicle-color'>Color: $vehicle[invColor]</p><p class='vehicle-stock'># In Stock: $vehicle[invStock]</p></div><p class='vehicle-thumbnail-title'>Vehicle Thumbnails</p>$AllSingleVehicleThumbnailsDisplay";
    return $dv;

}

// THIS FUNCTION BUILDS A DISPLAY OF VEHICLE THUMBNAILS FOR A SINGLE VEHICLE
function buildAllSingleVehicleThumbnailsDisplay($AllSingleVehicleThumbnails) {
    if (count($AllSingleVehicleThumbnails) == count($AllSingleVehicleThumbnails, COUNT_RECURSIVE)) {
        // echo "one thumbnail";
        $dv = '<ul class="thumbnail-images">';
        $dv .= '<li>';
        $dv .= "<figure><img src='$AllSingleVehicleThumbnails[imgPath]' alt='This is a vehicle thumbnail from the php motors vehicle inventory'></figure>";
        $dv .= '<li>';
        $dv .= '</ul>';
        return $dv;
    }
    else {
        // echo "two or more thumbnails";
        $thumbnailImageCounter = 1;
        $dv = '<ul class="thumbnail-images">';
        foreach ($AllSingleVehicleThumbnails as $AllSingleVehicleThumbnail) {
            $dv .= '<li>';
            $dv .= "<figure><img src='$AllSingleVehicleThumbnail[imgPath]' alt='This is a vehicle thumbnail number $thumbnailImageCounter from the php motors vehicle inventory'></figure>";
            $dv .= '</li>';
            $thumbnailImageCounter++;
        }
        $dv .= '</ul>';
        return $dv;
    } 
}


// THIS FUNCTION WILL BUILD A DISPLAY OF REVIEWS WITHIN AN UNORDERED LIST FOR CLIENT REVIEWS
function buildReviewsDisplay($reviews) {
    // Create unordered list element to hold all reviews returned
    $dr = '<ul class="clientReviews">';
    foreach ($reviews as $review) {
        // Get the date only from the whole date and time
        $reviewDate = substr($review['reviewDate'], 0, 10);

        $dr .= "<li><span class='first-part-text'>&#10023;$review[invMake] $review[invModel] (Reviewed On $reviewDate):</span> <span class='second-part-text'><a href='/phpmotors/reviews?action=getReviewToUpdate&reviewId=$review[reviewId]' title='Click to update this review'>Edit</a> | <a href='/phpmotors/reviews?action=getReviewToDelete&reviewId=$review[reviewId]' title='Click to delete this review'>Delete</a></span> <li>";
    }
    $dr .= '</ul>';

    return $dr;
}

// THIS FUNCTION WILL BUILD A DISPLAY OF REVIEWS FOR A SINGLE VEHICLE NOT CLIENT
function buildReviewsDisplayForVehicle($reviews) {
    // Create unordered list element to hold all reviews returned
    // Check if array is single array(1 row returned) or dimensional(2 or mores rows returned)

    if (count($reviews) == count($reviews, COUNT_RECURSIVE)) {
        // echo 'array is not multidimensional';
        // echo "one review";

        // Make a single review name for the client
        $firstLetterFromFirstName = substr($reviews['clientFirstname'], 0, 1);
        $reviewName =  $firstLetterFromFirstName . $reviews['clientLastname'];

        $dr = '<ul class="review-container">';
        $dr .= "<li class='review'><h5>$reviewName - Wrote On $reviews[reviewDate]:</h5><p>$reviews[reviewText]</p><li>";
        $dr .= '</ul>';

        return $dr;
    } 
    else {
        // echo 'array is multidimensional';
        // echo "two or more reviews";
        $dr = '<ul class="review-container">';
        foreach ($reviews as $review) {
            // Make a single review name for the client
            // Get first letter from the first name
            $firstLetterFromFirstName = substr($review['clientFirstname'], 0, 1);
            $reviewName =  $firstLetterFromFirstName.$review['clientLastname'];
            // Get the date only from the whole date and time
            $reviewDate = substr($review['reviewDate'], 0, 10);

            // $dr .= "<li class='review'><h4>$review[clientFirstname] $review[clientLastname]<span> - Wrote On $review[reviewDate]:</span></h4><p>$review[reviewText]</p><li>";
            $dr .= "<li class='review'><h4>$reviewName<span> - Wrote On $reviewDate:</span></h4><p>$review[reviewText]</p><li>";
        }
        $dr .= '</ul>';

        return $dr;
    }
}

// THIS FUNCTION WILL BUILD A DISPLAY OF REVIEWS TO BE SHOWED TO THE ADMIN
function buildReviewsDisplayForAdmin($reviews){
    // Create unordered list element to hold all reviews returned
    $dr = '<ul class="clientReviews">';
    foreach ($reviews as $review) {
        // Get the date only from the whole date and time
        $reviewDate = substr($review['reviewDate'], 0, 10);

        $dr .= "<li><span class='first-part-text'>&#10023;$review[invMake] $review[invModel] (Reviewed On $reviewDate by $review[clientFirstName] $review[clientLastName]):</span> <span class='second-part-text'><a href='/phpmotors/reviews?action=getReviewToUpdate&reviewId=$review[reviewId]' title='Click to update this review'>Edit</a> | <a href='/phpmotors/reviews?action=getReviewToDelete&reviewId=$review[reviewId]' title='Click to delete this review'>Delete</a></span> <li>";
    }
    $dr .= '</ul>';

    return $dr;
}



/* * ********************************
*  Functions for working with images
* ********************************* */

// Adds "-tn" designation to file name
function makeThumbnailName($image) {
    // The PHP strrpos() function looks for the location of the period in the image name.
    $i = strrpos($image, '.');
    // The PHP substr() function is then used to break the string apart as if it were an array.
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    // file name is concatenated to the "-tn" string and the extension is concatenated to the end
    $image = $image_name . '-tn' . $ext;
    return $image;
}

// Build images display for image management view
// This function is responsible for taking a multi-dimensional array of image information
// from the database and wrapping it up in HTML for display in the view
function buildImageDisplay($imageArray) {
    
    // inv-display
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
        $id .= '<li>';
        $id .= "<figure><img src='$image[imgPath]' title='$image[invMake] $image[invModel] Vehicle' alt='$image[invMake] $image[invModel] image on PHP Motors.com'></figure>";
        $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
        $id .= '</li>';
    }

    $id .= '</ul>';
    return $id;
}

// Build the vehicles select list
// This function takes a list of inventory vehicle makes, models and id's and builds them
// into an HTML select dropdown menu and is used in the image management view.
function buildVehiclesSelect($vehicles) {
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>&#9662;Choose a Vehicle</option>";
    foreach ($vehicles as $vehicle) {
        $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
}

// Handles the file upload process and returns the path
// This function stores the physical file to the server and returns the path of where the 
// file was stored. That path will then be inserted to the database.
function uploadFile($name) {
    // Gets the paths, full and local directory
    // The path variables (from the controller) are "global"-ized, meaning they are brought
    // into the function's scope for use.
    global $image_dir, $image_dir_path;

    if (isset($_FILES[$name])) {
        // Gets the actual file name
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
            return;
        }

        // Get the file from the temp folder on the server
        $source = $_FILES[$name]['tmp_name'];

        // Sets the new path - images folder in this directory
        $target = $image_dir_path . '/' . $filename;

        // Moves the file to the target folder
        move_uploaded_file($source, $target);

        // Send file for further processing
        processImage($image_dir_path, $filename);

        // Sets the path for the image for Database storage
        $filepath = $image_dir . '/' . $filename;

        // Returns the path where the file is stored
        return $filepath;
    }

}

// This function builds the actual paths for storing the images and also calls a function
// that will resize images to dimensions that are specified. It actually replaces the 
// original file with the modified file and creates the thumbnail file in the same location
// as other images

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
    // Set up the variables
    $dir = $dir . '/';

    // Set up the image path
    $image_path = $dir . $filename;

    // Set up the thumbnail image path
    $image_path_tn = $dir . makeThumbnailName($filename);

    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);

    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
}


// This function It is responsible for:
// 1) checking that only image files are being uploaded.
// 2) checking the size of the image and resizing it if it is larger than what was specified
// 3) replacing old images with new versions and 
// 4) destroying temporary files that may exist.
// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height){
    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];

    // Set up the function names
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image_from_file = 'imagecreatefromjpeg';
            $image_to_file = 'imagejpeg';
            break;
        case IMAGETYPE_GIF:
            $image_from_file = 'imagecreatefromgif';
            $image_to_file = 'imagegif';
            break;
        case IMAGETYPE_PNG:
            $image_from_file = 'imagecreatefrompng';
            $image_to_file = 'imagepng';
            break;
        default:
            return;
    } // ends the swith

    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);

    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;

    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {

        // Calculate height and width for the new image
        $ratio = max($width_ratio, $height_ratio);
        $new_height = round($old_height / $ratio);
        $new_width = round($old_width / $ratio);

        // Create the new image
        $new_image = imagecreatetruecolor($new_width, $new_height);

        // Set transparency according to image type
        if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
        }

        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }

        // Copy old image to new image - this resizes the image
        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

        // Write the new image to a new file
        $image_to_file($new_image, $new_image_path);
        // Free any memory associated with the new image
        imagedestroy($new_image);
    } 
    else {
        // Write the old image to a new file
        $image_to_file($old_image, $new_image_path);
    }

    // Free any memory associated with the old image
    imagedestroy($old_image);

} // ends resizeImage function


// Potential Problems
// While this may sound insane, there seems to be an issue when a image file is created with
// the ".jpeg" extension. If you attempt to upload such a file, it will usually fail to
// actually save the physical image file.

// So, my advice is to use an image editing application to open and then export the file as
// a ".jpg" file. You can't simply change the extension, you have to export or save the
// file as a JPG file with the three letter extension.

// Once that is done, then run the image through the upload process. This seems to solve 
// the issue.

?>