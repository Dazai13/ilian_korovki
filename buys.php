<?php
require 'backend/menu_function.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'];
}
$user_id = $_SESSION['user_id'];


$query = "SELECT c.product_id, c.quantity, p.title, p.price, p.img 
          FROM cart c
          JOIN products p ON c.product_id = p.id
          WHERE c.user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $user_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
    $remove_product_id = intval($_POST['remove_product_id']);

    $delete_query = "DELETE FROM cart WHERE product_id = :product_id AND user_id = :user_id";
    $stmt = $pdo->prepare($delete_query);
    $stmt->execute(['product_id' => $remove_product_id, 'user_id' => $user_id]);

    header("Location: buys.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {

    $clear_cart_query = "DELETE FROM cart WHERE user_id = :user_id";
    $stmt = $pdo->prepare($clear_cart_query);
    $stmt->execute(['user_id' => $user_id]);


    $totalPrice = array_sum(array_map(function($item) {
        return $item['price'] * $item['quantity'];
    }, $cartItems));


    $_SESSION['checkout_success'] = [
        'items' => $cartItems,
        'totalPrice' => $totalPrice
    ];

    header("Location: checkout_success.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Корзина</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="buys">
        <div class="container">
            <div class="buys-title">
                <span>Ваша корзина</span>
            </div>

            <?php if ($cartItems): ?>
                <div class="buys-items">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="buys-item">
                            <img src="<?php echo htmlspecialchars($item['img']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                            <div class="buys-details">
                                <span class="buys-item-title"><?php echo htmlspecialchars($item['title']); ?></span>
                                <span class="buys-item-price">Цена: <?php echo htmlspecialchars($item['price']); ?> ₽</span>
                                <span class="buys-item-quantity">Количество: <?php echo htmlspecialchars($item['quantity']); ?></span>
                                <span class="buys-item-total">Итого: <?php echo htmlspecialchars($item['price'] * $item['quantity']); ?> ₽</span>
                            </div>
                            <form method="POST" action="buys.php">
                                <input type="hidden" name="remove_product_id" value="<?php echo htmlspecialchars($item['product_id']); ?>">
                                <button type="submit">Удалить</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="buys-summary">
                    <span>Итого: 
                        <?php echo array_sum(array_map(function($item) {
                            return $item['price'] * $item['quantity'];
                        }, $cartItems)); ?> ₽
                    </span>
                    <form method="POST" action="buys.php">
                        <button type="submit" name="checkout">Оформить заказ</button>
                    </form>
                </div>
            <?php else: ?>
                <span class = "empty-buys">Ваша корзина пуста.</span>
            <?php endif; ?>
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
