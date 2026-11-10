<?php
// 1. Khai báo biến ban đầu
$ho_ten = "";
$email = "";
$gioi_tinh = "Nam";
$ngay_sinh = "";
$ma_sinh_vien = "";
$sdt = "";
$mat_khau = "";
$loi = [];             // Mảng chứa các lỗi
$thanh_cong = false;

// 2. Nếu người dùng bấm nút "Đăng ký" (form gửi bằng POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $ho_ten = trim($_POST["ho_ten"]);
    $email = trim($_POST["email"]);
    $gioi_tinh = $_POST["gioi_tinh"];
    $ngay_sinh = $_POST["ngay_sinh"] ?? "";
    $ma_sinh_vien = trim($_POST["ma_sinh_vien"] ?? "");
    $sdt = trim($_POST["sdt"] ?? "");
    $mat_khau = $_POST["mat_khau"];
    $nhap_lai = $_POST["nhap_lai"];

    // Kiểm tra họ tên
    if ($ho_ten == "") {
        $loi["ho_ten"] = "Vui lòng nhập họ tên.";
    }

    // Kiểm tra email
    if ($email == "") {
        $loi["email"] = "Vui lòng nhập email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $loi["email"] = "Email không đúng định dạng.";
    }

    // Kiểm tra ngày sinh
    if ($ngay_sinh == "") {
        $loi["ngay_sinh"] = "Vui lòng chọn ngày tháng năm sinh.";
    }

    // Kiểm tra mã sinh viên
    if ($ma_sinh_vien == "") {
        $loi["ma_sinh_vien"] = "Vui lòng nhập mã sinh viên.";
    } elseif (!preg_match('/^[A-Za-z0-9]+$/', $ma_sinh_vien)) {
        $loi["ma_sinh_vien"] = "Mã sinh viên chỉ được chứa chữ và số.";
    }

    // Kiểm tra số điện thoại
    if ($sdt == "") {
        $loi["sdt"] = "Vui lòng nhập số điện thoại.";
    } elseif (!preg_match('/^0\d{9,10}$/', $sdt)) {
        $loi["sdt"] = "Số điện thoại không hợp lệ.";
    }

    // Kiểm tra mật khẩu: ít nhất 6 ký tự
    if (strlen($mat_khau) < 6) {
        $loi["mat_khau"] = "Mật khẩu phải có ít nhất 6 ký tự.";
    }

    // Kiểm tra nhập lại mật khẩu
    if ($nhap_lai != $mat_khau) {
        $loi["nhap_lai"] = "Mật khẩu nhập lại không khớp.";
    }

    // Không có lỗi nào => thành công
    if (count($loi) == 0) {
        $thanh_cong = true;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="khung">

        <?php if ($thanh_cong) { ?>
            <!-- 3a. Hiện kết quả khi đăng ký thành công -->
            <h1>Đăng ký thành công</h1>
            <p class="thong-bao-dung">
                Xin chào <b><?php echo htmlspecialchars($ho_ten); ?></b>, bạn đã nhập các thông tin sau:
            </p>
            <table>
                <tr><th>Họ tên</th><td><?php echo htmlspecialchars($ho_ten); ?></td></tr>
                <tr><th>Email</th><td><?php echo htmlspecialchars($email); ?></td></tr>
                <tr><th>Ngày sinh</th><td><?php echo htmlspecialchars($ngay_sinh); ?></td></tr>
                <tr><th>Mã sinh viên</th><td><?php echo htmlspecialchars($ma_sinh_vien); ?></td></tr>
                <tr><th>Số điện thoại</th><td><?php echo htmlspecialchars($sdt); ?></td></tr>
                <tr><th>Giới tính</th><td><?php echo htmlspecialchars($gioi_tinh); ?></td></tr>
                <tr><th>Mật khẩu</th><td><?php echo strlen($mat_khau); ?> ký tự</td></tr>
            </table>
            <a class="nut" href="dang_nhap.php">Đến trang đăng nhập</a>

        <?php } else { ?>
            <!-- 3b. Hiện form (lần đầu vào trang hoặc khi có lỗi) -->
            <h1>Đăng ký</h1>

            <form method="POST" action="">
                <label for="ho_ten">Họ tên</label>
                <input type="text" id="ho_ten" name="ho_ten"
                       value="<?php echo htmlspecialchars($ho_ten); ?>">
                <?php if (isset($loi["ho_ten"])) { ?>
                    <p class="loi"><?php echo $loi["ho_ten"]; ?></p>
                <?php } ?>

                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="<?php echo htmlspecialchars($email); ?>">
                <?php if (isset($loi["email"])) { ?>
                    <p class="loi"><?php echo $loi["email"]; ?></p>
                <?php } ?>

                <label for="ngay_sinh">Ngày tháng năm sinh</label>
                <input type="date" id="ngay_sinh" name="ngay_sinh"
                       value="<?php echo htmlspecialchars($ngay_sinh); ?>">
                <?php if (isset($loi["ngay_sinh"])) { ?>
                    <p class="loi"><?php echo $loi["ngay_sinh"]; ?></p>
                <?php } ?>

                <label for="ma_sinh_vien">Mã sinh viên</label>
                <input type="text" id="ma_sinh_vien" name="ma_sinh_vien"
                       value="<?php echo htmlspecialchars($ma_sinh_vien); ?>">
                <?php if (isset($loi["ma_sinh_vien"])) { ?>
                    <p class="loi"><?php echo $loi["ma_sinh_vien"]; ?></p>
                <?php } ?>

                <label for="sdt">Số điện thoại</label>
                <input type="text" id="sdt" name="sdt"
                       value="<?php echo htmlspecialchars($sdt); ?>">
                <?php if (isset($loi["sdt"])) { ?>
                    <p class="loi"><?php echo $loi["sdt"]; ?></p>
                <?php } ?>

                <label>Giới tính</label>
                <div class="lua-chon">
                    <label>
                        <input type="radio" name="gioi_tinh" value="Nam"
                            <?php if ($gioi_tinh == "Nam") echo "checked"; ?>> Nam
                    </label>
                    <label>
                        <input type="radio" name="gioi_tinh" value="Nữ"
                            <?php if ($gioi_tinh == "Nữ") echo "checked"; ?>> Nữ
                    </label>
                </div>

                <label for="mat_khau">Mật khẩu</label>
                <input type="password" id="mat_khau" name="mat_khau">
                <?php if (isset($loi["mat_khau"])) { ?>
                    <p class="loi"><?php echo $loi["mat_khau"]; ?></p>
                <?php } ?>

                <label for="nhap_lai">Nhập lại mật khẩu</label>
                <input type="password" id="nhap_lai" name="nhap_lai">
                <?php if (isset($loi["nhap_lai"])) { ?>
                    <p class="loi"><?php echo $loi["nhap_lai"]; ?></p>
                <?php } ?>

                <button type="submit" class="nut">Đăng ký</button>
            </form>

            <p class="chuyen-trang">Đã có tài khoản? <a href="dang_nhap.php">Đăng nhập</a></p>
        <?php } ?>

        <p class="chuyen-trang"><a href="index.php">← Trang chủ</a></p>
    </div>
</body>
</html>
