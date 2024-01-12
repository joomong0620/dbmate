<?php

$totalAmount = $_GET['total_amount'];
$orderRequest = $_GET['order_request'];
$delRequest = $_GET['del_request'];
$orderDetails = json_decode($_GET['order_details'], true);
$orderTime = $_GET['order_time'];

$host = "localhost";
$user = "user";
$pw = "12345";
$dbName = "bdmate";

$conn = new mysqli($host, $user, $pw, $dbName);

$email = $_SESSION['email'];

$sql = "SELECT 이름, 안심번호 FROM 고객 WHERE 이메일 = '$email'";

$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>배달메이트</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            line-height: 1.6;
            color: #333;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1em 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1;
        }

        header img {
            max-width: 100%;
            height: auto;
        }

        .container {
            max-width: 700px;
            margin: 2em auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        h2, h3 {
            color: #9A2EBF;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
        }

        ul {
            margin-bottom: 20px;
            list-style-type: none;
        }

        ul li {
            background: #f4f4f4;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <header>
        <img src="BDMate.png" alt="배달메이트 로고" width="250" height="110">
    </header>

    <div class="container">
        <h2>주문 상세 정보</h2>
        <p><?php echo $orderTime; ?></p>
        <p>총 금액: ₩<?php echo $totalAmount; ?></p>
        <p>주문 요청 사항: <?php echo $orderRequest; ?></p>
        <p>배달 요청 사항: <?php echo $delRequest; ?></p>

        <h3>주문한 메뉴:</h3>
        <ul>
            <?php
            foreach ($orderDetails as $item) {
                echo '<li>' . $item['name'] . ' - ' . $item['price'] . '</li>';
            }
            ?>
        </ul>
        
    </div>
</body>

</html>