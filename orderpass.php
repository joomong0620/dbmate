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
        button {
            width: 180px;
            height: 50px;
            border: none;
            border-radius: 20px;
            font-size: 20px;
            color: #FFFFFF;
            cursor: pointer;
            margin: 10px 10px; /* 양쪽으로 마진 추가 */
            transition: background-color 0.3s; /* 배경색 변경 애니메이션 */
        }
        .order-detail-btn {
            background-color: #CC93D6;
        }
        .main-screen-btn {
            background-color: #CC93D6;
        }
        .icons-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .order-complete {
            font-family: Inter;
            font-size: 35px;
            font-weight: 600;
            line-height: 42px;
            letter-spacing: 0em;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .order-complete-icon img {
            width: 100px;  /* 이미지 너비를 24px로 수정 */
            height: 100px; /* 이미지 높이를 24px로 수정 */
        }

        .icons-container {
            text-align: center; /* 자식 요소를 중앙에 배치 */
        }
        

    </style>
</head>

<body>
<header>
    <img src="BDMate.png" alt="배달메이트 로고" width="250" height="110">
</header>
<div class="icons-container" style="margin-top: -100px;">
    <div class="order-complete-icon">
        <img src="order.png" alt="주문 완료 아이콘">
    </div>
    <div class="order-complete">
    주문이 완료되었습니다.<br>
    <span id="order-time" style="font-size:0.8em;"></span>
</div>
<script>
    document.getElementById('order-time').innerText = '주문 일자: ' + new Date().toLocaleString();
</script>

</div>
<div class="button-container" style="position: absolute; bottom: 100px; width: 100%; text-align: center;">
<button class="order-detail-btn" onclick="location.href='orderview.php?total_amount=<?php echo urlencode($_GET['total_amount']); ?>&order_request=<?php echo urlencode($_GET['order_request']); ?>&del_request=<?php echo urlencode($_GET['del_request']); ?>&order_details=<?php echo urlencode($_GET['order_details']); ?>&order_time=' + encodeURIComponent(document.getElementById('order-time').innerText)">주문 상세</button>
    <button class="main-screen-btn" onclick="location.href='delstatus.php'">배달 현황</button>
    <button class="main-screen-btn" onclick="location.href='ppp.php'">메인 화면</button>
</div>



    </div>
</body>

</html>
