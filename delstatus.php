<?php
session_start();

$host = "localhost";
$user = "user";
$pw = "12345";
$dbName = "bdmate";

// 데이터베이스 연결
$conn = new mysqli($host, $user, $pw, $dbName);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 이메일 세션에서 고객ID를 가져옵니다.
$email = $_SESSION['email'];

$sql = "SELECT 이름, 안심번호 FROM 고객 WHERE 이메일 = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 출력 데이터는 각 행에 대한 연관 배열입니다.
    $row = $result->fetch_assoc();
    echo '<div class="order-complete" style="position: absolute; top: 20%; left: 50%; transform: translate(-50%, -50%);">' . $row["이름"] . '님의 배달메이트가 달려가고 있습니다!!<br>';
    echo "안심번호: " . $row["안심번호"] . "<br></div>";
} else {
    echo "고객 정보가 없습니다.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>배달메이트</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1em 0;
            position: fixed; /* 헤더를 고정시킵니다. */
            top: 0; /* 헤더를 상단에 배치합니다. */
            width: 100%; /* 헤더의 너비를 100%로 설정합니다. */
            z-index: 1; /* 다른 요소 위에 헤더가 나타나도록 z-index를 설정합니다. */
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* viewport의 높이를 100%로 설정 */
            margin: 0;
            background-color: #f8f8f8;
            font-family: Arial, sans-serif;
            padding-top: 150px; /* 헤더의 높이만큼 body의 상단 패딩을 설정합니다. */
        }

        .order-complete {
            font-family: Inter;
            font-size: 30px; /* 글꼴 크기를 원하는 대로 키워보세요 */
            font-weight: 600;
            line-height: 48px;
            letter-spacing: 0em;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            margin-top: 90px; /* 배달 메시지의 상단 마진을 조절해 보세요 */
        }

        .status-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding-left: 20px;  /* 왼쪽 패딩을 20px로 추가 */
        }


        .status-dot {
            border: 1px solid #000;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            margin-left: 20px; 
            margin-right: 20px;  /* 오른쪽 마진을 20px로 추가 */
        }
        .status-text {
            font-family: Inter;
            font-size: 16px;
            /* 필요한 스타일 추가 */
        }

        .home-button-container {
            position: fixed; /* 고정 위치를 설정 */
            bottom: 0; /* 하단에 위치 */
            width: 100%; /* 너비를 100%로 설정 */
            text-align: center; /* 가운데 정렬 */
        }

        #home-button {
            padding: 10px 20px;
            font-size: 16px;
        }
        .status {
        position: relative; /* 상대 위치를 설정 */
        }
        .status img {
            position: absolute; /* 절대 위치를 설정 */
            bottom: 100%; /* 상태 텍스트 위에 위치 */
            left: 50%; /* 가운데 정렬 */
            transform: translateX(-50%); /* 가운데 정렬 보정 */
        }

    </style>
</head>

<body>
    <header>
        <img src="BDMate.png" alt="배달메이트 로고" width="250" height="110">
    </header>
    <div class="status-container">
        <div class="status-item">
            <div id="status-0" class="status">
                <div class="status-dot"></div>
                <div class="status-text">배달 잡는 중</div>
                <img id="status-image-0" src="del.png" style="display: none; width: 100px;">
            </div>
        </div>
        <div class="status-item">
            <div id="status-1" class="status">
                <img id="status-image-1" src="del.png" style="display: none; width: 100px;">
                <div class="status-dot"></div>
                <div class="status-text">배달 픽업 중</div>
            </div>
        </div>
        <div class="status-item">
            <div id="status-2" class="status">
                <img id="status-image-2" src="del.png" style="display: none; width: 100px;">
                <div class="status-dot"></div>
                <div class="status-text">배달 픽업 완료</div>
            </div>
        </div>
        <div class="status-item">
            <div id="status-3" class="status">
                <img id="status-image-3" src="del.png" style="display: none; width: 100px;">
                <div class="status-dot"></div>
                <div class="status-text">배달 중</div>
            </div>
        </div>
        <div class="status-item">
            <div id="status-4" class="status">
                <img id="status-image-4" src="del.png" style="display: none; width: 100px;">
                <div class="status-dot"></div>
                <div class="status-text">배달 완료</div>
            </div>
        </div>
    </div>
    <br><div class="home-button-container">
        <button id="home-button">메인화면</button>
    </div>
</body>

    <!-- 각 상태에 대응하는 이미지 추가 -->
    <img id="status-image-0" src="del.png" style="display: none; width: 100px;">
    <img id="status-image-1" src="del.png" style="display: none; width: 100px;">
    <img id="status-image-2" src="del.png" style="display: none; width: 100px;">
    <img id="status-image-3" src="del.png" style="display: none; width: 100px;">
    <img id="status-image-4" src="del.png" style="display: none; width: 100px;">

    <!-- 나머지 HTML 코드 -->

    <script>
const statuses = ['배달 잡는 중', '배달 픽업 중', '배달 픽업 완료', '배달 중', '배달 완료'];
const colors = ['#9A2EBF', '#9A2EBF', '#9A2EBF', '#9A2EBF', '#9A2EBF']; // 각 상태에 대응하는 색상

let statusIndex = 0;
// 초기 상태를 빨간색으로 설정
document.getElementById('status-' + statusIndex).querySelector('.status-dot').style.background = colors[statusIndex];
// 초기 상태에 해당하는 이미지를 보이게 함
document.getElementById('status-image-' + statusIndex).style.display = 'block';

const interval = setInterval(() => {
    // 이전 상태의 배경색을 흰색으로 변경
    document.getElementById('status-' + statusIndex).querySelector('.status-dot').style.background = '#fff';
    // 이전 상태에 해당하는 이미지를 숨김
    document.getElementById('status-image-' + statusIndex).style.display = 'none';

    // 상태 인덱스를 증가시킴
    statusIndex = (statusIndex + 1) % statuses.length;

    // 새 상태의 배경색을 해당 색상으로 변경
    document.getElementById('status-' + statusIndex).querySelector('.status-dot').style.background = colors[statusIndex];
    // 새 상태에 해당하는 이미지를 보이게 함
    document.getElementById('status-image-' + statusIndex).style.display = 'block';

    // 배달이 완료된 경우
    if (statusIndex === statuses.length - 1) {
        clearInterval(interval); // 상태 변경을 중지합니다.
        setTimeout(() => {
            // 2초 후에 배달 완료 알림을 표시합니다.
            alert('배달이 완료 되었습니다.');
            // review.php 페이지로 이동합니다.
            window.location.href = 'review.php';
        }, 2000);
        }
    }, 5000);

    document.getElementById('home-button').addEventListener('click', function () {
        window.location.href = 'ppp.php';
    });
</script>
</body>
</div>


</body>

</html>