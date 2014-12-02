<?php
//session_start();
include("common.php");


//$current_url = $_SERVER['REQUEST_URI'];
$current_url = "view_cart.php";
?>


<html>
    <head>
         <link rel="stylesheet" type="text/css" href="SiteCSS.css">
    </head>
    <body>
                <div class="storeheader">
            <h1>My Store</h1>
        </div>
        
        <div class="homecontent">
            <a href="catalog.php">Catalog</a><br><br>
<?php
if (isset($_SESSION["products"])) {
    $total = 0;
    echo '<form method="post" action="PAYMENT-GATEWAY">';
    echo '<ul>';
    $cart_items = 0;
    foreach ($_SESSION["products"] as $cart_itm) {

        $product_code = $cart_itm["code"];


        $query = "SELECT ProdName,ProdDescription,ProdPrice FROM products WHERE ProdCode='$product_code' LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_OBJ);

        echo '<hr />';
        //echo '<li class="cart-itm">';
        echo '<span class="remove-itm"><a href="cart_update.php?removep=' . $cart_itm["code"] . '&return_url=' . $current_url . '">Delete</a></span>';
        echo '<div class="p-price">$' . $results->ProdPrice . '</div>';
        echo '<div class="product-info">';
        echo '<h3>' . $results->ProdName . ' (Code :' . $product_code . ')</h3> ';
        echo '<div class="p-qty">Qty : ' . $cart_itm["qty"] . '</div>';
        echo '<div>' . $results->ProdDescription . '</div>';
        echo '</div>';
        echo '</li>';
        $subtotal = ($cart_itm["price"] * $cart_itm["qty"]);
        $total = ($total + $subtotal);

        echo '<input type="hidden" name="item_name[' . $cart_items . ']" value="' . $results->ProdName . '" />';
        echo '<input type="hidden" name="item_code[' . $cart_items . ']" value="' . $product_code . '" />';
        echo '<input type="hidden" name="item_desc[' . $cart_items . ']" value="' . $results->ProdDescription . '" />';
        echo '<input type="hidden" name="item_qty[' . $cart_items . ']" value="' . $cart_itm["qty"] . '" />';
        $cart_items ++;
    }
    echo '</ul>';
    echo '<span class="check-out-txt">';
    echo '<strong>Total : $' . $total . '</strong>  ';
    echo '</span>';
    echo '</form>';
} else {
    echo 'Your Cart is empty';
}
?>
            </div>
    </body>
</html>