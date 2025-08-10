<?php
class VoucherModel
{
    protected $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    /**
     * Lấy voucher áp dụng cho sản phẩm cụ thể nếu đang còn hạn sử dụng
     */
    public function getVoucherForProduct($productId)
    {
        try {
            $sql = "SELECT * FROM voucher 
                    WHERE (product_id = :pid OR product_id IS NULL)
                    AND start_date <= CURDATE()
                    AND end_date >= CURDATE()
                    ORDER BY discount_value DESC
                    LIMIT 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':pid', $productId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi khi lấy voucher: " . $e->getMessage();
            return null;
        }
    }

    /**
     * (Tuỳ chọn) Lấy tất cả các voucher đang hoạt động
     */
    public function getAllActiveVouchers()
    {
        try {
            $sql = "SELECT * FROM voucher WHERE NOW() BETWEEN start_date AND end_date ORDER BY start_date DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi khi lấy danh sách voucher: " . $e->getMessage();
            return [];
        }
    }
}
