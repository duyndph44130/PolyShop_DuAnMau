<?php
// File: commons/env.php

// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng Hàng số để không phải dùng $GLOBALS
define('BASE_URL', 'http://localhost/PolyShop_DuAnMau/');
define('BASE_URL_ADMIN', 'http://localhost/PolyShop_DuAnMau/admin/');

define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'polyshop_duanmau');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

define('PATH_ROOT', dirname(__DIR__ . '/../'));