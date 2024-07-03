<?php 			
include '../dbConnect.php';

// 페이지 번호 및 페이지 당 아이템 수 설정
$bookingNumber = isset($_POST['bookingNumber']) ? $_POST['bookingNumber'] : 1;


$query = "SELECT combined_data.booked_id, combined_data.service_id, combined_data.booking_number, combined_data.booking_type, combined_data.user_id, combined_data.booked_name, combined_data.booked_birth, combined_data.booked_contact, combined_data.booked_num,combined_data.booked_memo, combined_data.booked_fee, combined_data.payment_ok, combined_data.payment_time, combined_data.booked_ok, combined_data.is_canceled, combined_data.start_date, combined_data.end_date, combined_data.start_time, combined_data.end_time, combined_data.create_time, service_list.service_name
    FROM (
        SELECT booked_id, service_id, booking_number, booking_type, user_id, booked_name, booked_birth, booked_contact, booked_num, booked_fee, booked_memo, payment_ok, payment_time, booked_ok, is_canceled, create_time, start_date, end_date, start_time, end_time
        FROM booked_list
        UNION
        SELECT booked_id, service_id, booking_number, booking_type, user_id, booked_name, booked_birth, booked_contact, booked_num, booked_fee, booked_memo, payment_ok, payment_time, booked_ok, is_canceled, create_time, start_date, end_date, start_time, end_time
        FROM hourbooked_list
    ) AS combined_data
    JOIN service_list ON service_list.service_id = combined_data.service_id AND combined_data.booking_number='$bookingNumber'";
$result = $conn->query($query);

// 결과 배열 초기화
$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if($row['payment_ok']==1){
            $payment_info = "입금완료 [".$row['payment_time']."]";
        }else{
            $payment_info = "입금대기";
        }

        if($row['start_time']==''){
            $booking_date = $row['start_date']." ~ ".$row['end_date'];
        }else{
            $booking_date = $row['start_date']."/ [".$row['start_time']." ~ ".$row['end_time']."]";
        }


        $data[] = $row;
        $data['result_code'] = 1;
        $data['payment_info'] = $payment_info;
        $data['booking_date'] = $booking_date;
    }
} else {
    $data['result_code'] = 0;
}

echo json_encode($data);

$conn->close();


 ?>

