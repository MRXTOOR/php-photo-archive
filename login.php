<?php
include 'config.php';


// После успешной авторизации, например, при совпадении логина и пароля
if ($login_is_successful) {
    // Запускаем сессию
    session_start();

    // Сохраняем имя пользователя в сессии
    $_SESSION['user_name'] = $username; // Предположим, что $username содержит имя пользователя

    // Перенаправляем на страницу index.php
    header("Location: index.php");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $login = $_POST['login'];
    $password = $_POST['password'];

    // SQL-запрос для выбора пользователя из базы данных по логину
    $sql = "SELECT * FROM Users WHERE Login='$login'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Пользователь найден, проверяем пароль
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Password'])) {
            // Пароль верный, создаем сессию и перенаправляем на index.php
            $_SESSION['user_id'] = $row['ID_User'];
            $_SESSION['user_name'] = $row['Name'];
            header("Location: index.php");
            exit();
        } else {
            echo "Неверный пароль";
        }
    } else {
        echo "Пользователь с таким логином не найден";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="styles-autar.css">
    </head>

<body>
    <div class="login-form">
        <h2>Авторизация</h2>
        <form method="post">
            <div class="form-group">
                <label for="login">Логин:</label>
                <input type="text" id="login" name="login" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Войти</button>
        </form>
    </div>
</body>

</html>


