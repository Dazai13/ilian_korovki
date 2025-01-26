<?php
session_start();
require 'backend/add_news.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/styles/style.css" rel="stylesheet">
    <title>Новости</title>
</head>
<body>
    <?php include 'header.php';?>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="news">
            <div class="container">
              
                <div class = "news-title">Новости</div>

                <?php
                $news = getNews();
                if ($news && !empty($news)):
                    foreach ($news as $row): ?>
                        <div class="news-item">
                            <div class="news-header">
                                <span><?php echo htmlspecialchars($row['title']); ?></span>
                                <span>Добавлено: <?php echo htmlspecialchars($row['created_at']); ?></span>
                            </div>
                            <span><?php echo nl2br(htmlspecialchars($row['text'])); ?></span>

                        </div>
                    <?php endforeach;
                else: ?>
                    <p>Нет новостей.</p>
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
</body>
</html>
