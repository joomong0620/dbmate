<?php

$storeID = $_GET['store_id'];
$orderDetails = json_decode($_GET['order_details'], true);
$totalAmount = $_GET['total_amount'];
$orderID = isset($_GET['order_id']) ? $_GET['order_id'] : 'default_order_id';

$host = "localhost";
$user = "user";
$pw = "12345";
$dbName = "bdmate";

$conn = new mysqli($host, $user, $pw, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 가게명을 가져오는 SQL 쿼리
$storeQuery = "SELECT 가게명 FROM 가게 WHERE 가게ID = '$storeID'";
$storeResult = $conn->query($storeQuery);
$storeRow = $storeResult->fetch_assoc();
$storeName = $storeRow['가게명']; // 가게명을 가져옵니다.

// 주문 정보를 가져오는 SQL 쿼리
$orderQuery = "SELECT * FROM 주문 WHERE 주문ID = '$orderID'";
$orderResult = $conn->query($orderQuery);
$orderRow = $orderResult->fetch_assoc(); // 주문 정보를 배열로 가져옵니다.

// 쿠폰 금액을 랜덤으로 결정
$couponAmounts = array(1000, 2000, 3000);
$couponAmount = $couponAmounts[array_rand($couponAmounts)];

// 총 금액에서 쿠폰 금액을 뺌
$finalAmount = $totalAmount - $couponAmount;

$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <header>
    <img src="BDMate.png" alt="배달메이트 로고" width="250" height="110">
    </header>

    <title><?php echo $storeName; ?> 주문 내역</title>
    <style>
        /* 여기에 필요한 스타일을 추가하세요#CC93D6; */
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

        h2 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }

        button {
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

        button.pay-button {
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

            /* 결제하기 버튼의 위치 지정 */
            position: fixed;
            bottom: 10px;
            right: 10px;
        }

        button.pay-button:hover {
            background-color: #9A2EBF;
        }
        select#coupon-amount {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff; /* 배경색을 흰색으로 설정 */
            width: 100%; /* 너비를 100%로 설정 */
            max-width: 200px; /* 최대 너비를 200px로 설정 */
            margin-top: 10px; /* 위 여백 추가 */
        }
        select#coupon-amount option:hover {
            background-color: #C5B1D6;
        }
        p {
            font-size: 18px;
        }
    </style>
</head>
</head>

<body>
<h2><?php echo $storeName; ?> 주문 내역</h2>
<ul>
    <?php
    foreach ($orderDetails as $item) {
        echo '<li>' . $item['name'] . ' - ' . $item['price'] . '</li>';
    }
    ?>
</ul>
<p><label for="order-request">주문요청사항:</label>
    <input type="text" id="order-request" name="order-request"></p>
<p><label for="order-request">배달요청사항:</label>
    <input type="text" id="del-request" name="del-request"></p>
<!-- 기존 쿠폰 버튼 대신 select 요소를 사용합니다. -->
<p>쿠폰 적용 금액:
    <select id="coupon-amount" onchange="applyCoupon(this.value)">
        <option value="0">쿠폰을 선택하세요</option>
        <option value="1000">₩1000</option>
        <option value="2000">₩2000</option>
        <option value="3000">₩3000</option>
    </select>
</p>

<p>총 금액: ₩<span id="total-amount"><?php echo $totalAmount; ?></span></p>
<button class="pay-button" onclick="completeOrder()">결제하기</button>
<script>
    let initialTotalAmount = <?php echo $totalAmount; ?>; // 초기 총 금액을 저장합니다.
    let totalAmount = initialTotalAmount;

    function completeOrder() {
        let orderRequest = document.getElementById('order-request').value;
        alert('주문이 완료되었습니다. 주문요청사항: ' + orderRequest); // "주문이 완료되었습니다."라는 알림을 표시합니다.
        location.href = ('orderpass.php');
    }
    function completeOrder() {
        let orderRequest = document.getElementById('order-request').value;
        let delRequest = document.getElementById('del-request').value;
        let orderDetails = <?php echo json_encode($orderDetails); ?>;
        
        alert('주문이 완료되었습니다. 주문요청사항: ' + orderRequest); // "주문이 완료되었습니다."라는 알림을 표시합니다.
        
        location.href = 'orderpass.php?total_amount=' + totalAmount + '&order_request=' + orderRequest + '&del_request=' + delRequest + '&order_details=' + JSON.stringify(orderDetails);
    }
    // 'button' 파라미터 대신 'amount' 파라미터를 사용하고, 버튼에 대한 코드를 제거합니다.
    function applyCoupon(amount) {
        totalAmount = initialTotalAmount - amount; // 초기 총 금액에서 쿠폰 금액을 뺍니다.
        document.getElementById('total-amount').innerText = totalAmount; // 총 금액을 업데이트합니다.
    }
    function applyCoupon(amount) {
    totalAmount = initialTotalAmount - amount;
    document.getElementById('total-amount').innerText = totalAmount;
    
    // 쿠폰 금액에 따라 option 색상 변경
    let selectElement = document.getElementById('coupon-amount');
    for(let i=0; i<selectElement.options.length; i++) {
        if(selectElement.options[i].value == amount) {
            selectElement.options[i].style.backgroundColor = "#C5B1D6";
        } else {
            selectElement.options[i].style.backgroundColor = "initial";
        }
    }
}




</script>
</body>

</html>