<?php 
include '../dbConnect.php';

$noticeId = isset($_POST['noticeId']) ? $_POST['noticeId'] : '';
$noticeTitle = isset($_POST['title']) ? $_POST['title'] : '';
$pinned = isset($_POST['pinned']) ? $_POST['pinned'] : '';
$essential = isset($_POST['essential']) ? $_POST['essential'] : '';
$content = isset($_POST['content']) ? $_POST['content'] : '';

if($pinned=="true") {
	$pinned = 1;
}else{
	$pinned = 0;
}

if($essential=="true") {
	$essential = 1;
}else{
	$essential = 0;
}

$sql = "UPDATE notice_list SET notice_title='$noticeTitle', is_pinned='$pinned', is_essential='$essential', notice_content='$content' WHERE notice_id='$noticeId'";

if ($conn->query($sql)) {
    echo 200;
} else {
    echo 100;
}

$conn->close();


 ?>