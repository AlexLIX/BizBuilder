<?php
session_start();
if (!isset($_SESSION['user'])) {
    // Перенаправляем на страницу входа, если пользователь не авторизован
    header('Location: login.php');
    exit();
}
$user = $_SESSION['user'];

// Функция для обновления данных пользователя в файле
function update_user($updated_user) {
    $users = [];
    $file = fopen('users.txt', 'r');
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $user_data = json_decode($line, true);
            if ($user_data['email'] === $updated_user['email']) {
                $users[] = $updated_user;
            } else {
                $users[] = $user_data;
            }
        }
        fclose($file);
    }
    $file = fopen('users.txt', 'w');
    if ($file) {
        foreach ($users as $user) {
            fwrite($file, json_encode($user) . PHP_EOL);
        }
        fclose($file);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Обновляем данные пользователя
    $updated_user = [
        'username' => $username,
        'email' => $email,
        'password_hash' => $user['password_hash'], // оставляем хэш пароля без изменений
        'created_at' => $user['created_at']
    ];

    // Обновляем данные в файле
    update_user($updated_user);

    // Обновляем данные в сессии
    $_SESSION['user'] = $updated_user;

    echo "Профиль успешно обновлен.";
    // Перенаправляем обратно в личный кабинет
    header('Location: cabinet.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование профиля - BizBuilder AI</title>
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
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }

        .profile-section {
            max-width: 800px;
            width: 100%;
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

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container input {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .action-button {
            background-color: #079b0c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .action-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        footer {
            background-color: #079b0c;
            color: white;
            width: 100%;
            padding: 10px 0;
            text-align: center;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.2);
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
        <div class="profile-section">
            <h2>Редактирование профиля</h2>
            <form class="form-container" action="edit_profile.php" method="POST">
                <label for="username">Имя пользователя:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                <div class="button-group">
                    <button type="submit" class="action-button">Сохранить изменения</button>
                    <a href="cabinet.php" class="action-button">Отмена</a>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>© 2024 Все права защищены.</p>
        </div>
    </footer>
</body>
</html>