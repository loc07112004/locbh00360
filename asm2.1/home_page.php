<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        a.logout {
            float: right;
            margin-top: -40px;
            color: #4CAF50;
            text-decoration: none;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            padding: 5px;
        }

        input[type="submit"] {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Thông tin học sinh</h1>
    <a class="logout" href="signin_page.php">Đăng xuất</a>

    <?php
    // Kết nối tới cơ sở dữ liệu
    $conn = mysqli_connect('localhost', 'root', '', 'btec-student');

    // Kiểm tra kết nối
    if (!$conn) {
        die('Không thể kết nối tới cơ sở dữ liệu: ' . mysqli_connect_error());
    }

    // Xử lý thao tác thêm
    if (isset($_POST['add'])) {
        $fullname = $_POST['fullname'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $masv= $_POST['masv'];


        // Mã hóa mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (fullname, password, masv,email) VALUES ('$fullname', '$hashedPassword', '$masv','$email')";
        if (mysqli_query($conn, $query)) {
            echo "Học sinh đã được thêm thành công.";
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }
    }

 // Xử lý thao tác sửa
 if (isset($_POST['edit'])) {
    $user_id = $_POST['user_id'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $masv= $_POST['masv'];

    // Mã hóa mật khẩu
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET fullname='$fullname', password='$hashedPassword',masv='$masv', email='$email' WHERE id=$user_id";
    if (mysqli_query($conn, $query)) {
        echo "Thông tin học sinh đã được cập nhật thành công.";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}

    // Xử lý thao tác xóa
    if (isset($_GET['delete'])) {
        $user_id = $_GET['delete'];

        $query = "DELETE FROM users WHERE id=$user_id";
        if (mysqli_query($conn, $query)) {
            echo "Học sinh đã được xóa thành công.";
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }
    }
    // Truy vấn dữ liệu từ bảng 'users'
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);
    ?>

    <form method="POST" action="">
        <input type="text" name="fullname" placeholder="Họ tên" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="masv" name="masv" placeholder="masv" required>

        <input type="submit" name="add" value="Thêm">
    </form>

    <table>
        <tr>
            <th>id</th>
            <th>fullname</th>
            <th>password</th>
            <th>email</th>
            <th>masv</th>
        </tr>
        <?php
        // Kiểm tra và hiển thị dữ liệu
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['fullname'] . "</td>";
                echo "<td>" . $row['password'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['masv'] . "</td>";
                echo "<td>";
                echo "<a href='edit.php?id=" . $row['id'] . "'>Sửa</a> | ";
                echo "<a href='?delete=" . $row['id'] . "'>Xóa</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Không có học sinh nào.</td></tr>";
        }
        ?>
    </table>
</body>
</html>