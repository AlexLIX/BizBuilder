<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
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

        .tab-menu {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .tab-menu button {
            background-color: white;
            color: #079b0c;
            border: 2px solid #079b0c;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .tab-menu button.active {
            background-color: #079b0c;
            color: white;
        }

        .tab-menu button:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .form-container {
            display: none;
            max-width: 400px;
            width: 100%;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .form-container.active {
            display: block;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-container input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            background-color: #079b0c;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .form-container button:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
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
            </nav>
        </div>
    </header>

    <main>
        <div class="tab-menu">
            <button class="tab-button active" data-tab="login">Вход</button>
            <button class="tab-button" data-tab="register">Регистрация</button>
        </div>

        <div id="login" class="form-container active">
            <form action="auth.php" method="POST">
                <label>Email:</label>
                <input type="email" name="email" required>
                <label>Пароль:</label>
                <input type="password" name="password" required>
                <button type="submit">Войти</button>
            </form>
        </div>

        <div id="register" class="form-container">
            <form action="register.php" method="POST">
                <label>Имя пользователя:</label>
                <input type="text" name="username" required>
                <label>Email:</label>
                <input type="email" name="email" required>
                <label>Пароль:</label>
                <input type="password" name="password" required>
                <button type="submit">Зарегистрироваться</button>
            </form>
        </div>
    </main>

    <script>
        const tabButtons = document.querySelectorAll('.tab-button');
        const forms = document.querySelectorAll('.form-container');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                forms.forEach(form => form.classList.remove('active'));

                button.classList.add('active');
                document.getElementById(button.dataset.tab).classList.add('active');
            });
        });
    </script>
</body>
</html>