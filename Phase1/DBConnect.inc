<?php
session_start();
$conn = mysqli_connect("localhost", "root", "root", "Storefront");

if ($conn->connect_error) {
    echo "Couldn't make a connection";
    exit;
}


//error_reporting(0);