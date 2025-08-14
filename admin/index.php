<?php
// Bắt đầu session
session_start();

// Require file Common
require_once '../commons/env.php';
require_once '../commons/function.php';

// Kết nối CSDL (nếu cần)
$conn = connectDB();
if (!$conn) {
    die("Kết nối thất bại");
}

// Require toàn bộ file Controller
require_once './controllers/CategoryController.php';
require_once './controllers/ProductController.php';
require_once './controllers/AdminAuthController.php';
require_once './controllers/UserController.php';
require_once './controllers/CommentController.php';
require_once './controllers/OrderController.php';
require_once './controllers/ShippingInfoController.php';
require_once './controllers/VoucherController.php';
require_once './controllers/DashboardController.php';
require_once './controllers/ContactController.php';

// Require toàn bộ file Model
require_once './models/CategoryModel.php';
require_once './models/ProductModel.php';
require_once './models/UserModel.php';
require_once './models/CommentModel.php';
require_once './models/OrderModel.php';
require_once './models/ShippingInfoModel.php';
require_once './models/VoucherModel.php';
require_once './models/DashboardModel.php';
require_once './models/ContactModel.php';

// Danh sách route không yêu cầu đăng nhập
$publicRoutes = ['/login', '/logout', '/register'];

// Danh sách route yêu cầu quyền admin
$adminRoutes = [
    '/categories', '/category/add', '/category/edit', '/category/delete', '/category/detail',
    '/products', '/product/add', '/product/edit', '/product/delete', '/product/detail',
    '/users', '/user/add', '/user/edit', '/user/delete', '/user/detail',
    '/comments', '/comment/delete', '/comment/edit',
    '/orders', '/order/edit',
    '/shippinginfos', '/shippinginfo/edit',
    '/vouchers', '/voucher/add', '/voucher/edit', '/voucher/delete',
    '/contacts', '/contact/detail', '/contact/updateStatus', '/contact/delete'
];

// Lấy hành động từ URL
$act = $_GET['act'] ?? '/';

// Kiểm tra đăng nhập
if (!in_array($act, $publicRoutes)) {
    if (empty($_SESSION['user']['user_id'])) {
        header('Location: ?act=/login');
        exit;
    }
}

// Kiểm tra quyền admin
if (in_array($act, $adminRoutes)) {
    $userRole = strtolower($_SESSION['user']['role'] ?? '');
    if ($userRole !== 'admin') {
        $_SESSION['error'] = "Bạn không có quyền truy cập trang này!";
        header('Location: ?act=/dashboard');
        exit;
    }
}

// Định tuyến
match ($act) {
    '/' => (new DashboardController())->index(),
    '/dashboard' => (new DashboardController())->index(),

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
    '/login' => (new AdminAuthController())->login(),
    '/logout' => (new AdminAuthController())->logout(),

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
    '/orders' => (new OrderController())->list(),
    '/order/edit' => (new OrderController())->edit($_GET['id'] ?? null),

    // Shipping info
    '/shippinginfos' => (new ShippingInfoController())->list(),
    '/shippinginfo/edit' => (new ShippingInfoController())->edit($_GET['id'] ?? null),

    // Voucher
    '/vouchers' => (new VoucherController())->list(),
    '/voucher/add' => (new VoucherController())->add(),
    '/voucher/edit' => (new VoucherController())->edit($_GET['id'] ?? null),
    '/voucher/delete' => (new VoucherController())->delete($_GET['id'] ?? null),

    // Contact
    '/contacts' => (new ContactAdminController())->list(),
    '/contact/detail' => (new ContactAdminController())->detail($_GET['id'] ?? null),
    '/contact/updateStatus' => (new ContactAdminController())->updateStatus(),
    '/contact/delete' => (new ContactAdminController())->delete(),

    // 404 fallback
    default => http_response_code(404),
};
