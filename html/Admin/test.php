<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Calendar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: center;
            position: relative;
        }

        .reserved-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 5px;
        }

        .reserved-bar-1 {
            background-color: #ffcccc;
        }

        .reserved-bar-2 {
            background-color: #ffc0cb;
        }

        .reserved-bar-3 {
            background-color: #ffcc99;
        }

        .selected-date {
            background-color: #ccffcc;
        }

        #reservation-info {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h2>November 2023</h2>

<?php
// 예약된 날짜 설정 (임의의 예시 데이터)
$reservedDates = array(
    '2023-11-02', '2023-11-03',
    '2023-11-15', '2023-11-16', '2023-11-17', '2023-11-18', '2023-11-19', '2023-11-20',
    '2023-11-14', '2023-11-15'
);
?>

<table>
    <thead>
        <tr>
            <th>Sun</th>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th>Sat</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // 2023년 11월 1일부터 30일까지의 달력을 출력
        $currentDate = new DateTime('2023-11-01');
        $lastDay = new DateTime('2023-11-30');

        $reservationCount = 1;

        while ($currentDate <= $lastDay) {
            echo "<tr>";
            for ($i = 0; $i < 7; $i++) {
                $dateStr = $currentDate->format('Y-m-d');
                $dayNumber = $currentDate->format('j');
                $reservedClass = in_array($dateStr, $reservedDates) ? 'reserved' : '';

                echo "<td class='$reservedClass' data-date='$dateStr'>$dayNumber";

                // 예약된 날짜에 바 형태로 표시
                if (in_array($dateStr, $reservedDates)) {
                    echo "<div class='reserved-bar reserved-bar-$reservationCount'></div>";
                    $reservationCount++;
                }

                echo "</td>";
                $currentDate->add(new DateInterval('P1D'));
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<div id="reservation-info">
    <h3>Reservation Details</h3>
    <p id="selected-date-info"></p>
    <!-- 여기에 예약 상세 정보를 출력하는 부분을 추가하면 됩니다. -->
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var selectedDateInfo = document.getElementById('selected-date-info');

    // 각 날짜에 대한 클릭 이벤트 추가
    var dateCells = document.querySelectorAll('td');
    dateCells.forEach(function(cell) {
        cell.addEventListener('click', function() {
            // 선택된 날짜의 정보를 표시
            var selectedDate = this.getAttribute('data-date');
            selectedDateInfo.innerHTML = 'Selected Date: ' + selectedDate;

            // 선택된 날짜의 배경을 변경
            dateCells.forEach(function(cell) {
                cell.classList.remove('selected-date');
            });
            this.classList.add('selected-date');
        });
    });
});
</script>

</body>
</html>
