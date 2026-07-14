<?php
define('FCPATH', __DIR__ . '/public/');
require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . '/bootstrap.php';
$app = \Config\Services::codeigniter();
$app->initialize();

$controller = new \App\Controllers\Api\DashboardController();
$response = $controller->index();
echo $response->getBody();
