<?php
class VoucherModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAll() {
        $sql = "SELECT v.*, a.name as admin_name
                FROM voucher v
                JOIN admin a ON v.created_by = a.admin_id
                ORDER BY v.expiry_date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM voucher WHERE voucher_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($code, $discount_percent, $max_discount, $min_order_value, $expiry_date, $created_by) {
        $sql = "INSERT INTO voucher (code, discount_percent, max_discount, min_order_value, expiry_date, created_by)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$code, $discount_percent, $max_discount, $min_order_value, $expiry_date, $created_by]);
    }

    public function update($id, $code, $discount_percent, $max_discount, $min_order_value, $expiry_date) {
        $sql = "UPDATE voucher 
                SET code = ?, discount_percent = ?, max_discount = ?, min_order_value = ?, expiry_date = ? 
                WHERE voucher_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$code, $discount_percent, $max_discount, $min_order_value, $expiry_date, $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM voucher WHERE voucher_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function searchVouchers($keyword) {
        try {
            $sql = "SELECT v.*, a.name as admin_name
                    FROM voucher v
                    JOIN admin a ON v.created_by = a.admin_id
                    WHERE v.code LIKE :kw
                    ORDER BY v.expiry_date DESC";
            $stmt = $this->conn->prepare($sql);
            $kw = '%' . $keyword . '%';
            $stmt->bindParam(':kw', $kw);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi tìm kiếm voucher: " . $e->getMessage();
            return [];
        }
    }

}
