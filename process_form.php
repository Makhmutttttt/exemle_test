<?php
require 'connect_db.php';
require_once 'function_lower_image.php';
    $userName = htmlspecialchars($_POST['user_name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $homepage = htmlspecialchars($_POST['homepage'], ENT_QUOTES, 'UTF-8');
    $text = htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8');
    $ipAddress = htmlspecialchars($_SERVER['REMOTE_ADDR'], ENT_QUOTES, 'UTF-8');
    $browser = htmlspecialchars($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');

if(isset($_POST['submit'])){
        if (isset($_FILES['fileToUpload'])) {
        $file = $_FILES['fileToUpload'];
        // echo "file exist";
        // Проверка на ошибки загрузки файла
        if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileTmpPath = $file['tmp_name'];
        // $sizee = filesize($sourcePath);
        // echo $sizee;
        
        // Проверка типа файла
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($fileExtension, $allowedExtensions)) {
        // Проверка размера файла
        $maxFileSize = 100000; // 100 KB
        if ($fileSize >= $maxFileSize){
            $file_push = resizeImage($fileTmpPath, $fileTmpPath);
            // $file_push2 = compressImage($fileTmpPath, $fileTmpPath, $maxFileSize);
        }
        $fileSize = filesize($fileTmpPath);
        echo '------';
            echo $fileSize;
        echo '------';    
            // echo $file_push2;
        if ($fileSize <= $maxFileSize) {
        // Генерация уникального имени файла
        $uniqueFileName = uniqid() . '_' . $fileName;

        // Путь для сохранения файла
        $uploadDirectory = 'uploads/';
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);//как его добавил сратотало
        }
        $targetFilePath = $uploadDirectory . $uniqueFileName;
        echo '<img src="' . $targetFilePath . '" alt="" />';

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
    }
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
        } 
  else {
    // Загрузка без файла

    $stmt = $database->prepare("INSERT INTO guestbook (user_name, email, homepage, text, ip_address, browser) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $userName, PDO::PARAM_STR);
    $stmt->bindParam(2, $email, PDO::PARAM_STR);
    $stmt->bindParam(3, $homepage, PDO::PARAM_STR);
    $stmt->bindParam(4, $text, PDO::PARAM_STR);
    $stmt->bindParam(5, $ipAddress, PDO::PARAM_STR);
    $stmt->bindParam(6, $browser, PDO::PARAM_STR);
    $stmt->execute();

    echo "Message submitted successfully.";
//   header("Location: index.php");
}


?>