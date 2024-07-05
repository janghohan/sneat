<?php

include '../dbConnect.php';


$productIx = $_POST['product-ix'];
$editName = $_POST['edit-name'];
$editDate = $_POST['edit-date'];
$textLen = strlen($editName);

$sql = "INSERT INTO rankingup_edit_list(product_ix,edit_name,text_len,edit_date) VALUE('$productIx','$editName','$textLen','$editDate')";

if(mysqli_query($con,$sql)){
    echo "aa";
}

?>