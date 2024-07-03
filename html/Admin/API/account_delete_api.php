<?php 
include '../dbConnect.php';

$accountId = $_POST['accountId'];

$sql = "DELETE FROM admin_account WHERE account_id = '$accountId'";


if ($conn->query($sql) === TRUE) {
    $data = json_encode(array(
	    'dataCode' => 200,
	));
} else {
	$data = json_encode(array(
	    'dataCode' => 101,
	));
}

echo $data;

$conn->close();
?>