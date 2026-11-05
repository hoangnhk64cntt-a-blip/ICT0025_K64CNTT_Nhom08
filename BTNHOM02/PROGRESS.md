# Họ và tên
1 - Nguyễn Huy Hoàng 
2 - Hà Duy Long 
3 - Nittakone Sanathisarn
4 - Say Pha Un A Nan

# Phân công và đóng góp
Nhiệm vụ 1 : Hoàng và Sayfa cùng thảo luận trả lời
Nhiệm vụ 2 : Long và Nittakone cùng thảo luận và làm bài
Nhiệm vụ 3 : Cả nhóm cùng làm bài

# Kết quả thảo luận 

# Bảng kiểm thử và khó khăn hoặc lỗi còn tồn tại
# Nhiệm vụ 1
- Thưa thầy nhóm em xin trả lời các câu hỏi sau ạ :
Ví dụ A : Sau khi dự đoán nhóm em có kết quả là Cần cố gắng – Khá – Giỏi .Sau khi chạy kết quả bọn em nhận lại giống với khi dự đoán khi ghi điểm là 6,5 chương trình đánh giá sai ở điền kiện >=8 và chương trình chạy tiếp lọt vào nhánh điều kiện >=6,5 nên in ra kết quả là khá.\

Ví dụ B : Nhóm em dự đoán khi thử trạng thái 1,2,9 thì in ra kết quả lần lượt là Mới tạo - Đang xử lý - Không xác định và sau khi chạy bọn em thu được kết quả như lúc dự đoán, vai trò của nhánh default là xử lý các trường hợp nàm ngoài dự tính và khi ta bỏ break sau case 2 sẽ in ra kết quả là Đang xử lý và Không xác định .

Ví dụ C : Nhóm em dự đoán dãy số in ra là (1-2-3-4-5) ,số lần lặp là 5 lần và giá trị cuối $i=6 vì $i++, sau khi chạy nhóm em thu được kết quả giống với ban đầu. Sau khi đổi dấu từ <= 5 thành < 5 nhóm em thấy số lần lặp còn 4 lần và in ra (1-2-3-4) thay vì (1-2-3-4-5) như ban đầu và giá trị cuối $i=5 vì $i nhỏ hơn 5.

Ví dụ D : Nhóm em dự đoán dãy số in ra là (7-4-1-(-2)) và lặp 4 lần với giá trị $n= -2. Sau khi chạy nhóm em thấy có 4 lần lặp và giá trị cuối của $n = -2 , sau khi đổi thành n + 3 vòng lặp không dừng lại vì điều kiện n > 0 vẫn đúng nên vẫn thực hiện vòng lặp .

# Nhiệm vụ 2
-1.Kết quả chạy của 2 cách đều nhận về kết quả giống nhau :
+Khi ta dùng If/elseif/else in ra khi nhập trạng thái 1-2-9 lần lượt là Mới tạo - Đang xử lý - Không xác định.
+Khi ta dùng Switch in ra khi nhập trạng thái 1-2-9 lần lượt là Mới tạo - Đang xử lý - Không xác định.
-2.Vai trò của break
+`break` dùng để kết thúc case đang chạy.

# Nhiệm vụ 3 
-Kết quả sau khi chạy và in ra 
| Số lượng | For    | While  |
| 0        | 0 dòng | 0 dòng |
| 1        | 1 dòng | 1 dòng |
| 5        | 5 dòng | 5 dòng |

-Giải thích while
- giá trị khởi tạo: $i = 1.
- điều kiện tiếp tục: $i <= $soLuong.
- Bước tăng: $i++.
- Vòng lặp dùng khi i lớn hơn $soLuong.

-Kết luận
For va while cho kết quả giống nhau.
