<?php 

include '../dbConnect.php';

// 폼으로부터 전송된 데이터 가져오기
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$today = date("Y-m-d");

$md5Password =md5($password); //초기 비밀번호 설정값


$chk_sql = "SELECT * FROM members WHERE username = '$username'";
$result = $conn->query($chk_sql);

if($result->num_rows >0){
	echo "이미 존재하는 계정입니다.";
	return false;
}

$sql = "INSERT INTO members(name, email, password, phoneNumber, signupDate) VALUES ('$adminName', '$adminEmail', '$md5Password', '$adminContact', '$today')";

if ($conn->query($sql) === TRUE) {
    echo "계정이 성공적으로 생성되었습니다.";
} else {
    echo "오류: " . $sql . "<br>" . $conn->error;
}
// 데이터베이스 연결 종료
$conn->close();



 ?>