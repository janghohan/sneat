<?php
include '../dbConnect.php';
/**************** 문자전송하기 예제 필독항목 ******************/
/* 동일내용의 문자내용을 다수에게 동시 전송하실 수 있습니다
/* 대량전송시에는 반드시 컴마분기하여 1천건씩 설정 후 이용하시기 바랍니다. (1건씩 반복하여 전송하시면 초당 10~20건정도 발송되며 컨텍팅이 지연될 수 있습니다.)
/* 전화번호별 내용이 각각 다른 문자를 다수에게 보내실 경우에는 send 가 아닌 send_mass(예제:curl_send_mass.html)를 이용하시기 바랍니다.

/****************** 인증정보 시작 ******************/

$bookedId = isset($_POST['bookedId']) ? $_POST['bookedId'] : '';
$serviceId = isset($_POST['serviceId']) ? $_POST['serviceId'] : '';

$sms_url = "https://apis.aligo.in/send/"; // 전송요청 URL
$sms['user_id'] = "jeojeon3988"; // SMS 아이디
$sms['key'] = "s570v6fj4crmetxp315021qijgg7mhtj";//인증키

if($serviceId<=3){
	$bookingSql = "SELECT * FROM booked_list JOIN account_number JOIN service_list ON booked_list.booked_id='$bookedId' AND booked_list.service_id = account_number.service_id AND booked_list.service_id = service_list.service_id";
}else{
	$bookingSql = "SELECT * FROM hourbooked_list JOIN account_number JOIN service_list ON hourbooked_list.booked_id='$bookedId' AND hourbooked_list.service_id = account_number.service_id AND hourbooked_list.service_id = service_list.service_id";
}


$bookingResult = $conn->query($bookingSql);
$bookingRow = $bookingResult->fetch_assoc();


/****************** 전송정보 설정시작 ****************/

// $_POST['destination'] = '01111111111|담당자,01111111112|홍길동'; // 수신인 %고객명% 치환
$_POST['sender'] ="01022343988"; // 발신번호

$testMode = 'Y'; // Y 인경우 실제문자 전송X , 자동취소(환불) 처리
// $_POST['image'] = '/tmp/pic_57f358af08cf7_sms_.jpg'; // MMS 이미지 파일 위치 (저장된 경로)

if($serviceId<=3){
	$bookingText = "예약번호 : ".$bookingRow['booking_number']." \n날짜 : ".$bookingRow['start_date']."~".$bookingRow['end_date'];
}else{
	$bookingText = "예약번호 : ".$bookingRow['booking_number']." \n날짜 : ".$bookingRow['start_date']."\n시간 : ".$bookingRow['start_time']." ~ ".$bookingRow['end_time'];
}

$price = "\n결제금액 :".number_format($bookingRow['booked_fee'])."원".
$accountInfo = "\n".$bookingRow['bank']."은행 ".$bookingRow['number']." \n비타민 저전골 마을관리 사회적협동조합";


/****************** 전송정보 설정끝 ***************/

$sms['title'] = "예약이 확정되었습니다. [".$bookingRow['service_name']."]";
$sms['msg'] = $bookingText;
$sms['receiver'] = $bookingRow['booked_contact'];
$sms['sender'] = "01022343988";
$sms['testmode_yn'] = "N";
$sms['msg_type'] = "LMS";

// 만일 $_FILES 로 직접 Request POST된 파일을 사용하시는 경우 move_uploaded_file 로 저장 후 저장된 경로를 사용하셔야 합니다.
if(!empty($_FILES['image']['tmp_name'])) {
	$tmp_filetype = mime_content_type($_FILES['image']['tmp_name']); 
	if($tmp_filetype != 'image/png' && $tmp_filetype != 'image/jpg' && $tmp_filetype != 'image/jpeg') $_POST['image'] = '';
	else {
		$_savePath = "./".uniqid(); // PHP의 권한이 허용된 디렉토리를 지정
		if(move_uploaded_file($_FILES['file']['tmp_name'], $_savePath)) {
			$_POST['image'] = $_savePath;
		}
	}
}
// 이미지 전송 설정
if(!empty($_POST['image'])) {
	if(file_exists($_POST['image'])) {
		$tmpFile = explode('/',$_POST['image']);
		$str_filename = $tmpFile[sizeof($tmpFile)-1];
		$tmp_filetype = mime_content_type($_POST['image']);
		if ((version_compare(PHP_VERSION, '5.5') >= 0)) { // PHP 5.5버전 이상부터 적용
			$sms['image'] = new CURLFile($_POST['image'], $tmp_filetype, $str_filename);
			curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, true);
		} else {
			$sms['image'] = '@'.$_POST['image'].';filename='.$str_filename. ';type='.$tmp_filetype;
		}
	}
}
/*****/
$host_info = explode("/", $sms_url);
$port = $host_info[0] == 'https:' ? 443 : 80;

$oCurl = curl_init();
curl_setopt($oCurl, CURLOPT_PORT, $port);
curl_setopt($oCurl, CURLOPT_URL, $sms_url);
curl_setopt($oCurl, CURLOPT_POST, 1);
curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($oCurl, CURLOPT_POSTFIELDS, $sms);
curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
$ret = curl_exec($oCurl);
curl_close($oCurl);



$retArr = json_decode($ret,true); 

$data = json_encode(array(
    'result_code' => $retArr['result_code'],
    'message' => $retArr['message'],
    'meesageTxt' => $bookingText." ".$accountInfo,
    'bookingNumber' => $bookingRow['booking_number']

));

echo $data;
// print_r($retArr); // Response 출력 (연동작업시 확인용)

/**** Response 항목 안내 ****
// result_code : 전송성공유무 (성공:1 / 실패: -100 부터 -999)
// message : success (성공시) / reserved (예약성공시) / 그외 (실패상세사유가 포함됩니다)
// msg_id : 메세지 고유ID = 고유값을 반드시 기록해 놓으셔야 sms_list API를 통해 전화번호별 성공/실패 유무를 확인하실 수 있습니다
// error_cnt : 에러갯수 = receiver 에 포함된 전화번호중 문자전송이 실패한 갯수
// success_cnt : 성공갯수 = 이동통신사에 전송요청된 갯수
// msg_type : 전송된 메세지 타입 = SMS / LMS / MMS (보내신 타입과 다른경우 로그로 기록하여 확인하셔야 합니다)
/**** Response 예문 끝 ****/