<?php
class CategoryController
{
    protected $categoryModel;
    protected $productModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
    }

    public function detail($id)
    {
        // Lấy id danh mục từ URL
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            // Nếu không có id hợp lệ, có thể redirect về trang chủ
            header("Location: ?act=/");
            exit;
        }

        // Lấy thông tin danh mục
        $category = $this->categoryModel->getCategoryById($id);

        // Nếu không tìm thấy danh mục -> về trang chủ
        if (!$category) {
            header("Location: ?act=/");
            exit;
        }

        // Lấy sản phẩm trong danh mục
        $products = $this->productModel->getProductsByCategory($id);

        // Danh sách tất cả danh mục (để hiển thị sidebar nếu cần)
        $categories = $this->categoryModel->getAllCategories();

        // Gọi view
        require_once './views/category.php';
    }
}
