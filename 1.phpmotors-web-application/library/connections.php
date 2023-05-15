<?php
// PROXY CONNECTION TO THE PHPMOTORS DATABASE


// DATABASE CONNECTION FUNCTION USING A PDO INSTANCE - CONNECTING TO PHPMOTORS DATABASE
// THIS FUNCTION RETURNS A PDO INSTANCE CONNECTION TO THE DATABASE WHICH USED IN OTHER 
// CONTROLLERS (FUNCTIONS) TO GAIN ACCESS TO THE DATABASE
function phpmotorsConnect(){
    $server = 'localhost';
    $dbname = 'phpmotors';
    $username = 'iClient';
    $password = 'rr.NV5b((VK07gzi';

    // the server name and database name are combined into a Data Source Name DSN
    // DSN indicates the type of database being connected to - in this case a MySQL database
    $dsn = "mysql:host=$server;dbname=$dbname";

    // $options tells the server how errors should be handled - argument for new PDO
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    // Create the actual connection object and assign it to a variable
    try {
        $link = new PDO($dsn, $username, $password, $options);
        // $link is an instance-object of new PDO - has several PDO methods and attributes
        // echo 'Connection successful'; 
        return $link;
    } 
    catch (PDOException $e) {
        header('Location: /phpmotors/view/500.php');
        exit;
    }
}

//phpmotorsConnect();

?>