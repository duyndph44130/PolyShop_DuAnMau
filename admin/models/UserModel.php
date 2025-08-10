<?php
class UserModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Lấy tất cả user
    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT * FROM user ORDER BY user_id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy user theo ID
    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE user_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tìm user theo email
    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByPhone($phone) {
        $sql = "SELECT * FROM user WHERE phone = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$phone]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    // Tạo user mới (tự hash mật khẩu)
    public function create($name, $email, $password, $phone, $address, $role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("
            INSERT INTO user (name, email, password, phone, address, role)
            VALUES (:name, :email, :password, :phone, :address, :role)
        ");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    // Cập nhật user (tự hash mật khẩu nếu có nhập mới)
    public function update($id, $name, $email, $password, $phone, $address, $role) {
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        } else {
            // Lấy mật khẩu cũ
            $user = $this->getUserById($id);
            $hashedPassword = $user['password'];
        }

        $stmt = $this->conn->prepare("
            UPDATE user 
            SET name = :name, email = :email, password = :password, phone = :phone, 
                address = :address, role = :role
            WHERE user_id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    // Xoá user
    public function delete($id) {
        // 1. Lấy tất cả order_id của user
        $stmt = $this->conn->prepare("SELECT order_id FROM `order` WHERE user_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (!empty($orders)) {
            $inQuery = implode(',', array_fill(0, count($orders), '?'));

            // 2. Xóa orderdetail
            $stmt = $this->conn->prepare("DELETE FROM orderdetail WHERE order_id IN ($inQuery)");
            $stmt->execute($orders);

            // 3. Xóa payment
            $stmt = $this->conn->prepare("DELETE FROM payment WHERE order_id IN ($inQuery)");
            $stmt->execute($orders);

            // 4. Xóa shippinginfo (nếu có)
            $stmt = $this->conn->prepare("DELETE FROM shippinginfo WHERE order_id IN ($inQuery)");
            $stmt->execute($orders);

            // 5. Xóa order
            $stmt = $this->conn->prepare("DELETE FROM `order` WHERE order_id IN ($inQuery)");
            $stmt->execute($orders);
        }

        // 6. Xóa user
        $stmt = $this->conn->prepare("DELETE FROM user WHERE user_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Tìm kiếm user
    public function searchUsers($keyword) {
        $stmt = $this->conn->prepare("
            SELECT * FROM user 
            WHERE name LIKE :kw OR email LIKE :kw
        ");
        $kw = "%" . $keyword . "%";
        $stmt->bindParam(':kw', $kw, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
