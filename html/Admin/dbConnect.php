<?php 

// 데이터베이스 연결 설정
$servername = "localhost";
$username = "jeojeon";
$password = "Garden3988";
$dbname = "jeojeon";

$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 ?>