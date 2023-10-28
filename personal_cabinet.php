<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $photoName = $_POST['photo_name'];
    $photoDate = $_POST['photo_date'];
    $photoEvent = $_POST['photo_event'];
    $photoDescription = $_POST['photo_description'];
    $photoFilePath = $_FILES['photo_file']['tmp_name'];
    $_SESSION['user_avatar'] = $avatarPathFromDatabase;
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES['photo_file']['name']);

    move_uploaded_file($photoFilePath, $targetFile);

    $userId = $_SESSION['user_id'];
    $sql = "INSERT INTO Photos (Name, Date, Event, Description, FilePath, ID_User) 
            VALUES ('$photoName', '$photoDate', '$photoEvent', '$photoDescription', '$targetFile', '$userId')";

    if ($conn->query($sql) === TRUE) {
        echo "Фотография успешно добавлена!";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Личный кабинет</h2>
                    </div>
                    <div class="card-body">
                        <h2><?php echo $_SESSION['user_name']; ?></h2>
                        <p>Логин: <?php echo $_SESSION['user_name']; ?></p>
                        
                        <p>Пароль: *******</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Создать альбом</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="process_add_photo.php" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="photo_file">Выберите фотографию</label>
                                <input type="file" name="photo_file" id="photo_file" class="form-control" accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <label for="photo_name">Название фото</label>
                                <input type="text" name="photo_name" id="photo_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="photo_date">Дата создания фото</label>
                                <input type="text" name="photo_date" id="photo_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="photo_event">Мероприятие</label>
                                <input type="text" name="photo_event" id="photo_event" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="photo_description">Описание</label>
                                <input type="text" name="photo_description" id="photo_description" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Отправить заявку</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
