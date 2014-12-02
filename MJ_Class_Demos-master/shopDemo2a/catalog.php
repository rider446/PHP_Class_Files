<?php
require("common.php");
$_SESSION['prod_category'] = "xxCat";


?>
<html>
    <head>
        <title>My Store</title>
        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="SiteCSS.css">
    </head>
    <body>
        <div class="storeheader">
            <h1>My Store - Private Welcome</h1>
        </div>
        <div id="prodSearch">
            <form method="request" action="catalog.php">
                <select id="prod_category"  name="prod_category" value="*">
                    <option value="Aircraft">Aircraft</option>
                    <option value="Engine">Engine</option>
                    <option value="*">All</option>
                </select>
                
                <button id="bttnCategory">Search</button>
               <a href="view_cart.php">View Cart</a> 
            </form>
        </div>
       
        <div class="homecontent">
            <div class="products">
                <?php
                //current URL of the Page. cart_update.php redirects back to this URL
                //$current_url = base64_encode("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                //$xProdCat = filter_input  (1,  $_REQUEST['prod_category']);

                
                if ( empty($_REQUEST['prod_category'])) {

                    $xProdCat = null;
                } else {
                    $xProdCat = $_REQUEST['prod_category'];
                }

                if ($xProdCat == null || $xProdCat == '*') {
                    $query = "SELECT * FROM products ORDER BY ProdCatagory, ProdName ASC";
                } else {
                    $xProdCat = $_REQUEST['prod_category'];
                    $query = "SELECT * "
                            . " FROM products "
                            . " WHERE ProdCatagory =  '" . $xProdCat
                            . "' ORDER BY ProdCatagory, ProdName ASC";
                }

                $stmt = $db->prepare($query);
                $stmt->execute();

                //$results = $db->query("SELECT * FROM products ORDER BY id ASC");

                $results = $stmt->fetchAll(PDO::FETCH_OBJ);

                //print_r($results);
                if ($results) {

                    foreach ($results as $obj) {

                        echo '<div class="prodcat">';
                        echo '<form method="POST" action="cart_update.php">';

                        echo '<div class="prodnamepix">';

                        echo '<div class="prodname"><h3>' . $obj->ProdName . '</h3></div>';
                        echo '<div class="prodthumb">';
                        echo '<img src="img/' . $obj->ProdImage . '" class="prodimg" ></div>';

                        echo '</div>';

                        echo '<div class="proddesc">' . $obj->ProdDescription . '</div>';

                        echo '<div class="prodpriceqty>';
                        echo '<div class="prodprice">Price $' . $obj->ProdPrice . '</div>';
                        echo '<div class="prodqty">'
                        . 'Quantity &nbsp;<select id="product_qty"  name="product_qty" value="">
                                        <option value="0">0</option>                                        
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select><br><button class="add_to_cart">Add To Cart</button></div>';
                        echo '</div>';


                        // echo '</div>';
                        echo '<input type="hidden" name="product_code" value="' . $obj->ProdCode . '" />';
                        echo '<input type="hidden" name="type" value="add" />';
                        echo '<input type="hidden" name="return_url" value="catalog.php" />';
                        //echo '<input type="hidden" name="return_url" value="' . $current_url . '" />';
                        echo '</form>';

                        echo '</div>';
                        echo '<div class="prodbreak"><br><hr /><br></div>';
                    }
                }
                ?>
            </div>
        </div>

    </body>
</html>

