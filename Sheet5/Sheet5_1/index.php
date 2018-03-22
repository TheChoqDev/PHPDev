<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sheet 5 : #1</title>
</head>
<body>
<form method="get" action="test.php">
    <fieldset>
        <h1>Palindrome Tester</h1>
        <p></p>
        <label for="palinString">Phrase to test: </label><br />
        <input type="text" name="palinString"
               value="<?php if (isset($_GET['palinString'])) echo $_GET['palinString']; ?>"/>
        <br /><input type="submit" value="Test">
    </fieldset>
</form>
</body>
</html>

