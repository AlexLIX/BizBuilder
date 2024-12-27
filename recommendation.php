<?php
session_start();
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: login.php');
    exit();
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Рекомендации - BizBuilder AI</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #079b0c;
            color: white;
            width: 100%;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            height: 50px;
        }

        nav.menu {
            display: flex;
            gap: 20px;
        }

        .menu-item {
            color: #079b0c;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .recommendation-list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .recommendation-list li {
            padding: 10px;
            background-color: #f1f1f1;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        footer {
            background-color: #079b0c;
            color: white;
            width: 100%;
            padding: 10px 0;
            text-align: center;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.2);
            position: absolute;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="BizBuilder_glavnaya_1.png" alt="Логотип">
            </div>
            <nav class="menu">
                <a href="index.html" class="menu-item">Главная</a>
                <a href="details.html" class="menu-item">О нас</a>
                <a href="cabinet.php" class="menu-item">Личный кабинет</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="content">
            <h3>Рекомендации для выбора оптимальной бизнес-стратегии</h3>
            <p>Мы предлагаем несколько ключевых стратегий, которые помогут вам успешно начать и развить бизнес, основываясь на актуальных данных и тенденциях:</p>

            <div class="recommendation-list">
                <ul>
                    <li><strong>Стратегия 1: Адаптация к локальному рынку</strong>
                        <p>Изучите предпочтения местных потребителей и предложите продукты или услуги, которые соответствуют их интересам и потребностям.</p>
                    </li>
                    <li><strong>Стратегия 2: Инновации и технологии</strong>
                        <p>Используйте передовые технологии, чтобы предлагать инновационные решения, которые выделяют ваш бизнес на фоне конкурентов.</p>
                    </li>
                    <li><strong>Стратегия 3: Целевая аудитория и маркетинг</strong>
                        <p>Фокусируйтесь на конкретной целевой аудитории, разрабатывая персонализированные маркетинговые кампании.</p>
                    </li>
                    <li><strong>Стратегия 4: Экологичность и устойчивость</strong>
                        <p>Сделайте ваш бизнес более экологически устойчивым, предлагая продукты и услуги, которые поддерживают экологические инициативы.</p>
                    </li>
                    <li><strong>Стратегия 5: Расширение партнерств и сетевого взаимодействия</strong>
                        <p>Сотрудничество с другими компаниями может расширить возможности вашего бизнеса, улучшить доступ к рынкам и ресурсам.</p>
                    </li>
                </ul>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>© 2024 Все права защищены.</p>
        </div>
    </footer>
</body>
</html>
