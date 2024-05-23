<?php 
session_start();

$login = filter_var(trim($_POST["login"]), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST["pass"]), FILTER_SANITIZE_STRING);

// Подключение к базе данных
$mysql = new mysqli("MySQL-8.2", "root", "", "register-bg");

// Проверка на ошибки при подключении
if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}

$result = $mysql->query("SELECT * FROM `users` WHERE `login` = '$login'");
$user = $result->fetch_assoc();

if(!$user || !password_verify($pass, $user['pass'])) {
    echo "Неправильный логин или пароль";
    exit();
}

// Сохранение ID пользователя в сессии
$_SESSION['user_id'] = $user['id'];

// Сохранение имени пользователя в куки
setcookie('user', $user['name'], time() + 3600, "/");

// Перенаправление на страницу профиля после авторизации
header("Location: http://site.local/html/indexLK.html");
exit();
?>