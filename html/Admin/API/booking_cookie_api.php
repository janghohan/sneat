<?php 
//결제 하려고 하는 내역을 임시 저장하는 쿠키 페이지
session_start();
include '../dbConnect.php';

$expire = time() + (5 * 60);

$bookingServiceId = isset($_POST['bookingServiceId']) ? $_POST['bookingServiceId'] : '';
$bookingStartDate = isset($_POST['bookingStartDate']) ? $_POST['bookingStartDate'] : '';
$bookingEndDate = isset($_POST['bookingEndDate']) ? $_POST['bookingEndDate'] : '';
$bookingAdultNum = isset($_POST['bookingAdultNum']) ? $_POST['bookingAdultNum'] : '';
$bookingKidsNum = isset($_POST['bookingKidsNum']) ? $_POST['bookingKidsNum'] : '';
$bookingPrice = isset($_POST['bookingPrice']) ? $_POST['bookingPrice'] : '';

setcookie('bookingServiceId', $bookingServiceId, $expire, "/");
setcookie('bookingStartDate', $bookingStartDate, $expire, "/");
setcookie('bookingEndDate', $bookingEndDate, $expire, "/");
setcookie('bookingAdultNum', $bookingAdultNum, $expire, "/");
setcookie('bookingKidsNum', $bookingKidsNum, $expire, "/");
setcookie('bookingPrice', $bookingPrice, $expire, "/");


if(isset($_COOKIE['bookingPrice'])){
	echo 1;
}else{
	echo 0;
}




 ?>