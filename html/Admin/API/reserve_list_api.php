<?php 			
include '../dbConnect.php';

// 페이지 번호 및 페이지 당 아이템 수 설정
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$serviceId = isset($_POST['serviceId']) ? $_POST['serviceId'] : 'all';

$itemsPerPage = 10;
$displayPageNum = 10;

// 시작 아이템 및 끝 아이템 계산
$start = ($page - 1) * $itemsPerPage;

$countingNumber = (($page-1)*10) + 1;

// 정렬 변수
$sortData = isset($_POST['sortData']) ? $_POST['sortData'] : 'all';

$orderBySql = "combined_data.booked_id DESC";
$monthOrderBySql = "booked_list.booked_id DESC";
$hourOrderBySql = "hourbooked_list.booked_id DESC";
if($sortData=='desc'){
    $orderBySql = "combined_data.start_date DESC";
    $monthOrderBySql = "booked_list.start_date DESC";
    $hourOrderBySql = "hourbooked_list.start_date DESC";
}else if($sortData=="asc"){
    $orderBySql = "combined_data.start_date ASC";
    $monthOrderBySql = "booked_list.start_date ASC";
    $hourOrderBySql = "hourbooked_list.start_date ASC";
}

// 전체 레코드 수 쿼리
if($serviceId=='all'){
    $totalRecordsQuery = "SELECT COUNT(*) AS count FROM booked_list";
    $totalRecordsResult = $conn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

    $totalRecordsQuery2 = "SELECT COUNT(*) AS count FROM hourbooked_list";
    $totalRecordsResult2 = $conn->query($totalRecordsQuery2);
    $totalRecords2 = $totalRecordsResult2->fetch_assoc()['count'];
}else if($serviceId<=3){
    $totalRecordsQuery = "SELECT COUNT(*) AS count FROM booked_list WHERE service_id='$serviceId'";
    $totalRecordsResult = $conn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

    $totalRecords2 = 0;
}else if($serviceId>3){
    $totalRecordsQuery2 = "SELECT COUNT(*) AS count FROM hourbooked_list WHERE service_id='$serviceId'";
    $totalRecordsResult2 = $conn->query($totalRecordsQuery2);
    $totalRecords2 = $totalRecordsResult2->fetch_assoc()['count'];

    $totalRecords = 0;
}




$totalPages = ceil(($totalRecords+$totalRecords2)/ $itemsPerPage);


$endPage = ((($page - 1) / $displayPageNum) + 1) * $displayPageNum;

if($totalPages < $endPage) $endPage = $totalPages;

$startPage = (($page - 1)/$displayPageNum) * $displayPageNum + 1;

// 데이터 가져오기 쿼리
// $query = "SELECT * FROM notice_list JOIN admin_account ON notice_list.user_id=admin_account.account_id ORDER BY notice_list.create_time DESC LIMIT $start, $itemsPerPage";

