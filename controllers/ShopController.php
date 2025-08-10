<?php
class ShopController
{
    public function shop()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        // Lấy danh sách danh mục
        $categories = $categoryModel->getAllCategories();

        // Lấy các filter từ GET
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $category_id = isset($_GET['category']) ? intval($_GET['category']) : 0;
        $min_price = isset($_GET['min_price']) ? intval($_GET['min_price']) : 0;
        $max_price = isset($_GET['max_price']) ? intval($_GET['max_price']) : 0;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : '';

        // Lấy sản phẩm
        $products = $productModel->getFilteredProducts($keyword, $category_id, $min_price, $max_price, $sort);

        // Nếu không có sản phẩm và có từ khoá tìm kiếm
        $message = '';
        if (empty($products) && $keyword !== '') {
            $message = "Không tìm thấy sản phẩm nào cho từ khoá: <strong>" . htmlspecialchars($keyword) . "</strong>";
        }

        include './views/shop.php';
    }
}
