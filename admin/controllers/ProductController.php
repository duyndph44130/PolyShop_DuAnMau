<?php

class ProductController {
    public $modelProduct;
    public $modelCategory;

    public function __construct() {
        $this->modelProduct = new ProductModel();
        $this->modelCategory = new CategoryModel();
    }

    public function list() {
        $listProducts = $this->modelProduct->getAllProducts();

        $keyword = $_GET['keyword'] ?? '';
        if (!empty($keyword)) {
            $listProducts = $this->modelProduct->searchProducts($keyword);
        } else {
            $listProducts = $this->modelProduct->getAllProducts();
        }

        require_once './views/products/list.php';
    }

    public function detail($id) {
        $product = $this->modelProduct->getProductById($id);
        if (!$product) {
            http_response_code(404);
            echo "Sản phẩm không tồn tại.";
            return;
        }
        require_once './views/products/show.php';
    }

    public function add() {
        $errors = [];
        $categories = $this->modelCategory->getAllCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = (float) ($_POST['price'] ?? 0);
            $size = $_POST['size'] ?? '';
            $color = $_POST['color'] ?? '';
            $stock_quantity = (int) ($_POST['stock_quantity'] ?? 0);
            $category_id = $_POST['category_id'] ?? null;
            $created_by = 1;
            $image_url = '';

            if (empty($name)) $errors[] = "Tên sản phẩm không được để trống.";
            if ($price <= 0) $errors[] = "Giá sản phẩm phải lớn hơn 0.";
            if ($stock_quantity < 0) $errors[] = "Số lượng tồn kho không hợp lệ.";
            if (empty($category_id)) $errors[] = "Vui lòng chọn danh mục.";

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $fileType = mime_content_type($_FILES['image']['tmp_name']);
                if (!in_array($fileType, $allowedTypes)) {
                    $errors[] = "Chỉ cho phép upload ảnh (.jpg, .png, .gif, .webp).";
                } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
                    $errors[] = "Kích thước ảnh tối đa là 2MB.";
                } else {
                    $uploadDir = 'uploads/';
                    $filename = basename($_FILES['image']['name']);
                    $targetFile = $uploadDir . time() . '_' . $filename;
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                        $image_url = $targetFile;
                    } else {
                        $errors[] = "Không thể tải lên ảnh.";
                    }
                }
            }

            if (empty($errors)) {
                if ($this->modelProduct->addProduct($name, $description, $price, $size, $color, $stock_quantity, $image_url, $category_id, $created_by)) {
                    header('Location: ?act=/products');
                    exit;
                } else {
                    $errors[] = "Lỗi khi thêm sản phẩm vào CSDL.";
                }
            }
        }

        require_once './views/products/add.php';
    }

    public function edit($id) {
        $product = $this->modelProduct->getProductById($id);
        $categories = $this->modelCategory->getAllCategories();
        $errors = [];

        if (!$product) {
            http_response_code(404);
            echo "Sản phẩm không tồn tại.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = (float) ($_POST['price'] ?? 0);
            $size = $_POST['size'] ?? '';
            $color = $_POST['color'] ?? '';
            $stock_quantity = (int) ($_POST['stock_quantity'] ?? 0);
            $category_id = $_POST['category_id'] ?? null;
            $image_url = $product['image_url'];

            if (empty($name)) $errors[] = "Tên sản phẩm không được để trống.";
            if ($price <= 0) $errors[] = "Giá sản phẩm phải lớn hơn 0.";
            if ($stock_quantity < 0) $errors[] = "Số lượng tồn kho không hợp lệ.";
            if (empty($category_id)) $errors[] = "Vui lòng chọn danh mục.";

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $fileType = mime_content_type($_FILES['image']['tmp_name']);
                if (!in_array($fileType, $allowedTypes)) {
                    $errors[] = "Chỉ cho phép upload ảnh (.jpg, .png, .gif, .webp).";
                } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
                    $errors[] = "Kích thước ảnh tối đa là 2MB.";
                } else {
                    $uploadDir = 'uploads/';
                    $filename = basename($_FILES['image']['name']);
                    $targetFile = $uploadDir . time() . '_' . $filename;
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                        $image_url = $targetFile;
                    } else {
                        $errors[] = "Không thể tải lên ảnh mới.";
                    }
                }
            }

            if (empty($errors)) {
                if ($this->modelProduct->updateProduct($id, $name, $description, $price, $size, $color, $stock_quantity, $image_url, $category_id)) {
                    header('Location: ?act=/products');
                    exit;
                } else {
                    $errors[] = "Lỗi khi cập nhật sản phẩm.";
                }
            }
        }

        require_once './views/products/edit.php';
    }

    public function delete($id) {
        if ($this->modelProduct->deleteProduct($id)) {
            header('Location: ?act=/products');
            exit;
        } else {
            echo "Lỗi khi xóa sản phẩm.";
        }
    }
}
