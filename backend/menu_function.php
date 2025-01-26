<?php
require 'db.php';

/**
 * Получить все категории.
 *
 * @return array|false
 */
function getCategories($pdo) {
    try {
        $stmt = $pdo->query("SELECT id, name FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Ошибка получения категорий: ' . $e->getMessage());
        return false;
    }
}


/**
 * Получение продуктов по категории
 *
 * @param int $categoryId
 * @param PDO $pdo
 * @return array|false
 */
function getProductsByCategory($pdo, $categoryId) {
    try {

        $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->execute([$categoryId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Ошибка получения продуктов: ' . $e->getMessage());
        return false;
    }
}