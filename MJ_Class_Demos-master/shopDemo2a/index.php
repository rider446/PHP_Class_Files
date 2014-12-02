<?php
//connection to the database and start the session 
require("common.php");

$submitted_username = '';

// This if statement checks to determine whether the login form has been submitted 
// If it has, then the login code is run, otherwise the form is displayed 

if (!empty($_POST)) {
    // This query retreives the user's information from the database using 
    // their username. 
    $query = " 
            SELECT 
                user_id,
                firstname,
                lastname,
                username, 
                password, 
                salt, 
                email 
            FROM users 
            WHERE 
                username = :username 
        ";

    // The parameter values 
    $query_params = array(
        ':username' => $_POST['username']
    );

    try {
        // Execute the query against the database 
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    } catch (PDOException $ex) {
        // Note: On a production website, you should not output $ex->getMessage(). 
        // It may provide an attacker with helpful information about your code.  
        die("Failed to run query: " . $ex->getMessage());
    }

    // This variable tells us whether the user has successfully logged in or not. 
    // We initialize it to false, assuming they have not. 
    // If we determine that they have entered the right details, then we switch it to true. 

    $login_ok = false;

    // Retrieve the user data from the database.  If $row is false, then the username 
    // they entered is not registered.

    $row = $stmt->fetch();
    if ($row) {
        // Using the password submitted by the user and the salt stored in the database, 
        // we now check to see whether the passwords match by hashing the submitted password 
        // and comparing it to the hashed version already stored in the database. 
        //$check_password = hash('sha256', $_POST['password'] . $row['salt']); 
        $check_password = hash('sha256', $_POST['password'] . 100);
        for ($round = 0; $round < 65536; $round++) {
            $check_password = hash('sha256', $check_password . $row['salt']);
        }

        if ($check_password === $row['password']) {
            // If they do, then we flip this to true 

            $login_ok = true;

            $FullName = $row[firstname] . " " . $row[lastname];
            $_SESSION['fullname'] = $FullName;
        }
    }

    print_r($row);
    // If the user logged in successfully, then we send them to the private members-only page 
    // Otherwise, we display a login failed message and show the login form again 
    if ($login_ok) {
        // Preparing to store the $row array into the $_SESSION by 
        // removing the salt and password values from it.  Although $_SESSION is 
        // stored on the server-side, there is no reason to store sensitive values 
        // in it unless you have to.  Thus, it is best practice to remove these 
        // sensitive values first. 

        unset($row['salt']);
        unset($row['password']);

        // This stores the user's data into the session at the index 'user'. 
        // We will check this index on the private members-only page to determine whether 
        // or not the user is logged in.  We can also use it to retrieve 
        // the user's details. 


        $_SESSION['user'] = $row;

        // Redirect the user to the private members-only page.

        header("Location: privatewelcome.php");
        die("Redirecting to: private.php");
    } else {
        // Tell the user they failed 
        print("Login Failed.<br>");
        print_r($_SESSION);


        $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
    }
}
?> 
<html>
    <head>
        <title>My Store</title>
        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="SiteCSS.css">
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>       
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script> 

        <script>

            //setup jquery accordian
            $(function() {
                $("#accordion").accordion(
                        {
                            collapsible: true,
                            autoHeight: true,
                            heightStyle: "content"
                        }
                );
            });


            //check inputboxes
            function checkInputFields(theform)
            {
                var errMessage = "";

                errMessage = errMessage + validateUsername(theform.username);
                errMessage = errMessage + validatePassword(theform.password);


                if (errMessage === "")
                {
                    //no errors founds
                    return true;
                }
                else
                {
                    //found errors
                    document.getElementById("loginwarning").innerHTML = errMessage;

                    return false;
                }
            }


            function validateUsername(fld) {
                var error = "";
                var illegalChars = /\W/; // allow letters, numbers, and underscores

                if (fld.value === "") {
                    fld.style.background = 'Yellow';
                    error = "* Username - You didn't enter a username.<br>";
                } else if ((fld.value.length < 5) || (fld.value.length > 15)) {
                    fld.style.background = 'Yellow';
                    error = "* Username - The username is the wrong length." +
                            " <br>&nbsp;&nbsp;&nbsp;Needs to be betwen 6 and 14 characters<br>";
                } else if (illegalChars.test(fld.value)) {
                    fld.style.background = 'Yellow';
                    error = "* Username - The username contains illegal characters.<br>";
                } else {
                    fld.style.background = 'White';
                }
                return error;
            }

            function validatePassword(fld) {
                var error = "";
                var illegalChars = /[\W_]/; // allow only letters and numbers 

                if (fld.value === "") {
                    fld.style.background = 'Yellow';
                    error = "* Password - You didn't enter a password.<br>";
                } else if ((fld.value.length < 7) || (fld.value.length > 15)) {
                    error = "* Password - The password is the wrong length. <br>";
                    fld.style.background = 'Yellow';
                } else if (illegalChars.test(fld.value)) {
                    error = "* Password - The password contains illegal characters.<br>";
                    fld.style.background = 'Yellow';
                } else if (!((fld.value.search(/(a-z)+/)) && (fld.value.search(/(0-9)+/)))) {
                    error = "* Password - The password must contain at least one numeral.<br>";
                    fld.style.background = 'Yellow';
                } else {
                    fld.style.background = 'White';
                }
                return error;
            }

        </script>



    </head>
    <body>
        <div class="storeheader">
            <h1>My Store</h1>
        </div>
        <div class="homelogin">
            <form action="index.php" method="post"  onsubmit="return checkInputFields(this)">
                <table>
                    <tr><td><label for="username">Username</label> </td>
                        <td><input type="text" name="username" id="username" value="" size="15" /></td></tr>
                    <tr><td> <label for="password">Password</label></td>
                        <td> <input type="password" name="password" id="password" value="" size="15" /></td></tr>
                    <tr><td><a href="register.php">Register</a></td>
                        <td> <input type="submit" value="Enter" /></td></tr>
                </table>
            </form>
            <p id="loginwarning"></p>
        </div>


        <div class="homecontent">
            <div id="accordion">
                <h3>Welcome</h3>
                <div>
                    <p><a href="catalog.php">catalog</a></p>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim 
                        ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut 
                        aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit 
                        in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                        sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt 
                        mollit anim id est laborum.
                    </p>
                    <p>
                        Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. 
                        Nullam varius, turpis et commodo pharetra, est eros bibendum elit, 
                        nec luctus magna felis sollicitudin mauris. Integer in mauris eu
                        nibh euismod gravida. Duis ac tellus et risus vulputate vehicula.
                        Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula 
                        eu tempor congue, eros est euismod turpis, id tincidunt sapien risus
                        a quam. Maecenas fermentum consequat mi. Donec fermentum. Pellentesque 
                        malesuada nulla a mi. Duis sapien sem, aliquet nec, commodo eget, consequat 
                        quis, neque. Aliquam faucibus, elit ut dictum aliquet, felis nisl adipiscing 
                        sapien, sed malesuada diam lacus eget erat. Cras mollis scelerisque nunc. 
                        Nullam arcu. Aliquam consequat. Curabitur augue lorem, dapibus quis, 
                        laoreet et, pretium ac, nisi. Aenean magna nisl, mollis quis, molestie eu, 
                        feugiat in, orci. In hac habitasse platea dictumst.
                    </p>
                    <p>
                        Fusce convallis, mauris imperdiet gravida bibendum, nisl turpis suscipit 
                        mauris, sed placerat ipsum urna sed risus. In convallis tellus a mauris. 
                        Curabitur non elit ut libero tristique sodales. Mauris a lacus. Donec mattis 
                        semper leo. In hac habitasse platea dictumst. Vivamus facilisis diam at odio. 
                        Mauris dictum, nisi eget consequat elementum, lacus ligula molestie metus, non 
                        feugiat orci magna ac sem. Donec turpis. Donec vitae metus. Morbi tristique 
                        neque eu mauris. Quisque gravida ipsum non sapien. Proin turpis lacus, 
                        scelerisque vitae, elementum at, lobortis ac, quam. Aliquam dictum eleifend 
                        risus. In hac habitasse platea dictumst. Etiam sit amet diam. Suspendisse 
                        odio. Suspendisse nunc. In semper bibendum libero.
                    </p>
                </div>

                <h3>Source Code</h3>
                <div>
                    <xmp>
                        &lt; ?php
                        //connection to the database and start the session 
                        require("common.php");

                        $submitted_username = '';

                        // This if statement checks to determine whether the login form has been submitted 
                        // If it has, then the login code is run, otherwise the form is displayed 

                        if (!empty($_POST)) {
                        // This query retreives the user's information from the database using 
                        // their username. 
                        $query = " 
                        SELECT 
                        user_id,
                        firstname,
                        lastname,
                        username, 
                        password, 
                        salt, 
                        email 
                        FROM users 
                        WHERE 
                        username = :username 
                        ";

                        // The parameter values 
                        $query_params = array(
                        ':username' => $_POST['username']
                        );

                        try {
                        // Execute the query against the database 
                        $stmt = $db->prepare($query);
                        $result = $stmt->execute($query_params);
                        } catch (PDOException $ex) {
                        // Note: On a production website, you should not output $ex->getMessage(). 
                        // It may provide an attacker with helpful information about your code.  
                        die("Failed to run query: " . $ex->getMessage());
                        }

                        // This variable tells us whether the user has successfully logged in or not. 
                        // We initialize it to false, assuming they have not. 
                        // If we determine that they have entered the right details, then we switch it to true. 

                        $login_ok = false;

                        // Retrieve the user data from the database.  If $row is false, then the username 
                        // they entered is not registered.

                        $row = $stmt->fetch();
                        if ($row) {
                        // Using the password submitted by the user and the salt stored in the database, 
                        // we now check to see whether the passwords match by hashing the submitted password 
                        // and comparing it to the hashed version already stored in the database. 
                        //$check_password = hash('sha256', $_POST['password'] . $row['salt']); 
                        $check_password = hash('sha256', $_POST['password'] . 100);
                        for ($round = 0; $round < 65536; $round++) {
                        $check_password = hash('sha256', $check_password . $row['salt']);
                        }

                        if ($check_password === $row['password']) {
                        // If they do, then we flip this to true 

                        $login_ok = true;

                        $FullName = $row[firstname] . " " . $row[lastname];
                        $_SESSION['fullname'] = $FullName;
                        }
                        }

                        print_r($row);
                        // If the user logged in successfully, then we send them to the private members-only page 
                        // Otherwise, we display a login failed message and show the login form again 
                        if ($login_ok) {
                        // Preparing to store the $row array into the $_SESSION by 
                        // removing the salt and password values from it.  Although $_SESSION is 
                        // stored on the server-side, there is no reason to store sensitive values 
                        // in it unless you have to.  Thus, it is best practice to remove these 
                        // sensitive values first. 

                        unset($row['salt']);
                        unset($row['password']);

                        // This stores the user's data into the session at the index 'user'. 
                        // We will check this index on the private members-only page to determine whether 
                        // or not the user is logged in.  We can also use it to retrieve 
                        // the user's details. 


                        $_SESSION['user'] = $row;

                        // Redirect the user to the private members-only page.

                        header("Location: privatewelcome.php");
                        die("Redirecting to: private.php");
                        } else {
                        // Tell the user they failed 
                        print("Login Failed.<br>");
                        print_r($_SESSION);


                        $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
                        }
                        }
                        ?&gt; 
                        <html>
                            <head>
                                <title>My Store</title>
                                <meta charset="UTF-8">

                                <meta name="viewport" content="width=device-width">
                                <link rel="stylesheet" type="text/css" href="SiteCSS.css">
                                <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
                                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>       
                                <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script> 

                                <script>
                $(function() {
                    $("#accordion").accordion();
                });
                                </script>



                            </head>
                            <body>
                                <div class="storeheader">
                                    <h1>My Store</h1>
                                </div>
                                <div class="homelogin">
                                    <form action="index.php" method="post">
                                        <table>
                                            <tr><td><label for="username">Username</label> </td>
                                                <td><input type="text" name="username" id="username" value="" size="15" /></td></tr>
                                            <tr><td> <label for="password">Password</label></td>
                                                <td> <input type="password" name="password" id="password" value="" size="15" /></td></tr>
                                            <tr><td><a href="register.php">Register</a></td>
                                                <td> <input type="submit" value="Enter" /></td></tr>
                                        </table>
                                    </form>
                                </div>


                                <div class="homecontent">
                                    <div id="accordion">
                                        <h3>Welcome</h3>
                                        <div>
                                            <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim 
                                                ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut 
                                                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit 
                                                in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                                                sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt 
                                                mollit anim id est laborum.
                                            </p>
                                            <p>
                                                Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. 
                                                Nullam varius, turpis et commodo pharetra, est eros bibendum elit, 
                                                nec luctus magna felis sollicitudin mauris. Integer in mauris eu
                                                nibh euismod gravida. Duis ac tellus et risus vulputate vehicula.
                                                Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula 
                                                eu tempor congue, eros est euismod turpis, id tincidunt sapien risus
                                                a quam. Maecenas fermentum consequat mi. Donec fermentum. Pellentesque 
                                                malesuada nulla a mi. Duis sapien sem, aliquet nec, commodo eget, consequat 
                                                quis, neque. Aliquam faucibus, elit ut dictum aliquet, felis nisl adipiscing 
                                                sapien, sed malesuada diam lacus eget erat. Cras mollis scelerisque nunc. 
                                                Nullam arcu. Aliquam consequat. Curabitur augue lorem, dapibus quis, 
                                                laoreet et, pretium ac, nisi. Aenean magna nisl, mollis quis, molestie eu, 
                                                feugiat in, orci. In hac habitasse platea dictumst.
                                            </p>
                                            <p>
                                                Fusce convallis, mauris imperdiet gravida bibendum, nisl turpis suscipit 
                                                mauris, sed placerat ipsum urna sed risus. In convallis tellus a mauris. 
                                                Curabitur non elit ut libero tristique sodales. Mauris a lacus. Donec mattis 
                                                semper leo. In hac habitasse platea dictumst. Vivamus facilisis diam at odio. 
                                                Mauris dictum, nisi eget consequat elementum, lacus ligula molestie metus, non 
                                                feugiat orci magna ac sem. Donec turpis. Donec vitae metus. Morbi tristique 
                                                neque eu mauris. Quisque gravida ipsum non sapien. Proin turpis lacus, 
                                                scelerisque vitae, elementum at, lobortis ac, quam. Aliquam dictum eleifend 
                                                risus. In hac habitasse platea dictumst. Etiam sit amet diam. Suspendisse 
                                                odio. Suspendisse nunc. In semper bibendum libero.
                                            </p>
                                        </div>

                                        <h3>Source Code</h3>
                                        <div>
                                            Put code here
                                        </div>                

                                    </div>


                                </div>

                            </body>
                        </html>

                    </xmp>
                </div>                

            </div>


        </div>

    </body>
</html>
