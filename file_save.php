<?php
require 'connect_db.php';
require 'function_lower_image.php';
    $userName = htmlspecialchars($_POST['user_name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $homepage = htmlspecialchars($_POST['homepage'], ENT_QUOTES, 'UTF-8');
    $text = htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8');
    $ipAddress = htmlspecialchars($_SERVER['REMOTE_ADDR'], ENT_QUOTES, 'UTF-8');
    $browser = htmlspecialchars($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');
if (isset($_FILES['file'])) {
  $file = $_FILES['file'];

  // Проверка на ошибки загрузки файла
  if ($file['error'] === UPLOAD_ERR_OK) {
    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmpPath = $file['tmp_name'];

    // Проверка типа файла
    $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (in_array($fileExtension, $allowedExtensions)) {
      // Проверка размера файла
      $maxFileSize = 100 * 1024; // 100 KB
      if ($fileSize <= $maxFileSize) {
        // Генерация уникального имени файла
        $uniqueFileName = uniqid() . '_' . $fileName;

        // Путь для сохранения файла
        $uploadDirectory = 'uploads/';
        $targetFilePath = $uploadDirectory . $uniqueFileName;

        // Сохранение файла
        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
          // Файл успешно загружен, сохраняем данные в базу данных

        $stmt = $database->prepare("INSERT INTO guestbook (user_name, email, homepage, text, ip_address, browser, file_name) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $userName, PDO::PARAM_STR);
        $stmt->bindParam(2, $email, PDO::PARAM_STR);
        $stmt->bindParam(3, $homepage, PDO::PARAM_STR);
        $stmt->bindParam(4, $text, PDO::PARAM_STR);
        $stmt->bindParam(5, $ipAddress, PDO::PARAM_STR);
        $stmt->bindParam(6, $browser, PDO::PARAM_STR);
        $stmt->bindParam(7, $targetFilePath, PDO::PARAM_STR);
        $stmt->execute();

          echo "File uploaded successfully.";
        } else {
          echo "Error while uploading the file.";
        }
      } else {
        echo "File size exceeds the allowed limit.";
      }
    } else {
      echo "Invalid file format.";
    }
  } else {
    echo "Error during file upload.";
  }
} else {
  // Загрузка без файла
  $stmt = $database->prepare("INSERT INTO guestbook (user_name, email, message) VALUES (?, ?, ?)");
  $stmt->execute([$userName, $email, $message]);

  $stmt = $database->prepare("INSERT INTO guestbook (user_name, email, homepage, text, ip_address, browser) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bindParam(1, $userName, PDO::PARAM_STR);
  $stmt->bindParam(2, $email, PDO::PARAM_STR);
  $stmt->bindParam(3, $homepage, PDO::PARAM_STR);
  $stmt->bindParam(4, $text, PDO::PARAM_STR);
  $stmt->bindParam(5, $ipAddress, PDO::PARAM_STR);
  $stmt->bindParam(6, $browser, PDO::PARAM_STR);
  $stmt->execute();

  echo "Message submitted successfully.";
}
?>