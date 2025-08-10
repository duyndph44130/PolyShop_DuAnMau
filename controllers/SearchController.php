<?php
class SearchController
{
    public function search()
    {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        // Nếu keyword trống => về trang chủ
        if ($keyword === '') {
            header("Location: index.php");
            exit;
        }

        if ($keyword !== '') {
            $results = $productModel->searchProducts($keyword);
        } else {
            $results = [];
        }

        include './views/search.php';
    }
}
