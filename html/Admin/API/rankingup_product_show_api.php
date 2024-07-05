<?php

include '../dbConnect.php';


$productIx = $_POST['product-ix'];

$sql = "SELECT FROM rankingup_edit_list WHERE product_ix='$productIx'";
$result = mysqli_query($con,$sql);


$data = array();
$dataCode = '';
while($row = mysqli_num_rows($result)){
    $accordionNum = 1;

    $dataCode .= '<div style="display: flex; padding-bottom: 1rem;">'.
    '<div class="card accordion-item col-sm-11">';
    '<h2 class="accordion-header ">'.
    '<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion'.$accordionNum.'" aria-expanded="false">'.
    $row['edit_date'].' / '.$row['edit_name'].$row['text_len'].
    '</button></h2>'.
    '<div id="accordion'.$accordionNum.'" class="accordion-collapse collapse" data-bs-parent="#accordionExample">'.
    '<div class="accordion-body editName'.$row['ix'].'">'.
    '</div></div>'.
    '<div class="col-sm-1 d-grid">'.
    '<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter2">'.
    '<span><span class="d-none d-sm-inline-block">키워드</span></span>'.
    '</button></div></div>';

    $accordionNum ++;

}

// JSON으로 반환
$data = json_encode(array(
    'data' => $dataCode

));

echo $data;

$conn->close();

?>