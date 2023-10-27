<?php
session_start();

// Проверяем, если введенные данные - это администратор
if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin') {
    $_SESSION['admin'] = true;
    header("Location: admin.php"); // Перенаправляем администратора на административную страницу
    exit();
} else {
    header("Location: admin_login.php"); // Перенаправляем обратно на страницу авторизации в случае неверных данных
    exit();
}
?>
