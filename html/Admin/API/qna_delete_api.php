<?php 
include '../dbConnect.php';

$qnaId = $_POST['qnaId'];

$sql = "DELETE FROM qna_list WHERE qna_id = '$qnaId'";


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