<?php
// Start the session
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();

// Hàm mã hóa ID
function encodeId($id) {
    return strtr(base64_encode($id), '+/=', '*&BUYG'); // Thay thế ký tự
}

// Hàm giải mã ID
function decodeId($encodedId) {
    $encodedId = strtr($encodedId, '*&BUYG', '+/='); // Phục hồi ký tự
    return (int)base64_decode($encodedId); // Giải mã và chuyển về số nguyên
}

$user = NULL; // Add new user
$_id = NULL;

if (!empty($_GET['id'])) {
    $_id = decodeId($_GET['id']);
    $user = $userModel->findUserById($_id); // Update existing user
}

$errors = []; // Mảng để lưu các lỗi

if (!empty($_POST['submit'])) {
    // Kiểm tra tên
    if (empty($_POST['name']) || !preg_match('/^[A-Za-z0-9]{5,15}$/', $_POST['name'])) {
        $errors[] = "Name is required and must be 5-15 characters long, containing only letters and numbers.";
    }

    // Kiểm tra mật khẩu
    if (empty($_POST['password']) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[~!@#$%^&*()]).{5,10}$/', $_POST['password'])) {
        $errors[] = "Password is required and must be 5-10 characters long, including at least one lowercase letter, one uppercase letter, one digit, and one special character.";
    }

    // Nếu không có lỗi, thực hiện thao tác chèn hoặc cập nhật
    if (empty($errors)) {
        if (!empty($_id)) {
            $userModel->updateUser($_POST);
        } else {
            $userModel->insertUser($_POST);
        }
        header('location: list_users.php');
        exit; // Ngăn không cho thực thi các mã tiếp theo sau khi chuyển hướng
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User form</title>
    <?php include 'views/meta.php'; ?>
</head>
<body>
    <?php include 'views/header.php'; ?>
    <div class="container">
        <?php if ($user || !isset($_id)) { ?>
            <div class="alert alert-warning" role="alert">
                User form
            </div>
            <?php
            // Hiển thị thông báo lỗi nếu có
            if (!empty($errors)) {
                echo '<div class="alert alert-danger" role="alert">' . implode('<br>', $errors) . '</div>';
            }
            ?>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars(encodeId($_id)); ?>">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" name="name" placeholder="Name"
                        value='<?php if (!empty($user[0]['name'])) echo htmlspecialchars($user[0]['name']); ?>'>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
<input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
            </form>
        <?php } else { ?>
            <div class="alert alert-success" role="alert">
                User not found!
            </div>
        <?php } ?>
    </div>
</body>
</html>