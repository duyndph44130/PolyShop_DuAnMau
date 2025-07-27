<?php


// Kết nối CSDL qua PDO
function connectDB() {
    // Kết nối CSDL
    $host = DB_HOST;
    $port = DB_PORT;
    $dbname = DB_NAME;

    try {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USER, DB_PASS);

        // cài đặt chế độ báo lỗi là xử lý ngoại lệ
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // cài đặt chế độ trả dữ liệu
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
        return $conn;
    } catch (PDOException $e) {
        echo ("Connection failed: " . $e->getMessage());
    }
}

function deleteFile($file){
    $pathDelete = PATH_ROOT . $file;
    if (file_exists($pathDelete)) {
        unlink($pathDelete); // Hàm unlink dùng để xóa file
    }
}


// Tạo slug từ chuỗi tiếng Việt
function createSlug($string) {
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($string));
    return trim($slug, '-');
}

// Chuyển hướng trang
function redirect($url) {
    header("Location: $url");
    exit;
}

// Kiểm tra xem người dùng đã đăng nhập hay chưa
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Hiển thị thông báo flash
function flash($name = '', $message = '', $class = 'success') {
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            $_SESSION[$name] = "<div class='alert alert-$class'>$message</div>";
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            echo $_SESSION[$name];
            unset($_SESSION[$name]);
        }
    }
}

// Xử lý upload ảnh
function uploadFile($file, $folderSave){
    $file_upload = $file;
    $fileName = rand(10000, 99999) . $file_upload['name'];
    $pathStorage = $folderSave . $fileName;

    $tmp_file = $file_upload['tmp_name'];
    $pathSave = PATH_ROOT . $pathStorage;

    if (move_uploaded_file($tmp_file, $pathSave)) {
        // Debug: kiểm tra đã lưu chưa
        if (!file_exists($pathSave)) {
            die("❌ File chưa được lưu tại $pathSave");
        }
        return $pathStorage;
    }

    die("❌ Upload thất bại.");
}

    
// Hàm debug để in ra thông tin biến
if(!function_exists('debug')) {
    function debug($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

}