<?php
session_start();
include 'config.php';

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php"); // Перенаправляем неавторизованных пользователей на страницу авторизации
    exit();
}

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $photoName = $_POST['photo_name'];
    $photoDate = $_POST['photo_date'];
    $photoEvent = $_POST['photo_event'];
    $photoDescription = $_POST['photo_description'];

    // Обработка загруженного файла
    $targetDirectory = "uploads/"; // Директория, куда будут сохраняться изображения
    $targetFile = $targetDirectory . basename($_FILES['photo_file']['name']);
    move_uploaded_file($_FILES['photo_file']['tmp_name'], $targetFile);

    // Теперь $targetFile содержит путь к загруженному файлу, который вы можете сохранить в базе данных
    // Здесь вы также можете выполнить SQL-запрос для сохранения данных в базе данных

    // Пример SQL-запроса
    $sql = "INSERT INTO Photos (Name, Date, Event, Description, FilePath) VALUES ('$photoName', '$photoDate', '$photoEvent', '$photoDescription', '$targetFile')";

    if ($conn->query($sql) === TRUE) {
        echo "Фотография успешно добавлена!";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="styles-profile.css">
    </head>

<body>
    <div class="user-profile">
        <div class="user-info">
            <h2><?php echo $_SESSION['user_name']; ?></h2>
            <p>Логин: <?php echo $_SESSION['user_name']; ?></p>
            <p>Пароль: *******</p> <!-- Не рекомендуется отображать пароль пользователя в открытом виде -->
        </div>
        <div class="add-photo">
    <form method="post" action="process_add_photo.php" enctype="multipart/form-data">
        <!-- Форма для отправки заявки на добавление фотографии -->
        <button>+</button>
        <input type="file" name="photo_file" accept="image/*" required> <!-- Поле для загрузки изображения -->
        <input type="text" name="photo_name" placeholder="Название фото" required>
        <input type="text" name="photo_date" placeholder="Дата создания фото" required>
        <input type="text" name="photo_event" placeholder="Мероприятие" required>
        <input type="text" name="photo_description" placeholder="Описание" required>
        <button type="submit">Отправить заявку</button>
    </form>
</div>
    </div>
</body>

</html>