<header class="header">
    <div class="header_container">
        <nav class="header_nav">
            <a href="index.php" class="nav_link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Главная</a>
            <a href="news.php" class="nav_link <?php echo basename($_SERVER['PHP_SELF']) == 'news.php' ? 'active' : ''; ?>">Новости</a>
            <a href="buys.php" class="nav_link <?php echo basename($_SERVER['PHP_SELF']) == 'buys.php' ? 'active' : ''; ?>">Корзина</a>
            <a href="account.php" class="nav_link <?php echo basename($_SERVER['PHP_SELF']) == 'account.php' ? 'active' : ''; ?>">Личный кабинет</a>
        </nav>
    </div>
</header>
