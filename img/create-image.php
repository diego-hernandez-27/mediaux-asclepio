<?php
header('Content-Type: image/jpeg');

// Crear una imagen en blanco
$image = imagecreatetruecolor(150, 150);

// Establecer colores
$white = imagecolorallocate($image, 255, 255, 255);
$blue = imagecolorallocate($image, 0, 123, 255);

// Rellenar el fondo con blanco
imagefill($image, 0, 0, $white);

// Crear un círculo
imagefilledellipse($image, 75, 75, 140, 140, $blue);

// Guardar la imagen
imagejpeg($image, 'perfil.jpeg', 100);

// Liberar memoria
imagedestroy($image);
