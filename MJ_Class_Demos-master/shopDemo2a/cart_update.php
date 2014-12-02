<?php

//session_start(); //start session
include("common.php"); //include config file
//empty cart by distroying current session

if (isset($_GET["emptycart"]) && $_GET["emptycart"] == 1) {
    $return_url = base64_decode($_GET["return_url"]); //return url
    session_destroy();
    header('Location:' . $return_url);
}

//add item in shopping cart
if (isset($_POST["type"]) && $_POST["type"] == 'add') {
    $product_code = filter_var($_POST["product_code"], FILTER_SANITIZE_STRING); //product code
    $product_qty = filter_var($_POST["product_qty"], FILTER_SANITIZE_NUMBER_INT); //product code
    $return_url = base64_decode($_POST["return_url"]); //return url
    //limit quantity for single product


    $query = "SELECT ProdName,ProdPrice FROM products WHERE ProdCode='$product_code' LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_OBJ);


    
   // print_r('  ---  '.$product_code." ---ccc-  ".$stmt);

    if ($results) { //we have the product info 

        $new_product = array(array('name' => $results->ProdName, 'code' => $product_code, 'qty' => $product_qty, 'price' => $results->ProdPrice));
        if (isset($_SESSION["products"])) { //if we have the session
            $found = false; //set found item to false

            foreach ($_SESSION["products"] as $cart_itm) { //loop through session array
                if ($cart_itm["code"] == $product_code) { //the item exist in array
                    $product[] = array('name' => $cart_itm["name"], 'code' => $cart_itm["code"], 'qty' => $product_qty, 'price' => $cart_itm["price"]);
                    $found = true;
                } else {
                    //item doesn't exist in the list, just retrive old info and prepare array for session var
                    $product[] = array('name' => $cart_itm["name"], 'code' => $cart_itm["code"], 'qty' => $cart_itm["qty"], 'price' => $cart_itm["price"]);
                }
            }

            if ($found == false) { //we didn't find item in array
                //add new user item in array
                $_SESSION["products"] = array_merge($product, $new_product);
            } else {
                //found user item in array list, and increased the quantity
                $_SESSION["products"] = $product;
            }
        } else {
            //create a new session var if does not exist
            $_SESSION["products"] = $new_product;
        }
    }

    //redirect back to original page
   //header('Location:' . $return_url);
    header('Location: view_cart.php');
}

//remove item from shopping cart

if (isset($_GET["removep"]) && isset($_GET["return_url"]) && isset($_SESSION["products"])) {  
    $product_code = $_GET["removep"]; //get the product code to remove
    $return_url = base64_decode($_GET["return_url"]); //get return url

    
   
    foreach ($_SESSION["products"] as $cart_itm) { //loop through session array var
        if ($cart_itm["code"] != $product_code) { //item does,t exist in the list
            $product[] = array('name' => $cart_itm["name"], 'code' => $cart_itm["code"], 'qty' => $cart_itm["qty"], 'price' => $cart_itm["price"]);
            //$product[] = array('name' => $cart_itm["name"], 'code' => $cart_itm["code"], 'qty' => $cart_itm["qty"], 'price' => $cart_itm["price"]);
        }

        //create a new product list for cart
        $_SESSION["products"] = $product;
    }

   
    //redirect back to original page
    //header('Location:'.$return_url);
    header('Location: view_cart.php');
}

