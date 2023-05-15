<!-- HEADER INFORMATION -->
<a href='/phpmotors/index.php'>
    <img src="/phpmotors/images/site/logo.png" alt="This is php website logo" class="logo">
</a>

<?php
// Check if the cookieFirstname is set and echo it
// if (isset($cookieFirstname)) {
//     echo "<span class='welcome-message'>Welcome $cookieFirstname!</span>";
// }

// // Displaying the welcome message if the user is logged in - after logging in only
// // if(isset($_SESSION['loggedin']))
if (isset($_SESSION['loggedin'])) {
    $clientFirstname = $_SESSION['clientData']['clientFirstname'];
     echo "<a href='/phpmotors/accounts/index.php'><span class='welcome-message'>Welcome $clientFirstname  </span></a>";
}
?>

<div>

    <?php
    // if ($_SESSION['loggedin'] == TRUE)
    if (isset($_SESSION['loggedin'])) {
        $clientFirstname = $_SESSION['clientData']['clientFirstname'];
        echo $clientFirstname; 
        echo" | "; 
        echo "<a href='/phpmotors/accounts/index.php?action=logOut'>Logout</a>";
        // echo "logOut";
    } 
    else {
        echo "<a href='/phpmotors/accounts/index.php?action=login'>My Account</a>";
    }
    ?>

    <!-- <a href='/phpmotors/accounts/index.php?action=login'>My Account</a> -->
</div>