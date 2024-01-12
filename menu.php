<?php
$host = "localhost";
$user = "user";
$pw = "12345";
$dbName = "bdmate";

$conn = new mysqli($host, $user, $pw, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);


}

// 가게ID를 받아옴
$storeID = $_GET['store_id'];


// 해당 가게의 이름을 가져오는 SQL 쿼리
$storeNameQuery = "SELECT 가게명 FROM 가게 WHERE 가게ID = '$storeID'";
$storeNameResult = $conn->query($storeNameQuery);
$storeNameRow = $storeNameResult->fetch_assoc();
$storeName = $storeNameRow['가게명'];

// 해당 가게의 리뷰를 가져오는 SQL 쿼리
$reviewQuery = "SELECT * FROM 리뷰 WHERE 가게ID = '$storeID'";
$reviewResult = $conn->query($reviewQuery);


// 해당 가게의 메뉴를 가져오는 SQL 쿼리
$menuQuery = "SELECT * FROM 메뉴 WHERE 가게ID = '$storeID'";
$menuResult = $conn->query($menuQuery);
// 데이터베이스 연결이나 기타 서버 측 로직 이후에는 연결을 닫아주는 것이 좋습니다.
$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $storeName; ?> 가게 메뉴</title>
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

        .menu {
        margin: 10px; /* 위쪽, 아래쪽, 좌우 마진 모두 10px으로 설정 */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #FFFFFF;
        transition: transform 0.3s ease;
        width: 40%; /* 45%에서 40%로 수정 */
        box-sizing: border-box;
        text-align: center;
        display: inline-block;
        }

        .menu img {
        width: 400px;
        height: auto;
        max-height: 200px;
        object-fit: cover;
        border-radius: 5px;
        margin-bottom: 10px;
        }

        .menu h3 {
            margin: 10px 0;
        }

        .menu p {
            margin: 5px 0;
        }

        .menu button {
            background-color: #E0BFE6;
            color: #333;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .menu:hover {
            transform: scale(1.05);
        }

        #cart-button {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: #FFFFFF;
            color: #333;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        #cart {
            position: absolute; /* 배너 아래에 상대적으로 위치 */
            top: 50px; /* 카트 아이콘 아래에 표시되도록 조정 */
            right: 10px;
            height: 300px; /* 세로로 길게 조정 */
            overflow-y: auto; /* 내용이 넘칠 경우 스크롤 표시 */
            background-color: #f8f8f8;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: none; /* 초기에는 숨겨둠 */
        }

        #cart h2 {
            text-align: center;
        }

        #cart ul {
            list-style-type: none;
            padding: 0;
        }

        #cart li {
            margin-bottom: 10px;
        }

        /* 팝업 스타일 */
        #popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <header>
        <img src="BDMate.png" alt="배달메이트 로고" width="250" height="110">
    </header>
    <h2><?php echo $storeName; ?> 가게 메뉴</h2>

    <?php
    if ($menuResult->num_rows > 0) {
        while ($row = $menuResult->fetch_assoc()) {
            echo '<div class="menu">';
            echo '<img src="menu.images/' . $row["메뉴ID"] . '.png" alt="' . $row["메뉴명"] . '">';
            echo '<h3>' . $row["메뉴명"] . '</h3>';
            echo '<p>가격: ' . $row["메뉴가격"] . '</p>';
            echo '<button onclick="addToCart(\'' . $row["메뉴명"] . '\', \'' . $row["메뉴가격"] . '\')">담기</button>';
            echo '</div>';
        }
    } else {
        echo '<p>메뉴가 없습니다.</p>';
    }
    ?>
    <h2><?php echo $storeName; ?> 가게 리뷰</h2>

    <?php
    if ($reviewResult->num_rows > 0) {
        while ($row = $reviewResult->fetch_assoc()) {
            echo '<div class="review">';
            echo '<h3>' . $row["고객ID"] . '</h3>';
            echo '<p>별점: ' . $row["별점"] . '</p>';
            echo '<p>리뷰 내용: ' . $row["내용"] . '</p>';
            if ($row["사진"] != NULL) {
                echo '<img src="' . $row["사진"] . '" alt="리뷰 사진">';
            }
            echo '</div>';
        }
    } else {
        echo '<p>리뷰가 없습니다.</p>';
    }
    ?>


    <script>
        var cart = [];
        var totalAmount = 0;

        function addToCart(menuName, menuPrice) {
            cart.push({
                name: menuName,
                price: menuPrice
            });
            totalAmount += parseInt(menuPrice);
            updateCartUI();
        }

        function removeFromCart(index) {
            // 메뉴를 장바구니에서 삭제
            var removedItem = cart.splice(index, 1)[0];
            // 삭제한 메뉴의 가격을 총 금액에서 빼기
            totalAmount -= parseInt(removedItem.price);
            // 장바구니 UI 업데이트
            updateCartUI();
        }

        function updateCartUI() {
            var cartList = document.getElementById('cart-list');
            var totalAmountElement = document.getElementById('total-amount');
            var cartCountElement = document.getElementById('cart-count');

            cartList.innerHTML = '';
            cart.forEach(function (item, index) {
                var listItem = document.createElement('li');
                listItem.textContent = item.name + ' - ' + item.price;
                var removeButton = document.createElement('button');
                removeButton.textContent = '삭제';
                removeButton.onclick = function () {
                    removeFromCart(index);
                };
                listItem.appendChild(removeButton);
                cartList.appendChild(listItem);
            });

            totalAmountElement.textContent = '총 금액: ₩' + totalAmount;
            cartCountElement.textContent = cart.length;

            // Show the cart
            var cartElement = document.getElementById('cart');
            cartElement.style.display = 'block';
        }

        function toggleCart() {
            var cartElement = document.getElementById('cart');
            if (cartElement.style.display === 'block') {
                cartElement.style.display = 'none';
            } else {
                cartElement.style.display = 'block';
            }
        }

        // 팝업 열기
        function openPopup() {
            var popup = document.getElementById('popup');
            popup.style.display = 'block';

            // 팝업에 장바구니 정보 업데이트
            var popupCartList = document.getElementById('popup-cart-list');
            var popupTotalAmount = document.getElementById('popup-total-amount');

            popupCartList.innerHTML = '';
            cart.forEach(function (item) {
                var listItem = document.createElement('li');
                listItem.textContent = item.name + ' - ' + item.price;
                popupCartList.appendChild(listItem);
            });

            popupTotalAmount.textContent = '총 금액: ₩' + totalAmount;

            // 팝업을 열 때 주문 확인 버튼 숨기기
            var openPopupButton = document.getElementById('open-popup-button');
            openPopupButton.style.display = 'none';
        }

        // 주문 확인 버튼을 클릭하면 주문 페이지로 이동
        function placeOrder() {
        // 주문 내역을 URL 매개변수를 통해 order.php로 전달합니다.
        var orderDetails = JSON.stringify(cart);
        window.location.href = 'order.php?store_id=<?php echo $storeID; ?>&order_details=' + encodeURIComponent(orderDetails);
    }
    </script>

    <button id="cart-button" onclick="toggleCart()">🛒<span id="cart-count">0</span></button>

    <div id="cart" class="store-page">
        <h2>장바구니</h2>
        <ul id="cart-list"></ul>
        <p id="total-amount">총 금액: ₩0</p>
        <button onclick="openPopup()">주문 확인</button>
    </div>

    <button id="open-popup-button" onclick="placeOrder()" style="display: none;">주문 확인</button>

    <!-- 팝업 -->
<div id="popup">
    <h3>주문 내역</h3>
    <ul id="popup-cart-list"></ul>
    <p id="popup-total-amount">총 금액: ₩0</p>
    <button onclick="placeOrderFromPopup()">결제하기</button>
    <button onclick="closePopup()">닫기</button>
</div>

<script>
    function placeOrderFromPopup() {
        placeOrder();
        closePopup();
    }

    function closePopup() {
        var popup = document.getElementById('popup');
        popup.style.display = 'none';
    }
    function placeOrder() {
        // 주문 내역을 URL 매개변수를 통해 order.php로 전달합니다.
        var orderDetails = JSON.stringify(cart);
        
        // 주문 내역 및 총 금액을 URL에 포함시켜 전달합니다.
        window.location.href = 'order.php?store_id=<?php echo $storeID; ?>&order_details=' + encodeURIComponent(orderDetails) + '&total_amount=' + totalAmount;
    }
</script>



</html>