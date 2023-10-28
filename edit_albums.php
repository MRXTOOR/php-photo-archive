<?php
session_start();
include 'config.php';

// Проверяем, авторизован ли администратор
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Перенаправляем неавторизованных пользователей на страницу авторизации
    header("Location: admin_login.php");
    exit();
}

// SQL-запрос для извлечения альбомов из базы данных
$sql = "SELECT * FROM Album";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование альбомов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Редактирование альбомов</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Отображаем альбомы в виде таблицы
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['ID_Album'] . '</td>';
                    echo '<td>' . $row['Name'] . '</td>';
                    echo '<td>' . $row['Description'] . '</td>';
                    echo '<td>' . $row['Date'] . '</td>';
                    echo '<td>
                            <a href="edit_album.php?id=' . $row['ID_Album'] . '" class="btn btn-primary">Редактировать</a>
                            <a href="delete_album.php?id=' . $row['ID_Album'] . '" class="btn btn-danger">Удалить</a>
                            <a href="edit_photos.php?id=' . $row['ID_Album'] . '" class="btn btn-success">Редактировать фотографии</a>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
