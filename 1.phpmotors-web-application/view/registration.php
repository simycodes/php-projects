<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Simon Mule - PHP Motors Website">
    <meta name="Author" content="Simon Mule">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Rajdhani font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Rajdhani:wght@500&display=swap" rel="stylesheet">

    <!-- Rajdhani font link - bold -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Rajdhani:wght@700&display=swap" rel="stylesheet">

    <title>Registration Page | PHP Motors</title>

    <!-- TELLS PHONES NOT TO LIE ABOUT THEIR WIDTH & stops the font from enlarging when a phone is turned sideways-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- STYLE SHEETS -->
    <link href="../css/normalize.css" rel="stylesheet">
    <!-- phone-default -->
    <link href="../css/small.css" rel="stylesheet">
    <!-- enhance-tablet -->
    <link href="../css/medium.css" rel="stylesheet">
    <!-- enhance-desktop -->
    <link href="../css/large.css" rel="stylesheet">
</head>

<body>

    <div class="main-container">
        <!-- HEADER HERE -->
        <header>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
        </header>


        <!-- NAVIGATION HERE -->
        <nav>
            <?php echo $navList; ?>
        </nav>


        <!-- CONTENT HERE -->
        <main>
            <h1 class="form-title">Register</h1>

            <!-- form information -->
            <div class="form-information" id="contact-us-heading">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <form method="post" action="/phpmotors/accounts/index.php">
                    <fieldset>
                        <legend></legend>
                        <!-- putting the input element makes the input field to be activated if input name is clicked or touched -->
                        <label class="top">First Name* 
                            <input type="text" name="clientFirstname" placeholder="Enter your first here" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} ?> required>
                        </label>
                        <label class="top">Last Name* 
                            <input type="text" name="clientLastname" placeholder="Enter your last name here" <?php if(isset($clientLastname)){echo "value='$clientLastname'";} ?> required>
                        </label>
                        <label class="top">Email* 
                            <input type="email" name="clientEmail" placeholder="Enter your last name here" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> required>
                        </label>

                        <label class="top">Password* <input type="password" name="clientPassword" id="showHidePwdArea" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required></label>
                        <span>Passwords must be at least 8 characters and contain at least 1 </span>
                        <span>number, 1 capital letter and 1 special character</span>
                        <br>
                        <input type="button" name="showPassword" value="Show Password" class="showPasswordBtn" id="showPwd">
                    </fieldset>


                    <input type="submit" name="submit" value="Register" class="submitBtn">
                    <!-- Sending the key value-pair,action as the key and register as the value to the accounts controller -->
                    <input type="hidden" name="action" value="register">
                </form>
            </div>

        </main>

        <!-- FOOTER HERE -->
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>

    </div>
    <script src="/phpmotors/js/main.js"></script>

</body>

</html>