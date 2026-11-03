<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bien</title>
</head>
<body>
    <?php
// Khai báo biến tên đối tượng, số lượng và đơn giá
$ten_san_pham = "Áo mùa đông nam nữ";
$so_luong = 5;
$don_gia = 200000;

// Hiển thị giá trị ban đầu
echo "Sản phẩm: " . $ten_san_pham . "<br>";
echo "Số lượng ban đầu: " . $so_luong . "<br>";
echo "Đơn giá: " . $don_gia . " VNĐ<br><br>";
echo "Tổng tiền tạm tính: " . ($so_luong * $don_gia) . " VNĐ<br>";
// Thay đổi số lượng và in lại
$so_luong = 10;
echo "Số lượng sau khi cập nhật: " . $so_luong . "<br>";
// Nối chuỗi bằng toán tử dấu chấm (.)
echo "Tổng tiền tạm tính: " . ($so_luong * $don_gia) . " VNĐ";
?>
</body>
</html>