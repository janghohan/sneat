<?php 
include '../dbConnect.php';

$popupId = $_POST['popupId'];
$shown = $_POST['shown'];


if($shown=="true"){
	$shown = '1';
}else{
	$shown = '0';
}
$sql = "UPDATE popup_list SET is_show='$shown' WHERE popup_id='$popupId'";

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