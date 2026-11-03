<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nhóm 8</title>
</head>
<body>
    <?php
// Mô phỏng tính tiền mua hàng của nhóm
$ten_mat_hang = "Giáo trình Lập trình ứng dụng Web";
$so_luong =10;
$don_gia = 25000;
const TY_LE_PHI = 0.05; // Phí 5%

// Tính toán với biểu thức có ngoặc rõ ràng
$tien_hang = $so_luong * $don_gia;
$tien_phi = $tien_hang * TY_LE_PHI;
$tong_tien = $tien_hang + $tien_phi;

// Hiển thị kết quả có nhãn
echo "<h2>Hóa Đơn Mua Hàng</h2>";
echo "Mặt hàng: <strong>$ten_mat_hang</strong><br>";
echo "Số lượng: $so_luong<br>";
echo "Đơn giá: " . number_format($don_gia, 0, ',', '.') . " VNĐ<br>";
echo "Tiền hàng: " . number_format($tien_hang, 0, ',', '.') . " VNĐ<br>";
echo "Phí vận hành (5%): " . number_format($tien_phi, 0, ',', '.') . " VNĐ<br>";
echo "<strong>Tổng tiền cần thanh toán: " . number_format($tong_tien, 0, ',', '.') . " VNĐ</strong>";
?>
</body>
</html>