<?php 

class ProductController {
    public $modelProduct;

    public function __construct() {
        // Khởi tạo modelProduct hoặc các thành phần khác nếu cần
        $this->modelProduct = new ProductModel();
    }

    public function list() {
        // Lấy tất cả các sản phẩm từ model
        $listProducts = $this->modelProduct->getAllProducts();

        require_once './views/products/list.php';
    }
}