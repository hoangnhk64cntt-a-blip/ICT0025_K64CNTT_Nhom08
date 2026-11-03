<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hang</title>
</head>
<body>
   <?php
// Khai báo hằng số bằng const và define
const DON_VI_TIEN_TE = "VNĐ";
define("TY_LE_THUE_VAT", 0.1); // Thuế VAT 10%

$gia_tri_don_hang = 500000;
$tien_thue = $gia_tri_don_hang * TY_LE_THUE_VAT;
$tong_tien = $gia_tri_don_hang + $tien_thue;

// Sử dụng hằng số cùng biến trong hiển thị
echo "Giá trị đơn hàng: " . $gia_tri_don_hang . " " . DON_VI_TIEN_TE . "<br>";
echo "Thuế VAT (10%): " . $tien_thue . " " . DON_VI_TIEN_TE . "<br>";
echo "Tổng thanh toán: " . $tong_tien . " " . DON_VI_TIEN_TE;
?>
</body>
</html>