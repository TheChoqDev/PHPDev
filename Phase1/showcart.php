<?php
//connect to database
include("DBConnect.inc");

$display_block = "<h1>Your Shopping Cart</h1>";

//check for cart items based on user session id

$get_cart_sql = "SELECT st.id, si.item_title, si.item_price, st.sel_item_qty, st.sel_item_size, st.sel_item_color FROM store_shoppertrack AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE session_id = '".$_COOKIE["PHPSESSID"]."'";
$get_cart_res = $conn->query($get_cart_sql) or die("Couldn't connect :".$conn->error);


if ($get_cart_res->num_rows < 1) {
    //print message
    $display_block .= "<p>You have no items in your cart.
    Please <a href=\"seestore.php\">continue to shop</a>!</p>";
} else {
    //get info and build cart display
    $display_block .= "
    <table celpadding=\"3\" cellspacing=\"2\" border=\"1\" width=\"98%\">
    <tr>
    <th>Title</th>
    <th>Price</th>
    <th>Total Price</th>
    <th>Quantity</th>
    <th>Size</th>
    <th>Colour</th>
    <th>Action</th>
    </tr>";

    while ($cart_info = $get_cart_res->fetch_array()) {
   	    $id_no = $cart_info['id'];
   	    $item_title = stripslashes($cart_info['item_title']);
   	    $item_price = $cart_info['item_price'];
   	    $item_qty = $cart_info['sel_item_qty'];
   	    $item_color = $cart_info['sel_item_color'];
   	    $item_size = $cart_info['sel_item_size'];
	    $total_price = sprintf("%.02f", $item_price * $item_qty);

   	    $display_block .= "
   	    <tr>
   	    <td align=\"center\">$item_title <br></td>
   	    <td align=\"center\">\$ $item_price <br></td>
   	    <td align=\"center\">\$ $total_price</td>
   	    <td align=\"center\">$item_qty <br>
   	    <td align=\"center\">$item_size <br></td>
   	    <td align=\"center\">$item_color <br></td>
   	    
   	    
   	    
   	    <td align=\"center\"><a href=\"removefromcart.php?id=".$id_no."\">remove</a></td>
   	    </tr>";
    }

    $display_block .= "</table>";
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>XYZ </title>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <!--Google Font - IBM Plex Sans - Usage: font-family: 'IBM Plex Sans', sans-serif;-->
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:100" rel="stylesheet">
    <style>
        body {
            font-family: 'IBM Plex Sans', sans-serif;
        }
    </style>
</head>
<body>
<section>
    <ul class="nav justify-content-center">
        <li class="nav-item">
            <a class="nav-link" href="index.html">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="aboutus.html">About Us</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="contactus.html">Contact Us</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="seestore.php">Shop</a>
        </li>
<li class="nav-item">
            <a class="nav-link" href="#">Item Cart</a>
        </li>
    </ul>
</section>
<div class="container">
    <div class="col-sm-12">
        <?php echo $display_block; ?>
    </div></div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
