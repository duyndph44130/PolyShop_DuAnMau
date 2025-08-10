<?php
class HomeController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->getAllCategories();
        $newProducts = $this->productModel->getNewProducts();
        $featuredProducts = $this->productModel->getFeaturedProducts();

        require_once './views/home.php';
    }

    public function introduction() {
        require_once './views/introduction.php';
    }

    public function blog() {
        require_once './views/blog.php';
    }
}
