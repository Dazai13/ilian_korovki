<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Убедитесь, что этот путь к autoload.php корректен

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Получаем данные из формы
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    if (!$email || !$subject || !$message) {
        $_SESSION['error'] = "Некорректные данные в форме! Пожалуйста, заполните все поля правильно.";
        header('Location: /index.php'); // Абсолютный путь на главную страницу
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Настройки SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.mail.ru';
        $mail->SMTPAuth = true;
        $mail->Username = 'dazai1317@mail.ru'; // Ваш email
        $mail->Password = 'NShCbewvtjHeP5Tp0R11'; // Пароль приложения Mail.ru
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Настройки письма
        $mail->setFrom('dazai1317@mail.ru', 'Ваш сайт');
        $mail->addAddress('dazai1317@mail.ru'); // Получатель
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "
            <h3>Новое сообщение с сайта</h3>
            <p><strong>Email отправителя:</strong> $email</p>
            <p><strong>Тема:</strong> $subject</p>
            <p><strong>Сообщение:</strong></p>
            <p>$message</p>
        ";
        $mail->AltBody = strip_tags($message); // Альтернативный текст письма

        // Отправка письма
        if ($mail->send()) {
            $_SESSION['success'] = "Сообщение отправлено успешно! Спасибо за вашу обратную связь.";
        } else {
            $_SESSION['error'] = "Ошибка при отправке сообщения. Попробуйте позже.";
        }
    } catch (Exception $e) {
        $errorMessage = "Ошибка: {$mail->ErrorInfo}";
        error_log($errorMessage); // Логируем ошибку для диагностики
        $_SESSION['error'] = "Произошла ошибка при отправке сообщения. Попробуйте позже.";
    }

    // Перенаправляем на главную страницу
    header('Location: /index.php'); // Абсолютный путь
    exit;
} else {
    http_response_code(405);
    $_SESSION['error'] = "Неверный метод запроса.";
    header('Location: /index.php'); // Абсолютный путь
    exit;
}
