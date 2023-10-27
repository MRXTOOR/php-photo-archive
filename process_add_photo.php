<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $photoName = $_POST['photo_name'];
    $photoDate = $_POST['photo_date'];
    $photoEvent = $_POST['photo_event'];
    $photoDescription = $_POST['photo_description'];
    $submittedBy = $_SESSION['user_name']; // Получаем имя пользователя, отправившего заявку

    // Обработка загруженного файла
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES['photo_file']['name']);
    move_uploaded_file($_FILES['photo_file']['tmp_name'], $targetFile);

    // Сохраняем данные в таблице PhotoSuggestions
    $sql = "INSERT INTO PhotoSuggestions (PhotoName, PhotoDate, PhotoEvent, PhotoDescription, FilePath, SubmittedBy) VALUES ('$photoName', '$photoDate', '$photoEvent', '$photoDescription', '$targetFile', '$submittedBy')";

    if ($conn->query($sql) === TRUE) {
        // Заявка успешно отправлена
        header("Location: index.php");
        exit();
    } else {
        // Ошибка при сохранении данных в базу
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    // Если запрос не является POST-запросом, перенаправляем пользователя на главную страницу или страницу ошибки
    header("Location: index.php");
    exit();
}
?>
