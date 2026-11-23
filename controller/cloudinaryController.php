<?php

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


function uploadImagem($arquivo)
{
    global $config;

    if (empty($arquivo) || !isset($arquivo['tmp_name'])) {
        return false;
    }

    try {
        $upload = new UploadApi($config);
        $response = $upload->upload($arquivo['tmp_name']);

        return $response["public_id"];
    } catch (\Exception $e) {
        return false;
    }
}


function deletarImagem($public_id)
{
    global $cld;

    if (empty($public_id)) {
        return false;
    }

    try {
        $result = $cld->uploadApi()->destroy($public_id);

        return $result;
    } catch (\Exception $e) {
        return false;
    }
}

?>
