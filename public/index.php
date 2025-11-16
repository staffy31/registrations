<?php
// simple router - point your webroot to /public
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../lib/CSRF.php';
require_once __DIR__ . '/../models/PatientModel.php';
require_once __DIR__ . '/../controllers/PatientController.php';

use App\Config\Database;
use App\Lib\CSRF;
use App\Models\PatientModel;
use App\Controllers\PatientController;

session_start();
$db = (new Database())->connect();
$model = new PatientModel($db);
$controller = new PatientController($model);

$path = $_GET['p'] ?? 'register';
if ($path === 'api/register') {
    $controller->apiRegister();
    exit;
}
if ($path === 'register') {
    $token = CSRF::start();
    include __DIR__ . '/register.php';
    exit;
}
http_response_code(404);
echo 'Not Found';
