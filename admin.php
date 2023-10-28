<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница администрирования</title>
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
    // $sql = "SELECT ID_Album, Name FROM Albums";
    // $result = $conn->query($sql);
    // Проверяем, авторизован ли администратор
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
        // Перенаправляем неавторизованных пользователей на страницу авторизации
        header("Location: admin_login.php");
        exit();
    }

    // Подключение к базе данных
    include 'config.php';

    // SQL-запрос для извлечения предложений от пользователей
    $sql = "SELECT * FROM PhotoSuggestions";
    $result = $conn->query($sql);
    ?>
    <div class="admin-container">
        <h2>Страница администрирования</h2>
        <button class="btn btn-primary mb-3" id="create-album-button" data-bs-toggle="modal" data-bs-target="#album-modal">Создать альбом</button>
    </div>

    <!-- Модальное окно для создания альбома -->
    <div class="modal fade" id="album-modal" tabindex="-1" aria-labelledby="album-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="album-modal-label">Создание альбома</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="album-form" enctype="multipart/form-data" action="process_create_album.php" method="post">
                        <label for="album-name">Название альбома:</label>
                        <input type="text" id="album-name" name="album-name" class="form-control" required>
                        <label for="album-description">Описание альбома:</label>
                        <textarea id="album-description" name="album-description" class="form-control" required></textarea>
                        <label for="album-date">Дата создания альбома:</label>
                        <input type="date" id="album-date" name="album-date" class="form-control" required>
                        <label for="album-image">Картинка для альбома (jpg, png):</label>
                        <input type="file" id="album-image" name="album-image" class="form-control" accept=".jpg, .png" required>
                        <button type="submit" class="btn btn-primary mt-3">Создать альбом</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-3">
    <ul>
        <?php
 // Получить все предложения в виде массива
 $suggestions = $result->fetch_all(MYSQLI_ASSOC);

 // Отображение предложений в виде списка
 foreach ($suggestions as $row) {
     echo '<li>';
     echo 'Название: ' . $row['PhotoName'] . '<br>';
     echo 'Дата: ' . $row['PhotoDate'] . '<br>';
     echo 'Мероприятие: ' . $row['PhotoEvent'] . '<br>';
     echo 'Описание: ' . $row['PhotoDescription'] . '<br>';
     echo 'Пользователь: ' . $row['SubmittedBy'] . '<br>';
     echo '<a href="' . $row['FilePath'] . '" target="_blank">Посмотреть изображение</a>';

     // Кнопка для удаления заявки
     echo '<form action="delete_suggestion.php" method="post" class="mt-3">';
     echo '<input type="hidden" name="suggestion_id" value="' . $row['ID_Suggestion'] . '">';
     echo '<button type="submit" class="btn btn-danger">Удалить заявку</button>';
     echo '</form>';

     // Выбор альбома для добавления фотографии
     $albumSql = "SELECT ID_Album, Name FROM Album";
     $albumResult = $conn->query($albumSql);
     
     // Проверьте, есть ли альбомы в базе данных
     if ($albumResult->num_rows > 0) {
         echo '<form action="add_to_album.php" method="post" class="mt-3">';
         echo '<input type="hidden" name="suggestion_id" value="' . $row['ID_Suggestion'] . '">';
         echo '<label for="album-select">Выберите альбом:</label>';
         echo '<select name="album_id" id="album-select" class="form-control">';
         
         // Перебирайте результаты запроса и создайте варианты выбора
         while ($albumRow = $albumResult->fetch_assoc()) {
             echo '<option value="' . $albumRow['ID_Album'] . '">' . $albumRow['Name'] . '</option>';
         }
         
         echo '</select>';
         echo '<button type="submit" class="btn btn-primary mt-3">Добавить в альбом</button>';
         echo '</form>';
     } else {
         echo 'Нет доступных альбомов';
     }

     echo '</li>';
 }
        ?>
    </ul>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
