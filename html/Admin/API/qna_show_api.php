<?php 			
include '../dbConnect.php';

// 페이지 번호 및 페이지 당 아이템 수 설정
$qnaId = isset($_POST['qnaId']) ? $_POST['qnaId'] : '';


// 데이터 가져오기 쿼리
$query = "SELECT * FROM qna_list WHERE qna_id='$qnaId'";
$result = $conn->query($query);
$row = $result->fetch_assoc();

// 결과 배열 초기화

// JSON으로 반환
$data = json_encode(array(
    'title' => $row['qna_title'],
    'content' => $row['qna_content'],
    'time' => $row['create_time'],
    'user' => $row['user_name'],
    'answer' => $row['answer_content']

));

echo $data;

$conn->close();


 ?>

