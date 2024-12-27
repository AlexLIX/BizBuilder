<?php
session_start();
if (!isset($_SESSION['user'])) {
    // Перенаправляем на страницу входа, если пользователь не авторизован
    header('Location: login.php');
    exit();
}
$user = $_SESSION['user'];

function get_trends($segment, $region, $data) {
    foreach ($data as $entry) {
        if ($entry['segment'] === $segment) {
            return $entry['regions'][$region] ?? [];
        }
    }
    return [];
}

function save_user_choice($username, $segment, $region) {
    $filename = 'user_choices.txt';
    $user_choices = [];

    if (file_exists($filename)) {
        $json_data = file_get_contents($filename);
        $user_choices = json_decode($json_data, true);
    }

    $user_choices[$username] = [
        'segment' => $segment,
        'region' => $region,
    ];

    file_put_contents($filename, json_encode($user_choices));
}

function get_user_choice($username) {
    $filename = 'user_choices.txt';
    if (file_exists($filename)) {
        $json_data = file_get_contents($filename);
        $user_choices = json_decode($json_data, true);
        return $user_choices[$username] ?? null;
    }

    return null;
}

$data = json_decode(file_get_contents('bigdata.txt'), true);
$username = $_SESSION['username'] ?? $user['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['segment']) && isset($_POST['region'])) {
        $segment = $_POST['segment'];
        $region = $_POST['region'];

        save_user_choice($username, $segment, $region);
    } else if (isset($_POST['like_trends']) && $_POST['like_trends'] === 'no') {
        // Если пользователю не нравятся тренды, очистить выбор
        save_user_choice($username, '', '');
    } else if (isset($_POST['like_trends']) && $_POST['like_trends'] === 'yes') {
        // Уведомление о сохранении данных
        $notification = "Данные сохранены.";
    }
}

$user_choice = get_user_choice($username);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обработка больших данных - BizBuilder AI</title>
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

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container select, .form-container button {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container button {
            background-color: #079b0c;
            color: white;
            border: none;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .form-container button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .trend-list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .trend-list li {
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
        }

        .notification-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .notification-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .notification-content button {
            background-color: #079b0c;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .notification-content button:hover {
            background-color: #065e03;
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
            <h3>Обработка больших данных (Big Data)</h3>
            
            <?php if (!$user_choice || empty($user_choice['segment']) || empty($user_choice['region'])) { ?>
                <form class="form-container" action="bigdata.php" method="POST">
                    <label for="segment">Выберите область бизнеса:</label>
                    <select id="segment" name="segment" required>
                        <?php foreach ($data as $entry) { ?>
                            <option value="<?php echo htmlspecialchars($entry['segment']); ?>"><?php echo htmlspecialchars($entry['segment']); ?></option>
                        <?php } ?>
                    </select>

                    <label for="region">Выберите область:</label>
                    <select id="region" name="region" required>
                        <?php 
                        $regions = [];
                        foreach ($data as $entry) {
                            foreach ($entry['regions'] as $region => $trends) {
                                $regions[$region] = $region;
                            }
                        }
                        foreach ($regions as $region) { ?>
                            <option value="<?php echo htmlspecialchars($region); ?>"><?php echo htmlspecialchars($region); ?></option>
                        <?php } ?>
                    </select>

                    <button type="submit">Показать тренды</button>
                </form>
            <?php } else { ?>
                <div class="trend-list">
                    <h4>Тренды для сегмента "<?php echo htmlspecialchars($user_choice['segment']); ?>" в области "<?php echo htmlspecialchars($user_choice['region']); ?>"</h4>
                    <ul>
                        <?php 
                        $trends = get_trends($user_choice['segment'], $user_choice['region'], $data);
                        foreach ($trends as $trend) {
                            if (is_array($trend)) {
                                echo "<li>";
                                echo htmlspecialchars($trend['trend'] ?? 'Без названия');
                                if (!empty($trend['sales'])) {
                                    echo "<ul>";
                                    foreach ($trend['sales'] as $sale) {
                                        echo "<li>" . htmlspecialchars($sale['month'] . ": " . $sale['amount'] . " ед.") . "</li>";
                                    }
                                    echo "</ul>";
                                }
                                echo "</li>";
                            } else {
                                echo "<li>" . htmlspecialchars($trend) . "</li>";
                            }
                        }
                        ?>
                    </ul>
                </div>

                <form class="form-container" action="bigdata.php" method="POST">
                    <label>Понравились ли вам эти тренды?</label>
                    <button type="submit" name="like_trends" value="yes">Да</button>
                    <button type="submit" name="like_trends" value="no">Нет</button>
                </form>
            <?php } ?>
        </div>
    </main>

    <!-- Notification Modal -->
    <?php if (isset($notification)) { ?>
        <div class="notification-modal" id="notificationModal">
            <div class="notification-content">
                <p><?php echo htmlspecialchars($notification); ?></p><br>
                <a href="cabinet.php"><button>Перейти в личный кабинет</button></a>
            </div>
        </div>
    <?php } ?>

    <footer>
        <div class="container">
            <p>© 2024 Все права защищены.</p>
        </div>
    </footer>

    <script>
        <?php if (isset($notification)) { ?>
            document.getElementById('notificationModal').style.display = 'flex';
        <?php } ?>
    </script>
</body>
</html>
