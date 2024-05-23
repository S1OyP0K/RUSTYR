<?php
// Проверяем существование сессии и пользователя
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("status" => "error", "message" => "Пользователь не авторизован"));
    exit();
}

// Получение идентификатора пользователя из сессии
$userId = $_SESSION['user_id'];

// Подключение к базе данных
$dbHost = 'MySQL-8.2';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'register-bg';

// Создание подключения
$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение описания пользователя из POST-запроса
$userDescription = $_POST['description'];

// Подготовленный запрос для обновления описания пользователя
$sql = "UPDATE users SET description = ? WHERE id = ?";

// Подготовка и выполнение запроса
if ($stmt = $conn->prepare($sql)) {
    // Привязываем параметры
    $stmt->bind_param("si", $userDescription, $userId);

    // Выполняем запрос
    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "Описание успешно обновлено", "description" => $userDescription));
    } else {
        echo json_encode(array("status" => "error", "message" => "Ошибка при обновлении описания"));
    }

    // Закрываем запрос
    $stmt->close();
} else {
    echo json_encode(array("status" => "error", "message" => "Ошибка при подготовке запроса"));
}

// Закрываем соединение с базой данных
$conn->close();
?>
