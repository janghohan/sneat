<?php 			
include '../dbConnect.php';

// 페이지 번호 및 페이지 당 아이템 수 설정
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$itemsPerPage = 10;
$displayPageNum = 10;

// 시작 아이템 및 끝 아이템 계산
$start = ($page - 1) * $itemsPerPage;

// 전체 레코드 수 쿼리
$totalRecordsQuery = "SELECT COUNT(*) AS count FROM notice_list";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['count'];
$totalPages = ceil($totalRecords/ $itemsPerPage);
$endPage = ((($page - 1) / $displayPageNum) + 1) * $displayPageNum;

if($totalPages < $endPage) $endPage = $totalPages;

$startPage = (($page - 1)/$displayPageNum) * $displayPageNum + 1;

// 데이터 가져오기 쿼리
$query = "SELECT * FROM notice_list JOIN admin_account ON admin_account.account_id=notice_list.account_id ORDER BY notice_list.create_time DESC LIMIT $start, $itemsPerPage";
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
    $dataCode .= '</span>'.$row['notice_id'];
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate">';
    $dataCode .= '<label class="switch switch-primary switch-sm">';
    if($row['is_pinned']=='1'){
        $dataCode .= '<input type="checkbox" class="switch-input pinned" checked data-id="'.$row['notice_id'].'">';
        $dataCode .= '<span class="switch-toggle-slider">';
        $dataCode .= '<span class="switch-on"></span>';
    }else{
        $dataCode .= '<input type="checkbox" class="switch-input pinned" id="switch" data-id="'.$row['notice_id'].'">';
        $dataCode .= '<span class="switch-toggle-slider">';
        $dataCode .= '<span class="switch-off"></span>';
    }
    $dataCode .= '</span>';
    $dataCode .= '</label>';
    $dataCode .= '<span class="d-none">고정</span>';
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate">';
    $dataCode .= '<label class="switch switch-primary switch-sm">';
    if($row['is_essential']=='1'){
        $dataCode .= '<input type="checkbox" class="switch-input essential" checked data-id="'.$row['notice_id'].'">';
        $dataCode .= '<span class="switch-toggle-slider">';
        $dataCode .= '<span class="switch-on"></span>';
    }else{
        $dataCode .= '<input type="checkbox" class="switch-input essential" id="switch" data-id="'.$row['notice_id'].'">';
        $dataCode .= '<span class="switch-toggle-slider">';
        $dataCode .= '<span class="switch-off"></span>';
    }
    $dataCode .= '</span>';
    $dataCode .= '</label>';
    $dataCode .= '<span class="d-none">필독</span>';
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate d-flex align-items-center">';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['notice_title'];
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate d-flex align-items-center">';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['name'];
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.number_format($row['notice_views']);
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['create_date'];
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<div class="d-inline-block text-nowrap">';
    $dataCode .= '<button class="btn btn-sm btn-icon update-record" data-bs-toggle="modal" data-bs-target="#addNewCCModal" data-id="'.$row['notice_id'].'">';
    $dataCode .= '<i class="bx bx-edit"></i></button>';
    $dataCode .= '<button class="btn btn-sm btn-icon delete-record" data-id="'.$row['notice_id'].'">';
    $dataCode .= '<i class="bx bx-trash"></i></button>';
    $dataCode .= '<div class="dropdown-menu dropdown-menu-end m-0">';
    $dataCode .= '<a href="admin_account_view.html?accountId='.$row['notice_id'].'" class="dropdown-item">보기</a>';
    $dataCode .= '</div>';
    $dataCode .= '</div>';
    $dataCode .= '</td>';

    $dataCode .= '</tr>';



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

