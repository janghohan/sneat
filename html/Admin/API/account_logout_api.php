<?php 


foreach ($_COOKIE as $key => $value) {
    // 특정 단어가 포함된 경우
    if (strpos($key, 'admin') !== false) {
        // 쿠키 삭제 (만료 시간을 이전으로 설정)
        setcookie($key, '', time() - 3600, '/');
    }
}

echo "<script>alert('로그아웃 되었습니다.');</script>";

echo "<script> location.href='../admin_login.html';</script>";


 ?>