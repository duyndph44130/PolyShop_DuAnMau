<?php
class UserModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAllUsers() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM user");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    public function getUserById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE user_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($name, $email, $password, $phone, $address, $role) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO user (name, email, password, phone, address, role)
                VALUES (:name, :email, :password, :phone, :address, :role)
            ");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password); // Không mã hóa
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':role', $role);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi thêm người dùng: " . $e->getMessage();
            return false;
        }
    }

    public function update($id, $name, $email, $password, $phone, $address, $role) {
        try {
            $stmt = $this->conn->prepare("
                UPDATE user SET name = :name, email = :email, password = :password,
                    phone = :phone, address = :address, role = :role WHERE user_id = :id
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password); // Không mã hóa
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':role', $role);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi cập nhật người dùng: " . $e->getMessage();
            return false;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM user WHERE user_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi xoá người dùng: " . $e->getMessage();
            return false;
        }
    }

public function searchUsers($keyword) {
    try {
        $sql = "SELECT * FROM user 
                WHERE name LIKE :kw OR email LIKE :kw";
        $stmt = $this->conn->prepare($sql);
        $kw = '%' . $keyword . '%';
        $stmt->bindParam(':kw', $kw);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Lỗi tìm kiếm: " . $e->getMessage();
        return [];
    }
}


}
