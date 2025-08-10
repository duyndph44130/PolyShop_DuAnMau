<?php
class ProductController {
    private $productModel;
    private $categoryModel;
    private $commentModel;
    private $voucherModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->commentModel = new CommentModel();
        $this->voucherModel = new VoucherModel();
    }

    public function detail($id)
    {
        if (!isset($id) || !is_numeric($id)) {
            header("Location: ?act=/");
            exit;
        }

        $product = $this->productModel->getProductById($id);
        if (!$product) {
            header("Location: ?act=/");
            exit;
        }

        $category = $this->categoryModel->getCategoryById($product['category_id']);
        $categories = $this->categoryModel->getAllCategories();

        // Lấy bình luận theo sản phẩm
        $comments = $this->commentModel->getCommentsByProductId($id);

        // Lấy khuyến mãi voucher (nếu có)
        $voucher = $this->voucherModel->getVoucherForProduct($id);

        require_once './views/productdetail.php';
    }
}
