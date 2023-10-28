<?php
include 'config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $name = $_POST['name'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    
   
    $avatarName = $_FILES['avatar']['name'];
    $avatarTmpName = $_FILES['avatar']['tmp_name'];
    
  
    $avatarPath = 'avatars/' . $avatarName; 

    // Хэшируем пароль (рекомендуется использовать более безопасные методы хеширования)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

   
    $sql = "INSERT INTO Users (Login, Name, Password, Avatar) VALUES ('$login', '$name', '$hashedPassword', '$avatarPath')";

    if ($conn->query($sql) === TRUE) {
        // Перемещаем загруженный аватар в папку "avatars"
        move_uploaded_file($avatarTmpName, $avatarPath);
        // Перенаправляем пользователя на страницу авторизации после успешной регистрации
        header("Location: login.php");
        exit(); 
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Регистрация</h2>
                        <form method="post">
                            <div class="form-group">
                                <label for="name">Имя:</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="login">Логин:</label>
                                <input type="text" id="login" name="login" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Пароль:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="avatar">Аватар:</label>
                                <input type="file" id="avatar" name="avatar" class="form-control" accept="avatars/*">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Регистрация</button>
                        </form>
                        <p class="mt-3 text-center">У вас уже есть аккаунт? <a href="login.php">Войдите</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
    <div class="container">
        <div class="footer-content">
            <p>VDOVIN STANISLAV</p>
            <p>ГБПОУ РО РКРИПТ</p>
        </div>
    </div>
</footer>

    <!-- Bootstrap JS и скрипты JavaScript могут быть добавлены здесь, если необходимо -->

</body>

</html>