<?php
//set up a couple of functions
function doDB()
{

    //connect to server and select database; you may need it
    $conn = new mysqli('localhost', 'root', 'root', 'subscription');
    //if connection fails, stop script execution
    if ($conn->connect_error) {
        echo "Couldn't make a connection";
        exit;
    }
    return $conn;
}

function emailChecker($email,$conn) {

	//check that SUB_Email is not already in list
	$check_sql = "SELECT SUB_ID FROM subscribers WHERE SUB_Email ='".$email."'";
	$check_res = $conn->query($check_sql);
	return $check_res;
}

//determine if they need to see the form or not
if (empty($_POST)) {
	//they need to see the form, so create form block
	$display_block = "
	<form method=\"POST\" action=\"".$_SERVER["PHP_SELF"]."\">

	<p><strong>Your E-Mail Address:</strong><br/>
	<!--Made it email for my own satisfaction-->
	<input type=\"email\" name=\"SUB_Email\" size=\"40\" maxlength=\"150\">

	<p><strong>Action:</strong><br/>
	<input type=\"radio\" name=\"action\" value=\"sub\" checked> subscribe
	<input type=\"radio\" name=\"action\" value=\"unsub\"> unsubscribe

	<p><input type=\"submit\" name=\"submit\" value=\"Submit Form\"></p>
	</form>";

} else if (($_POST) && ($_POST["action"] == "sub")) {
	//trying to subscribe; validate SUB_Email address
	if ($_POST["SUB_Email"] == "") {
        header("Location: index.php");
		exit;
	} else {
		//connect to database
		$conn = doDB();
		//check that SUB_Email is in list
		$check_res = emailChecker($_POST["SUB_Email"],$conn);

		//get number of results and do action
		if ($check_res->num_rows < 1) {

			//free result
            $check_res->free();

			//add record
			$add_sql = "INSERT INTO subscribers (SUB_Email) VALUES('".$_POST["SUB_Email"]."')";
			$add_res = $conn->query($add_sql) or die($conn->error);
			$display_block = "<p>Thanks for signing up!</p>";

			//close connection to MSSQL
            $conn->close();
		} else {
			//print failure message
			$display_block = "<p>You're already subscribed!</p>";
		}
	}
} else if (($_POST) && ($_POST["action"] == "unsub")) {
	//trying to unsubscribe; validate SUB_Email address
	if ($_POST["SUB_Email"] == "") {
		header("Location: index.php");
		exit;
	} else {
		//connect to database
		$conn = doDB();

		//check that SUB_Email is in list
		$check_res = emailChecker($_POST["SUB_Email"],$conn);

		//get number of results and do action
		if ($check_res->num_rows < 1) {
			//free result
			$check_res->free();

			//print failure message
			$display_block = "<p>Couldn't find your address!</p>
			<p>No action was taken.</p>";
		} else {
			//get value of ID from result

			$id = $check_res->fetch_array()["SUB_ID"];


			//unsubscribe the address
			$del_sql = "DELETE FROM subscribers WHERE SUB_ID =".$id;
			$del_res = $conn->query($del_sql) or die($conn->error);
			$display_block = "<P>You're unsubscribed!</p>";
		}
		$conn->close();
	}
}
?>
<html>
<head>
<title>Subscribe/Unsubscribe to a Mailing List</title>
</head>
<body>
<h1>Subscribe/Unsubscribe to a Mailing List</h1>
<?php echo "$display_block"; ?>
</body>
</html>