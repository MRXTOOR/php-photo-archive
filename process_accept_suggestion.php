<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем ID предложения из POST-запроса
    $suggestionId = $_POST['suggestion_id'];

    // Обработка принятого предложения (ваш SQL-запрос для добавления в альбом и т.д.)

    // Удаляем предложение из таблицы PhotoSuggestions
    $deleteSql = "DELETE FROM PhotoSuggestions WHERE ID_Suggestion = $suggestionId";
    if ($conn->query($deleteSql) === TRUE) {
        echo "Предложение успешно принято и удалено.";
    } else {
        echo "Ошибка: " . $deleteSql . "<br>" . $conn->error;
    }
}

$conn->close();
?>