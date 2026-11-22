<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['arquivo'])) {
    header('Location: /conectapets/index.php');
    exit;
}

$arquivo = $_FILES['arquivo'];

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;

// Load .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Init config and Create Cloudinary
$config = new Configuration($_ENV['CLOUDINARY_URL']);
$cld = new Cloudinary($config);

// Upload and delete the image 
$upload = new UploadApi($config);
$response = $upload -> upload($arquivo['tmp_name']); // upload
// guarda $responsa["public_id"] no banco de dados como o id para a imagem
$result = $cld->uploadApi()->destroy($response["public_id"]); // delete

?>