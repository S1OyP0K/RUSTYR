<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Пользователь не авторизован");
}

// Подключение к базе данных
$servername = "MySQL-8.2";
$username = "root";
$password = "";
$dbname = "register-bg";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получение ID пользователя из сессии
$userId = $_SESSION['user_id'];

$sql = "SELECT login, name, pass AS password, photo, description FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>