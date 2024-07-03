<?php 
include '../dbConnect.php';

$accountId = isset($_COOKIE['admin_id']) ? $_COOKIE['admin_id'] : 139;

$noticeTitle = isset($_POST['title']) ? $_POST['title'] : '';
$pinned = isset($_POST['pinned']) ? $_POST['pinned'] : '';
$essential = isset($_POST['essential']) ? $_POST['essential'] : '';
$content = isset($_POST['content']) ? $_POST['content'] : '';
$today = date("Y-m-d");



if($pinned=="true") {
	$pinned = 1;
}else{
	$pinned = 0;
}

if($essential=="true") {
	$essential = 1;
}else{
	$essential = 0;
}

$sql = "INSERT INTO notice_list(is_pinned,is_essential,account_id,notice_title,notice_content,create_date) VALUES('$pinned','$essential','$accountId','$noticeTitle','$content','$today')";

if ($conn->query($sql)) {
	$noticeIx = $conn->insert_id;

	if(isset($_FILES['files'])){
	    $fileCount = count($_FILES['files']['name']);

	    // 선택된 모든 파일 처리
	    $fileProcessOk = true;
	    for($i=0; $i<$fileCount; $i++){
	        $fileName = $_FILES['files']['name'][$i];
	        $fileSize = $_FILES['files']['size'][$i];
	        $fileTmpName = $_FILES['files']['tmp_name'][$i];
	        $fileType = $_FILES['files']['type'][$i];
	        
	        // 파일 처리 예시: 업로드 폴더로 이동
	        $uploadDir = '../../../../STATIC/files/';
	        $targetFilePath = $uploadDir . $fileName;

	        $filePath = "http://jeojeon.com/STATIC/files/".$fileName;
	        
	        if(move_uploaded_file($fileTmpName, $targetFilePath)){
	            // echo "파일 {$fileName} 업로드 완료. 크기: {$fileSize} bytes, 타입: {$fileType}, 제목: {$title}<br>";

	            $fileSql = "INSERT INTO file_list(file_name,file_path,type,type_ix) VALUES('$fileName','$filePath','notice','$noticeIx')";
	            $conn->query($fileSql);
	        } else {
	            $fileProcessOk = false;
	        }
	    }

	    if($fileProcessOk){
	    	echo 200;
	    }else{
	    	echo 100;
	    }

	}else{
		echo 200;
	}

} else {
    echo 100;
}

$conn->close();


 ?>