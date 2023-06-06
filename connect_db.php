<?php

$host = "127.0.0.1";
$dbname = "guest_book";
$port = "3307";
$user = "root";
$password_sql = "";
$dsn = "mysql:host={$host};dbname={$dbname};port={$port};";

$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false, // Отключение эмуляции prepare для безопасности
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Включение генерации исключений при ошибках
];

$database = new PDO($dsn, $user, $password_sql, $options);

?>