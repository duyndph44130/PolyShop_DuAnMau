<?php 
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once '../commons/env.php';
require_once '../commons/function.php';

// Require toàn bộ file Controller
require_once './controllers/CategoryController.php';
require_once './controllers/ProductController.php';

// Require toàn bộ file Model
require_once './models/CategoryModel.php';
require_once './models/ProductModel.php';


// Route
$act = $_GET['act'] ?? '/';

$controller = new CategoryController();

match ($act) {
    '/' => $controller->list(),

    // Route category
    '/categories' => $controller->list(),
    '/category/add' => $controller->add(),
    '/category/edit' => $controller->edit($_GET['id'] ?? null),
    '/category/delete' => $controller->delete($_GET['id'] ?? null),
    '/category/detail' => $controller->detail($_GET['id'] ?? null),
    '/category/show' => $controller->detail($_GET['id'] ?? null),

    // Route product
    '/products' => (new ProductController())->list(),
    '/product/add' => (new ProductController())->add(),
    '/product/edit' => (new ProductController())->edit($_GET['id'] ?? null),
    '/product/delete' => (new ProductController())->delete($_GET['id'] ?? null),
    '/product/detail' => (new ProductController())->detail($_GET['id'] ?? null),

    default => http_response_code(404),
};

