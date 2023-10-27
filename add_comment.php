<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $photoId = $_POST['photo_id'];
    $comment = $_POST['comment'];
    $userId = $_SESSION['user_id']; // Предположим, что ID пользователя хранится в сессии

    // SQL-запрос для добавления комментария в базу данных
    $sql = "INSERT INTO Comments (ID_Photos, ID_User, Text) VALUES ('$photoId', '$userId', '$comment')";
    if ($conn->query($sql) === TRUE) {
        echo "Комментарий успешно добавлен!";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>