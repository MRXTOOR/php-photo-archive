<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация администратора</title>
    <link rel="stylesheet" href="styles-admin-login.css">
</head>
<?php
session_start();
include 'config.php';
?>

<body>
    <div class="login-container">
        <h2>Вход для администратора</h2>
        <form action="admin_authenticate.php" method="post">
            <label for="username">Логин:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Войти</button>
        </form>
    </div>
</body>

</html>
