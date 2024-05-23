<?php
session_start();

// Используем FILTER_SANITIZE_SPECIAL_CHARS вместо устаревшего FILTER_SANITIZE_STRING
$login = filter_var(trim($_POST["login"]), FILTER_SANITIZE_SPECIAL_CHARS);
$name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_SPECIAL_CHARS);
$pass = filter_var(trim($_POST["pass"]), FILTER_SANITIZE_SPECIAL_CHARS);

if (mb_strlen($login) < 5 || mb_strlen($login) > 90) {
    header("Location: register.html?error=Недопустимая длина логина");
    exit();
} else if (mb_strlen($name) < 3 || mb_strlen($name) > 50) {
    header("Location: register.html?error=Недопустимая длина имени");
    exit();
} else if (mb_strlen($pass) < 8 || mb_strlen($pass) > 16) {
    header("Location: register.html?error=Недопустимая длина пароля");
    exit();
}

// Хеширование пароля с использованием bcrypt
$hashedPass = password_hash($pass, PASSWORD_DEFAULT);

$mysql = new mysqli("MySQL-8.2", "root", "", "register-bg");

// Проверка на ошибки при подключении
if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}

// Подготовленный запрос для вставки данных в таблицу
$stmt = $mysql->prepare("INSERT INTO users (login, pass, name) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $login, $hashedPass, $name);

if ($stmt->execute()) {
    // Получение ID последнего вставленного пользователя
    $userId = $stmt->insert_id;
    
    // Сохранение ID пользователя в сессию
    $_SESSION['user_id'] = $userId;

    // Установка куки для имени пользователя
    setcookie('user', $name, time() + 3600, "/");
    
    header("Location: http://site.local/html/indexLK.html");
    exit();
} else {
    echo "Ошибка: " . $stmt->error;
}

$stmt->close();
$mysql->close();
?>
