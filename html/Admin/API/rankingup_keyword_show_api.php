<?php

include '../dbConnect.php';


$editIx = $_POST['edit-ix'];

$sql = "SELECT FROM rankingup_keyword WHERE edit_ix='$editIx'";
$result = mysqli_query($con,$sql);


$data = array();
$dataCode = '';
while($row = mysqli_num_rows($result)){
    $dataCode .= '<button type="button" class="btn btn-primary keyword-btn">'.
    $row['keyword'].
    '<span class="badge bg-white text-primary ms-1">'.$row['rank'].'<span>'.
    '<span type="button" class="btn-close keyword-delete" data-v="'.$row['ix'].'"></span></button>';


}

// JSON으로 반환
$data = json_encode(array(
    'data' => $dataCode

));

echo $data;

$conn->close();

?>