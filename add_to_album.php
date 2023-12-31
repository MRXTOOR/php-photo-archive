<?php
// Подключение к базе данных
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем идентификаторы заявки и выбранного альбома из формы
    $suggestionId = $_POST['suggestion_id'];
    $albumId = $_POST['album_id'];

    // Получаем информацию о фотографии из заявки
    $getPhotoSql = "SELECT PhotoName, PhotoDescription, PhotoDate, FilePath, SubmittedBy FROM PhotoSuggestions WHERE ID_Suggestion = $suggestionId";
    $photoResult = $conn->query($getPhotoSql);

    if ($photoResult->num_rows > 0) {
        // Получаем данные фотографии
        $photoData = $photoResult->fetch_assoc();

        // Получаем ID пользователя на основе имени пользователя из таблицы Users
        $userName = $conn->real_escape_string($photoData['SubmittedBy']);
        $getUserSql = "SELECT ID_User FROM Users WHERE Login = '$userName'";
        $userResult = $conn->query($getUserSql);

        if ($userResult->num_rows > 0) {
            $userRow = $userResult->fetch_assoc();
            $userId = $userRow['ID_User'];

            // SQL-запрос для добавления фотографии в выбранный альбом
            $addPhotoSql = "INSERT INTO Photos (ID_Album, Name, Description, Date, ID_User, Image_Path)
                            VALUES ($albumId, '" . $photoData['PhotoName'] . "', '" . $photoData['PhotoDescription'] . "', '" . $photoData['PhotoDate'] . "', $userId, '" . $photoData['FilePath'] . "')";

            // Выполняем SQL-запрос для добавления фотографии
            if ($conn->query($addPhotoSql) === TRUE) {
                // Если добавление успешно, удаляем заявку
                $deleteSuggestionSql = "DELETE FROM PhotoSuggestions WHERE ID_Suggestion = $suggestionId";
                if ($conn->query($deleteSuggestionSql) === TRUE) {
                    // Если удаление заявки успешно, перенаправляем обратно на страницу администратора
                    header("Location: admin.php");
                    exit();
                } else {
                    // Если произошла ошибка при удалении заявки
                    echo "Ошибка при удалении заявки: " . $conn->error;
                }
            } else {
                // Если произошла ошибка при добавлении фотографии
                echo "Ошибка при добавлении фотографии в альбом: " . $conn->error;
            }
        } else {
            // Если пользователь не найден
            echo "Пользователь не найден.";
        }
    } else {
        // Если фотография не найдена
        echo "Фотография не найдена.";
    }
} else {
    // Если запрос не является POST-запросом
    header("Location: index.php");
    exit();
}

// Закрытие соединения с базой данных
$conn->close();
?>
