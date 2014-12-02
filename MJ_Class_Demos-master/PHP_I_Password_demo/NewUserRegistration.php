<?php
require "common.php";

if (isset($_POST['username'])) {
    $pwd = $_POST['password'];


    //create sql statement
    $sql_stmt = "INSERT INTO tbl_user "
            . "(firstname, "
            . "lastname, "
            . "username, "
            . "password) "
            . "VALUES "
            . "(:firstname, "
            . ":lastname, "
            . ":username, "
            . ":password)";

    //prepare the sql statement
    $sqlh = $pdo->prepare($sql_stmt);

    //sanitize the input
    $in_firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    $in_lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    $in_username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $in_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    //hash the password
    /*
     * NOTE THAT password_hash should go into a field that
     * is 255 in length.  It also includes a builtin random salt 
     * and it currently uses BCrypt.
     */
    $in_password = password_hash($in_password, PASSWORD_DEFAULT);

    //bind the parameters
    $sqlh->bindparam(":firstname", $in_firstname);
    $sqlh->bindparam(":lastname", $in_lastname);
    $sqlh->bindparam(":username", $in_username);
    $sqlh->bindparam(":password", $in_password);

    //excecute the sqlstatement
    $sqlh->execute();

    echo '<div id="newuserstatus">
        <p>User Was Successfully entered</p>
        </div>';
    
    
}
 else {
    

    echo "        <div id='newuser' >
            <form method='POST' action='NewUserRegistration.php'>
                <table >
                    <tbody>
                        <tr>
                            <td colspan=2>New User</td>
                        </tr>
                        <tr>
                            <td>First Name</td>
                            <td><input type='text' name='firstname' value='joe' size='25' /></td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td><input type='text' name='lastname' value='smith' size='25' /></td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td><input type='text' name='username' value='jsmith' size='25' /></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><input type='password' name='password' value='hotdog' size='25'/></td>
                        </tr>
                        <tr>
                            <td>Confirm Password</td>
                            <td><input type='password' name='password' value='hotdog' size='25' /></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><input type='submit' value='Enter' name='newuserenter' /></td>
                        </tr>
                    </tbody>
                </table>
            </form>

        </div>";
        
 }

?>


<html>
    <head>
        <title></title>



    </head>
    <body>
        <!--
        <div id="newuser" >
            <form method="POST" action="NewUserRegistration.php">
                <table border="1" id="table1">
                    <tbody>
                        <tr>
                            <td colspan="2">New User</td>
                        </tr>
                        <tr>
                            <td>First Name</td>
                            <td><input type="text" name="firstname" value="joe" size="25" /></td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td><input type="text" name="lastname" value="smith" size="25" /></td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td><input type="text" name="username" value="jsmith" size="25" /></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><input type="password" name="password" value="hotdog" size="25"/></td>
                        </tr>
                        <tr>
                            <td>Confirm Password</td>
                            <td><input type="password" name="password" value="hotdog" size="25" /></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><input type="submit" value="Enter" name="newuserenter" /></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <div id="newuserstatus">

        </div>
        -->
        
                <br><a href="index.php">home</a>
    </body>
</html>