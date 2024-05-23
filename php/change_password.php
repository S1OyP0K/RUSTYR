<?php
session_start();

$response = array('status' => 'error', 'message' => 'Неизвестная ошибка');

if (!isset($_SESSION['user_id'])) {
    $response['message'] = "Пользователь не авторизован";
    echo json_encode($response);
    exit();
}

// Подключение к базе данных
$servername = "MySQL-8.2";  // Убедитесь, что это правильное имя хоста
$username = "root";
$password = "";
$dbname = "register-bg";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    $response['message'] = "Ошибка подключения: " . $conn->connect_error;
    echo json_encode($response);
    exit();
}

// Получение ID пользователя из сессии
$userId = $_SESSION['user_id'];

// Получение старого и нового паролей
$oldPassword = filter_var(trim($_POST['old-password']), FILTER_SANITIZE_SPECIAL_CHARS);
$newPassword = filter_var(trim($_POST['new-password']), FILTER_SANITIZE_SPECIAL_CHARS);

// Получение текущего хешированного пароля пользователя
$sql = "SELECT pass FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !password_verify($oldPassword, $user['pass'])) {
    $response['message'] = "Неправильный старый пароль";
    echo json_encode($response);
    exit();
}

// Хеширование нового пароля
$newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

// Обновление пароля в базе данных
$sql = "UPDATE users SET pass = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $newPasswordHash, $userId);

if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = "Пароль успешно изменен";
} else {
    $response['message'] = "Ошибка при изменении пароля: " . $stmt->error;
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
