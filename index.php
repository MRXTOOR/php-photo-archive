<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="заглушка для css нормализера">
    <link rel="stylesheet" href="styles.css">
    <title>Фотоархив</title>
    <script src="https://www.youtube.com/iframe_api"></script>
</head>

<body>

    <div class="video-container">
        <iframe id="youtube-video" width="560" height="315" src="https://www.youtube.com/embed/XJUACTxwIdE?si=iV8A9BYp23adwSdb&mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen autoplay></iframe>
        <div class="overlay-text">Здесь хранится история колледжа</div>
    </div>

    <?php
    if (isset($_SESSION['user_name'])) {
        // Пользователь авторизован, выводим его имя и ссылку на личный кабинет
        echo '<div>Привет, ' . $_SESSION['user_name'] . '!</div>';
        echo '<a href="personal_cabinet.php">Личный кабинет</a>';
    } else {
        // Пользователь не авторизован, выводим кнопку для регистрации
        echo '<button class="registration-button" onclick="redirectToRegistrationPage()">Регистрация</button>';
    }
    ?>

<div class="albums">
    <?php
    // Проверка, авторизован ли пользователь
    if (isset($_SESSION['user_name'])) {
        // SQL-запрос для получения данных об альбомах
        $sql = "SELECT * FROM Album";
        $result = $conn->query($sql);

        // Выводим названия альбомов и их картинки
        while ($row = $result->fetch_assoc()) {
            echo '<div class="album">';
            echo '<a href="./page-albom.php?album_id=' . $row['ID_Album'] . '">';
            echo '<img class="album-avatar" src="' . $row['AlbumImage'] . '" alt="Аватар альбома">';
            echo '<div class="album-info">';
            echo '<div class="album-name">' . $row['Name'] . '</div>';
            echo '<div class="album-date">' . $row['Date'] . '</div>';
            echo '</a>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        // Если пользователь не авторизован, выводите сообщение или перенаправьте на страницу авторизации
        echo 'Вы не авторизованы. <a href="login.php">Авторизуйтесь</a> для доступа к альбомам.';
    }

    $conn->close();
    ?>
</div>

    <footer class="footer">
        <div class="footer-content">
            <p>VDOVIN STANISLAV</p>
            <p>ГБПОУ РО РКРИПТ</p>
        </div>
    </footer>

    <script>
        function redirectToRegistrationPage() {
            window.location.href = "registration.php";
        }
    </script>

</body>

</html>