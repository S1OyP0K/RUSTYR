<?php
// submit_review.php

// Подключение к базе данных
$servername = "MySQL-8.2";
$username = "root"; // Замените на ваше имя пользователя MySQL
$password = ""; // Замените на ваш пароль MySQL
$dbname = "tour_database"; // Замените на имя вашей базы данных

// Включение сообщений об ошибках
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8mb4"); // Установка кодировки соединения
} catch (mysqli_sql_exception $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tour_id = $_POST['tour_id'];
    $user_name = $_POST['user_name'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $sql = "INSERT INTO reviews (tour_id, user_name, rating, comment) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isis", $tour_id, $user_name, $rating, $comment);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Ваш отзыв успешно добавлен!";
    } else {
        echo "Ошибка при добавлении отзыва.";
    }

    $stmt->close();
}

$conn->close();
?>
