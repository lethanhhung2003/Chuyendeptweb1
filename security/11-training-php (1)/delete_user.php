<?php
session_start();

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    die("Bạn cần đăng nhập để thực hiện hành động này.");
}

// Kiểm tra nếu có yêu cầu xóa từ form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Yêu cầu không hợp lệ.");
    }

    // Lấy ID người dùng từ form
    $user_id = $_POST['user_id'];
    $current_user_id = $_SESSION['user_id']; // ID của người dùng đang đăng nhập

    // Kiểm tra xem người dùng có quyền xóa không
    if ($current_user_id == $user_id) {
        // Kết nối đến cơ sở dữ liệu (giả sử bạn đã có kết nối)
        // Thay thế với mã kết nối của bạn
        $db = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');

        // Thực hiện xóa người dùng
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);

        echo "Người dùng đã được xóa.";
    } else {
        die("Bạn không có quyền xóa người dùng này.");
    }
} else {
    die("Yêu cầu không hợp lệ.");
}
?>