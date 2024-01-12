<?php
// 데이터베이스 연결 또는 다른 서버 측 로직을 추가할 수 있습니다.

// 예시: 데이터베이스 연결
$host = "localhost";
$user = "user";
$pw = "12345";
$dbName = "bdmate";

$conn = new mysqli($host, $user, $pw, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 메뉴 표시 페이지로 이동하는 함수
function showMenu($storeId)
{
// 가게 ID를 URL에 포함하여 새로운 페이지로 이동
    echo '<script>window.location.href = "menu.php?store_id=' . $storeId . '";</script>';
    exit();
}
$createFavoritesTableQuery = "CREATE TABLE IF NOT EXISTS 찜 (
  아이디 INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  사용자아이디 VARCHAR(30) NOT NULL,
  가게아이디 VARCHAR(30) NOT NULL,
  찜한시간 TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
?>
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
            
            #search-bar {
                text-align: center;
                margin: 20px;
            }

            #store-search {
                width: 300px; /* 원하는 너비로 조절 */
                height: 30px; /* 원하는 높이로 조절 */
                padding: 5px; /* 원하는 패딩으로 조절 */
                font-size: 16px; /* 원하는 글꼴 크기로 조절 */
            }

            #search-bar button {
                height: 40px; /* 원하는 높이로 조절 */
            }

            #categories {
                display: flex;
                justify-content: space-around;
                padding: 20px;
                background-color: #fff;
                border-bottom: 1px solid #ccc;
            }

            .category-button {
                cursor: pointer;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                background-color: #f8f8f8;
                transition: background-color 0.3s ease;
            }

            .category-button:hover {
                background-color: #e0e0e0;
            }

            #recommended-stores {
                text-align: center;
                padding: 20px;
                background-color: #fff;
            }

            .store {
                margin: 10px;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                background-color:   #ffffff;
                transition: transform 0.3s ease;
                width: 48%;
                display: inline-block;
                box-sizing: border-box;
                display: none;
            }

            .store:hover {
                transform: scale(1.05);
            }

            .store img {
                width: 400px;
                /* 원하는 너비로 설정하세요 */
                height: 200px;
                /* 원하는 높이로 설정하세요 */
                object-fit: cover;
                border-radius: 5px;
                margin-bottom: 10px;
            }

            .category-button img {
                width: 23px;
                /* 원하는 크기로 조절하세요 */
                height: 23px;
                /* 원하는 크기로 조절하세요 */
                margin-right: 5px;
                /* 아이콘과 텍스트 간격 조절을 위해 추가 */
            }

            .store-page {
                display: none;
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }

            .store-page img {
                width: 100%;
                height: auto;
                border-radius: 5px;
                margin-bottom: 20px;
            }

            .store-description {
                margin-bottom: 20px;
            }

            .menu {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
            }

            .menu-item {
                width: 30%;
                margin-bottom: 20px;
            }

            .menu-item img {
                width: 200%;
                height: auto;
                border-radius: 5px;
            }
            .menu-category {
                display: none; /* 초기에는 숨김 */
            }

            #recommended-stores {
                text-align: center;
                padding: 20px;
                background-color: #fff;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
            }

            #recommended-store img {
                width: 150px;  /* 이미지 너비 조절 */
                height: 150px;  /* 이미지 높이 조절 */
                object-fit: cover;
                border-radius: 5px;
                margin-bottom: 10px;
            }
            #recommended-stores h2 {
                margin-bottom: 10px;
            }

            #recommended-store p {
                margin-bottom: 20px;
            }
            /* 찜 버튼 스타일 */
            #favorite-button {
                background-color: #cccccc;
                color: #333333;
                border: none;
                padding: 10px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                transition-duration: 0.4s;
                cursor: pointer;
            }

            /* 찜한 상태의 스타일 */
            #favorite-button.favorited {
                background-color: #ff0000;
                color: white;
            }

            #favorite-icon {
                position: fixed;
                top: 10px;
                right: 10px;
                background-color: white;
                padding: 10px;
                border-radius: 5px;
                cursor: pointer;
                color: black;
                border: 2px solid black;  /* 테두리 추가 */
                z-index: 9999;  /* 추가 */

            }

            #favorite-list {
                background-color: white;
                border: 1px solid lightgray;
                border-radius: 5px;
                padding: 10px;
                margin-top: 10px;
                color: black;
            }

            #favorite-list div {
                margin-bottom: 10px;
                cursor: pointer;}

            #customer-button {
                font-size: 15px;
                position: fixed;
                top: 10px;
                right: 80px;
                background-color: white;
                padding: 10px;
                border-radius: 5px;
                cursor: pointer;
                color: black;
                z-index: 9999;  /* 추가 */
            }

        </style>


        </style>

    </head>

    <body>

    <header>
        <img src="BDMate.png" alt="배달메이트 로고" width="250" height="110">
        <a href="user.php" style="position: fixed; top: 10px; right: 100px;"><button id="customer-button">👤 내정보</button></a>
        <div id="favorite-icon" onclick="showFavorites()">
            ❤️ 찜
            <div id="favorite-list" style="display: none;"></div>
            <button id="favorite-category-button" onclick="showFavoriteCategory()" style="display: none;">찜 카테고리 이동</button>
        </div>
    </header>

    <div id="categories">
        <div class="category-button" onclick="filterByCategory('한식')">
            <img src="korean-icon.png" alt="한식 아이콘">
            한식
        </div>
        <div class="category-button" onclick="filterByCategory('중식')">
            <img src="chinese-icon.png" alt="중식 아이콘">
            중식
        </div>
        <div class="category-button" onclick="filterByCategory('양식')">
            <img src="western-icon.png" alt="양식 아이콘">
            양식
        </div>
        <div class="category-button" onclick="filterByCategory('일식')">
            <img src="japanese-icon.png" alt="일식 아이콘">
            일식
        </div>
        <div class="category-button" onclick="filterByCategory('패스트푸드')">
            <img src="fastfood-icon.png" alt="패스트푸드 아이콘">
            패스트푸드
        </div>
        <div class="category-button" onclick="filterByCategory('디저트')">
            <img src="desert-icon.png" alt="디저트 아이콘">
            디저트
        </div>
    </div>

    <div id="search-bar">
        <input type="text" placeholder="가게 검색" id="store-search">
        <button onclick="searchStores()">🔍</button>
    </div>


    <div id="recommended-stores">
        <?php
        // 메뉴 카테고리를 가져오는 SQL 쿼리
        $menuCategoryQuery = "SELECT DISTINCT 메뉴그룹명 FROM 메뉴카테고리";
        $menuCategoryResult = $conn->query($menuCategoryQuery);

        // 각 메뉴 카테고리에 대한 가게 목록을 가져오고 출력
        if ($menuCategoryResult->num_rows > 0) {
            while ($menuCategoryRow = $menuCategoryResult->fetch_assoc()) {
                $menuGroup = $menuCategoryRow["메뉴그룹명"];


                // 메뉴 카테고리를 기준으로 해당 카테고리에 속한 가게 정보를 가져오는 SQL 쿼리
                $storeQuery = "SELECT * FROM 가게 WHERE 가게ID IN (SELECT 가게ID FROM 메뉴카테고리 WHERE 메뉴그룹명 = '$menuGroup')";
                $storeResult = $conn->query($storeQuery);


                // 결과를 반복문을 통해 출력
                if ($storeResult->num_rows > 0) {
                    while ($row = $storeResult->fetch_assoc()) {
                        // 클릭 이벤트를 추가하여 해당 가게의 메뉴를 보여주는 함수 호출
                        echo '<div class="store" data-id="' . $row["가게ID"] . '" data-category="' . $menuGroup . '" onclick="showMenu(\'' . $row["가게ID"] . '\')">';
                        echo '<img src="store_images/' . $row["가게ID"] . '.png" alt="' . $row["가게명"] . '">';
                        echo '<h3>' . $row["가게명"] . '</h3>';
                        echo '<p>주소: ' . $row["가게주소"] . '</p>';
                        echo '<p>전화번호: ' . $row["전화번호"] . '</p>';
                        echo '<p>운영시간: ' . $row["운영시간"] . '</p>';
                        echo '<p>가게소개글: ' . $row["가게소개글"] . '</p>';
                        echo '<p>⭐' . $row["평점"] . '</p>';
                        echo '<p>✏️' . $row["리뷰수"] . '</p>';
                        echo '<button class="favorite-button" onclick="toggleFavorite(this, event)">❤️ 찜하기</button>';
                        echo '</div>';
                    }
                } else {
                    echo "가게 정보가 없습니다.";
                }
            }
        } else {
            echo "메뉴 카테고리가 없습니다.";
        }

        ?>
        <div id="recommended-stores" style="display: flex; justify-content: space-between;">
            <?php
            // 평점이 4.8 이상인 가게 정보를 가져옵니다.
            $highRatingStoreQuery = "SELECT * FROM 가게 WHERE 평점 >= 4.5";
            $highRatingStoreResult = $conn->query($highRatingStoreQuery);

            // 결과가 있다면 랜덤하게 한 가게를 선택하여 출력합니다.
            if ($highRatingStoreResult->num_rows > 0) {
                $stores = array();
                while ($row = $highRatingStoreResult->fetch_assoc()) {
                    $stores[] = $row;
                }
                shuffle($stores); // 배열을 랜덤하게 섞습니다.
                $selectedStores = array_slice($stores, 0, 5); // 섞인 배열에서 앞에서부터 5개의 가게를 선택합니다.

                echo '<h2 style="width:100%; text-align:center;">오늘의 추천가게</h2>';
                foreach ($selectedStores as $store) {
                    echo '<div class="recommended-store" style="flex: 1; margin: 0 10px; text-align: center;">';
                    echo '<a href="menu.php?store_id=' . $store["가게ID"] . '">';
                    echo '<img src="store_images/' . $store["가게ID"] . '.png" alt="오늘의 추천가게" style="width: 170px; height: 170px;">';  // 이미지 크기를 100px x 100px로 설정
                    echo '</a>';
                    echo '<p>' . $store["가게명"] . '</p>';
                    echo '</div>';
                }
            } else {
                echo "추천할 가게 정보가 없습니다.";
            }


            ?>

        </div>




        <script>
            function showMenu(storeId) {
                window.location.href = 'menu.php?store_id=' + storeId;
            }

            function filterByCategory(category) {
                var stores = document.querySelectorAll('.store');

                stores.forEach(function (store) {
                    var storeCategory = store.getAttribute('data-category');
                    if (storeCategory === category && store.style.display === 'none') {
                        store.style.display = 'block'; /* 선택한 카테고리에 해당하는 가게들을 표시 */
                    } else {
                        store.style.display = 'none'; /* 이미 표시된 가게들을 숨김 */
                    }
                });
            }


            function searchStores() {
            var searchInput = document.getElementById('store-search').value.toLowerCase();
            var stores = document.querySelectorAll('.store');

            stores.forEach(function (store) {
                var storeName = store.querySelector('h3').innerText.toLowerCase();
                if (storeName.includes(searchInput)) {
                    store.style.display = 'block';
                } else {
                    store.style.display = 'none';
                }
            });
        }
        


            function toggleMenu(categoryId) {
                var category = document.getElementById(categoryId);
                if (category.style.display === 'block') {
                    category.style.display = 'none';
                } else {
                    category.style.display = 'block';
                }

                var favoritedStores = [];

            }
            function toggleFavorite(button, event) {
                event.stopPropagation();
                var isFavorited = button.classList.toggle('favorited');
                button.innerText = isFavorited ? '찜 취소' : '❤️ 찜하기';

                // 가게 정보를 가져옴
                var store = button.parentElement;
                var storeId = store.getAttribute('data-id');
                var storeName = store.querySelector('h3').innerText;

                if (isFavorited) {
                    favoritedStores.push({ id: storeId, name: storeName });
                } else {
                    favoritedStores = favoritedStores.filter(function (store) {
                        return store.id !== storeId;
                    });
                }

                // 찜한 가게들의 정보를 로컬 스토리지에 저장
                localStorage.setItem('favoritedStores', JSON.stringify(favoritedStores));
                
                updateFavoriteIcon();
            }
            var favoritedStores = JSON.parse(localStorage.getItem('favoritedStores')) || [];



            function updateFavoriteIcon() {
                var favoriteList = document.getElementById('favorite-list');
                favoriteList.innerHTML = ''; // 찜 목록을 초기화

                // 각 찜한 가게에 대해 목록에 추가
                favoritedStores.forEach(function (store) {
                    var storeElement = document.createElement('div');
                    storeElement.innerText = store.name;
                    storeElement.onclick = function () {
                        showMenu(store.id);
                    };
                    favoriteList.appendChild(storeElement);
                });
            }
            // 찜 카테고리 페이지로 이동하는 함수
            function showFavoriteCategory() {
                window.location.href = 'favorites.php';  // 찜 카테고리 페이지의 URL을 입력하세요.
            }

            
            function showFavorites() {
                var favoriteList = document.getElementById('favorite-list');
                var favoriteCategoryButton = document.getElementById('favorite-category-button');
                var isDisplayed = favoriteList.style.display !== 'none';

                favoriteList.style.display = isDisplayed ? 'none' : 'block';
                favoriteCategoryButton.style.display = isDisplayed ? 'none' : 'block';
            }
            


            window.onload = function () {
                favoritedStores = JSON.parse(localStorage.getItem('favoritedStores')) || [];
                updateFavoriteIcon();
            };


        </script>

    </body>

    </html>

<?php
// 데이터베이스 연결이나 기타 서버 측 로직 이후에는 연결을 닫아주는 것이 좋습니다.
$conn->close();
?>