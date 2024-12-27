<?php

// Функция для хэширования пароля
function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Функция для записи данных пользователя в файл
function save_user($username, $email, $password_hash) {
    // Создаем массив с данными пользователя
    $user_data = [
        'username' => $username,
        'email' => $email,
        'password_hash' => $password_hash,
        'created_at' => date('Y-m-d H:i:s')
    ];

    // Преобразуем массив в строку JSON
    $user_json = json_encode($user_data) . PHP_EOL;

    // Записываем данные в файл users.txt
    file_put_contents('users.txt', $user_json, FILE_APPEND);
}

// Функция для проверки существования email
function email_exists($email) {
    // Откроем файл users.txt для чтения
    $file = fopen('users.txt', 'r');
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $user_data = json_decode($line, true);
            if ($user_data['email'] === $email) {
                fclose($file);
                return true;
            }
        }
        fclose($file);
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Проверяем, существует ли уже email
    if (email_exists($email)) {
        echo "Этот email уже зарегистрирован.";
    } else {
        // Хэшируем пароль
        $password_hash = hash_password($password);

        // Сохраняем данные пользователя в файл
        save_user($username, $email, $password_hash);

        echo "Регистрация прошла успешно.";
    }
}
?>