<?php 
include '../dbConnect.php';

$userId = $_POST['userId'];

$sql = "DELETE FROM user_list WHERE user_id = '$userId'";


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