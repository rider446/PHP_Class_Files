<?php
// First we execute our common code to connection to the database and start the session 
require("common.php");

// At the top of the page we check to see whether the user is logged in or not 
if (empty($_SESSION['user'])) {
    // If they are not, we redirect them to the login page. 
    header("Location: login.php");

    die("Redirecting to login.php");
}

?> 
<html>
    <head>
        <title>My Store</title>
        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="SiteCSS.css">

    </head>
    <body>
        <?php
        echo($_SESSION['fullname'].'&nbsp; <a href="logoff.php">Log out</a>');
        ?>
        <div class="storeheader">
            <h1>My Store - Private Welcome</h1>
        </div>

                <div class="homecontent">
            <p>Private Welcome</p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim 
                ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut 
                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit 
                in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt 
                mollit anim id est laborum.
            </p>



        </div>
    </body>
</html>

