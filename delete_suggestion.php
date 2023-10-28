<?php
// Подключение к базе данных
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем идентификатор заявки из формы
    $suggestionId = $_POST['suggestion_id'];

    // SQL-запрос для удаления заявки из базы данных
    $sql = "DELETE FROM PhotoSuggestions WHERE ID_Suggestion = $suggestionId";

    if ($conn->query($sql) === TRUE) {
        // Если удаление успешно, перенаправляем обратно на страницу администратора
        header("Location: admin.php");
        exit();
    } else {
        // Если произошла ошибка при удалении, можно обработать её соответственно
        echo "Ошибка при удалении заявки: " . $conn->error;
    }
} else {
    // Если запрос не является POST-запросом, перенаправляем пользователя на главную страницу или страницу ошибки
    header("Location: index.php");
    exit();
}

// Закрытие соединения с базой данных
$conn->close();
?>