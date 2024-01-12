<!DOCTYPE html>
<html lang="en">
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
        }

        .customer-info {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f8f8;
        }

        .customer-info h2 {
            margin: 0 0 20px;
            color: #333;
            font-size: 24px;
        }

        .customer-info p {
            margin: 0 0 10px;
            color: #666;
            font-size: 16px;
        }

        /* 추가된 부분 */
        .main-screen-btn {
            position: fixed;
            bottom: 10px;
            right: 10px;
            background-color: #333;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }

        button.main-screen-btn {
            background-color: #C5B1D6;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
        button.main-screen-btn:hover {
            background-color: #9A2EBF;
        }
    </style>
</head>
<body>

<header>
    <img src="BDMate.png" alt="배달메이트 로고" width="250" height="110">
</header>

<?php
// 데이터베이스 연결 설정
session_start();
$host = "localhost";
$user = "user";
$pw = "12345";
$dbName = "bdmate";

$conn = new mysqli($host, $user, $pw, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 로그인된 사용자의 이메일을 세션에서 가져옵니다.
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // 이메일을 사용하여 데이터베이스에서 고객 정보를 가져옵니다.
    $query = "SELECT * FROM 고객 WHERE 이메일 = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo '<div class="customer-info">';
        echo '<h2>👤고객 정보</h2>';
        echo '<p><strong>이름:</strong> ' . $row["이름"] . '</p>';
        echo '<p><strong>이메일:</strong> ' . $row["이메일"] . '</p>';
        echo '<p><strong>생년월일:</strong> ' . $row["생년월일"] . '</p>';
        echo '<p><strong>주소:</strong> ' . $row["주소"] . '</p>';
        echo '<p><strong>전화번호:</strong>' . $row["전화번호"] . '</p>';
        echo '</div>';
    } else {
        echo "고객 정보가 없습니다.";
    }
}
$conn->close();
?>

<button class="main-screen-btn" onclick="location.href='ppp.php'">메인 화면</button>

</body>
</html>