if($serviceId=='all'){
    $query = "SELECT combined_data.booked_id, combined_data.service_id, combined_data.booking_number, combined_data.booking_type, combined_data.user_id, combined_data.booked_name, combined_data.booked_birth, combined_data.booked_contact, combined_data.booked_num, combined_data.booked_fee, combined_data.payment_ok, combined_data.booked_ok, combined_data.is_canceled, combined_data.start_date, combined_data.end_date, combined_data.start_time, combined_data.end_time, combined_data.create_date, service_list.service_name
    FROM (
        SELECT booked_id, service_id, booking_number, booking_type, user_id, booked_name, booked_birth, booked_contact, booked_num, booked_fee, payment_ok, booked_ok, is_canceled, create_date, start_date, end_date, start_time, end_time
        FROM booked_list
        UNION
        SELECT booked_id, service_id, booking_number, booking_type, user_id, booked_name, booked_birth, booked_contact, booked_num, booked_fee, payment_ok, booked_ok, is_canceled, create_date, start_date, end_date, start_time, end_time
        FROM hourbooked_list
    ) AS combined_data
    JOIN service_list ON service_list.service_id = combined_data.service_id
    ORDER BY $orderBySql
    LIMIT $start, $itemsPerPage";

}else if($serviceId<=3){
    $query = "SELECT * FROM booked_list JOIN service_list ON service_list.service_id=booked_list.service_id AND booked_list.service_id='$serviceId' ORDER BY $monthOrderBySql LIMIT $start,$itemsPerPage";
}else if($serviceId>3){
     $query = "SELECT * FROM hourbooked_list JOIN service_list ON service_list.service_id=hourbooked_list.service_id AND hourbooked_list.service_id='$serviceId' ORDER BY $hourOrderBySql LIMIT $start,$itemsPerPage";
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
    $dataCode .= '</span>'.$row['booking_number'];
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate d-flex align-items-center">';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['booking_type'];
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate d-flex align-items-center">';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['service_name'];
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    //어여와
    if($row['start_time']==''){
        $dataCode .= '<td>';
        $dataCode .= '<span class="text-truncate d-flex align-items-center">';
        $dataCode .= '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">';
        $dataCode .= '</span>'.$row['start_date']." ~ ".$row['end_date'];
        $dataCode .= '</span>';
        $dataCode .= '</td>';
    }else{
        $dataCode .= '<td>';
        $dataCode .= '<span class="text-truncate d-flex align-items-center">';
        $dataCode .= '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">';
        $dataCode .= '</span>'.$row['start_date']." [".$row['start_time']."부터 ".$row['end_time']."]";
        $dataCode .= '</span>';
        $dataCode .= '</td>';
    }

    // $dataCode .= '<td>';
    // $dataCode .= '<span class="text-truncate">';
    // $dataCode .= '<label class="switch switch-primary switch-sm">';
    // if($row['is_canceled']=='1'){
    //     $dataCode .= '<input type="checkbox" class="switch-input essential" checked data-id="'.$row['booked_id'].'">';
    //     $dataCode .= '<span class="switch-toggle-slider">';
    //     $dataCode .= '<span class="switch-on"></span>';
    // }else{
    //     $dataCode .= '<input type="checkbox" class="switch-input essential" id="switch" data-id="'.$row['booked_id'].'">';
    //     $dataCode .= '<span class="switch-toggle-slider">';
    //     $dataCode .= '<span class="switch-off"></span>';
    // }
    // $dataCode .= '</span>';
    // $dataCode .= '</label>';
    // $dataCode .= '<span class="d-none">필독</span>';
    // $dataCode .= '</span>';
    // $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate d-flex align-items-center">';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['booked_name'];
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate d-flex align-items-center">';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['booked_contact'];
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.$row['booked_num'];
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2">';
    $dataCode .= '</span>'.number_format($row['booked_fee'])."원";
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<span class="text-truncate">';
    $dataCode .= '<label class="switch switch-primary switch-sm">';
    if($row['payment_ok']=='1'){
        $dataCode .= '<input type="checkbox" class="switch-input is_pay" checked data-id="'.$row['booked_id'].'" service-id="'.$row['service_id'].'">';
        $dataCode .= '<span class="switch-toggle-slider">';
        $dataCode .= '<span class="switch-on"></span>';
    }else{
        $dataCode .= '<input type="checkbox" class="switch-input is_pay" id="switch" data-id="'.$row['booked_id'].'" service-id="'.$row['service_id'].'">';
        $dataCode .= '<span class="switch-toggle-slider">';
        $dataCode .= '<span class="switch-off"></span>';
    }
    $dataCode .= '</span>';
    $dataCode .= '</label>';
    $dataCode .= '<span class="d-none">필독</span>';
    $dataCode .= '</span>';
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    if($row['is_canceled']==1){
        $dataCode .= '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2">';
        $dataCode .= '</span>예약취소';
    }else{
        $dataCode .= '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2">';
        $dataCode .= '</span>예약중';
    }
    $dataCode .= '</td>';

    $dataCode .= '<td>';
    $dataCode .= '<div class="d-inline-block text-nowrap">';
    $dataCode .= '<button class="btn btn-sm btn-icon update-record" data-bs-toggle="modal" data-bs-target="#largeModal" data-id="'.$row['booking_number'].'">';
    $dataCode .= '<i class="bx bx-edit"></i></button>';
    $dataCode .= '<button class="btn btn-sm btn-icon delete-record" data-id="'.$row['booked_id'].'" service-id="'.$row['service_id'].'">';
    $dataCode .= '<i class="bx bx-trash"></i></button>';
    $dataCode .= '<div class="dropdown-menu dropdown-menu-end m-0">';
    $dataCode .= '<a href="admin_account_view.html?accountId='.$row['booked_id'].'" class="dropdown-item">보기</a>';
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
    'test' => (($page - 1) / $displayPageNum) + 1,
    'query' => $query,
    'sort' => $sortData

));

echo $data;

$conn->close();


 ?>

