<?php

try 
    { 

        ////$db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options); 
        $db = new PDO("mysql:host=localhost;dbname=wp_storedemo2",'',''); 
        $db->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION); 
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);  
        print_r("**** Good database connection"); 
    } 
    catch(PDOException $ex) 
    { 

        die("Failed to connect to the database: " . $ex->getMessage()); 
    } 


    session_start();
?>

