<?php
class ContactModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Lấy danh sách liên hệ (có thể phân trang, lọc trạng thái nếu cần)
    public function getAllContacts(): array {
        $sql = "SELECT * FROM contact ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    // Lấy chi tiết 1 liên hệ theo id
    public function getContactById(int $id): ?array {
        $sql = "SELECT * FROM contact WHERE contact_id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);
        return $contact ?: null;
    }

    // Cập nhật trạng thái liên hệ (vd: đã xử lý, chờ xử lý)
    public function updateStatus(int $id, string $status): bool {
        $sql = "UPDATE contact SET status = :status WHERE contact_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Xóa liên hệ
    public function deleteContact(int $id): bool {
        $sql = "DELETE FROM contact WHERE contact_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
