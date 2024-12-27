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
        if (isset($entry['segment']) && $entry['segment'] === $segment) {
            return $entry['regions'][$region] ?? [];
        }
    }
    return [];
}

function get_user_data($username) {
    $filename = 'user_choices.txt';
    if (file_exists($filename)) {
        $json_data = file_get_contents($filename);
        $user_choices = json_decode($json_data, true);
        return $user_choices[$username] ?? null;
    }
    return null;
}

$user_data = get_user_data($user['username']);
$data = json_decode(file_get_contents('bigdata.txt'), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Интерактивный Дешборд - BizBuilder AI</title>
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
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .content {
            display: flex;
            flex: 1;
            gap: 20px;
        }

        .trend-summary {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .trend-summary p {
            margin: 0;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
        }

        .trend-summary ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .trend-summary li {
            padding: 10px;
            background-color: #f1f1f1;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .chart-container {
            flex: 1;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-container canvas {
            width: 600px;
            height: 500px;
        }

        footer {
            background-color: #079b0c;
            color: white;
            width: 100%;
            padding: 10px 0;
            text-align: center;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.2);
        }

        #salesChart{
            position: inline-block;
            top: 0px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <div class="trend-summary">
                <h3>Интерактивный Дешборд</h3>
                <?php if ($user_data) { ?>
                    <p><strong>Сегмент:</strong> <?php echo htmlspecialchars($user_data['segment']); ?></p>
                    <p><strong>Регион:</strong> <?php echo htmlspecialchars($user_data['region']); ?></p>
                    <h4>Тренды:</h4>
                    <ul>
                        <?php foreach (get_trends($user_data['segment'], $user_data['region'], $data) as $trend) {
                            echo "<li>{$trend['trend']}</li>";
                        } ?>
                    </ul>
                <?php } else { ?>
                    <p>Нет сохраненных данных.</p>
                <?php } ?>
            </div>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>© 2024 Все права защищены.</p>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const trends = <?php echo json_encode(get_trends($user_data['segment'], $user_data['region'], $data)); ?>;
            const labels = trends.length > 0 ? trends[0]['sales'].map(sale => sale['month']) : [];
            const datasets = trends.map(trend => ({
                label: trend['trend'],
                data: trend['sales'].map(sale => sale['amount']),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }));

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
