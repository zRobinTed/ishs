<?php
session_start();

// 원소 데이터 배열
// 실제 프로젝트에서는 모든 원소를 1번부터 118번까지 추가하세요.
$elements = [
    1 => ['atomic_number' => 1, 'name' => 'Hydrogen',   'symbol' => 'H'],
    2 => ['atomic_number' => 2, 'name' => 'Helium',     'symbol' => 'He'],
    3 => ['atomic_number' => 3, 'name' => 'Lithium',    'symbol' => 'Li'],
    4 => ['atomic_number' => 4, 'name' => 'Beryllium',  'symbol' => 'Be'],
    5 => ['atomic_number' => 5, 'name' => 'Boron',      'symbol' => 'B']
    // ... 여기에 6번부터 118번 원소 추가
];

$feedback = "";

// 폼이 제출된 경우 정답 체크
if(isset($_POST['submit'])) {
    $userAnswer = trim($_POST['answer']);
    $currentElement = $_SESSION['currentElement'];
    
    if (strcasecmp($userAnswer, $currentElement['symbol']) === 0) {
        $feedback = "정답입니다!";
    } else {
        $feedback = "오답입니다. 정답은 " . $currentElement['symbol'] . " 입니다.";
    }
    
    // 새로운 문제를 위해 랜덤 원소 선택
    $randomKey = array_rand($elements);
    $_SESSION['currentElement'] = $elements[$randomKey];
} else {
    // 첫 접속 시 랜덤 원소 선택
    $randomKey = array_rand($elements);
    $_SESSION['currentElement'] = $elements[$randomKey];
}

$currentElement = $_SESSION['currentElement'];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>원소 기호 맞추기 퀴즈</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 30px auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1, p {
            text-align: center;
        }
        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            font-size: 1em;
            margin-bottom: 15px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 1em;
            border: none;
            border-radius: 4px;
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .feedback {
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>원소 기호 맞추기 퀴즈</h1>
    <!-- 질문 출력 -->
    <p>원자번호 <?php echo htmlspecialchars($currentElement['atomic_number']); ?>번 원소의 기호는?</p>
    
    <!-- 정답 입력 폼 -->
    <form action="index.php" method="post">
        <input type="text" name="answer" placeholder="원소 기호를 입력하세요." required autofocus>
        <input type="submit" name="submit" value="제출">
    </form>
    
    <!-- 피드백 영역 -->
    <?php if($feedback !== ""): ?>
    <p class="feedback"><?php echo htmlspecialchars($feedback); ?></p>
    <?php endif; ?>
</div>
</body>
</html>
