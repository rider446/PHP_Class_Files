<?php
require "common.php";

print_r($_POST);

if (isset($_POST['usrName'])) {
    echo "Login true <br><br>";

    $sql_li_stmt = "Select username, password "
            . "From tbl_user "
            . "where username=:usrname";
    $sqlh_li = $pdo->prepare($sql_li_stmt);

    $x_usrName = filter_var($_POST['usrName'], FILTER_SANITIZE_STRING);

    $sqlh_li->bindParam(":usrname", $x_usrName);
    $sqlh_li->execute();


    $li_result = $sqlh_li->fetch();

    print_r($li_result['password'] . "<br><br>");

    $hash = $li_result['password'];


    if (password_verify($_POST['usrpwd'], $hash)) {
        echo 'Password is valid!';
    } else {
        echo 'Invalid password.';
    }

}
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

        <form method="POST" action="Login.php">
            <table border="1">
                <thead>
                    <tr>
                        <th colspan="2">Login</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>username</td>
                        <td><input type="text" name="usrName" value="" size="25" /></td>
                    </tr>
                    <tr>
                        <td>password</td>
                        <td><input type="text" name="usrpwd" value="" size="25" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Enter" name="Enter" /></td>
                    </tr>
                </tbody>
            </table>
        </form>
<?php
// put your code here
?>
    </body>
</html>
