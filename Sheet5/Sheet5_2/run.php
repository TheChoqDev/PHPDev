<?php
//Defining Taxes
define("TPS", 1.05);
define("TVQ", 1.09975);
//Defining Discounts Array
$itemList = array(
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

        $item = $_GET["itemKey"];
        if (is_numeric($_GET["quantity"])) {
            $quantity = $_GET["quantity"];
            if ($quantity > 0) {
                if (checkStock($quantity, $itemList)) {
                    $thList = ["Name", "Unit Price", "Quantity", "Total Discount", "Price After Discount", "Tax TPS & TVQ", "Total Price"];
                    $itemCategory = $itemList[$item][3];
                    //echo "$itemCategory";
                    $itemPrice = $itemList[$item][1];
                    $itemPriceX = $itemPrice*$quantity;
                    $discount = findDiscount($itemCategory, $discountList,$itemPriceX);

                    //Getting the name from the array so that is uses the wanted capitalization
                    $itemKey = $itemList[$item][0];
                    $itemPriceWithDiscount = $itemPrice * ((100 - $discount) / 100);
                    $taxPrice = (($itemPriceWithDiscount * (TPS)) * (TVQ)) - $itemPriceWithDiscount;
                    $totalPrice = $itemPriceWithDiscount + $taxPrice;
                    $tdList = [$itemKey, number_format((float)$itemPrice, 2, '.', ''),
                        $quantity, number_format((float)$discount, 2, '.', '')."%",
                        number_format((float)$itemPriceWithDiscount * $quantity, 2, '.', ''),
                        number_format((float)$taxPrice * $quantity, 2, '.', ''),
                        number_format((float)$totalPrice * $quantity, 2, '.', '')];
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
                    confirmOrder();
                } else {
                    echo "Sorry, you asked for $quantity " . $itemList[$_GET["itemKey"]][0]  . "s, unfortunately we only have ".$itemList[$_GET["itemKey"]][2]." in stock";
                    throwError();
                }
            } else {
                echo "You want $quantity " . $itemList[$_GET["itemKey"]][0]  . "s, unfortunately we are the ones selling";
                throwError();
            }
        } else {
            echo 'The quantity must be a number.';
            throwError();
        }
    } else {
        echo 'Sorry that is not an item we sell.';
        throwError();
    }

function findDiscount($selected, $discountList,$price)
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
    if (isset($_GET["discount"]) && $price>50) $discountPrice+=(1-(($price-5000)/$price));
    return $discountPrice;
}

function checkStock($number, $itemList)
{
    $hasEnoughStock = false;
        //Debug
        //echo "$number < $item[2] <br>";
        if ($itemList[$_GET['itemKey']][2] >= $number) $hasEnoughStock = true;

    return $hasEnoughStock;
}

function throwError(){
    echo '<form method="get" action="index.php"><input type="hidden" name="itemKey" value="'.$_GET['itemKey'].'" />';
    echo'<input type="hidden" name="quantity" value="'.$_GET['quantity'].'" />';
    if (isset($_GET['discount'])) echo '<input type="hidden" name="discount" value="'.$_GET['discount'].'" />';
    echo '<input type="submit" value="Go Back"></form>';
    echo '<form action="goodbye.html">';
    echo '<input type="submit" value="Exit"></form>';

}

function confirmOrder(){
    echo '<form method="GET" action="index.php"><input type="hidden" name="itemKey" value="'.$_GET['itemKey'].'" />';
    echo'<input type="hidden" name="quantity" value="'.$_GET['quantity'].'" />';
    if (isset($_GET['discount'])) echo '<input type="hidden" name="discount" value="'.$_GET['discount'].'" />';
    echo '<input type="submit" value="Go Back"></form>';
    echo '<form method="GET" action="order.php"><input type="hidden" name="itemKey" value="'.$_GET['itemKey'].'" />';
    echo'<input type="hidden" name="quantity" value="'.$_GET['quantity'].'" />';
    if (isset($_GET['discount'])) echo '<input type="hidden" name="discount" value="'.$_GET['discount'].'" />';
    echo '<input type="submit" value="Place Order"></form>';
}

