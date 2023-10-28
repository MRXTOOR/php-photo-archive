<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $albumId = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_changes'])) {
        // Обработка формы, если была нажата кнопка "Сохранить"
        foreach ($_POST['photo_id'] as $index => $photoId) {
            $photoName = mysqli_real_escape_string($conn, $_POST['photo_name'][$index]);
            $photoDescription = mysqli_real_escape_string($conn, $_POST['photo_description'][$index]);

            // SQL-запрос для обновления данных в таблице Photos
            $updateSql = "UPDATE Photos SET Name='$photoName', Description='$photoDescription' WHERE ID_Photos='$photoId'";
            $conn->query($updateSql);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_photo'])) {
        // Обработка формы, если была нажата кнопка "Удалить"
        $photoIdToDelete = $_POST['photo_id'][0]; // Предполагаем, что у вас есть только одна фотография для удаления
    
        // Удаление связанных комментариев
        $deleteCommentsSql = "DELETE FROM comments WHERE ID_Photos='$photoIdToDelete'";
        if ($conn->query($deleteCommentsSql) === TRUE) {
            // После успешного удаления комментариев, удаляем фотографию из таблицы Photos
            $deletePhotoSql = "DELETE FROM Photos WHERE ID_Photos='$photoIdToDelete'";
            if ($conn->query($deletePhotoSql) === TRUE) {
                // После успешного удаления фотографии перенаправляем пользователя обратно на страницу редактирования фотографий
                header("Location: edit_photos.php?id=$albumId");
                exit();
            } else {
                echo "Ошибка при удалении фотографии: " . $conn->error;
            }
        } else {
            echo "Ошибка при удалении комментариев: " . $conn->error;
        }
    }

    // SQL-запрос для извлечения фотографий из определенного альбома
    $photosSql = "SELECT * FROM Photos WHERE ID_Album='$albumId'";
    $photosResult = $conn->query($photosSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование Фотографий</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Редактирование Фотографий</h2>
        <form method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Фото</th>
                        <th>Описание</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $photosResult->fetch_assoc()) {
                        echo '<tr>';
                        echo '<input type="hidden" name="photo_id[]" value="' . $row['ID_Photos'] . '">';
                        echo '<td><input type="text" name="photo_name[]" value="' . htmlspecialchars($row['Name']) . '"></td>';
                        echo '<td><img src="' . $row['Image_Path'] . '" alt="Фото" style="width: 100px;"></td>';
                        echo '<td><input type="text" name="photo_description[]" value="' . htmlspecialchars($row['Description']) . '"></td>';
                        echo '<td><button class="btn btn-primary" type="submit" name="save_changes">Сохранить</button>';
                        // Добавляем кнопку "Удалить"
                        echo ' <button class="btn btn-danger" type="submit" name="delete_photo">Удалить</button></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
<div class="text-center"><a href="edit_albums.php" class="btn btn-primary">Вернуться на страницу редактирования альбома </a></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
} else {
    echo "Идентификатор альбома не был передан.";
}
?>
