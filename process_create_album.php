<?php
session_start();
include 'config.php'; // Подключите файл с настройками для подключения к базе данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $albumName = $_POST['album-name'];
    $albumDescription = $_POST['album-description'];
    $albumDate = $_POST['album-date'];

    // Обработка загруженного файла
    $targetDirectory = "images/";
    $targetFile = $targetDirectory . basename($_FILES['album-image']['name']);
    move_uploaded_file($_FILES['album-image']['tmp_name'], $targetFile);

    // Подготавливаем SQL-запрос для вставки данных в базу данных
    $sql = $conn->prepare("INSERT INTO Album (Name, Description, AlbumImage, Date) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $albumName, $albumDescription, $targetFile, $albumDate);

    // Выполняем подготовленный запрос
    if ($sql->execute()) {
        // Если запрос выполнен успешно, перенаправляем пользователя обратно на страницу администратора
        header("Location: admin.php");
        exit();
    } else {
        // Если произошла ошибка при выполнении запроса, выведите сообщение об ошибке или перенаправьте на страницу ошибки
        echo "Ошибка при добавлении данных: " . $conn->error;
        exit();
    }

    // Закрываем подготовленный запрос и соединение с базой данных
    $sql->close();
    $conn->close();
} else {
    // Если запрос не является POST-запросом, перенаправляем пользователя на главную страницу или страницу ошибки
    header("Location: index.php");
    exit();
}
?>
