<?php

try
{
    $pdo = new PDO("mysql:host=localhost;dbname=wp_newuser_demo;",'root','');
    echo "Good database connection <br>";
    
}
catch (PDOException $e)
{
    echo "Could not connect to database <br>".$e->getMessage();
    
}



?>

