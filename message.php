<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/styles/style.css" rel="stylesheet">
    <title>Личный кабинет</title>
</head>
<body>
    <?php
    include 'header.php';
    ?>
        <div id="message-form" class="account-message">
            <div class="container">
                <span class="message-title">Написать сообщение</span>
                <form id="contactForm" action="/backend/send_message.php" method="POST">
                    <label for="email">Ваш Email:</label>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                    <label for="subject">Тема сообщения:</label>
                    <input type="text" name="subject" id="subject" placeholder="Тема" required>
                    <label for="message">Сообщение:</label>
                    <textarea name="message" placeholder="Сообщение..." id="message" rows="5" required></textarea>
                    <button type="submit">Отправить</button>
                </form>
            </div>
        </div>
</body>
</html>
