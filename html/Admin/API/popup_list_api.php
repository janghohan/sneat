<?php 			
include '../dbConnect.php';

// 페이지 번호 및 페이지 당 아이템 수 설정
$page = isset($_POST['page']) ? $_POST['page'] : 1;

$itemsPerPage = 10;
$displayPageNum = 10;

// 시작 아이템 및 끝 아이템 계산
$start = ($page - 1) * $itemsPerPage;

$countingNumber = (($page-1)*10) + 1;

$totalRecordsQuery = "SELECT COUNT(*) AS count FROM popup_list";

$totalPages = ceil(($totalRecords+$totalRecords2)/ $itemsPerPage);


$endPage = ((($page - 1) / $displayPageNum) + 1) * $displayPageNum;

if($totalPages < $endPage) $endPage = $totalPages;

$startPage = (($page - 1)/$displayPageNum) * $displayPageNum + 1;

// 데이터 가져오기 쿼리
$query = "SELECT * FROM popup_list ORDER BY create_time DESC LIMIT $start, $itemsPerPage";
$result = $conn->query($query);

// 결과 배열 초기화
$data = array();
$dataCode = '';
// 데이터를 배열에 추가
while ($row = $result->fetch_assoc()) {

	

    $dataCode .= '<tr>';
    $dataCode .= '<td class="control dtr-hidden" tabindex="0" style="display: none;"></td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate d-flex align-items-center">';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$countingNumber;
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate d-flex align-items-center">';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['popup_title'];
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate">';
    $dataCode .= '<label class="switch switch-primary switch-sm">';
    if($row['is_show']=='1'){
        $dataCode .= '<input type="checkbox" class="switch-input is_show" checked data-id="'.$row['popup_id'].'">';
        $dataCode .= '<span class="switch-toggle-slider">';
        $dataCode .= '<span class="switch-on"></span>';
    }else{
        $dataCode .= '<input type="checkbox" class="switch-input is_show" id="switch" data-id="'.$row['popup_id'].'">';
        $dataCode .= '<span class="switch-toggle-slider">';
        $dataCode .= '<span class="switch-off"></span>';
    }
    $dataCode .= '</span>';
    $dataCode .= '</label>';
    $dataCode .= '<span class="d-none">필독</span>';
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<div class="d-inline-block text-nowrap">';
    $dataCode .= '<button class="btn btn-sm btn-icon delete-record" data-id="'.$row['popup_id'].'">';
    $dataCode .= '<i class="bx bx-trash"></i></button>';
    $dataCode .= '<div class="dropdown-menu dropdown-menu-end m-0">';
    $dataCode .= '<a href="admin_account_view.html?accountId='.$row['popup_id'].'" class="dropdown-item">보기</a>';
    $dataCode .= '</div>';
    $dataCode .= '</div>';
    $dataCode .= '</td>';

    $dataCode .= '</tr>';

    $countingNumber ++;


}

// JSON으로 반환
$data = json_encode(array(
    'data' => $dataCode,
    'totalRecords' => $totalRecords,
    'startPage' => $startPage,
    'endPage' => $endPage,
    'totalPages' => $totalPages,
    'test' => (($page - 1) / $displayPageNum) + 1

));

echo $data;

$conn->close();


 ?>

