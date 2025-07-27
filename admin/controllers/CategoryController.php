<?php
class CategoryController {
    public $modelCategory;

    public function __construct() {
        // Khởi tạo modelCategory hoặc các thành phần khác nếu cần
        $this->modelCategory = new CategoryModel();
    }

    public function list() {
        // Lấy tất cả các danh mục từ model
        $listCategories = $this->modelCategory->getAllCategories();

        require_once './views/categories/list.php';
    }

    public function detail($id) {
        // Lấy thông tin chi tiết danh mục từ model
        $category = $this->modelCategory->getCategoryById($id);
        $productCount = $this->modelCategory->countProductsInCategory($id); // mới

        require_once './views/categories/show.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            $errors = [];

            if( empty($name) || empty($description)) {
                $errors[] = "Tên và mô tả không được để trống.";
            }

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo $error . "<br>";
                }
                return;
            }

            if ($this->modelCategory->addCategory($name, $description)) {
                header('Location: index.php?act=/categories');
            } else {
                echo "Lỗi khi thêm danh mục.";
            }
        }
        require_once './views/categories/add.php';
    }

    public function edit($id) {
        $category = $this->modelCategory->getCategoryById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if ($this->modelCategory->updateCategory($id, $name, $description)) {
                header('Location: index.php?act=/categories');
            } else {
                echo "Lỗi khi cập nhật danh mục.";
            }
        }
        require_once './views/categories/edit.php';
    }

    public function delete($id) {
        if ($this->modelCategory->destroyCategory($id)) {
            header('Location: index.php?act=/categories');
        } else {
            echo "Lỗi khi xóa danh mục.";
        }
    }
}