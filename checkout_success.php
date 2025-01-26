<?php
session_start();

if (!isset($_SESSION['checkout_success'])) {
    header("Location: index.php"); 
    exit;
}

$checkoutData = $_SESSION['checkout_success'];
$cartItems = $checkoutData['items'];
$totalPrice = $checkoutData['totalPrice'];


unset($_SESSION['checkout_success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Заказ оформлен</title>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="offer">
            <div class="container">
                <span class= "offer-title">Заказ</span>
                <span class = "summary-price">Ваш заказ оформлен на общую сумму: <strong><?php echo $totalPrice; ?> ₽</strong></span>

                <div class="ordered-items">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="ordered-item">
                            <img src="<?php echo htmlspecialchars($item['img']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                            <div class="ordered-item-details">
                                <span class="ordered-item-title"><?php echo htmlspecialchars($item['title']); ?></span>
                                <span class="ordered-item-quantity">Количество: <?php echo htmlspecialchars($item['quantity']); ?></span>
                                <span class="ordered-item-price">Цена: <?php echo htmlspecialchars($item['price'] * $item['quantity']); ?> ₽</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="checkout-actions">
                    <a href="index.php" class="button">На главную</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="not-login">
            <div class="container">
                <div class="not-log">
                    <span>Для просмотра этой страницы необходимо авторизироваться</span>
                </div>
            </div>
        </div>
    <?php endif; ?>    
    <script src="scripts/script.js"></script>
</body>
</html>
