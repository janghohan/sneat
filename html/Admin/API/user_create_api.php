<?php 

include '../dbConnect.php';

// 폼으로부터 전송된 데이터 가져오기
$userName = $_POST['userName'];
$userId = $_POST['userId'];
$userContact = $_POST['userContact'];
$userEmail = $_POST['userEmail'];
$userPassword = $_POST['userPassword'];

$md5Password =md5($userPassword); //초기 비밀번호 설정값

$userContact = addHyphenToPhoneNumber($userContact);

// SQL 쿼리 작성 및 실행
$sql = "INSERT INTO user_list (id, pwd, name, email, contact) VALUES ('$userId', '$md5Password','$userName', '$userEmail', '$userContact')";


$chk_sql = "SELECT * FROM user_list WHERE id = '$userId'";
$result = $conn->query($chk_sql);

if($result->num_rows >0){
	echo "이미 존재하는 계정입니다.";
	return false;
}


if ($conn->query($sql) === TRUE) {
    echo "계정이 성공적으로 생성되었습니다.";
} else {
    echo "오류: " . $sql . "<br>" . $conn->error;
}
// 데이터베이스 연결 종료
$conn->close();

function addHyphenToPhoneNumber($phoneNumber) {
    // 하이픈이 이미 입력되어 있는지 확인
    if (strpos($phoneNumber, '-') === false) {
        // 하이픈이 없으면 추가
        $phoneNumber = substr($phoneNumber, 0, 3) . '-' . substr($phoneNumber, 3, 4) . '-' . substr($phoneNumber, 7);
    }

    return $phoneNumber;
}

 ?>