<?php
include 'config.php';

session_start();
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Авторизация</h2>
                        <form method="post">
                            <div class="form-group">
                                <label for="login">Логин:</label>
                                <input type="text" id="login" name="login" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Пароль:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Войти</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <p>VDOVIN STANISLAV</p>
            <p>ГБПОУ РО РКРИПТ</p>
        </div>
    </div>
</footer>
</html>


