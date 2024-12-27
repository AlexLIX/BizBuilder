<?php
session_start();
if (!isset($_SESSION['user'])) {
    // Перенаправляем на страницу входа, если пользователь не авторизован
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
    <title>Личный кабинет - BizBuilder AI</title>
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
            color: 079b0c;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: row;
            padding: 20px;
            max-width: 1400px;
            margin: left;
            margin-left: 380px;
            margin-right: 350px;
        }

        .sidebar {
            width: 300px;
            margin-right: 20px;
        }

        .profile-section {

            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .profile-section h2 {
            color: #079b0c;
            margin-bottom: 20px;
        }

        .profile-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .profile-details label {
            font-weight: bold;
        }

        .profile-details p {
            margin: 0;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }

        .action-button {
            background-color: #079b0c;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            display: block;
        }

        .action-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .feature-menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
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
        <div class="sidebar">
            <div class="profile-section">
                <h2>Личный кабинет</h2>
                <div class="profile-details">
                    <label>Имя пользователя:</label>
                    <p><?php echo htmlspecialchars($user['username']); ?></p>
                    <label>Email:</label>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
                <div class="button-group">
                    <a href="edit_profile.php" class="action-button">Редактировать профиль</a>
                    <a href="logout.php" class="action-button">Выйти</a>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="feature-menu">
                <a href="bigdata.php" class="action-button">Обработка больших данных</a>
                <a href="dashboard.php" class="action-button">Интерактивный Дешборд</a>
                <a href="recommendation.php" class="action-button">Рекомендации</a>
                <!-- Добавьте здесь кнопки для других функций по мере необходимости -->
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