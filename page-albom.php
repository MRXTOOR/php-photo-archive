<?php
include 'config.php';
session_start();
if (isset($_GET['album_id'])) {
    $albumId = $_GET['album_id'];

    // SQL-запрос для получения данных об альбоме по ID
    $albumSql = "SELECT * FROM Album WHERE ID_Album = $albumId";
    $albumResult = $conn->query($albumSql);

    // Если альбом существует
    if ($albumResult->num_rows > 0) {
        $albumRow = $albumResult->fetch_assoc();

        // SQL-запрос для получения фотографий для данного альбома
        $photosSql = "SELECT * FROM Photos WHERE ID_Album = $albumId";
        $photosResult = $conn->query($photosSql);
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Фотоархив</title>
            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="styles.css">
        </head>

        <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <?php
        if (isset($_SESSION['user_name'])) {
            $user_name = $_SESSION['user_name'];
            $user_avatar = ''; // Получите путь к изображению профиля пользователя из базы данных и сохраните в эту переменную

            // Проверяем, есть ли путь к изображению профиля
            if (!empty($user_avatar)) {
                echo '<a class="navbar-brand" href="#"><img src="' . $user_avatar . '" alt="Аватар" class="rounded-circle" style="width: 30px; height: 30px;"></a>';
            } else {
                // Если изображение отсутствует, вы можете отобразить дефолтный аватар
                echo '<a class="navbar-brand" href="#"><img src="path_to_default_avatar.jpg" alt="Аватар" class="rounded-circle" style="width: 30px; height: 30px;"></a>';
            }

            echo '<div class="text-center collapse navbar-collapse" id="navbarNav">';
            echo '<ul class="navbar-nav ml-auto">';
            echo '<li class="nav-item">';
            echo '<a class=" nav-link" href="personal_cabinet.php">Личный кабинет</a>';
            echo '</li>';
            echo '<li class="nav-item">';
            echo '<p class="nav-link mb-0">Пользователь: ' . $user_name . '</p>';
            echo '</li>';
            echo '</ul>';
            echo '</div>';
        }
        ?>
    </div>
</nav>
   


    <div class="mt-2 ml-2"><a href="Index.php" class="btn btn-primary">Вернуться на главную страницу </a></div>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title"><?php echo $albumRow['Name']; ?></h2>
                
                                <p class="card-text">Описание альбома: <?php echo $albumRow['Description']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
    <?php
    // Отображаем фотографии
    while ($photoRow = $photosResult->fetch_assoc()) {
        echo '<div class="col-md-3 mb-3">';
        echo '<a href="./page-photo.php?photo_id=' . $photoRow['ID_Photos'] . '">';
        echo '<img src="' . $photoRow['Image_Path'] . '" alt="Фотография" class="img-fluid" style="max-width: 200px; max-height: 150px;">';
        echo '</a>';
        echo '</div>';
    }
    ?>
</div>



            </div>
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

<?php
} else {
// Если альбом не найден, можно вывести сообщение об ошибке или перенаправить на другую страницу
echo 'Альбом не найден.';
}
} else {
// Если ID_Album не передан в URL, можно вывести сообщение об ошибке или перенаправить на другую страницу
echo 'ID_Album не передан в URL.';
}

$conn->close();
?>