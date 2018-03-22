<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sheet 2 : #2</title>
</head>
<body>

<?php
echo "
<form>
    <fieldset>
        <h1>Palindrome Tester</h1>
        <p></p>
        <label for=\"palinString\">Phrase to test: <br /><textarea name=\"palinString\"></textarea></label>
        <br /><input type=\"submit\">
    </fieldset>
</form>
";
if (!empty($_GET)) palindromeTest($_GET["palinString"]);
/**
 * Created by PhpStorm.
 * User: remi
 * Date: 2018-02-02
 * Time: 12:17 PM
 */


function palindromeTest($palinString)
{
    $testString = strtoupper(preg_replace('/[^a-z]+/i', '', $palinString));
    $reverseString = strrev($testString);

    //Debugging
    //echo "$testString, $reverseString, strcmp =>".strcmp($testString,$reverseString)."" ;


    if (strcmp($testString, $reverseString) === 0) {
        echo '<h3>"' . $palinString . '" is a palindrome.</h3>';
    } else {
        echo '<h3>"' . $palinString . '" is not a palindrome.</h3>';
    }


}

?>
</body>
</html>

