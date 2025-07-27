<?php 
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once '../commons/env.php';
require_once '../commons/function.php';

// Require toàn bộ file Controller
require_once './controllers/CategoryController.php';

// Require toàn bộ file Model
require_once './models/CategoryModel.php';


// Route
$act = $_GET['act'] ?? '/';

match ($act) {
    '/' => (new CategoryController())->list(),
    '/categories' => (new CategoryController())->list(),
    default => http_response_code(404),
};
