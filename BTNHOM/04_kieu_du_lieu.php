<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kieu du lieu</title>
</head>
<body>
    <?php
// Khởi tạo các biến với các kiểu dữ liệu khác nhau
$chuoi = " Xin Chào"; // String
$so_nguyen = 2026; // Integer
$so_thuc = 8.88; // Float
$logic = true; // Boolean
$rong = null; // NULL

// Sử dụng var_dump để xem kiểu và giá trị
echo "<strong>Kiểu dữ liệu ban đầu:</strong><br>";
var_dump($chuoi); echo "<br>";
var_dump($so_nguyen); echo "<br>";
var_dump($so_thuc); echo "<br>";
var_dump($logic); echo "<br>";
var_dump($rong); echo "<br><br>";

// Ép kiểu chuỗi số sang số nguyên
$chuoi_so = "12";
$ep_kieu = (int)$chuoi_so;

echo "<strong>Sau khi ép kiểu:</strong><br>";
echo "Biến gốc: "; var_dump($chuoi_so); echo "<br>";
echo "Biến sau khi ép kiểu: "; var_dump($ep_kieu);
?>
</body>
</html>