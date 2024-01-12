<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>리뷰 작성</title>
    <style>
        /* 여기에 필요한 스타일을 추가하세요 */
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
        .review-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .review-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center; /* 가운데 정렬 */
            margin-top: 250px;
        }

        .review-textarea {
            width: 100%;
            height: 200px;
            margin-bottom: 20px;
        }

        .submit-button {
            display: block;
            width: 180px;
            height: 50px;
            background-color: #C5B1D6;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 20px;
            margin: 10px auto;
            font-size: 20px;
        }

        .submit-button:hover {
            background-color: #9A2EBF;
        }

        .star-rating {
            direction: rtl;
            display: inline-block;
            unicode-bidi: bidi-override;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: lightgrey;
            font-size: 30px;
            padding: 0;
            cursor: pointer;
            display: inline-block;
            margin-right: -3px;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #9A2EBF;
        }
        .review-detail-btn {
            background-color: #CC93D6;
        }
        .review-complete-icon img {
            width: 100px;  /* 이미지 너비를 24px로 수정 */
            height: 100px; /* 이미지 높이를 24px로 수정 */
        }
        .icons-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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
<div class="review-container">
    <div class="icons-container">
        <div class="review-title">식사는 맛있게 하셨나요? 이 가게에 대한 리뷰를 적겠습니까?</div>
        <div class="review-complete-icon">
            <img src="review.png" alt="리뷰 아이콘">
        </div>
        <button id="yes-button" class="submit-button">네</button>
        <button id="no-button" class="submit-button">아니오</button>
        <div id="review-area" style="display: none;">
</div>

        <div class="star-rating">
            <input type="radio" id="5-stars" name="rating" value="5"/>
            <label for="5-stars">★</label>
            <input type="radio" id="4-stars" name="rating" value="4"/>
            <label for="4-stars">★</label>
            <input type="radio" id="3-stars" name="rating" value="3"/>
            <label for="3-stars">★</label>
            <input type="radio" id="2-stars" name="rating" value="2"/>
            <label for="2-stars">★</label>
            <input type="radio" id="1-star" name="rating" value="1"/>
            <label for="1-star">★</label>
        </div>
        <textarea class="review-textarea"></textarea>
        <button id="submit-button" class="submit-button">리뷰 제출</button>
    </div>
</div>

<script>
    document.getElementById('yes-button').addEventListener('click', function () {
        document.getElementById('review-area').style.display = 'block';
        this.style.display = 'none';
        document.getElementById('no-button').style.display = 'none'; // 아니오 버튼도 숨깁니다.
    });

    document.getElementById('no-button').addEventListener('click', function () {
        // 아니오 버튼을 클릭하면 ppp.php 페이지로 이동합니다.
        window.location.href = 'ppp.php';
    });

    document.getElementById('submit-button').addEventListener('click', function () {
        alert('리뷰가 성공적으로 등록되었습니다.');
        window.location.href = 'ppp.php';
    });
</script>

</body>

</html>
