<?php 

include '../dbConnect.php';

$dateRange = array();
for ($i = 6; $i >= 0; $i--) {
    $dateRange[] = date('Y-m-d', strtotime("-$i days"));
}

// 쿼리 생성
$query = "
    SELECT
        date_range.date AS visit_date,
        COALESCE(COUNT(visitor_logs.visit_date), 0) AS row_count
    FROM
        (SELECT '" . implode("' AS date UNION SELECT '", $dateRange) . "') AS date_range
    LEFT JOIN
        visitor_logs ON date_range.date = DATE(visitor_logs.visit_date)
        AND visitor_logs.visit_date >= DATE_SUB(NOW(), INTERVAL 1 WEEK)
    GROUP BY
        date_range.date
    ORDER BY
        visit_date";

// 쿼리 실행
$result = $conn->query($query);

// 결과 출력
if ($result) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}



 ?>