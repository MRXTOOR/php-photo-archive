<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница администрирования</title>
    <!-- <link rel="stylesheet" href="styles-admin-page.css"> -->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
 <style>
        /* Добавленные стили для закрытия модального окна */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php
    session_start();

    // Проверяем, авторизован ли администратор
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
        // Перенаправляем неавторизованных пользователей на страницу авторизации
        header("Location: admin_login.php");
        exit();
    }
    ?>

    <div class="admin-container">
        <h2>Страница администрирования</h2>
        <button id="suggestions-button">Предложения</button>
        <button id="create-album-button">Создать альбом</button>
    </div>

    <div class="modal" id="suggestions-modal">
    <div class="modal-content">
        <span class="close" id="close-modal">&times;</span>
        <h2>Предложения по добавлению фотографий в альбомы</h2>
        <ul>
            <?php
            // Подключение к базе данных
            include 'config.php';

            // SQL-запрос для извлечения предложений от пользователей
            $sql = "SELECT * FROM PhotoSuggestions";
            $result = $conn->query($sql);

            // Отображение предложений в виде списка
            while ($row = $result->fetch_assoc()) {
                echo '<li>';
                echo 'Название: ' . $row['PhotoName'] . '<br>';
                echo 'Дата: ' . $row['PhotoDate'] . '<br>';
                echo 'Мероприятие: ' . $row['PhotoEvent'] . '<br>';
                echo 'Описание: ' . $row['PhotoDescription'] . '<br>';
                echo 'Пользователь: ' . $row['SubmittedBy'] . '<br>';
                echo '<a href="' . $row['FilePath'] . '" target="_blank">Посмотреть изображение</a>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>
</div>


    <div class="modal" id="album-modal">
        <div class="modal-content">
            <span class="close" id="close-album-modal">&times;</span>
            <h2>Создание альбома</h2>
            <form id="album-form" enctype="multipart/form-data" action="process_create_album.php" method="post">
                <label for="album-name">Название альбома:</label>
                <input type="text" id="album-name" name="album-name" required>
                <label for="album-description">Описание альбома:</label>
                <textarea id="album-description" name="album-description" required></textarea>
                <label for="album-date">Дата создания альбома:</label>
                <input type="date" id="album-date" name="album-date" required>
                <label for="album-image">Картинка для альбома (jpg, png):</label>
                <input type="file" id="album-image" name="album-image" accept=".jpg, .png" required>
                <button type="submit">Создать альбом</button>
            </form>
        </div>
    </div>

    <script>
        var suggestionsModal = document.getElementById('suggestions-modal');
        var createAlbumModal = document.getElementById('album-modal');
        var suggestionsButton = document.getElementById('suggestions-button');
        var createAlbumButton = document.getElementById('create-album-button');
        var closeModalButton = document.getElementById('close-modal');
        var closeAlbumModalButton = document.getElementById('close-album-modal');

        suggestionsButton.onclick = function() {
            suggestionsModal.style.display = 'block';
        }

        createAlbumButton.onclick = function() {
            createAlbumModal.style.display = 'block';
        }

        closeModalButton.onclick = function() {
            suggestionsModal.style.display = 'none';
        }

        closeAlbumModalButton.onclick = function() {
            createAlbumModal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == suggestionsModal) {
                suggestionsModal.style.display = 'none';
            }

            if (event.target == createAlbumModal) {
                createAlbumModal.style.display = 'none';
            }
        }
    </script>
</body>

</html>
