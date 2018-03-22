<?php
//connect to database
include("database.inc");

if (!$_POST) {
    //haven't seen the selection form, so show it
    $display_block = "<h1>Select an Entry</h1>";

    //get parts of records
    $get_list_sql = "SELECT id, l_name, f_name FROM master_name ORDER BY l_name, f_name";

    $get_list_res = $conn->query($get_list_sql) or die("Unable to retrieve records :" . $conn->error);

    if ($get_list_res->num_rows < 1) {
        //no records
        $display_block .= "<p><em>Sorry, no records to select!</em></p>";

    } else {
        //has records, so get results and print in a form
        $display_block .= "
		<form method=\"post\" action=\"" . $_SERVER["PHP_SELF"] . "\">
		<p><strong>Select a Record to View:</strong><br/>
		<select name=\"sel_id\">
		<option value=\"\">-- Select One --</option>";

        while ($recs = mysqli_fetch_array($get_list_res)) {
            $id = $recs['id'];
            $display_name = stripslashes($recs['l_name'] . ", " . $recs['f_name']);
            $display_block .= "<option value=\"" . $id . "\">" . $display_name . "</option>";
        }

        $display_block .= "
		</select>
		<p><input type=\"submit\" name=\"submit\" value=\"View Selected Entry\"></p>
		</form>";
    }
    //free result
    $get_list_res->free();

} else if ($_POST) {
    //check for required fields
    if ($_POST["sel_id"] == "") {
        header("Location: selectEntry.php");
        echo "EXITING";
        exit;
    }

    //get master_info
    $get_master_sql = "SELECT f_name, l_name
	                   FROM master_name WHERE id = '" . $_POST["sel_id"] . "'";
    $get_master_res = $conn->query($get_master_sql) or die("Unable to retrieve records :" . $conn->error);

    while ($name_info = $get_master_res->fetch_array()) {
        $display_name = stripslashes($name_info['l_name'] . ", " . $name_info['f_name']);

    }

    $display_block .= "<h1>Showing Record for " . $display_name . "</h1>";

    //free result
    $get_master_res->free();
    //get all addresses
    $get_addresses_sql = "SELECT address, city, state, zipcode, type
	                      FROM address WHERE master_id = '" . $_POST["sel_id"] . "'";
    $get_addresses_res = $conn->query($get_addresses_sql) or die("Unable to retrieve records :" . $conn->error);

    if ($get_addresses_res->num_rows > 0) {

        $display_block .= "<p><strong>Addresses:</strong><br/>
		<ul>";
        while ($add_info = $get_addresses_res->fetch_array()) {
            $address = stripslashes($add_info['address']);
            $city = stripslashes($add_info['city']);
            $state = stripslashes($add_info['state']);
            $zipcode = stripslashes($add_info['zipcode']);
            $address_type = $add_info['type'];
            $display_block .= "<li>$address $city $state $zipcode ($address_type)</li>";
        }

        $display_block .= "</ul>";
    }

    //free result
    $get_addresses_res->free();

    //get all tel
    $get_tel_sql = "SELECT tel_number, type FROM telephone
	                WHERE master_id = '" . $_POST["sel_id"] . "'";
    $get_tel_res = $conn->query($get_tel_sql) or die("Unable to retrieve records :" . $conn->error);

    if ($get_tel_res->num_rows > 0) {

        $display_block .= "<p><strong>Telephone:</strong><br/>
		<ul>";

        while ($tel_info = $get_tel_res->fetch_array()) {
            $tel_number = stripslashes($tel_info['tel_number']);
            $tel_type = $tel_info['type'];

            $display_block .= "<li>$tel_number ($tel_type)</li>";
        }
        $display_block .= "</ul>";
    }

    //free result
    $get_tel_res->free();

    //get all fax
    $get_fax_sql = "SELECT fax_number, type FROM fax
	                WHERE master_id = '" . $_POST["sel_id"] . "'";
    $get_fax_res = $conn->query($get_fax_sql) or die("Unable to retrieve records :" . $conn->error);

    if ($get_fax_res->num_rows > 0) {

        $display_block .= "<p><strong>Fax:</strong><br/>
<ul>";

        while ($fax_info = $get_fax_res->fetch_array()) {
            $fax_number = stripslashes($fax_info['fax_number']);
            $fax_type = $fax_info['type'];

            $display_block .= "<li>$fax_number ($fax_type)</li>";
        }

        $display_block .= "</ul>";
    }

    //free result
    $get_fax_res->free();

    //get all email
    $get_email_sql = "SELECT email, type FROM email
	                  WHERE master_id = '" . $_POST["sel_id"] . "'";
    $get_email_res = $conn->query($get_email_sql) or die("Unable to retrieve records");

    if ($get_email_res->num_rows > 0) {

        $display_block .= "<p><strong>Email:</strong><br/>
		<ul>";

        while ($email_info = $get_email_res->fetch_array()) {
            $email = stripslashes($email_info['email']);
            $email_type = $email_info['type'];

            $display_block .= "<li>$email ($email_type)</li>";
        }

        $display_block .= "</ul>";
    }

    //free result
    $get_email_res->free();

    //get personal note
    $get_notes_sql = "SELECT note FROM personal_notes
	                  WHERE master_id = '" . $_POST["sel_id"] . "'";
    $get_notes_res = $conn->query($get_notes_sql) or die("Unable to retrieve records: ".$conn->error);

    if ($get_notes_res->num_rows == 1) {
        while ($note_info = $get_notes_res->fetch_array()) {
            $note = nl2br(stripslashes($note_info['note']));
        }
        $display_block .= "<p><strong>Personal Notes:</strong><br/>$note</p>";

    }

    //free result
    $get_notes_res->free();

    $display_block .= "<br/>
	<p align=\"center\"><a href=\"" . $_SERVER["PHP_SELF"] . "\">select another</a></p>";
}
//close connection to MySQLi
$conn->close()
?>
<html>
<head>
    <title>My Records</title>
</head>
<body>
<?php echo $display_block;?>
</body>
</html>