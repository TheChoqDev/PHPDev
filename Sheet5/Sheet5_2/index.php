<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Furniture Temptations</title>
</head>
<?php
//Defining arrays
$itemList = array(
    array("Chair", 325, 8, "FN"),
    array("Sofa", 450, 0, "FN"),
    array("Table", 150, 10, "FN"),
    array("Lamp", 45, 10, "AC"),
    array("Mirror", 125, 5, "AC"),
    array("Rug", 99, 5, "FL"),
    array("Tiles", 150.50, 20, "FL"),
);
?>
<body>
<form action="run.php" method="get">
    <fieldset>
        <h3>Order Products</h3>
        <label for="itemKey">Item Name: </label>
        <select name="itemKey">
            <?php

            foreach ($itemList as $key => $item){
                $stickyString = "";
                if ($_GET['itemKey'] == $key) $stickyString.="selected";
                echo "<option value='$key' $stickyString>$item[0]</option>";
            } ?>
        </select>
        <br/>
        <label for="quantity">Quantity: </label>
        <select name="quantity">
            <?php
            for ($i = 1; $i <= 10; $i++){
                $stickyString = "";
                if ($_GET['quantity'] == $i) $stickyString.="selected";
                echo "<option value=\"$i\" $stickyString>$i</option>";
            }
            ?>
        </select><br/>
        <label for="discount">$50 Discount </label>

        <?php
        $stickyString = '';
        if (isset($_GET["discount"])) $stickyString.="checked";
        echo"<input type=\"checkbox\" name=\"discount\" $stickyString>";?>
        <br/>
        <input type="submit" value="Add to Cart">
    </fieldset>
</form>
<pre>
<?php //print_r($itemList); ?>
    </pre>
</body>
</html>