<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sheet 2 : #1</title>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: remi
 * Date: 2018-02-02
 * Time: 11:35 AM
 */

if (!empty($_GET)) {
    $Temp = $_GET["Temp"];
    $stringVal = $_GET["symbol"];
    convert($Temp, $stringVal);
}else {
    echo "
    
    <form action=\"Sheet2_1.php\" method=\"get\">
        <fieldset>
            <legend>Temperature Converter</legend>
            <label for=\"Temp\">Temperature</label><input type=\"number\" name=\"Temp\">
            <label for=\"symbol\">Symbol</label><input type=\"text\" name=\"symbol\">
            <input type=\"submit\">
        </fieldset>
    </form>
    ";
}
/**
 * @param $convertNum
 * @param $string
 */
function convert($convertNum, $string)
{
    if (is_numeric($convertNum)) {
        if (strcmp(strtoupper($string), 'C') === 0) {
            $convertedC = ($convertNum * 1.8) + 32;
            echo '<h3>' . $convertNum . ' °C is ' . $convertedC . ' °F <br />';
        } else if (strcmp(strtoupper($string), 'F') === 0) {
            $convertedF = ($convertNum - 32) /1.8;
            echo '<h3>' . $convertNum . ' °F is ' . $convertedF . ' °C <br />';
        }else {
            echo "The symbol you entered is invalid.";
        }
    } else {
        echo "The number you entered is... Well ".$convertNum." is not a number...";
    }
}

?>
</body>
</html>
