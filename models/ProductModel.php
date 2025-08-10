<?php
class ProductModel
{
    protected $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getNewProducts($limit = 8)
    {
        $sql = "SELECT * FROM product ORDER BY product_id DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeaturedProducts($limit = 8)
    {
        $sql = "SELECT * FROM product WHERE is_featured = 1 LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $sql = "SELECT * FROM product WHERE product_id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductsByCategory($categoryId) {
        $sql = "SELECT * FROM product WHERE category_id = :catId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':catId', (int)$categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchProducts($keyword) {
        $sql = "SELECT * FROM product 
                WHERE name LIKE :keyword 
                OR description LIKE :keyword";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFilteredProducts($keyword, $category_id, $min_price, $max_price, $sort)     {
        $sql = "SELECT * FROM product WHERE 1";

        if ($keyword !== '') {
            $sql .= " AND name LIKE :keyword";
        }
        if ($category_id > 0) {
            $sql .= " AND category_id = :category_id";
        }
        if ($min_price > 0) {
            $sql .= " AND price >= :min_price";
        }
        if ($max_price > 0) {
            $sql .= " AND price <= :max_price";
        }

        // Sắp xếp
        if ($sort == 'price_asc') {
            $sql .= " ORDER BY price ASC";
        } elseif ($sort == 'price_desc') {
            $sql .= " ORDER BY price DESC";
        } elseif ($sort == 'newest') {
            $sql .= " ORDER BY created_at DESC";
        } elseif ($sort == 'oldest') {
            $sql .= " ORDER BY created_at ASC";
        } else {
            $sql .= " ORDER BY product_id DESC";
        }

        $stmt = $this->conn->prepare($sql);

        if ($keyword !== '') {
            $stmt->bindValue(':keyword', '%' . $keyword . '%');
        }
        if ($category_id > 0) {
            $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        }
        if ($min_price > 0) {
            $stmt->bindValue(':min_price', $min_price, PDO::PARAM_INT);
        }
        if ($max_price > 0) {
            $stmt->bindValue(':max_price', $max_price, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
