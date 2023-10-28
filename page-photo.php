<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фотография</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="footer.css">
</head>

<body>
    <div class="container">
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
                echo '<div class="row mt-5">';
                echo '<div class="col-md-6 offset-md-3">';
                echo '<div class="card">';
                echo '<img src="' . $photoRow['Image_Path'] . '" class="card-img-top" alt="Фотография">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">Название фото: ' . $photoRow['Name'] . '</h5>';
                echo '<p class="card-text">Автор: ' . $userName . '</p>';
                echo '<p class="card-text">Дата создания: ' . $photoRow['Date'] . '</p>';
                echo '<p class="card-text">Описание фото: ' . $photoRow['Description'] . '</p>';

                // Отображаем комментарии
                $commentsSql = "SELECT c.*, u.Name AS UserName FROM Comments c 
                                INNER JOIN Users u ON c.ID_User = u.ID_User
                                WHERE c.ID_Photos = $photoId";
                $commentsResult = $conn->query($commentsSql);
                echo '<div class="comments">';
                echo '<h3 class="mt-4">Комментарии</h3>';
                while ($commentRow = $commentsResult->fetch_assoc()) {
                    $commentUser = $commentRow['UserName'];
                    $commentText = $commentRow['Text'];
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h6 class="card-subtitle mb-2 text-muted">' . $commentUser . '</h6>';
                    echo '<p class="card-text">' . $commentText . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';

                // Форма для добавления комментария
                echo '<div class="mt-4">';
                if (isset($_SESSION['user_name'])) {
                    echo '<div class="form-group">';
                    echo '<label for="comment-text">Ваш комментарий</label>';
                    echo '<input type="text" class="form-control" id="comment-text" placeholder="Введите комментарий...">';
                    echo '</div>';
                    echo '<button class="btn btn-primary text-center  mt-3" onclick="addComment(' . $photoId . ')">Отправить</button>';
                } else {
                    echo '<div class="alert alert-warning" role="alert">Авторизуйтесь, чтобы оставить комментарий.</div>';
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="alert alert-danger mt-5" role="alert">Фотография не найдена.</div>';
            }
        } else {
            echo '<div class="alert alert-danger mt-5" role="alert">ID_Photos не передан в URL.</div>';
        }

        $conn->close();
        ?>
    </div>
    <div class="text-center mt-2 ml-2"><a href="Index.php" class="btn btn-primary">Вернуться на страницу с альбомами </a></div>
    <!-- Bootstrap JS и скрипт для добавления комментария -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addComment(photoId) {
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
        }
    </script>
</body>
<footer class="footer mt-3">
    <div class="container">
        <div class="footer-content">
            <p>VDOVIN STANISLAV</p>
            <p>ГБПОУ РО РКРИПТ</p>
        </div>
    </div>
</footer>
</html>
