<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $recaptchaResponse = $_POST['g-recaptcha-response']; 
    $secretKey = '6LfLecMqAAAAAHR1qGeYtkc1bCSzBqpzuqclVDhS';
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        'secret' => $secretKey,
        'response' => $recaptchaResponse,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $result = json_decode($response, true);

    if (!$result['success']) {
        die('Ошибка CAPTCHA: Подтвердите, что вы не робот.');
    }

    $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header('Location: /account.php');
        exit();
    } else {

        die('Неверный email или пароль.');
    }
}
?>
