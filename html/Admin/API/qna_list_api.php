<?php           
include '../dbConnect.php';

// 페이지 번호 및 페이지 당 아이템 수 설정
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$isAnswered = isset($_POST['isAnswered']) ? $_POST['isAnswered'] : 'all';

$itemsPerPage = 10;
$displayPageNum = 10;

// 시작 아이템 및 끝 아이템 계산
$start = ($page - 1) * $itemsPerPage;

$countingNumber = (($page-1)*10) + 1;


// 전체 레코드 수 쿼리


if($isAnswered=='all'){
    $totalRecordsQuery = "SELECT COUNT(*) AS count FROM qna_list";
}else if($isAnswered==1){
    $totalRecordsQuery = "SELECT COUNT(*) AS count FROM qna_list WHERE is_answered=1";
}else if($isAnswered==0){
    $totalRecordsQuery = "SELECT COUNT(*) AS count FROM qna_list WHERE is_answered=0";
}

$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['count'];
$totalPages = ceil($totalRecords/ $itemsPerPage);
$endPage = ((($page - 1) / $displayPageNum) + 1) * $displayPageNum;

if($totalPages < $endPage) $endPage = $totalPages;

$startPage = (($page - 1)/$displayPageNum) * $displayPageNum + 1;

// 데이터 가져오기 쿼리
if($isAnswered=='all'){
    $query = "SELECT * FROM qna_list ORDER BY create_time DESC LIMIT $start, $itemsPerPage";
}else if($isAnswered==1){
    $query = "SELECT * FROM qna_list WHERE is_answered=1 ORDER BY create_time DESC LIMIT $start, $itemsPerPage";
}else if($isAnswered==0){
    $query = "SELECT * FROM qna_list WHERE is_answered=0 ORDER BY create_time DESC LIMIT $start, $itemsPerPage";
}

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
    $dataCode .= '</span>'.$row['category'];
    $dataCode .= '</span>';
    $dataCode .= '</td>';


    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate d-flex align-items-center">';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['qna_title'];
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate d-flex align-items-center">';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['user_name'];
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate d-flex align-items-center">';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">';
    if($row['is_member']==1){
        $dataCode .= '</span>회원';
    }else{
        $dataCode .= '</span>비회원';
    }
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate d-flex align-items-center">';
    if($row['is_answered']==1){
        $dataCode .= '<span class="badge bg-primary">';
        $dataCode .= '답변완료</span">';
    }else{
        $dataCode .= '<span class="badge bg-secondary">';
        $dataCode .= '답변대기</span">';
    }
    
    $dataCode .= '</span>';
    $dataCode .= '</td>';


    $dataCode .= '<td>';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['create_time'];
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<div class="d-inline-block text-nowrap">';
    $dataCode .= '<button class="btn btn-sm btn-icon show-record" data-bs-toggle="modal" data-bs-target="#largeModal" data-id="'.$row['qna_id'].'">';
    $dataCode .= '<i class="bx bx-edit"></i></button>';
    $dataCode .= '<button class="btn btn-sm btn-icon delete-record" data-id="'.$row['qna_id'].'">';
    $dataCode .= '<i class="bx bx-trash"></i></button>';
    $dataCode .= '<div class="dropdown-menu dropdown-menu-end m-0">';
    $dataCode .= '<a href="admin_account_view.html?accountId='.$row['qna_id'].'" class="dropdown-item">보기</a>';
    $dataCode .= '</div>';
    $dataCode .= '</div>';
    $dataCode .= '</td>';

    $dataCode .= '</tr>';


    $countingNumber = $countingNumber + 1;
}

// JSON으로 반환
$data = json_encode(array(
    'data' => $dataCode,
    'totalRecords' => $totalRecords,
    'startPage' => $startPage,
    'endPage' => $endPage,
    'totalPages' => $totalPages,
    'test' => (($page - 1) / $displayPageNum) + 1,
    'isAanswered' => $isAnswered

));

echo $data;

$conn->close();


 ?>

