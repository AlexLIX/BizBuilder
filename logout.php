<?php
session_start();
session_destroy(); // Уничтожение всех данных сессии
header('Location: login.php'); // Перенаправление на страницу входа
exit();
?>
