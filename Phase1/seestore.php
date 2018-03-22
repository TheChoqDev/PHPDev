<?php
//connect to database
include("DBConnect.inc");

$display_block = "<h1>My Categories</h1>
<p>Select a category to see its items.</p>

";

//show categories first
$get_cats_sql = "SELECT id, cat_title, cat_desc FROM store_categories ORDER BY cat_title";
$get_cats_res = $conn->query($get_cats_sql) or die("Couldn't connect :".$conn->error);

if ($get_cats_res->num_rows < 1) {

    $display_block = "<p><em>Sorry, no categories to browse.</em></p>";
}else{
    while ($cats = $get_cats_res->fetch_array()) {
        $cat_id = $cats['id'];
        $cat_title = strtoupper(stripslashes($cats['cat_title']));
        $cat_desc = stripslashes($cats['cat_desc']);

        $display_block .= "<p><strong><a href=\"" . $_SERVER["PHP_SELF"] . "?cat_id=" . $cat_id . "\">" . $cat_title . "</a></strong><br/>" . $cat_desc . "</p>";

        if (!isset($_GET["cat_id"])) {
        }else{

            if ($_GET["cat_id"] == $cat_id) {
                //get items
                $get_items_sql = "SELECT id, item_title, item_price FROM store_items WHERE cat_id = '" . $cat_id . "' ORDER BY item_title";
                $get_items_res = $conn->query($get_items_sql) or die("Couldn't connect :".$conn->error);

                if ($get_items_res->num_rows < 1) {
                    $display_block .= "<p><em>Sorry, no items in this category.</em></p>";
                    //$display_block .= "<ul>";
                }else{
                    while ($items = $get_items_res->fetch_array()) {

                        $item_id = $items['id'];
                        $item_title = stripslashes($items['item_title']);
                        $item_price = $items['item_price'];

                        $display_block .= "<li><a href=\"showitem.php?item_id=" . $item_id . "\">" . $item_title . "</a></strong> (\$" . $item_price . ")</li>";
                    }

                    $display_block .= "</ul>";
                }

                //free results
                $get_items_res->free();

            }
        }
    }
//free results
    $get_cats_res->free();

//close connection to MySQL
    $conn->close();
}?>
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"                          integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"       integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
