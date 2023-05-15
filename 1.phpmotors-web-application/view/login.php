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

    <title>Login Page | PHP Motors</title>

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
            <h1 class="form-title">Sign in</h1>

            <!-- form information -->
            <div class="form-information" id="contact-us-heading">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>
                <form method="post" action="/phpmotors/accounts/index.php">
                    <fieldset>
                        <legend></legend>
                        <!-- putting the input element makes the input field to be activated if input name is clicked or touched -->
                        <label class="top">Email* <input type="email" name="clientEmail" placeholder="someone@gmail.com" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> required></label>
                        <label class="top">Password* <input type="password" name="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required></label>
                        <span>Passwords must be at least 8 characters and contain at least 1 </span>
                        <span>number, 1 capital letter and 1 special character</span>
                    </fieldset>
                    <input type="submit" value="Sign-in" class="submitBtn">
                    <input type="hidden" name="action" value="signIn">
                </form>
            </div>

            <div class="not-member">
                <a href='/phpmotors/accounts/index.php?action=registration'>Not a member yet?</a>
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