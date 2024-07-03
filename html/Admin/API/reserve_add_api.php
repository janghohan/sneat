<?php 			
include '../dbConnect.php';

// 페이지 번호 및 페이지 당 아이템 수 설정
$bookingServiceId = isset($_POST['bookingService']) ? $_POST['bookingService'] : 1;
$bookingStartDate = isset($_POST['booking-start']) ? $_POST['booking-start'] : '';
$bookingEndDate = isset($_POST['booking-end']) ? $_POST['booking-end'] : '';

$bookingStartTime = isset($_POST['booking-s-time']) ? $_POST['booking-s-time'] : '';
$bookingEndTime = isset($_POST['booking-e-time']) ? $_POST['booking-e-time'] : '';

$bookingName = isset($_POST['booking-name']) ? $_POST['booking-name'] : '';
$bookingBirth = isset($_POST['booking-birth']) ? $_POST['booking-birth'] : '';
$bookingPhone = isset($_POST['booking-phone']) ? $_POST['booking-phone'] : '';

$bookingPhone = preg_replace("/(\d{3})(\d{4})(\d{4})/", "$1-$2-$3", $bookingPhone);

$bookingNum = isset($_POST['booking-num']) ? $_POST['booking-num'] : '';

$bookingTxt = isset($_POST['booking-txt']) ? $_POST['booking-txt'] : '';

$bookingPrice = isset($_POST['booking-price']) ? $_POST['booking-price'] : '';

$bookingNumber = date("YmdHis").$bookingServiceId;
$today = date("Y-m-d");

//예약하려는 날짜가 당일인지 체크
if($bookingStartDate==date("Y-m-d")){
	echo -2;
}else{
	//예약된 날짜가 있는지 체크
	if($bookingServiceId<=3){
		$chkSql = "SELECT * FROM booked_list WHERE start_date<='$bookingStartDate' AND '$bookingStartDate'<end_date AND service_id='$bookingServiceId'";

	}else{

		$chkSql = "SELECT * FROM hourbooked_list WHERE start_date='$bookingStartDate' AND service_id='$bookingServiceId' AND (('$bookingStartTime'>=start_time AND '$bookingStartTime' < end_time) OR ('$bookingEndTime' > start_time AND '$bookingEndTime' <= end_time))";
	}

	$chkRresult = $conn->query($chkSql);

	if($chkRresult->num_rows <= 0){

		if($bookingServiceId<=3){
			$sql = "INSERT INTO booked_list (booking_number,booking_type,service_id,user_id,booked_name,booked_birth,booked_contact,booked_num,booked_fee,booked_memo,start_date,end_date,create_date) VALUES('$bookingNumber','관리자','$bookingServiceId','','$bookingName','$bookingBirth','$bookingPhone','$bookingNum','$bookingPrice','$bookingTxt','$bookingStartDate','$bookingEndDate','$today')";
		}else{
			$sql = "INSERT INTO hourbooked_list (booking_number,booking_type,service_id,user_id,booked_name,booked_birth,booked_contact,booked_num,booked_fee,booked_memo,start_time,end_time,start_date,create_date) VALUES('$bookingNumber','관리자','$bookingServiceId','','$bookingName','$bookingBirth','$bookingPhone','$bookingNum','$bookingPrice','$bookingTxt','$bookingStartTime','$bookingEndTime','$bookingStartDate','$today')";
		}


		if ($conn->query($sql) === TRUE) {
		    echo 1;
		} else {
		    echo 0;
		}


	}else{
		echo -1;
	}
}



$conn->close();


?>