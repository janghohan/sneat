<?php 
session_start();
include '../dbConnect.php';
$expiration_time = time() + (60 * 540);

$email = isset($_POST['email']) ? $_POST['email'] : 'wkdgh5430';
$password = isset($_POST['password']) ? $_POST['password'] : 'wkdgh4232';


$sql = "SELECT * FROM admin_account WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // 저장된 솔트와 입력된 비밀번호를 조합하여 해시 생성
   	$mdPassword = md5($password);

    // 비밀번호 일치 여부 확인
    if ($mdPassword == $row['password']) {

        setcookie('admin_id', $row['account_id'], $expiration_time, "/");
        setcookie('admin_name', $row['name'], $expiration_time, "/");
        setcookie('admin_email', $row['email'], $expiration_time, "/");
        setcookie('admin_contact', $row['phoneNumber'], $expiration_time, "/");

        echo 200;
        // exit;
    } else {
        echo "아이디 또는 비밀번호가 일치하지 않습니다.";
    }
} else {
    echo "아이디 또는 비밀번호가 일치하지 않습니다.";
}

// $conn->close();


 ?>