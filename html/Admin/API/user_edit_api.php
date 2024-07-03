<?php 

include '../dbConnect.php';

// 폼으로부터 전송된 데이터 가져오기
$userix = isset($_POST['editUserId']) ? $_POST['editUserId'] : '';
$userName = isset($_POST['editName']) ? $_POST['editName'] : '';
$userId = isset($_POST['editId']) ? $_POST['editId'] : '';
$userContact = isset($_POST['editContact']) ? $_POST['editContact'] : '';
$userEmail = isset($_POST['editEmail']) ? $_POST['editEmail'] : '';
$userPassword = isset($_POST['editPassword']) ? $_POST['editPassword'] : '';


$md5Password =md5($userPassword); //초기 비밀번호 설정값

$userContact = addHyphenToPhoneNumber($userContact);

// SQL 쿼리 작성 및 실행
if($userPassword==""){
	$sql = "UPDATE user_list SET id='$userId',name='$userName', email='$userEmail', contact='$userContact' WHERE user_id='$userix'";
}else{
	$sql = "UPDATE user_list SET id='$userId', pwd='$md5Password', name='$userName', email='$userEmail', contact='$userContact' WHERE user_id='$userix'";
}

if ($conn->query($sql) === TRUE) {
    echo "정보가 수정되었습니다.";
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