<?php
// Bắt đầu phiên
session_start();

// Require file Common
require_once '../commons/env.php';
require_once '../commons/function.php';

// Require toàn bộ file Controller
require_once './controllers/CategoryController.php';
require_once './controllers/ProductController.php';
require_once './controllers/AdminAuthController.php';
require_once './controllers/UserController.php';
require_once './controllers/CommentController.php';
require_once './controllers/OrderController.php';
require_once './controllers/PaymentController.php';
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
require_once './models/PaymentModel.php';
require_once './models/ShippingInfoModel.php';
require_once './models/VoucherModel.php';
require_once './models/DashboardModel.php';
require_once './models/ContactModel.php';

// Định nghĩa các route yêu cầu quyền admin
$adminRoutes = [
    // Danh mục
    '/categories', '/category/add', '/category/edit', '/category/delete', '/category/detail',
    
    // Sản phẩm
    '/products', '/product/add', '/product/edit', '/product/delete', '/product/detail',
    
    // Người dùng
    '/users', '/user/add', '/user/edit', '/user/delete', '/user/detail',

    // Bình luận
    '/comments', '/comment/delete', '/comment/edit',

    // Đơn hàng
    '/orders', '/order/edit',

    // Thanh toán
    '/payments',

    // Vận chuyển
    '/shippinginfos', '/shippinginfo/edit',

    // Voucher
    '/vouchers', '/voucher/add', '/voucher/edit', '/voucher/delete',
];


// Xác định hành động
$act = $_GET['act'] ?? '/';

// Danh sách route không yêu cầu đăng nhập
$publicRoutes = ['/login', '/logout', '/register'];

// Kiểm tra đăng nhập
if (!in_array($act, $publicRoutes)) {
    if (empty($_SESSION['user'])) {
        // Chưa đăng nhập → chuyển về login
        header('Location: ?act=/login');
        exit;
    }
}

// Kiểm tra quyền truy cập trang admin
if (in_array($act, $adminRoutes)) {
    $userRole = strtolower($_SESSION['user']['role'] ?? '');

    if ($userRole !== 'admin') {
        // Không có quyền → chuyển về dashboard và flash thông báo
        $_SESSION['error'] = "Bạn không có quyền truy cập trang này!";
        header('Location: ?act=/');
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
    '/orders' => (new OrderController()) ->list(),
    '/order/detail' => (new OrderController()) ->detail($_GET['id'] ?? null),
    '/order/edit' => (new OrderController()) ->edit($_GET['id'] ?? null),    

    // Payment
    '/payments' => (new PaymentController())->list(),
    '/payment/detail' => (new PaymentController())->detail(id: $_GET['id'] ?? null),

    // Shipping info
    '/shippinginfos' => (new ShippingInfoController())->list(),
    '/shippinginfo/detail' => (new ShippingInfoController())->detail( $_GET['id'] ?? null),
    '/shippinginfo/edit' => (new ShippingInfoController())->update( $_GET['id'] ?? null),
    

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
