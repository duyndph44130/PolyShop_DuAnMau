<?php
class ContactModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function addMessage(string $name, string $email, ?string $phone, string $subject, string $message): bool {
        try {
            $sql = "INSERT INTO contact (name, email, phone, subject, message, status, created_at)
                    VALUES (:name, :email, :phone, :subject, :message, 'new', NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':message', $message);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("ContactModel::addMessage error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllMessages(): array {
        try {
            $sql = "SELECT * FROM contact ORDER BY created_at DESC";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            error_log("ContactModel::getAllMessages error: " . $e->getMessage());
            return [];
        }
    }

    public function markAsRead(int $id): bool {
        try {
            $sql = "UPDATE contact SET status = 'read' WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("ContactModel::markAsRead error: " . $e->getMessage());
            return false;
        }
    }
}
