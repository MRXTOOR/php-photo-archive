<?php
session_start();
include 'config.php';

// Проверяем, авторизован ли администратор
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Перенаправляем неавторизованных пользователей на страницу авторизации
    header("Location: admin_login.php");
    exit();
}

// Проверяем, получен ли идентификатор альбома
if (isset($_GET['id'])) {
    $albumId = $_GET['id'];

    // SQL-запрос для удаления фотографий в альбоме
    $deletePhotosSql = "DELETE FROM Photos WHERE ID_Album='$albumId'";

    if ($conn->query($deletePhotosSql) === TRUE) {
        // Удаление фотографий успешно, теперь можно удалить сам альбом
        $deleteAlbumSql = "DELETE FROM Album WHERE ID_Album='$albumId'";
        if ($conn->query($deleteAlbumSql) === TRUE) {
            // Если удаление успешно, перенаправляем обратно на страницу редактирования альбомов
            header("Location: edit_albums.php");
            exit();
        } else {
            // Если произошла ошибка при удалении альбома, можно обработать её соответственно
            echo "Ошибка при удалении альбома: " . $conn->error;
            exit();
        }
    } else {
        // Если произошла ошибка при удалении фотографий, можно обработать её соответственно
        echo "Ошибка при удалении фотографий в альбоме: " . $conn->error;
        exit();
    }
} else {
    // Если идентификатор альбома не был передан, можно обработать соответственно (например, перенаправить на страницу ошибки)
    echo "Идентификатор альбома не был передан.";
    exit();
}
?>
