<?php 			
include '../dbConnect.php';

// 페이지 번호 및 페이지 당 아이템 수 설정
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$itemsPerPage = 10;
$displayPageNum = 10;

// 시작 아이템 및 끝 아이템 계산
$start = ($page - 1) * $itemsPerPage;

// 전체 레코드 수 쿼리
$totalRecordsQuery = "SELECT COUNT(*) AS count FROM admin_account";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['count'];
$totalPages = ceil($totalRecords/ $itemsPerPage);
$endPage = ((($page - 1) / $displayPageNum) + 1) * $displayPageNum;

if($totalPages < $endPage) $endPage = $totalPages;

$startPage = (($page - 1)/$displayPageNum) * $displayPageNum + 1;

// 데이터 가져오기 쿼리
$query = "SELECT * FROM admin_account LIMIT $start, $itemsPerPage";
$result = $conn->query($query);

// 결과 배열 초기화
$data = array();
$dataCode = '';
// 데이터를 배열에 추가
while ($row = $result->fetch_assoc()) {

	

    $dataCode .= '<tr>';
    $dataCode .= '<td class="control dtr-hidden" tabindex="0" style="display: none;"></td>';
    $dataCode .= '<td class="sorting_1">';
    $dataCode .= '<div class="d-flex justify-content-start align-items-center user-name">';
    $dataCode .= '<div class="avatar-wrapper">';
    $dataCode .= '<div class="avatar avatar-sm me-3">';

    $states = array('success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary');
    $state = $states[array_rand($states)];

    $dataCode .= '<span class="avatar-initial rounded-circle bg-label-'.$state.'">'.substr($row['email'], 0, 2).'</span>';
    $dataCode .= '</div>';
    $dataCode .= '</div>';

    $dataCode .= '<div class="d-flex flex-column">';
    $dataCode .= '<a href="admin_account_view.html?accountId='.$row['account_id'].'" class="text-body text-truncate">';
    $dataCode .= '<span class="fw-medium">'.$row['name'].'</span>';
    $dataCode .= '</a>';
    $dataCode .= '</div>';
    $dataCode .= '</div>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate d-flex align-items-center">';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['email'];
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['phoneNumber'];

    $dataCode .= '<td>';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['signupDate'];

    $dataCode .= '<td>';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['LastLoginDate'];

    $dataCode .= '<td>';
    $dataCode .= '<div class="d-inline-block text-nowrap">';
    $dataCode .= '<button class="btn btn-sm btn-icon update-record" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEditUser" data-id="'.$row['account_id'].'">';
    $dataCode .= '<i class="bx bx-edit"></i></button>';
    $dataCode .= '<button class="btn btn-sm btn-icon delete-record" data-id="'.$row['account_id'].'">';
    $dataCode .= '<i class="bx bx-trash"></i></button>';
    $dataCode .= '<div class="dropdown-menu dropdown-menu-end m-0">';
    $dataCode .= '<a href="admin_account_view.html?accountId='.$row['account_id'].'" class="dropdown-item">보기</a>';
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

