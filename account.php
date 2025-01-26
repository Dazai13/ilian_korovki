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
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="account-window">
            <div class="container">
                <div class="account-title">
                    <span>Вход</span>
                </div>
                <div class="account-user">
                    <span>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                </div>
                <a class="account-btn message" href="message.php">Написать сообщение</a>
                <a class="account-btn exit" href="/backend/logout.php">Выйти</a>
            </div>
        </div>
        </div>
    <?php else: ?>
        <div id="login" class="login-window">
            <div class="container">
                <div class="log-title">
                    <span>Авторизация</span>
                </div>
                <form class="login" action="/backend/login.php" method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Пароль" required>
                    <div class="g-recaptcha" data-sitekey="6LfLecMqAAAAAOaqg6uPuDrJvYLcC6j9srrtXXaM"></div>
                    <button type="submit">Войти</button>
                </form>
                <a href="#" id="to-register" class="change-sign">Нет аккаунта?</a>
            </div>
        </div>
        <div id="reg" class="register-window hidden">
            <div class="container">
                <div class="reg-title">
                    <span>Регистрация</span>
                </div>
                <form class="reg" action="/backend/register.php" method="POST">
                    <input type="text" name="username" placeholder="Логин" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Пароль" required>
                    <div class="g-recaptcha" data-sitekey="6LfLecMqAAAAAOaqg6uPuDrJvYLcC6j9srrtXXaM"></div>
                    <button type="submit">Зарегистрироваться</button>
                </form>
                <a href="#" id="to-login" class="change-sign">Уже есть аккаунт?</a>
            </div>
        </div>
        <script src ="scripts/account.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php endif; ?>
</body>
</html>
