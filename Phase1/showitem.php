<?php
//connect to database
include("DBConnect.inc");

$display_block = "<h1>My Store - Item Detail</h1>";

//validate item
$get_item_sql = "SELECT c.id as cat_id, c.cat_title, si.item_title, si.item_price, si.item_desc, si.item_image FROM store_items AS si LEFT JOIN store_categories AS c on c.id = si.cat_id WHERE si.id = '".$_GET["item_id"]."'";
$get_item_res = $conn->query($get_item_sql) or die("Couldn't connect :".$conn->error);

if ($get_item_res->num_rows < 1) {
   //invalid item
   $display_block .= "<p><em>Invalid item selection.</em></p>";
   }else{
   //valid item, get info
   while ($item_info = $get_item_res->fetch_array()) {
	   $cat_id = $item_info['cat_id'];
	   $cat_title = strtoupper(stripslashes($item_info['cat_title']));
	   $item_title = stripslashes($item_info['item_title']);
	   $item_price = $item_info['item_price'];
	   $item_desc = stripslashes($item_info['item_desc']);
	   $item_image = $item_info['item_image'];
	}

   //make breadcrumb trail

   $display_block .= "<p><strong><em>You are viewing:</em><br/>
   <a href=\"seestore.php?cat_id=".$cat_id."\">".$cat_title."</a> &gt; ".$item_title."</strong></p>
   <table cellpadding=\"3\" cellspacing=\"3\">
   <tr>
   <td valign=\"middle\" align=\"center\"><img class=\"img-fluid\" src=\"Images/$item_image\"/></td>
   <td valign=\"middle\"><p><strong>Description:</strong><br/>".$item_desc."</p>
   <p><strong>Price:</strong> \$".$item_price."</p>
   <form method=\"post\" action=\"addtocart.php\">";
   //free result
   $get_item_res->free();

   //get colors
   $get_colors_sql = "SELECT item_color FROM store_item_color WHERE item_id = '".$_GET["item_id"]."' ORDER BY item_color";
   $get_colors_res = $conn->query($get_colors_sql) or die("Couldn't connect :".$conn->error);

       if ($get_colors_res->num_rows > 0) {
        $display_block .= "<p><strong>Available Colors:</strong><br/>
        <select name=\"sel_item_color\">";

        while ($colors = $get_colors_res->fetch_array()) {
           $item_color = $colors['item_color'];
           $display_block .= "<option value=\"".$item_color."\">".$item_color."</option>";
       }
       $display_block .= "</select>";
   }

   //free result
   $get_colors_res->free();

   //get sizes
   $get_sizes_sql = "SELECT item_size FROM store_item_size WHERE item_id = ".$_GET["item_id"]." ORDER BY item_size";
   $get_sizes_res = $conn->query($get_sizes_sql) or die("Couldn't connect :".$conn->error);

   if ($get_sizes_res->num_rows > 0) {

       $display_block .= "<p><strong>Available Sizes:</strong><br/>
       <select name=\"sel_item_size\">";

       while ($sizes = $get_sizes_res->fetch_array()) {
          $item_size = $sizes['item_size'];
          $display_block .= "<option value=\"".$item_size."\">".$item_size."</option>";
       }
   }

   $display_block .= "</select>";

   //free result
   $get_sizes_res->free();

   $display_block .= "
   <p><strong>Select Quantity:</strong>
   <select name=\"sel_item_qty\">";

   for($i=1; $i<11; $i++) {
       $display_block .= "<option value=\"".$i."\">".$i."</option>";
   }

   $display_block .= "
   </select>
   <input type=\"hidden\" name=\"sel_item_id\" value=\"".$_GET["item_id"]."\"/>
   <p><input type=\"submit\" name=\"submit\" value=\"Add to Cart\"/></p>
   </form>
   </td>
   </tr>
   </table>";
}
//close connection to MySQLi
$conn->close();
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
            <a class="nav-link" href="showcart.php">Item Cart</a>
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