<?php
include 'config.php';
session_start();

if (isset($_GET['photo_id'])) {
    $photoId = $_GET['photo_id'];

    // SQL-запрос для получения данных о фотографии по ID
    $photoSql = "SELECT * FROM Photos WHERE ID_Photos = $photoId";
    $photoResult = $conn->query($photoSql);

    if ($photoResult->num_rows > 0) {
        $photoRow = $photoResult->fetch_assoc();

        // SQL-запрос для получения имени пользователя (автора) по ID пользователя
        $userId = $photoRow['ID_User'];
        $userSql = "SELECT Name FROM Users WHERE ID_User = $userId";
        $userResult = $conn->query($userSql);
        $userRow = $userResult->fetch_assoc();
        $userName = $userRow['Name'];

        // Отображаем страницу с фотографией и комментариями
        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>Фотография</title>';
        echo '<link rel="stylesheet" href="styles.css">';
        echo '</head>';
        echo '<body>';
        echo '<p class="user-info">Пользователь: ' . $_SESSION['user_name'] . '</p>';
        echo '<div class="photo-container">';
        echo '<img src="' . $photoRow['Image_Path'] . '" alt="Фотография">';
        echo '<h2>Название альбома</h2>';
        echo '<p>Название фото: ' . $photoRow['Name'] . '</p>';
        echo '<p>Автор: ' . $userName . '</p>';
        echo '<p>Дата создания: ' . $photoRow['Date'] . '</p>';
        echo '<p>Описание фото: ' . $photoRow['Description'] . '</p>';

        // Отображаем комментарии
        $commentsSql = "SELECT c.*, u.Name AS UserName FROM Comments c 
        INNER JOIN Users u ON c.ID_User = u.ID_User
        WHERE c.ID_Photos = $photoId";
        $commentsResult = $conn->query($commentsSql);
        echo '<div class="comments">';
        echo '<h3>Комментарии</h3>';
        while ($commentRow = $commentsResult->fetch_assoc()) {
            $commentUser = $commentRow['UserName'];
            $commentText = $commentRow['Text'];
        
            echo '<div class="comment"><strong>' . $commentUser . ':</strong> ' . $commentText . '</div>';
        }
        echo '<div class="comment-input">';
        if (isset($_SESSION['user_name'])) {
            echo '<input type="text" id="comment-text" placeholder="Введите комментарий...">';
            echo '<button onclick="addComment(' . $photoId . ')">Отправить</button>';
        } else {
            echo '<div class="error-message">Авторизуйтесь, чтобы оставить комментарий.</div>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</body>';
        echo '<footer class="footer">';
        echo '<div class="footer-content">';
        echo '<p>VDOVIN STANISLAV</p>';
        echo '<p>ГБПОУ РО РКРИПТ</p>';
        echo '</div>';
        echo '</footer>';
        echo '<script>';
        echo 'function addComment(photoId) {
            var commentText = document.getElementById("comment-text").value;
            if (commentText.trim() !== "") {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "add_comment.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); // Перезагружаем страницу после добавления комментария
                    }
                };
                xhr.send("photo_id=" + photoId + "&comment=" + commentText);
            } else {
                alert("Введите комментарий.");
            }
        }';
        echo '</script>';
        echo '</html>';
    } else {
        echo 'Фотография не найдена.';
    }
} else {
    echo 'ID_Photos не передан в URL.';
}

$conn->close();
?>