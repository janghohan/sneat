<?php 
include '../dbConnect.php';

$bookingNumber = isset($_POST['view_bookingNumber']) ? $_POST['view_bookingNumber'] : '';
$serviceId = isset($_POST['view_serviceId']) ? $_POST['view_serviceId'] : '';
$bookingNum = isset($_POST['view_bookingNum']) ? $_POST['view_bookingNum'] : '';
$bookingName = isset($_POST['view_bookingName']) ? $_POST['view_bookingName'] : '';
$bookingBirth = isset($_POST['view_bookingBirth']) ? $_POST['view_bookingBirth'] : '';
$bookingContact = isset($_POST['view_bookingContact']) ? $_POST['view_bookingContact'] : '';
$bookingPrice = isset($_POST['view_bookingPrice']) ? $_POST['view_bookingPrice'] : '';
$bookingMemo = isset($_POST['view_bookingMemo']) ? $_POST['view_bookingMemo'] : '';
$bookingPayed = isset($_POST['view_isPayed']) ? $_POST['view_isPayed'] : '';

$today = date("Y-m-d H:i:s");
if($bookingPayed=="on"){
	$bookingPayed = 1;
}else{
	$bookingPayed = 0;
}


if($serviceId<=3){
	$sql = "UPDATE booked_list SET booked_name='$bookingName', booked_birth='$bookingBirth', booked_contact='$bookingContact', booked_num='$bookingNum', booked_fee='$bookingPrice', booked_memo='$bookingMemo', payment_ok='$bookingPayed', payment_time='$today', booked_ok='$bookingPayed' WHERE booking_number='$bookingNumber'";
}else{
	$sql = "UPDATE hourbooked_list SET booked_name='$bookingName', booked_birth='$bookingBirth', booked_contact='$bookingContact', booked_num='$bookingNum', booked_fee='$bookingPrice', booked_memo='$bookingMemo', payment_ok='$bookingPayed', payment_time='$today', booked_ok='$bookingPayed' WHERE booking_number='$bookingNumber'";
}



if ($conn->query($sql)) {
    echo 1;
} else {
    echo 0;
}

$conn->close();


 ?>