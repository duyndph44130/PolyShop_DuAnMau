<?php
session_start(); // Khởi động session ở đầu file

// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php';
require_once './commons/function.php';

$conn = connectDB(); // Kết nối CSDL

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Load models
require_once './models/ProductModel.php';
require_once './models/CategoryModel.php';
require_once './models/UserModel.php';
require_once './models/OrderModel.php'; // Đã cập nhật
require_once './models/VoucherModel.php'; // Đã cập nhật
require_once './models/ShippinginfoModel.php'; // Đã cập nhật
require_once './models/CommentModel.php';
require_once './models/ContactModel.php';
require_once './models/CartModel.php';

// Load controllers
require_once './controllers/HomeController.php';
require_once './controllers/CategoryController.php';
require_once './controllers/ProductController.php';
require_once './controllers/AuthController.php';
require_once './controllers/CheckoutController.php';
require_once './controllers/SearchController.php';
require_once './controllers/OrderController.php';
require_once './controllers/UserController.php';
require_once './controllers/CommentController.php';
require_once './controllers/ContactController.php';
require_once './controllers/CartController.php';
require_once './controllers/ShopController.php';

// Lấy route từ URL
$act = $_GET['act'] ?? '/';

// Định tuyến đơn giản
match ($act) {
    '/', '/home', 'home' => (new HomeController())->index(),
    '/product/detail', 'product/detail' => (new ProductController())->detail($_GET['id'] ?? null),
    '/category', 'category' => (new CategoryController())->detail($_GET['id'] ?? null),
    '/search', 'search' => (new SearchController())->search(),
    '/shop', 'shop' => (new ShopController())->shop(),
    '/blog', 'blog' => (new HomeController)->blog(),

    '/cart', 'cart' => (new CartController())->cart(),
    '/cart/add', 'cart/add' => (new CartController())->add(),
    '/cart/remove', 'cart/remove' => (new CartController())->remove(),
    '/cart/update', 'cart/update' => (new CartController())->update(),

    // '/checkout', 'checkout' => (new CheckoutController())->checkout(), // Thêm route cho trang thanh toán
    // '/thankyou', 'thankyou' => (new CheckoutController())->thankYou(), // Thêm route cho trang cảm ơn

    // '/order/track' => (new OrderController())->track(), // Nếu bạn muốn thêm chức năng theo dõi đơn hàng

    '/comment/add', 'comment/add' => (new CommentController())->add(),

    '/introduction', 'introduction' => (new HomeController())->introduction(),

    '/contact', 'contact' => (new ContactController())->form(),
    '/contact/send', 'contact/send' => (new ContactController())->send(),

    '/login', 'login' => (new AuthController())->login(),
    '/logout', 'logout' => (new AuthController())->logout(),
    '/register', 'register' => (new AuthController())->register(),

    default => http_response_code(404),
};
