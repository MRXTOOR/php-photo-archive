<?php
include 'config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $name = $_POST['name'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    // Получаем имя файла и путь к временному файлу
    $avatarName = $_FILES['avatar']['name'];
    $avatarTmpName = $_FILES['avatar']['tmp_name'];
    
    // Папка, куда будет загружен аватар
    $avatarPath = 'avatars/' . $avatarName; // Создайте папку "avatars" в корне проекта

    // Хэшируем пароль (рекомендуется использовать более безопасные методы хеширования)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL-запрос для добавления пользователя в базу данных
    $sql = "INSERT INTO Users (Login, Name, Password, Avatar) VALUES ('$login', '$name', '$hashedPassword', '$avatarPath')";

    if ($conn->query($sql) === TRUE) {
        // Перемещаем загруженный аватар в папку "avatars"
        move_uploaded_file($avatarTmpName, $avatarPath);
        // Перенаправляем пользователя на страницу авторизации после успешной регистрации
        header("Location: login.php");
        exit(); // Важно завершить выполнение скрипта после отправки заголовка
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
    <title>Регистрация</title>
    <link rel="stylesheet" href="styles-registr.css">
    </head>

    <body>
        <div class="registration-form">
            <h2>Регистрация</h2>
            <form method="post">
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="login">Логин:</label>
                    <input type="text" id="login" name="login" required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="avatar">Аватар:</label>
                    <input type="file" id="avatar" name="avatar" accept="avatars/*">
                </div>
                <button type="submit">Регистрация</button>
            </form>
        </div>

        <script>
            // JavaScript код
        </script>

<footer class="footer">
    <div class="footer-content">
        <p>VDOVIN STANISLAV</p>
        <p>ГБПОУ РО РКРИПТ</p>
    </div>
</footer>
    </body>

    </html>
    