<?php $conn = new mysqli('localhost', 'root', 'root', 'AddressBook');

if ($conn->connect_error) {
echo "Couldn't make a connection";
exit;
}

error_reporting(0);
