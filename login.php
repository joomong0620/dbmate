<?php
// 데이터베이스 연결 설정
session_start(); 

$host = "localhost";  // MySQL 서버가 다른 호스트에 있는 경우 이 부분을 변경
$user = "user";       // MySQL 사용자 이름
$pw = "12345";         // MySQL 비밀번호
$dbName = "bdmate";    // 데이터베이스 이름

// 연결 생성
$conn = new mysqli($host, $user, $pw, $dbName);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 폼에서 전송된 이메일과 비밀번호
    $email = $_POST["email"];
    $password = $_POST["password"];

    // 이메일과 비밀번호를 사용하여 데이터베이스에서 사용자를 찾습니다.
    $query = "SELECT * FROM 고객 WHERE 이메일 = '$email' AND 비밀번호 = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // 사용자가 존재하면 로그인 성공
        // 로그인된 사용자의 이메일을 세션에 저장
        $_SESSION['email'] = $email;
        echo "<p class='login-success'>로그인 성공!</p>";
        header("Location: http://localhost/sqltest/ppp.php");
        exit();
        // 여기에서 추가적인 작업 수행 가능
    } else {
        // 사용자가 존재하지 않으면 로그인 실패
        echo "<p class='login-failure'>로그인 실패. 이메일 또는 비밀번호를 확인하세요.</p>";
    }
}

// 주문 상세 페이지에서 세션에 저장된 이메일을 사용하여 고객 정보를 불러옵니다.
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $query = "SELECT * FROM 고객 WHERE 이메일 = '$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        // 고객 정보를 불러옵니다.
        $customerData = $result->fetch_assoc();
        // 여기에서 추가적인 작업 수행 가능
    } else {
        echo "<p class='error'>고객 정보를 찾을 수 없습니다.</p>";
    }
}

// 연결 종료
$conn->close();
?>
