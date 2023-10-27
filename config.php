<?php
$servername = "localhost"; // Имя сервера 
$username = "root"; // Имя 
$password = ""; // Пароль
$database = "PhotoArchiveBD"; 


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}
?>