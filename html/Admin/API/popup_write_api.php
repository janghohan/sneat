<?php 
include '../dbConnect.php';

$popupTitle = isset($_POST['popupTitle']) ? $_POST['popupTitle'] : '';
$shown = isset($_POST['shown']) ? $_POST['shown'] : '';
$content = isset($_POST['content']) ? $_POST['content'] : '';

if($shown=="true"){
	$shown = 1;
}else{
	$shown = 1;
}

$sql = "INSERT INTO popup_list(popup_title,popup_content,is_show) VALUES('$popupTitle','$content','$shown')";

if ($conn->query($sql)) {
    echo 200;
} else {
    echo 100;
}

$conn->close();


 ?>