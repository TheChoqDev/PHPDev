<?php
//connect to database
include("DBConnect.inc");

if (isset($_POST["sel_item_id"])) {
    //validate item and get title and price
    $get_iteminfo_sql = "SELECT item_title FROM store_items WHERE id =".$_POST["sel_item_id"];
    $get_iteminfo_res = $conn->query($get_iteminfo_sql) or die("Couldn't connect :".$conn->error);

    if ($get_iteminfo_res->num_rows < 1) {
        //invalid id, send away
        header("Location: seestore.php");
        exit();
    } else {
        //get info
        while ($item_info = $get_iteminfo_res->fetch_array()) {
            $item_title =  stripslashes($item_info['item_title']);
        }

        //add info to cart table
        if(isset($item_info['sel_item_color'])&&$item_info['sel_item_size']){
            $addtocart_sql = "INSERT INTO store_shoppertrack (session_id, sel_item_id, sel_item_qty, sel_item_size, sel_item_color, date_added) VALUES ('" . $_COOKIE["PHPSESSID"] . "', '" . $_POST["sel_item_id"] . "', '" . $_POST["sel_item_qty"] . "', '" . $_POST["sel_item_size"] . "', '" . $_POST["sel_item_color"] . "', now())";
            }else if(isset($item_info['sel_item_size'])){
            $addtocart_sql = "INSERT INTO store_shoppertrack (session_id, sel_item_id, sel_item_qty, sel_item_size,  date_added) VALUES ('" . $_COOKIE["PHPSESSID"] . "', '" . $_POST["sel_item_id"] . "', '" . $_POST["sel_item_qty"] . "', '" . $_POST["sel_item_size"] . "', now())";
        }else if(isset($item_info['sel_item_color'])) {
            $addtocart_sql = "INSERT INTO store_shoppertrack (session_id, sel_item_id, sel_item_qty, sel_item_color, date_added) VALUES ('" . $_COOKIE["PHPSESSID"] . "', '" . $_POST["sel_item_id"] . "', '" . $_POST["sel_item_qty"] . "', '" . $_POST["sel_item_color"] . "', now())";
        }else{
            $addtocart_sql = "INSERT INTO store_shoppertrack (session_id, sel_item_id, sel_item_qty, date_added) VALUES ('" . $_COOKIE["PHPSESSID"] . "', '" . $_POST["sel_item_id"] . "', '" . $_POST["sel_item_qty"] . "', now())";
		}
        $addtocart_res = $conn->query($addtocart_sql) or die("Couldn't connect :".$conn->error);

        //redirect to showcart page
        header("Location: showcart.php");
        exit();
    }

} else {
    //send them somewhere else
    header("Location: seestore.php");
    exit();
}
