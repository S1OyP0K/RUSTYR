<!DOCTYPE html>
<html>
<head>
    <title>Поиск туров</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #4CAF50;
        }

        h3 {
            color: #2E8B57;
        }

        form {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .review {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .review p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
<div id="notification" style="display: none; background-color: #4CAF50; color: white; padding: 10px; border-radius: 5px; margin-bottom: 10px;">Отзыв успешно отправлен!</div>
<?php
// search_tours.php

// Подключение к базе данных
$servername = "MySQL-8.2";
$username = "root";
$password = "";
$dbname = "tour_database";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

if (isset($_GET['cities']) && isset($_GET['datepicker']) && isset($_GET['members1'])) {
    $location = $_GET['cities'];
    $date_range = $_GET['datepicker'];
    $dates = explode('-', $date_range);
    $date_from = date('Y-m-d', strtotime(trim($dates[0])));
    $date_to = date('Y-m-d', strtotime(trim($dates[1])));
    $participants = $_GET['members1'];

    $sql = "SELECT * FROM tours WHERE location = ? AND date BETWEEN ? AND ? AND participants >= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $location, $date_from, $date_to, $participants);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Найденные туры:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='tour'>";
            echo "<p>Название тура: <strong>" . $row["name"] . "</strong></p>";
            echo "<p>Описание: " . $row["description"] . "</p>";
            echo "<p>Дата: " . $row["date"] . "</p>";
            echo "<p>Цена: " . $row["price"] . " рублей</p>";

            // Получение отзывов и средней оценки для данного тура
            $tour_id = $row["id"];
            $review_sql = "SELECT AVG(rating) as average_rating FROM reviews WHERE tour_id = ?";
            $review_stmt = $conn->prepare($review_sql);
            $review_stmt->bind_param("i", $tour_id);
            $review_stmt->execute();
            $review_result = $review_stmt->get_result();
            $review_row = $review_result->fetch_assoc();
            $average_rating = $review_row['average_rating'] !== null ? round($review_row['average_rating'], 2) : null;

            if ($average_rating !== null) {
                echo "<p>Средняя оценка: " . $average_rating . "</p>";
            } else {
                echo "<p>Средняя оценка: Нет отзывов.</p>";
            }

            // Отображение отзывов
            $reviews_sql = "SELECT * FROM reviews WHERE tour_id = ?";
            $reviews_stmt = $conn->prepare($reviews_sql);
            $reviews_stmt->bind_param("i", $tour_id);
            $reviews_stmt->execute();
            $reviews_result = $reviews_stmt->get_result();

            if ($reviews_result->num_rows > 0) {
                echo "<h3>Отзывы:</h3>";
                while ($review = $reviews_result->fetch_assoc()) {
                    echo "<div class='review'>";
                    echo "<p>Имя: " . $review["user_name"] . "</p>";
                    echo "<p>Оценка: " . $review["rating"] . "</p>";
                    echo "<p>Комментарий: " . $review["comment"] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Отзывов пока нет.</p>";
            }

            // Форма для оставления отзыва и оценки
            echo "<h3>Оставьте ваш отзыв:</h3>";
            echo '<form action="../validation-form/submit_review.php" method="post">';
            echo '<input type="hidden" name="tour_id" value="' . $row["id"] . '">';
            echo 'Имя: <input type="text" name="user_name" required><br>';
            echo 'Оценка: <select name="rating" required>';
            for ($i = 1; $i <= 5; $i++) {
                echo "<option value=\"$i\">$i</option>";
            }
            echo '</select><br>';
            echo 'Комментарий: <textarea name="comment" required></textarea><br>';
            echo '<input type="submit" value="Отправить">';
            echo '</form>';
            echo "</div>";
        }
    } else {
        echo "<p>Туры не найдены.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Пожалуйста, заполните все поля формы.</p>";
}

$conn->close();
?>
<script>
    // JavaScript для обработки отправки формы и обновления страницы
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Предотвращаем стандартное поведение формы
            
            // Отправка данных формы на сервер
            var formData = new FormData(form);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'submit_review.php');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('notification').style.display = 'block'; // Показываем уведомление
                    setTimeout(function() {
                        location.reload(); // Обновляем страницу через 2 секунды
                    }, 2000);
                }
            };
            xhr.send(formData);
        });
    });
</script>
</body>
</html>
