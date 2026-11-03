<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>nhóm 8</title>
</head>
<body>

<h2>BÀI 5: TOÁN TỬ TRONG PHP</h2>

<?php
$a = 10;
$b = 3;

echo "<h3>1. Toán tử số học</h3>";
echo "a = $a, b = $b <br>";
echo "Cộng: " . ($a + $b) . "<br>";
echo "Trừ: " . ($a - $b) . "<br>";
echo "Nhân: " . ($a * $b) . "<br>";
echo "Chia: " . ($a / $b) . "<br>";
echo "Chia lấy dư: " . ($a % $b) . "<br>";

echo "<h3>2. Toán tử gán</h3>";
$a += 5;
echo "Giá trị a sau khi cộng thêm 5: " . $a . "<br>";

echo "<h3>3. Toán tử so sánh</h3>";
echo "5 == '5': ";
var_dump(5 == "5");
echo "<br>";

echo "5 === '5': ";
var_dump(5 === "5");
echo "<br>";

echo "<h3>4. Toán tử logic</h3>";
echo "10 > 5 và 3 < 5: ";
var_dump(10 > 5 && 3 < 5);
?>

</body>
</html>