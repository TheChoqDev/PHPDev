<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Furniture Temptations</title>
</head>
<body>
<?php
define("TPS", 1.05);
define("TVQ", 1.09975);
//Defining arrays
$itemList = array(
    //array("Name", "Price", "Inventory", "Product Category"),
    array("Chair", 325, 8, "FN"),
    array("Sofa", 450, 0, "FN"),
    array("Table", 150, 10, "FN"),
    array("Lamp", 45, 10, "AC"),
    array("Mirror", 125, 5, "AC"),
    array("Rug", 99, 5, "FL"),
    array("Tiles", 150.50, 20, "FL"),
);

$discountList = array(
    array("FN", 20),
    array("AC", 15)
);


if (!empty($_GET)) {
    echo "<form action=\"index.php\" method=\"get\">
        <fieldset>
            <h3>Order Products</h3>
            <label for=\"itemName\">Item Name: </label><input type=\"text\" name=\"itemName\" id=\"itemName\"/><br/>
            <label for=\"quantity\">Quantity: </label><input type=\"text\" name=\"quantity\" id=\"quantity\"/><br/>
            <input type=\"submit\" value=\"Add to Cart\">
        </fieldset>
    </form>
</div>";

    if (findItem($_GET["itemName"], $itemList)) {
        $item = $_GET["itemName"];
        $itemIndex = getItemIndex($itemList, $item);
        if (is_numeric($_GET["quantity"])) {
            $quantity = $_GET["quantity"];
            if ($quantity > 0) {
                if (checkStock($quantity, $itemList)) {
                    $thList = ["Name", "Unit Price", "Quantity", "Discount", "Price After Discount", "Tax TPS & TVQ", "Total Price"];
                    $itemCategory = $itemList[$itemIndex][3];
                    //echo "$itemCategory";
                    $discount = findDiscount($itemCategory, $discountList);
                    $itemPrice = $itemList[$itemIndex][1];
                    //Getting the name from the array so that is uses the wanted capitalization
                    $itemName = $itemList[$itemIndex][0];
                    $itemPriceWithDiscount = $itemPrice * ((100 - $discount) / 100);
                    $taxPrice = (($itemPriceWithDiscount * (TPS)) * (TVQ)) - $itemPriceWithDiscount;
                    $totalPrice = $itemPriceWithDiscount + $taxPrice;
                    $tdList = [$itemName, $itemPrice, $quantity, "$discount%", $itemPriceWithDiscount * $quantity, $taxPrice * $quantity, $totalPrice * $quantity];
                    echo "<table>";
                    echo "<tr>";
                    foreach ($thList as $item) {
                        echo "<th>$item</th>";
                    }
                    echo "</tr>";
                    echo "<tr>";
                    foreach ($tdList as $item) {
                        echo "<td>$item</td>";
                    }
                    echo "</tr>";
                    echo "</table>";
                } else {
                    echo "Sorry, you asked for $quantity " . $item . "s, unfortunately we don't have that many in stock";
                }
            } else {
                echo "You want $quantity " . $item . "s, unfortunately we are the ones selling";
            }
        } else {
            echo 'The quantity must be a number.';
        }
    } else {
        echo 'Sorry ' . $_GET["itemName"] . ' is not an item we sell.';
    }
} else {
    echo "<div class=\"container\">
    <form action=\"index.php\" method=\"get\">
        <fieldset>
            <h3>Order Products</h3>
            <label for=\"itemName\">Item Name: </label><input type=\"text\" name=\"itemName\" id=\"itemName\"/><br/>
            <label for=\"quantity\">Quantity: </label><input type=\"text\" name=\"quantity\" id=\"quantity\"/><br/>
            <input type=\"submit\" value=\"Add to Cart\">
        </fieldset>
    </form>
</div>";
}
/*~~~~~~~~~~~~~~|Functions|~~~~~~~~~~~~~~*/
function findItem($selected, $itemList)
{
    $itemFound = false;
    foreach ($itemList as $item) {

        //Debug
        //echo strtoupper($item[0]) ." ". strtoupper($selected)." => ".strcmp(strtoupper($item[0]), strtoupper($selected))."<br>";

        if (strcmp(strtoupper($item[0]), strtoupper($selected)) === 0) $itemFound = true;

    }
    return $itemFound;//I love you Rémi
}

/**
 * @param $number
 * @param $itemList
 * @return bool
 */

function findDiscount($selected, $discountList)
{
    $discountPrice = 0;
    foreach ($discountList as $item) {
        //echo "$item[0], $selected";
        if (strcmp($item[0], $selected) === 0) {
            $discountPrice = $item[1];
            break;
        } else {
            $discountPrice = 0;
        }
    }
    return $discountPrice;
}

function getItemIndex($itemList, $selected)
{
    $itemIndex = -1;
    $indexAccumulator = 0;
    foreach ($itemList as $item) {
        //Debug
        //echo strtoupper($item[0]) ." ". strtoupper($selected)." => ".strcmp(strtoupper($item[0]), strtoupper($selected))."<br>";
        if (strcmp(strtoupper($item[0]), strtoupper($selected)) === 0) $itemIndex = $indexAccumulator;
        $indexAccumulator++;
    }
    return $itemIndex;
}

?>
</body>
</html>
