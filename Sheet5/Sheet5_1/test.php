<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018-03-14
 * Time: 4:45 PM
 */
if (!empty($_GET)) palindromeTest($_GET["palinString"]);

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

    echo "<p><a href='index.php?palinString=$palinString'>Click here</a> to test an other phrase.</p>";

}