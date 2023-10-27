<?php
include 'config.php';

// SQL-запрос для получения предложений от пользователей
$sql = "SELECT * FROM PhotoSuggestions";
$result = $conn->query($sql);

// Отображаем предложения
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="suggestion-item">';
        echo '<strong>Пользователь:</strong> ' . $row['SubmittedBy'] . '<br>';
        echo '<strong>Название:</strong> ' . $row['PhotoName'] . '<br>';
        echo '<strong>Дата:</strong> ' . $row['PhotoDate'] . '<br>';
        echo '<strong>Мероприятие:</strong> ' . $row['PhotoEvent'] . '<br>';
        echo '<strong>Описание:</strong> ' . $row['PhotoDescription'] . '<br>';
        echo '<button onclick="acceptSuggestion(' . $row['ID_Suggestion'] . ')">Принять</button>';
        echo '</div>';
    }
} else {
    echo 'Нет предложений от пользователей.';
}

$conn->close();
?>