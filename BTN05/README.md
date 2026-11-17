# Thành viên và nhiệm vụ
1.Nguyễn Huy Hoàng — Xử lý giao dịch
   - Rà soát xử lý form trong `index.php`: kiểm tra danh mục, số tiền, phạm vi Cá nhân/Gia đình.
   - Dùng PDO `prepare` để lưu giao dịch; hiển thị thông báo thành công hoặc lỗi.
   - Kiểm thử: bỏ trống danh mục/số tiền và nhập số tiền bằng 0 hoặc âm; các trường hợp không hợp lệ không được lưu.

2.Hà Duy Long — Cơ sở dữ liệu
   - Kiểm tra schema, khóa ngoại và cột `doi_tuong` trong `giaodich.sql`.
   - Kiểm tra các danh mục Ăn uống, Mua đồ, Chi tiêu cá nhân và ví mặc định.
   - Kiểm thử: chọn từng danh mục và xác nhận giao dịch được lưu; kiểm tra trường hợp chưa có ví.

3.Nittakone — Giao diện
   - Rà soát form và giao diện responsive trong `style.css`.
   - Kiểm tra cách chọn danh mục, số tiền, phạm vi Cá nhân/Gia đình và ghi chú.
   - Kiểm thử giao diện trên màn hình máy tính và điện thoại.

4.Sayfa — Lịch sử và kiểm thử tích hợp
   - Rà soát truy vấn `SELECT`/`JOIN`, cách hiển thị thu/chi, thời gian và ghi chú trong `index.php`.
   - Kiểm tra `htmlspecialchars` cho dữ liệu hiển thị và trạng thái chưa có giao dịch.
   - Chạy lại luồng từ nhập giao dịch đến hiển thị lịch sử; ghi kết quả thực tế và lỗi nếu có.

## Ca kiểm thử chung
| Mã | Dữ liệu / thao tác | Kết quả mong đợi |
|---|---|---|
| TC01 | Chọn **Ăn uống**, nhập `5000`, chọn **Cá nhân** | Lưu thành công; lịch sử hiện khoản chi `-5.000 đ` và phạm vi Cá nhân. |
| TC02 | Bỏ trống danh mục hoặc số tiền | Hiện thông báo lỗi; không thêm giao dịch. |
| TC03 | Nhập số tiền `0` hoặc số âm | Hiện thông báo lỗi; không thêm giao dịch. |
| TC04 | Chọn **Mua đồ**, nhập số tiền hợp lệ, chọn **Gia đình** | Lưu thành công; lịch sử hiện phạm vi Gia đình. |
| TC05 | Nhập ghi chú `<script>alert(1)</script>` | Ghi chú được hiển thị như văn bản, không thực thi mã. |
| TC06 | Mở trang khi chưa có giao dịch | Hiện trạng thái “Chưa có giao dịch nào”. |

Mỗi thành viên ghi lại **dữ liệu đầu vào**, **kết quả mong đợi**, **kết quả thực tế** và **đạt/không đạt** khi kiểm thử.
