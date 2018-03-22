<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gambler's Garden</title>
</head>
<body>
<form action="index.php" method="get">
    <input type="submit" value="Buy a ticket!">
</form>
<?php
    $fortyNineNumbers = [];
    for ($i = 0; $i<49;$i++)array_push($fortyNineNumbers, $i+1);
    shuffle($fortyNineNumbers);
    $ticketNumbers = array_slice($fortyNineNumbers, 0,6);
    sort($ticketNumbers);

    echo 'Ticket numbers: ';
foreach ($ticketNumbers as $ticketNumber) {
        echo "$ticketNumber ";
    }
?>
</body>
</html>
