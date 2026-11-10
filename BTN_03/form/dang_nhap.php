<?php
// 1. Khai báo biến ban đầu
$loai_dang_nhap = "email";
$thong_tin_dang_nhap = "";
$mat_khau = "";
$loi = [];             // Mảng chứa các lỗi
$thanh_cong = false;

// 2. Nếu người dùng bấm nút "Đăng nhập" (form gửi bằng POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $loai_dang_nhap = $_POST["loai_dang_nhap"] ?? "email";
    $thong_tin_dang_nhap = trim($_POST["thong_tin_dang_nhap"] ?? "");
    $mat_khau = $_POST["mat_khau"] ?? "";

    // Kiểm tra thông tin đăng nhập theo loại đã chọn
    if ($thong_tin_dang_nhap == "") {
        $loi["thong_tin_dang_nhap"] = "Vui lòng nhập thông tin đăng nhập.";
    } elseif ($loai_dang_nhap == "email" && !filter_var($thong_tin_dang_nhap, FILTER_VALIDATE_EMAIL)) {
        $loi["thong_tin_dang_nhap"] = "Email không đúng định dạng.";
    } elseif ($loai_dang_nhap == "sdt" && !preg_match('/^0\\d{9,10}$/', $thong_tin_dang_nhap)) {
        $loi["thong_tin_dang_nhap"] = "Số điện thoại không hợp lệ.";
    } elseif ($loai_dang_nhap == "ma_sinh_vien" && !preg_match('/^[A-Za-z0-9]+$/', $thong_tin_dang_nhap)) {
        $loi["thong_tin_dang_nhap"] = "Mã sinh viên chỉ được chứa chữ và số.";
    } elseif (!in_array($loai_dang_nhap, ["email", "sdt", "ma_sinh_vien"], true)) {
        $loi["thong_tin_dang_nhap"] = "Vui lòng chọn cách đăng nhập hợp lệ.";
    }

    // Kiểm tra mật khẩu
    if ($mat_khau == "") {
        $loi["mat_khau"] = "Vui lòng nhập mật khẩu.";
    }

    // Không có lỗi nào => thành công
    if (count($loi) == 0) {
        $thanh_cong = true;
    }
}

$nhan_dang_nhap = [
    "email" => "Email",
    "sdt" => "Số điện thoại",
    "ma_sinh_vien" => "Mã sinh viên",
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="khung">

        <?php if ($thanh_cong) { ?>
            <!-- 3a. Hiện kết quả khi đăng nhập thành công -->
            <h1>Đăng nhập thành công</h1>
            <p class="thong-bao-dung">Bạn đã nhập các thông tin sau:</p>
            <table>
                <tr>
                    <th><?php echo htmlspecialchars($nhan_dang_nhap[$loai_dang_nhap]); ?></th>
                    <td><?php echo htmlspecialchars($thong_tin_dang_nhap); ?></td>
                </tr>
                <tr><th>Mật khẩu</th><td><?php echo strlen($mat_khau); ?> ký tự</td></tr>
            </table>
            <a class="nut" href="dang_nhap.php">Quay lại</a>

        <?php } else { ?>
            <!-- 3b. Hiện form (lần đầu vào trang hoặc khi có lỗi) -->
            <h1>Đăng nhập</h1>

            <form method="POST" action="">
                <label for="loai_dang_nhap">Đăng nhập bằng</label>
                <select id="loai_dang_nhap" name="loai_dang_nhap">
                    <?php foreach ($nhan_dang_nhap as $gia_tri => $nhan) { ?>
                        <option value="<?php echo htmlspecialchars($gia_tri); ?>"
                            <?php if ($loai_dang_nhap == $gia_tri) echo "selected"; ?>>
                            <?php echo htmlspecialchars($nhan); ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="thong_tin_dang_nhap">Email / số điện thoại / mã sinh viên</label>
                <input type="text" id="thong_tin_dang_nhap" name="thong_tin_dang_nhap"
                       value="<?php echo htmlspecialchars($thong_tin_dang_nhap); ?>">
                <?php if (isset($loi["thong_tin_dang_nhap"])) { ?>
                    <p class="loi"><?php echo $loi["thong_tin_dang_nhap"]; ?></p>
                <?php } ?>

                <label for="mat_khau">Mật khẩu</label>
                <input type="password" id="mat_khau" name="mat_khau">
                <?php if (isset($loi["mat_khau"])) { ?>
                    <p class="loi"><?php echo $loi["mat_khau"]; ?></p>
                <?php } ?>

                <button type="submit" class="nut">Đăng nhập</button>
            </form>

            <p class="chuyen-trang">Chưa có tài khoản? <a href="dang_ky.php">Đăng ký</a></p>
        <?php } ?>

        <p class="chuyen-trang"><a href="index.php">← Trang chủ</a></p>
    </div>
</body>
</html>
