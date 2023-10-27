<?php
include 'config.php';
session_start(); // Запускаем сессию

if (isset($_SESSION['user_name'])) {
if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];

  
    echo '<p class="user-info">Пользователь: ' . $user_name . '</p>';

} else {
   
    header("Location: login.php");
}

if(isset($_GET['album_id'])) {

    $albumId = $_GET['album_id'];

    // SQL-запрос для получения данных об альбоме по ID
    $albumSql = "SELECT * FROM Album WHERE ID_Album = $albumId";
    $albumResult = $conn->query($albumSql);

    // Если альбом существует
    if ($albumResult->num_rows > 0) {
        $albumRow = $albumResult->fetch_assoc();

        // SQL-запрос для получения фотографий для данного альбома
        $photosSql = "SELECT * FROM Photos WHERE ID_Album = $albumId";
        $photosResult = $conn->query($photosSql);

        // HTML-разметка для отображения информации об альбоме и его фотографиях
        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>Фотоархив</title>';
        echo '<link rel="stylesheet" href="styles.css">';
        echo '</head>';
        echo '<body>';
      
        echo '<div class="album-container">';
        echo '<div class="album-header">';
        echo '<h2>' . $albumRow['Name'] . '</h2>';
        echo '<p>Мероприятие: ' . $albumRow['Event'] . '</p>';
        echo '<p>Описание альбома: ' . $albumRow['Description'] . '</p>';
        echo '</div>';
        echo '<div class="photos">';

// Отображаем фотографии
while ($photoRow = $photosResult->fetch_assoc()) {
    echo '<a href="./page-photo.php?photo_id=' . $photoRow['ID_Photos'] . '">';
    echo '<img src="' . $photoRow['Image_Path'] . '" alt="Фотография">';
    echo '</a>';
}

echo '</div>';
        echo '</div>';
        echo '</body>';
        echo '<footer class="footer">';
        echo '<div class="footer-content">';
        echo '<p>VDOVIN STANISLAV</p>';
        echo '<p>ГБПОУ РО РКРИПТ</p>';
        echo '</div>';
        echo '</footer>';
        echo '</html>';
    } else {
        // Если альбом не найден, можно вывести сообщение об ошибке или перенаправить на другую страницу
        echo 'Альбом не найден.';
    }
} else {
    // Если ID_Album не передан в URL, можно вывести сообщение об ошибке или перенаправить на другую страницу
    echo 'ID_Album не передан в URL.';
}

$conn->close();
} else {
    // Если пользователь не авторизован, выведите сообщение или перенаправьте на страницу авторизации
    echo 'Вы не авторизованы. <a href="login.php">Авторизуйтесь</a> для просмотра фотографий.';
}
?>