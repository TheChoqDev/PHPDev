<?php
include("database.inc");

if (!$_POST) {
	//haven't seen the form, so show it
	$display_block .= "
	<form method=\"post\" action=\"".$_SERVER["PHP_SELF"]."\">
	<p><strong>First/Last Names:</strong><br/>
	<input type=\"text\" name=\"f_name\" size=\"30\" maxlength=\"75\">
	<input type=\"text\" name=\"l_name\" size=\"30\" maxlength=\"75\"></p>

	<p><strong>Address:</strong><br/>
	<input type=\"text\" name=\"address\" size=\"30\"></p>

	<p><strong>City/State/Zip:</strong><br/>
	<input type=\"text\" name=\"city\" size=\"30\" maxlength=\"50\">
	<input type=\"text\" name=\"state\" size=\"5\" maxlength=\"2\">
	<input type=\"text\" name=\"zipcode\" size=\"10\" maxlength=\"10\"></p>

	<p><strong>Address Type:</strong><br/>
	<input type=\"radio\" name=\"add_type\" value=\"home\" checked> home
	<input type=\"radio\" name=\"add_type\" value=\"work\"> work
	<input type=\"radio\" name=\"add_type\" value=\"other\"> other</p>

	<p><strong>Telephone Number:</strong><br/>
	<input type=\"text\" name=\"tel_number\" size=\"30\" maxlength=\"25\">
	<input type=\"radio\" name=\"tel_type\" value=\"home\" checked> home
	<input type=\"radio\" name=\"tel_type\" value=\"work\"> work
	<input type=\"radio\" name=\"tel_type\" value=\"other\"> other</p>

	<p><strong>Fax Number:</strong><br/>
	<input type=\"text\" name=\"fax_number\" size=\"30\" maxlength=\"25\">
	<input type=\"radio\" name=\"fax_type\" value=\"home\" checked> home
	<input type=\"radio\" name=\"fax_type\" value=\"work\"> work
	<input type=\"radio\" name=\"fax_type\" value=\"other\"> other</p>

	<p><strong>Email Address:</strong><br/>
	<input type=\"password\" name=\"email\" size=\"30\" maxlength=\"150\">
	<input type=\"radio\" name=\"email_type\" value=\"home\" checked> home
	<input type=\"radio\" name=\"email_type\" value=\"work\"> work
	<input type=\"radio\" name=\"email_type\" value=\"other\"> other</p>
	<p><strong>Personal Note:</strong><br/>
	<textarea name=\"note\" cols=\"35\" rows=\"3\" wrap=\"virtual\"></textarea></p>

	<p><input type=\"submit\" name=\"submit\" value=\"Add Entry\"></p>
	</form>";

} else if ($_POST) {
	//time to add to tables, so check for required fields
	if (($_POST["f_name"] == "") || ($_POST["l_name"] == "")) {
		header("Location: addEntry.php");
		exit;
	}
	
	$date = date('Y-m-d H:i:s');
	//add to master_name table
	$add_master_sql = "INSERT INTO master_name (date_added, date_modified, f_name, l_name)
                       VALUES ('$date', '$date', '".$_POST["f_name"]."', '".$_POST["l_name"]."')";
	$conn->query($add_master_sql) or die("Unable to insert records: ".$conn->error);

	//get master_id for use with other tables
	/*$master_id_res = $conn->query("SELECT id From master_name Where id='".$conn->insert_id."'");
	$row=$conn->mysqli_fetch_array($master_id_res);*/
	$master_id=$conn->insert_id;


	if (($_POST["address"]) || ($_POST["city"]) || ($_POST["state"]) || ($_POST["zipcode"])) {
		//something relevant, so add to address table
		$add_address_sql = "INSERT INTO address (master_id, date_added, date_modified,
		                    address, city, state, zipcode, type)  VALUES ('".$master_id."',
		                    '$date', '$date', '".$_POST["address"]."', '".$_POST["city"]."',
		                    '".$_POST["state"]."' , '".$_POST["zipcode"]."' , '".$_POST["add_type"]."')";
		
        $conn->query($add_address_sql) or die("Unable to insert records: ".$conn->error);
	}

	if ($_POST["tel_number"]) {
		//something relevant, so add to telephone table
		$add_tel_sql = "INSERT INTO telephone (master_id, date_added, date_modified,
		                tel_number, type)  VALUES ('".$master_id."', '$date', '$date',
		                '".$_POST["tel_number"]."', '".$_POST["tel_type"]."')";
        $conn->query($add_tel_sql) or die("Unable to insert records: ".$conn->error);
	}

	if ($_POST["fax_number"]) {
		//something relevant, so add to fax table
		$add_fax_sql = "INSERT INTO fax (master_id, date_added, date_modified,
		                fax_number, type)  VALUES ('".$master_id."', '$date', '$date',
		                '".$_POST["fax_number"]."', '".$_POST["fax_type"]."')";
        $conn->query($add_fax_sql) or die("Unable to insert records: ".$conn->error);
	}

	if ($_POST["email"]) {
		//something relevant, so add to email table
		$add_email_sql = "INSERT INTO email (master_id, date_added, date_modified,
		                  email, type)  VALUES ('".$master_id."', '$date', '$date',
		                  '".$_POST["email"]."', '".$_POST["email_type"]."')";
        $conn->query($add_email_sql) or die("Unable to insert records: ".$conn->error);
	}

	if ($_POST["note"]) {
		//something relevant, so add to notes table
		$add_notes_sql = "INSERT INTO personal_notes (master_id, date_added, date_modified,
		                  note)  VALUES ('".$master_id."', '$date', '$date', '".$_POST["note"]."')";
        $conn->query($add_notes_sql) or die("Unable to insert records: ".$conn->error);
	}
	// close connection to MySQLi
	$conn->close();
	$display_block = "<p>Your entry has been added.  Would you like to <a href=\"addentry.php\">add another</a>?</p>";
}

?>
<html>
<head>
<title>Add an Entry</title>
</head>
<body>
<h1>Add an Entry</h1>
<?php echo $display_block; ?>
</body>
</html>