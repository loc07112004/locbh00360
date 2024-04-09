<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "btec-student";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Kiểm tra xem có tham số ID được truyền qua URL không
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Lấy thông tin người dùng từ cơ sở dữ liệu dựa trên ID
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy người dùng.";
        exit();
    }
} else {
    echo "Thiếu thông tin người dùng.";
    exit();
}

// Kiểm tra xem người dùng đã nhấn nút "Cập nhật" chưa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $new_fullname = $_POST['fullname'];
    $new_password = $_POST['password'];
    $new_email = $_POST['email'];
    $new_masv = $_POST['masv'] ;


// Mã hóa mật khẩu mới
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Cập nhật thông tin người dùng trong cơ sở dữ liệu
$sql = "UPDATE users SET fullname = '$new_fullname',masv = '$new_masv', password = '$hashed_password', email = '$new_email' WHERE id = $user_id";

if ($conn->query($sql) === TRUE) {
    echo "Cập nhật thông tin thành công!";
} else {
    echo "Lỗi khi cập nhật thông tin: " . $conn->error;
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa thông tin người dùng</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Sửa thông tin người dùng</h1>

    <form method="POST" action="">
        <label for="fullname">Họ và tên:</label>
        <input type="text" name="fullname" value="<?php echo $user['fullname']; ?>"><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" value="<?php echo $user['password']; ?>"><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>"><br>

        <label for="masv">masv:</label>
        <input type="masv" name="masv" value="<?php echo $user['masv']; ?>"><br>

        <input type="submit" value="Cập nhật">
    </form>
    <a class="back-button" href="home_page.php">Quay trở lại trang chủ</a>
</body>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type='text'],
        input[type='password'],
        input[type='email'] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type='submit'] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type='submit']:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ccc;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #999;
        }
    </style>
</html>

<?php
// Đóng kết nối với cơ sở dữ liệu
$conn->close();
?>