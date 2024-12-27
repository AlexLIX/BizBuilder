<?php
session_start();

// Функция для проверки пароля
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

// Функция для проверки пользователя
function check_user($email, $password) {
    $file = fopen('users.txt', 'r');
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $user_data = json_decode($line, true);
            if ($user_data['email'] === $email) {
                if (verify_password($password, $user_data['password_hash'])) {
                    fclose($file);
                    return $user_data; // Возвращаем данные пользователя
                } else {
                    fclose($file);
                    return false;
                }
            }
        }
        fclose($file);
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user_data = check_user($email, $password);
    if ($user_data) {
        // Сохраняем данные пользователя в сессии
        $_SESSION['user'] = $user_data;
        // Перенаправляем пользователя в личный кабинет
        header('Location: cabinet.php');
        exit();
    } else {
        echo "Неправильный email или пароль.";
    }
}
?>