<?php
include 'config.php';

// SQL-запрос для получения списка альбомов
$sql = "SELECT ID_Album, Name FROM Album";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Выводим каждый альбом
    while ($row = $result->fetch_assoc()) {
        echo '<div class="album-item" data-album-id="' . $row['ID_Album'] . '">' . $row['Name'] . '</div>';
    }
} else {
    echo 'Нет доступных альбомов';
}

$conn->close();
?>
