<?php

include '../dbConnect.php';


$productName = $_POST['product-name'];

$sql = "DELETE FROM rankingup_product WHERE product_name='$productName' AND username='$username'";

if(mysqli_query($con,$sql)){
    echo "aa";
}

?>