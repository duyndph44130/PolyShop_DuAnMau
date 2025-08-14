<?php
class CategoryController
{
    protected $categoryModel;
    protected $productModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel  = new ProductModel();
    }

    public function detail($id = null): void
    {
        // Lấy id từ GET trước, nếu không có thì dùng tham số router
        $categoryId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$categoryId && $id !== null) {
            $categoryId = filter_var($id, FILTER_VALIDATE_INT);
        }

        // Kiểm tra hợp lệ
        if (!$categoryId || $categoryId <= 0) {
            header('Location: ?act=/');
            exit;
        }

        // Lấy danh mục
        $category = $this->categoryModel->getCategoryById($categoryId);
        if (!$category) {
            header('Location: ?act=/');
            exit;
        }

        // Lấy sản phẩm thuộc danh mục
        $products   = $this->productModel->getProductsByCategory($categoryId);
        $categories = $this->categoryModel->getAllCategories(); // nếu cần sidebar

        require_once './views/category.php';
    }

    private function redirectHome()
    {
        header("Location: ?act=/");
        exit;
    }
}
