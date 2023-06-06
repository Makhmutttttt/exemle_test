<?php
function resizeImage($sourcePath, $destinationPath)
{
    $maxWidth = 1920;
    $maxHeight = 1080;
    // Получение информации об изображении
    $imageInfo = getimagesize($sourcePath);
    $originalWidth = $imageInfo[0];
    $originalHeight = $imageInfo[1];
    $mime = $imageInfo['mime'];

    // Определение типа изображения
    if ($mime == 'image/jpeg') {
        $sourceImage = imagecreatefromjpeg($sourcePath);
    } elseif ($mime == 'image/gif') {
        $sourceImage = imagecreatefromgif($sourcePath);
    } elseif ($mime == 'image/png') {
        $sourceImage = imagecreatefrompng($sourcePath);
    } else {
        return false; // Неподдерживаемый формат изображения
    }

    // Вычисление новых размеров с сохранением пропорций
    $widthRatio = $originalWidth / $maxWidth;
    $heightRatio = $originalHeight / $maxHeight;
    $scaleRatio = max($widthRatio, $heightRatio);
    $newWidth = round($originalWidth / $scaleRatio);
    $newHeight = round($originalHeight / $scaleRatio);

    // Создание пустого изображения с новыми размерами
    $destinationImage = imagecreatetruecolor($newWidth, $newHeight);

    // Масштабирование и копирование изображения
    imagecopyresampled($destinationImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

    // Сохранение изображения в новом размере
    if ($mime == 'image/jpeg') {
        imagejpeg($destinationImage, $destinationPath, 80); // 80 - качество JPEG (0-100)
    } elseif ($mime == 'image/gif') {
        imagegif($destinationImage, $destinationPath);
    } elseif ($mime == 'image/png') {
        imagepng($destinationImage, $destinationPath, 8); // 8 - качество PNG (0-9)
    }

    // Очистка памяти
    imagedestroy($sourceImage);
    imagedestroy($destinationImage);

    return true;
}

function compressImage($sourcePath, $destinationPath, $targetSizeKB) {
    $info = getimagesize($sourcePath);
    $mime = $info['mime'];
    // echo $targetSizeKB;


    switch ($mime) {
        case 'image/jpeg':
            compressJPEG($sourcePath, $destinationPath, $targetSizeKB);
            break;

        case 'image/gif':
            compressGIF($sourcePath, $destinationPath, $targetSizeKB);
            break;

        case 'image/png':
            compressPNG($sourcePath, $destinationPath, $targetSizeKB);
            break;

        default:
            // Неподдерживаемый формат изображения
            return false;
    }
}

function compressJPEG($sourcePath, $destinationPath, $targetSizeKB) {
    $quality = 75;

    while (filesize($destinationPath) > $targetSizeKB  && $quality > 0) {
        $image = imagecreatefromjpeg($sourcePath);
        imagejpeg($image, $destinationPath, $quality);
        imagedestroy($image);
        $quality -= 5;
        // echo '*****';
        // // echo $targetSizeKB;
        // echo 'File size: ' . filesize($destinationPath) . ' bytes<br>';
        // echo '*****';  
        // echo "Current quality: $quality\n";
    }

    // echo '*****';
    // echo $targetSizeKB;
    // // echo filesize($destinationPath);
    // echo '*****';  

}

function compressGIF($sourcePath, $destinationPath, $targetSizeKB) {
    $image = imagecreatefromgif($sourcePath);
    imagegif($image, $destinationPath);
    imagedestroy($image);

    while (filesize($destinationPath) > $targetSizeKB * 1024) {
        $image = imagecreatefromgif($destinationPath);
        imagegif($image, $destinationPath);
        imagedestroy($image);
    }
}

function compressPNG($sourcePath, $destinationPath, $targetSizeKB) {
    $image = imagecreatefrompng($sourcePath);
    imagepng($image, $destinationPath, 9); // Используется максимальное сжатие PNG (компрессия уровня 9)
    imagedestroy($image);

    while (filesize($destinationPath) > $targetSizeKB * 1024) {
        $image = imagecreatefrompng($destinationPath);
        imagepng($image, $destinationPath, 9);
        imagedestroy($image);
    }
}

?>