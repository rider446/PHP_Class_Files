<?php
require( 'common.php');

print_r("<br>*** Good test<br>");
    print_r($_POST);
if(!empty($_POST)) 
    { 
       

        if(empty($_POST['username'])) 
        { 
 
            die("Please enter a username."); 
        } 
         
        // Ensure that the user has entered a non-empty password 
        if(empty($_POST['password'])) 
        { 
            die("Please enter a password."); 
        } 
         

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        { 
            die("Invalid E-Mail Address"); 
        } 
         
 
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                username = :username 
        "; 
         

        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
         
        try 
        { 
            // These two statements run the query against your database table. 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
    
        $row = $stmt->fetch(); 
         
        // If a row was returned, then we know a matching username was found in 
        // the database already and we should not allow the user to continue. 
        if($row) 
        { 
            die("This username is already in use"); 
        } 
         
        // Now we perform the same type of check for the email address, in order 
        // to ensure that it is unique. 
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :email 
        "; 
         
        $query_params = array( 
            ':email' => $_POST['email'] 
        ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
            die("This email address is already registered"); 
        } 
         

        $query = " 
            INSERT INTO users (
                firstname,
                lastname,
                username, 
                password, 
                salt, 
                email 
            ) VALUES ( 
                :firstname,
                :lastname,
                :username, 
                :password, 
                :salt, 
                :email 
            ) 
        "; 
         
        // A salt is randomly generated here to protect again brute force attacks 
        // and rainbow table attacks.  The following statement generates a hex 
        // representation of an 8 byte salt.  Representing this in hex provides 
        // no additional security, but makes it easier for humans to read. 
 
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
        $salt = 100;
        //test $salt = (mt_rand(0, 2147483647)) . (mt_rand(0, 2147483647)); 

        $password = hash('sha256', $_POST['password'] . $salt); 
         
        // Next we hash the hash value 65536 more times.  The purpose of this is to 
        // protect against brute force attacks.  Now an attacker must compute the hash 65537 
        // times for each guess they make against a password, whereas if the password 
        // were hashed only once the attacker would have been able to make 65537 different  
        // guesses in the same amount of time instead of only one. 
        for($round = 0; $round < 65536; $round++) 
        { 
            $password = hash('sha256', $password . $salt); 
        } 
         

        $query_params = array( 
            ':firstname' => $_POST['firstname'],
            ':lastname' => $_POST['lastname'],
            ':username' => $_POST['username'], 
            ':password' => $password, 
            ':salt' => $salt, 
            ':email' => $_POST['email'] 
        ); 
         
        try 
        { 
            // Execute the query to create the user 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // This redirects the user back to the login page after they register 
        ////header("Location: login.php"); 
        header("Location: index.php"); 
         
        // Calling die or exit after performing a redirect using the header function 
        // is critical.  The rest of your PHP script will continue to execute and 
        // will be sent to the user if you do not die or exit. 
        ////die("Redirecting to login.php");
        die("Redirecting to index.php");
    } 

?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" type="text/css" href="SiteCSS.css">


        <script>
            function checkInputFields(theform)
            {
                var errMessage = "";

                errMessage = errMessage + validateFirstname(theform.firstname);
                errMessage = errMessage + validateLastname(theform.lastname);
                errMessage = errMessage + validateUsername(theform.username);
                errMessage = errMessage + validatePassword(theform.password);
                errMessage = errMessage + validateEmail(theform.email);
                
                if (errMessage === "")
                {
                    //no errors founds
                    return true;
                }
                else
                {
                    //found errors
                    document.getElementById("regerr").innerHTML = errMessage;

                    return false;
                }
            }

            function validateFirstname(fld) {
                var error = "";
                var illegalChars = /\W/; // allow letters, numbers, and underscores

                if (fld.value === "") {
                    fld.style.background = 'Yellow';
                    error = "* First Name - You didn't enter a first name.<br>";
                } else if (illegalChars.test(fld.value)) {
                    fld.style.background = 'Yellow';
                    error = "* First Name - The username contains illegal characters.<br>";
                } else {
                    fld.style.background = 'White';
                }
                return error;
            }

            function validateLastname(fld) {
                var error = "";
                var illegalChars = /\W/; // allow letters, numbers, and underscores

                if (fld.value === "") {
                    fld.style.background = 'Yellow';
                    error = "* Last Name - You didn't enter a last name.<br>";
                } else if (illegalChars.test(fld.value)) {
                    fld.style.background = 'Yellow';
                    error = "* Last Name - The username contains illegal characters.<br>";
                } else {
                    fld.style.background = 'White';
                }
                return error;
            }

            function validateUsername(fld) {
                var error = "";
                var illegalChars = /\W/; // allow letters, numbers, and underscores

                if (fld.value === "") {
                    fld.style.background = 'Yellow';
                    error = "* Username - You didn't enter a username.<br>";
                } else if ((fld.value.length < 5) || (fld.value.length > 15)) {
                    fld.style.background = 'Yellow';
                    error = "* Username - The username is the wrong length."+
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

            function validateEmail(fld) {
                var error = "";
                var tfld = fld.vale;                      // value of field with whitespace trimmed off


                if (fld.value === "") {
                    fld.style.background = 'Yellow';
                    error = "* Email - You didn't enter an email address.<br>";
                } 
                else {
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
        <h1>Register</h1>

        <form action="register.php" method="post" onsubmit="return checkInputFields(this)">

            <table>

                <tr>
                    <td>First Name</td>
                    <td><input type="text" name="firstname" id="firstname" value="" size="25" /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type="text" name="lastname" value="" size="25" /></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" id="username" value=""  size="25"/></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" id="password" value="" size="25" /> </td>
                </tr>

                <tr>
                    <td>E-Mail:</td>
                    <td><input type="text" name="email"  id="email" value=""  size="25"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Register" /></td>
                </tr>
            </table>

        </form>

        <p id="regerr"></p>

    </body>
</html>
