<?php
require 'db.php';

/**
 * Получить новости из базы данных.
 *
 * @return array|false Возвращает массив новостей или false, если ошибка.
 */
function getNews() {
    global $pdo;

    try {
        $stmt = $pdo->query("SELECT title, text, created_at FROM news ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {

        error_log('Ошибка получения новостей: ' . $e->getMessage());
        return false;
    }
}
?>
