<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../const.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$payload = [
    'iss' => 'http://example.org',
    'aud' => 'http://example.com',
    'iat' => 1356999524,
    'nbf' => 1357000000
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // $json = file_get_contents('php://input');
    // header("Content-Type: application/json");
    echo "asdasd";
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // $data = array('name' => $_GET['name']);
    // header("Content-Type: application/json");
    // echo json_encode($data);
    // exit();
    $jwt = JWT::encode($payload, $JWT_key, 'HS256');
    $decoded = JWT::decode($jwt, new Key($JWT_key, 'HS256'));
    echo $jwt . '<br>';
    header("Content-Type: application/json");
    $decoded_array = (array)$decoded;
    echo json_encode($decoded_array);
}
