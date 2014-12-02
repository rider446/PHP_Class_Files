<?php
require "common.php";

$status_message = "";

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

    try {
        //excecute the sqlstatement
        $sqlh->execute();
        $status_message = "User Successfully added.";
    } catch (PDOException $e) {
        $status_message = "Failed Please Try Again.";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<?php echo $status_message  ?>
        
        <br><a href="index.php">home</a>
    </body>
</html>
