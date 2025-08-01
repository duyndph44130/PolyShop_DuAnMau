<?php
// Bắt đầu phiên
session_start();

// Require file Common
require_once '../commons/env.php';
require_once '../commons/function.php';

// Require toàn bộ file Controller
require_once './controllers/CategoryController.php';
require_once './controllers/ProductController.php';
require_once './controllers/AuthController.php';
require_once './controllers/UserController.php';
require_once './controllers/CommentController.php';
require_once './controllers/OrderController.php';
require_once './controllers/PaymentController.php';
require_once './controllers/VoucherController.php';

// Require toàn bộ file Model
require_once './models/CategoryModel.php';
require_once './models/ProductModel.php';
require_once './models/UserModel.php';
require_once './models/CommentModel.php';
require_once './models/OrderModel.php';
require_once './models/PaymentModel.php';
require_once './models/VoucherModel.php';

// Định nghĩa các route yêu cầu quyền admin
$adminRoutes = [
    '/categories', '/category/add', '/category/edit', '/category/delete', '/category/detail',
    '/products', '/product/add', '/product/edit', '/product/delete', '/product/detail',
    '/users', '/user/add', '/user/edit', '/user/delete', '/user/detail'
];

// Xác định hành động
$act = $_GET['act'] ?? '/';

// Kiểm tra đăng nhập (trừ login & logout)
if (!in_array($act, ['/login', '/logout']) && empty($_SESSION['user'])) {
    header('Location: ?act=/login');
    exit;
}

// Kiểm tra quyền admin
if (in_array($act, $adminRoutes) && (strtolower($_SESSION['user']['role'] ?? '') !== 'admin')) {
    echo "❌ Bạn không có quyền truy cập trang này!";
    exit;
}


// Định tuyến
match ($act) {
    '/' => (new CategoryController())->list(),

    // Category
    '/categories' => (new CategoryController())->list(),
    '/category/add' => (new CategoryController())->add(),
    '/category/edit' => (new CategoryController())->edit($_GET['id'] ?? null),
    '/category/delete' => (new CategoryController())->delete($_GET['id'] ?? null),
    '/category/detail' => (new CategoryController())->detail($_GET['id'] ?? null),

    // Product
    '/products' => (new ProductController())->list(),
    '/product/add' => (new ProductController())->add(),
    '/product/edit' => (new ProductController())->edit($_GET['id'] ?? null),
    '/product/delete' => (new ProductController())->delete($_GET['id'] ?? null),
    '/product/detail' => (new ProductController())->detail($_GET['id'] ?? null),

    // Auth
    '/login' => (new AuthController())->login(),
    '/logout' => (new AuthController())->logout(),
    '/register' => (new AuthController())->register(),


    // User
    '/users' => (new UserController())->list(),
    '/user/add' => (new UserController())->add(),
    '/user/edit' => (new UserController())->edit($_GET['id'] ?? null),
    '/user/delete' => (new UserController())->delete($_GET['id'] ?? null),
    '/user/detail' => (new UserController())->detail($_GET['id'] ?? null),

    // Comment
    '/comments' => (new CommentController())->list(),
    '/comment/add' => (new CommentController())->add(),
    '/comment/delete' => (new CommentController())->delete($_GET['id'] ?? null),
    '/comment/detail' => (new CommentController())->detail($_GET['id'] ?? null),
    '/comment/edit' => (new CommentController())->updateStatus($_GET['id'] ?? null),

    // Order
    '/orders' => (new OrderController()) ->list(),
    '/order/detail' => (new OrderController()) ->detail($_GET['id'] ?? null),
    '/order/edit' => (new OrderController()) ->edit($_GET['id'] ?? null),    

    // Payment
    '/payments' => (new PaymentController())->list(),
    '/payment/detail' => (new PaymentController())->detail($_GET['id'] ?? null),

    // Voucher
    '/vouchers' => (new VoucherController())->list(),
    '/voucher/add' => (new VoucherController())->add(),
    '/voucher/edit' => (new VoucherController())->edit($_GET['id'] ?? null),
    '/voucher/delete' => (new VoucherController())->delete($_GET['id'] ?? null),    

    // 404 fallback
    default => http_response_code(404),
};
