<?php

include '../dbConnect.php';


$productName = $_POST['product-name'];
$today = date("Y-m-d H:i:s");

$sql = "INSERT INTO rankingup_product(username,product_name,c_date) VALUE('wkdgh5430','$productName','$today')";

if(mysqli_query($con,$sql)){
    echo "aa";
}

?>