<?php
class VoucherModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getVoucherByCode($code)
    {
        $sql = "SELECT * FROM voucher WHERE name = :code AND NOW() BETWEEN start_date AND end_date";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getVoucherForProduct($product_id)
    {
        $sql = "SELECT * FROM voucher WHERE (product_id IS NULL OR product_id = :product_id) AND NOW() BETWEEN start_date AND end_date";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByName($name)
    {
        $sql = "SELECT * FROM voucher WHERE name = :name";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
