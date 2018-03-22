<?php
//connect to database
include("DBConnect.inc");

if (isset($_GET["id"])) {
$delete_item_sql = "DELETE FROM store_shoppertrack WHERE id = '".$_GET["id"]."' and session_id = '".$_COOKIE["PHPSESSID"]."'";
$delete_item_res = $conn->query($delete_item_sql) or die("Couldn't connect :".$conn->error);
//redirect to showcart page
header("Location: showcart.php");
exit();}
//send them somewhere else
header("Location: seestore.php");
exit();

