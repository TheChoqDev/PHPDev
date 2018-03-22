<?php
//connect to database
include("database.inc");

if (!$_POST) {
//haven't seen the selection form, so show it
    $display_block = "<h1>Select an Entry</h1>";
//get parts of records
    $get_list_sql = "SELECT id, l_name, f_name FROM master_name ORDER BY l_name, f_name";
    $res1 = $conn->query($get_list_sql) or die("Unable to delete records");
    if ($res1->num_rows < 1) {
//no records
        $display_block .= "<p><em>Sorry, no records to select!</em></p>";
    } else {
//has records, so get results and print in a form
        $display_block .= "<form method=\"".post."\" action=\"".$_SERVER["PHP_SELF"]."\"><p><strong>Select a Record to Delete:</strong><br/><select name=\"sel_id\"><option value=\"\">-- Select One --</option>";
while ($recs = $res1->fetch_array()) {
    $id = $recs['id'];
    $display_name = stripslashes($recs['l_name'] . ", " . $recs['f_name']);
    $display_block .= "<option value=\"" . $id . "\">" . $display_name . "</option>";
}
$display_block .= "</select><p><input type=\"submit\" name=\"submit\" value=\"Delete Selected Entry\"></p></form>";
}
//free result
    $res1->free();
} else if ($_POST) {
//check for required fields
    if ($_POST["sel_id"] == "") {
        header("Location: deleteEntry.php");
        exit;
    }
//issue queries
    $sql2 = "DELETE FROM master_name WHERE id = '" . $_POST["sel_id"] . "'";
    $sql4 = "DELETE FROM address WHERE master_id = '" . $_POST["sel_id"] . "'";
    $sqlx = "DELETE FROM telephone WHERE master_id = '" . $_POST["sel_id"] . "'";
    $sqlfax = "DELETE FROM email WHERE master_id = '" . $_POST["sel_id"] . "'";
    $sqle = "DELETE FROM fax WHERE master_id = '" . $_POST["sel_id"] . "'";
    $del_note_sql = "DELETE FROM personal_notes WHERE master_id = '" . $_POST["sel_id"] . "'";

    $res2 = $conn->query($sql2) or die("Unable to delete records");
    $res3 = $conn->query($sql4) or die("Unable to delete records");
    $res4 = $conn->query($sqlx) or die("Unable to delete records");
    $res5 = $conn->query($sqlfax) or die("Unable to delete records");
    $res6 = $conn->query($sqle) or die("Unable to delete records");
    $res7 = $conn->query($del_note_sql) or die("Unable to delete records");

//free result
//close connection
    $display_block = "<h1>Record(s) Deleted</h1><p>Would you like to <a href=\"" . $_SERVER["PHP_SELF"] . "\">delete another</a>?</p>";
}
?>
<html>
<head>
    <title>My Records</title>
</head>
<body>
<?php echo $display_block; ?>
</body>
</html>