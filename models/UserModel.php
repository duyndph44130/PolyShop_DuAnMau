<?php
class UserModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function findByEmail(string $email) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM `user` WHERE email = :email LIMIT 1");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("UserModel::findByEmail error: " . $e->getMessage());
            return null;
        }
    }

    public function findByPhone(string $phone) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM `user` WHERE phone = :phone LIMIT 1");
            $stmt->bindParam(':phone', $phone);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("UserModel::findByPhone error: " . $e->getMessage());
            return null;
        }
    }

    public function create(string $name, string $email, string $password, string $phone, string $address, string $role = 'client'): bool {
        try {
            $sql = "INSERT INTO `user` (name, email, password, phone, address, role, created_at, updated_at)
                    VALUES (:name, :email, :password, :phone, :address, :role, NOW(), NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':role', $role);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("UserModel::create error: " . $e->getMessage());
            return false;
        }
    }

    public function getUserById(int $id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM `user` WHERE user_id = :id LIMIT 1");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("UserModel::getUserById error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Cập nhật thông tin tài khoản
     * Nếu $password trống -> không đổi mật khẩu
     */
    public function updateUser(int $id, string $name, string $email, string $phone, string $address, string $password = null): bool {
        try {
            if (!empty($password)) {
                $sql = "UPDATE `user`
                        SET name = :name, email = :email, phone = :phone, address = :address,
                            password = :password, updated_at = NOW()
                        WHERE user_id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':password', $password);
            } else {
                $sql = "UPDATE `user`
                        SET name = :name, email = :email, phone = :phone, address = :address,
                            updated_at = NOW()
                        WHERE user_id = :id";
                $stmt = $this->conn->prepare($sql);
            }
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("UserModel::updateUser error: " . $e->getMessage());
            return false;
        }
    }
}
