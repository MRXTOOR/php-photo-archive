<?php
session_start();
include 'config.php';

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php"); // Перенаправляем неавторизованных пользователей на страницу авторизации
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $photo_name = $_POST['photo_name'];
    $photo_date = $_POST['photo_date'];
    $photo_event = $_POST['photo_event'];
    $photo_description = $_POST['photo_description'];
    
    // Добавьте код для обработки и вставки данных в базу данных, используя SQL-запрос
    $user_id = $_SESSION['user_id']; // Получите ID пользователя из сессии

    // SQL-запрос для добавления заявки на фотографию
    $sql = "INSERT INTO PhotoSuggestions (UserID, PhotoName, PhotoDate, PhotoEvent, PhotoDescription) VALUES ('$user_id', '$photo_name', '$photo_date', '$photo_event', '$photo_description')";

    if ($conn->query($sql) === TRUE) {
        echo "Заявка успешно отправлена!";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма предложения фотографий</title>
    <link rel="stylesheet" href="styles-predlog.css">
</head>

<body>
    <div class="suggestions-form">
        <h2>Фотографии для предложения</h2>
        <ul class="suggestions-list">
            <li>
                <div class="suggestion-info">
                    <p>Имя пользователя: John Doe</p>
                    <p>Название фотографии: Фото 1</p>
                    <p>Дата фотографии: 01.01.2023</p>
                    <p>Автор фотографии: John Doe</p>
                    <p>Мероприятие: Событие 1</p>
                    <p>Описание фотографии: Описание фото 1</p>
                </div>
                <div class="suggestion-actions">
                    <button class="approve-button">✓</button>
                    <button class="reject-button">✗</button>
                </div>
            </li>

        </ul>
    </div>
    <div class="move-to-album-form">
        <h2>Выберите альбом для перемещения фотографии</h2>
        <select id="album-select">
            <option value="album1">Альбом 1</option>
            <option value="album2">Альбом 2</option>
            <option value="album3">Альбом 3</option>

        </select>
        <button id="move-button">Переместить</button>
        <button id="cancel-move-button">Отмена</button>
    </div>
    <script src="script-modal-predlog.js"></script>
</body>

</html>