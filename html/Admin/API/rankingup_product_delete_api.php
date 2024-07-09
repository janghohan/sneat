<?php

include '../dbConnect.php';


$productIx = $_POST['product_ix'];

$sql = "DELETE FROM rankingup_product WHERE ix='$productIx' AND username='wkdgh5430'";


if($conn->query($sql) === TRUE){
    $data['msg'] = 1;
}else{
    $data['msg'] = 0;
}

$conn->close();

echo json_encode($data);
?>