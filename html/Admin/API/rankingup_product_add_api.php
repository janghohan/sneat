<?php

include '../dbConnect.php';


$productName = $_POST['product_name'];
$today = date("Y-m-d H:i:s");

$sql = "INSERT INTO rankingup_product(username,product_name,c_date) VALUES('wkdgh5430','$productName','$today')";

if($conn->query($sql) === TRUE){
    $last_id = $conn->insert_id;
    $data['msg'] = 1;
    $data['productName'] = $productName;
    $data['productIx'] = $last_id;
}else{
    $data['msg'] = 0;
}

$conn->close();

echo json_encode($data);

?>