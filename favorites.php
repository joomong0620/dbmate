<!DOCTYPE html>
<html lang="en">

<head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>배달메이트</title>
        <style>
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
        }

        header img {
            max-width: 100%;
            height: auto;
        }

        .store {
            max-width: 500px;
            margin: 2em auto;
            padding: 10px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        .store h3 {
            color: #9A2EBF;
            margin-bottom: 20px;
        }

        .store a {
            color: #333;
            text-decoration: none;
        }

        .store button {
            background-color: #9A2EBF;
            color: #fff;
            border: none;
            padding: 3px 10px;
            cursor: pointer;
        }

        .store button:hover {
            background-color: #f1f1f1;
            color: #9A2EBF;
        }

        .dropdown {
            cursor: pointer;
            background-color: #fff;
            color: black;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 120px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
      </style>
   </head>
   <body>
    <header>
        <img src="BDMate.png" alt="배달메이트 로고" width="250" height="110">
    </header>

    <h1 class="dropdown" onclick="toggleDropdown(1)">
        <span id="category-name-1">나중에 가볼 맛집 ▼</span>
        <div id="favorite-stores-1" class="dropdown-content"></div>
    </h1>
    <h1 class="dropdown" onclick="toggleDropdown(2)">
        <span id="category-name-2">분위기 맛집 ▼</span>
        <div id="favorite-stores-2" class="dropdown-content"></div>
    </h1>
    <h1 class="dropdown" onclick="toggleDropdown(3)">
        <span id="category-name-3">진짜 맛집 ▼</span>
        <div id="favorite-stores-3" class="dropdown-content"></div>
    </h1>
  
    <button id="add-category">카테고리 추가</button>
    <div id="categories"></div>
    <div id="favorite-stores"></div>

    <script>
        function toggleDropdown(category) {
            var dropdownContent = document.getElementById('favorite-stores-' + category);
            if (dropdownContent.style.display === "none") {
                dropdownContent.style.display = "block";
            } else {
                dropdownContent.style.display = "none";
            }
        }

        var addCategoryButton = document.getElementById('add-category');
        var categoriesDiv = document.getElementById('categories');
        var categoryCounter = 4;

        addCategoryButton.onclick = function() {
            var categoryName = prompt('새 카테고리의 이름을 입력해주세요.');
            
            if (categoryName) {
                var category = document.createElement('h1');
                category.className = 'dropdown';
                category.onclick = function() {
                    toggleDropdown(categoryCounter);
                }

                var categoryNameSpan = document.createElement('span');
                categoryNameSpan.id = 'category-name-' + categoryCounter;
                categoryNameSpan.textContent = categoryName + ' ▼';
                category.appendChild(categoryNameSpan);

                var favoriteStoresDiv = document.createElement('div');
                favoriteStoresDiv.id = 'favorite-stores-' + categoryCounter;
                favoriteStoresDiv.className = 'dropdown-content';
                category.appendChild(favoriteStoresDiv);

                categoriesDiv.appendChild(category);
                categoriesDiv.appendChild(addCategoryButton);
                categoryCounter++;
            }
        }

        var favoritedStores = JSON.parse(localStorage.getItem('favoritedStores')) || [];
        var favoriteStoresDiv = document.getElementById('favorite-stores');

        function createFavoriteStore(store) {
            var storeDiv = document.createElement('div');
            storeDiv.className = 'store';

            var storeName = document.createElement('h3');
            var storeLink = document.createElement('a');
            storeLink.href = 'menu.php?store_id=' + store.id;   // 가게의 메뉴 페이지 URL
            storeLink.innerText = store.name;
            storeName.appendChild(storeLink);
            
            var moveToCategoryButton = document.createElement('button');
            moveToCategoryButton.innerText = '찜 카테고리 이동';
            moveToCategoryButton.onclick = function() {
                var category = prompt('어느 카테고리에 이동시키시겠습니까? 1: 나중에 가볼 맛집, 2: 분위기 맛집, 3: 진짜 맛집, 4 이상: 직접 추가한 카테고리');
                var targetCategoryDiv = document.getElementById('favorite-stores-' + category);

                var alreadyExists = Array.from(targetCategoryDiv.children).some(function(child) {
                    return child.querySelector('a').href === storeLink.href;
                });

                if (!alreadyExists) {
                    targetCategoryDiv.appendChild(createFavoriteStore(store));
                } else {
                    alert('이미 해당 카테고리에 가게가 존재합니다.');
                }
            }
            storeDiv.appendChild(moveToCategoryButton);
            
            storeDiv.appendChild(storeName);
            return storeDiv;
        }

        favoritedStores.forEach(function (store) {
            favoriteStoresDiv.appendChild(createFavoriteStore(store));
        });
    </script>
</body>

</html>