<?php 			
include '../dbConnect.php';

// 페이지 번호 및 페이지 당 아이템 수 설정
$qnaId = isset($_POST['qnaId']) ? $_POST['qnaId'] : '';
$answerContent = isset($_POST['answerContent']) ? $_POST['answerContent'] : '';

$accountId = isset($_COOKIE['account_id']) ? $_COOKIE['account_id'] : '';
$answerTime = date("Y-m-d H:i:s");

// 데이터 가져오기 쿼리
$query = "UPDATE qna_list SET is_answered=1, answer_content='$answerContent', admin_id='$accountId', answer_time='$answerTime' WHERE qna_id='$qnaId'";

if($conn->query($query)){
    echo 200;
}else{
    echo 100;
}


$conn->close();


 ?>

