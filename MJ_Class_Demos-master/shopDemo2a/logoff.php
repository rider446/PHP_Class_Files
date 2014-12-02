<?php

    // First we execute our common code to connection to the database and start the session 
    require("common.php"); 
     
    // We remove the user's data from the session 
    unset($_SESSION['user']); 
     
    // We redirect them to the login page 
//    header("Location: login.php"); 
//    die("Redirecting to: login.php");
?>
<html>
    <head>
        <title>My Store</title>
        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="SiteCSS.css">

    </head>
    <body>
        <a href="index.php">Login</a><br>
        <div class="storeheader">
            <h1>My Store - Private Welcome</h1>
        </div>

                <div class="homecontent">
            <p>You have successfully  logged off</p>
            <p>
               Please come again.
            </p>

        </div>
    </body>
</html>

