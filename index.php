<?php

require 'backend/menu_function.php';
session_start();

$categories = getCategories($pdo);

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'];
}
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;


    $check_cart_query = "SELECT * FROM cart WHERE product_id = :product_id AND user_id = :user_id";
    $stmt = $pdo->prepare($check_cart_query);
    $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);

    if ($stmt->rowCount() > 0) {

        $update_query = "UPDATE cart SET quantity = quantity + :quantity WHERE product_id = :product_id AND user_id = :user_id";
        $stmt = $pdo->prepare($update_query);
        $stmt->execute(['quantity' => $quantity, 'product_id' => $product_id, 'user_id' => $user_id]);
    } else {

        $insert_query = "INSERT INTO cart (product_id, quantity, user_id) VALUES (:product_id, :quantity, :user_id)";
        $stmt = $pdo->prepare($insert_query);
        $stmt->execute(['product_id' => $product_id, 'quantity' => $quantity, 'user_id' => $user_id]);
    }

    header("Location: buys.php");
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
    <title>Ильинсие коровки</title>
</head>
<body>
    <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success">
                <?php
                echo htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']);
                ?>
            </div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert error">
                <?php
                echo htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>
    <?php include 'header.php'; ?>
    <div class="main_window">
        <div class="container">
            <div class="leff-sidebar">
                <div class="menu-title">
                    <span>Магазин</span>
                </div>
                <div class="menu-block">
                    <?php if ($categories): ?>
                        <?php foreach ($categories as $category): ?>
                            <div class="menu-item">
                                <a href="#" data-target="category-<?php echo $category['id']; ?>" class="category-link">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Категории не найдены.</p>
                    <?php endif; ?>                  
                </div>
            </div>

            <div class="right-sidebar">
                <div class="hello-window">
                    <div class="hello-title">
                        ООО "Ильинская коровка"
                    </div>
                    <div class="hello-text">
                        ООО "Ильинская коровка" - молокоперерыбатывающее предприятие, основанное в 2021 году. В настоящее время ООО "Ильинская коровка" - современный, технически оснащенный завод, выпускающий более 10 наименований молочной продукции. Миссия нашей компании - выпускать доступную для населения и предприятий высококачественную молочную продукцию.
                    </div>
                </div>

                <?php if ($categories): ?>
                    <?php foreach ($categories as $category): ?>
                        <div id="category-<?php echo $category['id']; ?>" class="katalog">
                            <div class="katalog-title"><?php echo htmlspecialchars($category['name']); ?></div>
                            
                            <?php
                            $products = getProductsByCategory($pdo, $category['id']);
                            if ($products): 
                            ?>
                                <div class="products-block">
                                    <?php foreach ($products as $product): ?>
                                        <div class="product-item">
                                            <?php

                                            if (!empty($product['img'])) {
                                                echo '<img src="' . htmlspecialchars($product['img']) . '" alt="' . htmlspecialchars($product['title']) . '">';
                                            } else {
                                                echo '<p>Нет изображения</p>';
                                            }
                                            ?>
                                            <span class="product-title"><?php echo htmlspecialchars($product['title']); ?></span>
                                            <span class="product-subtitle"><?php echo htmlspecialchars($product['intro']); ?></span>
                                            <div class="price"><span>Цена: <?php echo htmlspecialchars($product['price']); ?> ₽</span></div>
                                            <div class="otzivi">
                                                <div class="stars" id="stars-<?php echo $product['id']; ?>">
                                                    <i class="fas fa-star" data-value="1"></i>
                                                    <i class="fas fa-star" data-value="2"></i>
                                                    <i class="fas fa-star" data-value="3"></i>
                                                    <i class="fas fa-star" data-value="4"></i>
                                                    <i class="fas fa-star" data-value="5"></i>
                                                </div>
                                                <span>Отзывы: <?php echo htmlspecialchars($product['reviews_count']); ?></span>
                                            </div>
                                            <form method="POST" action="index.php" class="buys-action">
                                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                <input type="number" name="quantity" value="1" min="1" <?php echo !isset($_SESSION['user_id']) ? 'disabled' : ''; ?>>
                                                <?php if (isset($_SESSION['user_id'])): ?>
                                                    <button type="submit">Добавить в корзину</button>
                                                <?php else: ?>
                                                    <button type="button" disabled title="Войдите в аккаунт, чтобы добавить в корзину">Добавить в корзину</button>
                                                <?php endif; ?>
                                            </form>

                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p>Продукты не найдены в этой категории.</p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="scripts/script.js"></script>
</body>
</html>
