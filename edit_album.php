<?php
session_start();
include 'config.php';

// Проверяем, авторизован ли администратор
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Перенаправляем неавторизованных пользователей на страницу авторизации
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Обработка данных, отправленных через форму редактирования альбома
    $albumId = $_POST['album_id'];
    $newName = $_POST['new_name'];
    $newDescription = $_POST['new_description'];
    
    // SQL-запрос для обновления данных альбома
    $updateSql = "UPDATE Album SET Name='$newName', Description='$newDescription' WHERE ID_Album='$albumId'";
    
    if ($conn->query($updateSql) === TRUE) {
        // Если обновление успешно, перенаправляем обратно на страницу редактирования альбомов
        header("Location: edit_albums.php");
        exit();
    } else {
        // Если произошла ошибка, можно обработать её соответственно
        echo "Ошибка при редактировании альбома: " . $conn->error;
    }
} else {
    // Если запрос не является POST-запросом, получаем идентификатор альбома из URL
    $albumId = $_GET['id'];
    
    // SQL-запрос для извлечения данных выбранного альбома
    $selectSql = "SELECT * FROM Album WHERE ID_Album='$albumId'";
    $result = $conn->query($selectSql);
    
    if ($result->num_rows > 0) {
        // Получаем данные альбома
        $row = $result->fetch_assoc();
        $albumName = $row['Name'];
        $albumDescription = $row['Description'];
    } else {
        // Если альбом не найден, можно обработать соответственно (например, перенаправить на страницу ошибки)
        echo "Альбом не найден.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование альбома</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Редактирование альбома</h2>
        <form method="post" action="">
            <input type="hidden" name="album_id" value="<?php echo $albumId; ?>">
            <div class="mb-3">
                <label for="new_name" class="form-label">Новое название альбома:</label>
                <input type="text" class="form-control" id="new_name" name="new_name" value="<?php echo $albumName; ?>" required>
            </div>
            <div class="mb-3">
                <label for="new_description" class="form-label">Новое описание альбома:</label>
                <textarea class="form-control" id="new_description" name="new_description" rows="4" required><?php echo $albumDescription; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
