<?php
class VoucherModel {
    protected $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAll($product_id = null) {
        $sql = "SELECT v.*, p.name AS product_name 
                FROM voucher v
                LEFT JOIN product p ON v.product_id = p.product_id";

        if ($product_id !== null) {
            $sql .= " WHERE v.product_id = :product_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        } else {
            $sql .= " ORDER BY v.voucher_id DESC";
            $stmt = $this->conn->prepare($sql);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM voucher WHERE voucher_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($name, $discount_value, $max_discount, $min_order_value, $start_date, $end_date, $product_id) {
        $stmt = $this->conn->prepare("
            INSERT INTO voucher (name, discount_value, max_discount, min_order_value, start_date, end_date, product_id)
            VALUES (:name, :discount_value, :max_discount, :min_order_value, :start_date, :end_date, :product_id)
        ");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':discount_value', $discount_value, PDO::PARAM_INT);
        $stmt->bindParam(':max_discount', $max_discount, PDO::PARAM_INT);
        $stmt->bindParam(':min_order_value', $min_order_value, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);

        // xử lý null nếu chọn "tất cả sản phẩm"
        if ($product_id === '' || $product_id === null) {
            $stmt->bindValue(':product_id', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        }

        return $stmt->execute();
    }

    public function update($id, $name, $discount_value, $max_discount, $min_order_value, $start_date, $end_date, $product_id) {
        $stmt = $this->conn->prepare("
            UPDATE voucher 
            SET name = :name, discount_value = :discount_value, max_discount = :max_discount, 
                min_order_value = :min_order_value, start_date = :start_date, end_date = :end_date, product_id = :product_id
            WHERE voucher_id = :id
        ");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':discount_value', $discount_value, PDO::PARAM_INT);
        $stmt->bindParam(':max_discount', $max_discount, PDO::PARAM_INT);
        $stmt->bindParam(':min_order_value', $min_order_value, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);

        if ($product_id === '' || $product_id === null) {
            $stmt->bindValue(':product_id', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        }

        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM voucher WHERE voucher_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function search($keyword, $product_id = null) {
        $sql = "SELECT v.*, p.name AS product_name 
                FROM voucher v
                LEFT JOIN product p ON v.product_id = p.product_id
                WHERE v.name LIKE :kw";

        if ($product_id !== null) {
            $sql .= " AND v.product_id = :product_id";
        }

        $sql .= " ORDER BY v.voucher_id DESC";
        $stmt = $this->conn->prepare($sql);
        $kw = "%$keyword%";
        $stmt->bindParam(':kw', $kw);

        if ($product_id !== null) {
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
