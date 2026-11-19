<?php
$host = '127.0.0.1';
$port = 3307;
$dbname = 'chi_tieu';
$username = 'root';
$password = '';

try {
    $conn = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}

$thong_bao = '';
$loai_thong_bao = '';
$form_data = [
    'danh_muc_id' => '',
    'so_tien' => '',
    'doi_tuong' => 'ca_nhan',
    'ghi_chu' => ''
];
$edit_id = null;
$edit_mode = false;

// Xử lý các hành động: xóa (vào thùng rác), khôi phục
$action = $_GET['action'] ?? '';
$id_action = $_GET['id'] ?? null;
$view = $_GET['view'] ?? 'main'; // 'main' (mặc định) hoặc 'trash' (thùng rác)

if ($action === 'delete' && $id_action) {
    $stmt = $conn->prepare("UPDATE giaodich SET deleted_at = CURRENT_TIMESTAMP WHERE id = :id");
    $stmt->execute([':id' => $id_action]);
    header("Location: index.php");
    exit;
}

if ($action === 'restore' && $id_action) {
    $stmt = $conn->prepare("UPDATE giaodich SET deleted_at = NULL WHERE id = :id");
    $stmt->execute([':id' => $id_action]);
    header("Location: index.php?view=trash");
    exit;
}

// Xử lý khi nhấn nút Sửa
if ($action === 'edit' && $id_action) {
    $stmt = $conn->prepare("SELECT * FROM giaodich WHERE id = :id AND deleted_at IS NULL");
    $stmt->execute([':id' => $id_action]);
    $gd_edit = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($gd_edit) {
        $edit_mode = true;
        $edit_id = $gd_edit['id'];
        $form_data = [
            'danh_muc_id' => $gd_edit['danh_muc_id'],
            'so_tien' => $gd_edit['so_tien'],
            'doi_tuong' => $gd_edit['doi_tuong'],
            'ghi_chu' => $gd_edit['ghi_chu']
        ];
    }
}

$stmt_dm = $conn->query("SELECT id, ten_danh_muc, loai FROM danhmuc ORDER BY id");
$danh_sach_dm = $stmt_dm->fetchAll(PDO::FETCH_ASSOC);
$danh_muc_ids = array_map('strval', array_column($danh_sach_dm, 'id'));

$stmt_vi = $conn->query("SELECT id FROM vi_tien ORDER BY id ASC LIMIT 1");
$vi_tien_id = $stmt_vi->fetchColumn();

// Xử lý thêm mới hoặc cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_luu'])) {
    foreach (['danh_muc_id', 'so_tien', 'doi_tuong', 'ghi_chu'] as $field) {
        if (isset($_POST[$field]) && is_string($_POST[$field])) {
            $form_data[$field] = trim($_POST[$field]);
        }
    }
    
    $post_edit_id = $_POST['edit_id'] ?? '';

    if ($form_data['danh_muc_id'] === '' || $form_data['so_tien'] === '') {
        $thong_bao = 'Vui lòng chọn danh mục và nhập số tiền.';
        $loai_thong_bao = 'error';
    } elseif (!in_array($form_data['danh_muc_id'], $danh_muc_ids, true)) {
        $thong_bao = 'Danh mục không hợp lệ. Vui lòng chọn lại.';
        $loai_thong_bao = 'error';
    } elseif (!is_numeric($form_data['so_tien']) || (float) $form_data['so_tien'] <= 0) {
        $thong_bao = 'Số tiền phải là số lớn hơn 0.';
        $loai_thong_bao = 'error';
    } elseif (!in_array($form_data['doi_tuong'], ['ca_nhan', 'gia_dinh'], true)) {
        $thong_bao = 'Vui lòng chọn phạm vi cá nhân hoặc gia đình.';
        $loai_thong_bao = 'error';
    } elseif ($vi_tien_id === false) {
        $thong_bao = 'Chưa có ví tiền để ghi nhận giao dịch. Vui lòng tạo ví trước.';
        $loai_thong_bao = 'error';
    } else {
        try {
            if ($post_edit_id !== '') {
                // Cập nhật giao dịch đã có
                $sql_update = "UPDATE giaodich 
                               SET danh_muc_id = :dm_id, doi_tuong = :doi_tuong, so_tien = :tien, ghi_chu = :ghi_chu 
                               WHERE id = :id";
                $stmt = $conn->prepare($sql_update);
                $stmt->execute([
                    ':dm_id' => $form_data['danh_muc_id'],
                    ':doi_tuong' => $form_data['doi_tuong'],
                    ':tien' => $form_data['so_tien'],
                    ':ghi_chu' => $form_data['ghi_chu'],
                    ':id' => $post_edit_id
                ]);
                $thong_bao = 'Đã cập nhật giao dịch thành công.';
                $loai_thong_bao = 'success';
                // Reset form sau khi cập nhật
                $edit_mode = false;
                $edit_id = null;
                $form_data = ['danh_muc_id' => '', 'so_tien' => '', 'doi_tuong' => 'ca_nhan', 'ghi_chu' => ''];
            } else {
                // Thêm mới giao dịch
                $sql_insert = "INSERT INTO giaodich
                               (vi_tien_id, danh_muc_id, doi_tuong, so_tien, ngay_giao_dich, ghi_chu)
                               VALUES (:vi_id, :dm_id, :doi_tuong, :tien, CURRENT_DATE, :ghi_chu)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->execute([
                    ':vi_id' => $vi_tien_id,
                    ':dm_id' => $form_data['danh_muc_id'],
                    ':doi_tuong' => $form_data['doi_tuong'],
                    ':tien' => $form_data['so_tien'],
                    ':ghi_chu' => $form_data['ghi_chu']
                ]);
                $thong_bao = 'Đã lưu giao dịch thành công.';
                $loai_thong_bao = 'success';
                // Reset form sau khi thêm mới
                $form_data = ['danh_muc_id' => '', 'so_tien' => '', 'doi_tuong' => 'ca_nhan', 'ghi_chu' => ''];
            }
        } catch (PDOException $e) {
            $thong_bao = 'Không thể lưu giao dịch. Lỗi: ' . $e->getMessage();
            $loai_thong_bao = 'error';
        }
    }
}

// Lấy danh sách giao dịch (Tùy thuộc vào đang ở chế độ xem Thùng rác hay Bình thường)
$where_condition = $view === 'trash' ? "gd.deleted_at IS NOT NULL" : "gd.deleted_at IS NULL";

$sql_select = "SELECT gd.id, gd.so_tien, gd.ghi_chu, gd.created_at, gd.doi_tuong,
                      dm.ten_danh_muc, dm.loai
               FROM giaodich gd
               JOIN danhmuc dm ON gd.danh_muc_id = dm.id
               WHERE $where_condition
               ORDER BY gd.id DESC";
$stmt_select = $conn->query($sql_select);
$lich_su = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f7fb">
    <title>Sổ thu chi</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Thêm một chút CSS cho các nút hành động */
        .action-links a { margin-right: 10px; text-decoration: none; font-size: 14px; }
        .action-links a.edit { color: #007bff; }
        .action-links a.delete { color: #dc3545; }
        .action-links a.restore { color: #28a745; }
        .header-actions { float: right; }
        .header-actions a { padding: 5px 10px; background: #eee; border-radius: 4px; text-decoration: none; color: #333;}
    </style>
</head>
<body>
    <div class="page-shell">
        <header class="topbar">
            <a class="brand" href="index.php">
                <span class="brand-mark" aria-hidden="true">S</span>
                <span>Sổ thu chi</span>
            </a>
            <span class="topbar-note">Quản lý tài chính cá nhân</span>
        </header>

        <main>
            <section class="page-heading">
                <div>
                    <p class="eyebrow">TỔNG QUAN</p>
                    <h1><?= $view === 'trash' ? 'Thùng rác' : 'Ghi chép giao dịch' ?></h1>
                    <p class="subtitle"><?= $view === 'trash' ? 'Các giao dịch đã bị xóa.' : 'Theo dõi các khoản thu và chi của bạn trong một nơi.' ?></p>
                </div>
                <span class="today-chip"><?= date('d/m/Y') ?></span>
            </section>

            <?php if ($thong_bao !== ''): ?>
                <div class="notice notice-<?= htmlspecialchars($loai_thong_bao, ENT_QUOTES, 'UTF-8') ?>" role="status">
                    <span class="notice-icon" aria-hidden="true"><?= $loai_thong_bao === 'success' ? '✓' : '!' ?></span>
                    <?= htmlspecialchars($thong_bao, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <div class="content-grid">
                <?php if ($view !== 'trash'): ?>
                <section class="card form-card">
                    <div class="card-heading">
                        <div class="heading-icon" aria-hidden="true"><?= $edit_mode ? '✎' : '+' ?></div>
                        <div>
                            <h2><?= $edit_mode ? 'Sửa giao dịch' : 'Thêm giao dịch' ?></h2>
                            <p><?= $edit_mode ? 'Cập nhật lại thông tin giao dịch.' : 'Điền thông tin cho khoản thu hoặc chi mới.' ?></p>
                        </div>
                    </div>

                    <?php if (count($danh_sach_dm) === 0): ?>
                        <div class="notice notice-error" role="status">Chưa có danh mục. Vui lòng thêm danh mục vào cơ sở dữ liệu trước.</div>
                    <?php endif; ?>

                    <form method="POST" action="index.php">
                        <!-- Input ẩn để lưu ID khi sửa -->
                        <input type="hidden" name="edit_id" value="<?= htmlspecialchars((string)$edit_id, ENT_QUOTES, 'UTF-8') ?>">
                        
                        <div class="field">
                            <label for="danh_muc_id">Danh mục <span>*</span></label>
                            <select id="danh_muc_id" name="danh_muc_id" required>
                                <option value="">Chọn danh mục</option>
                                <?php foreach ($danh_sach_dm as $dm): ?>
                                    <option value="<?= htmlspecialchars((string) $dm['id'], ENT_QUOTES, 'UTF-8') ?>"
                                        <?= $form_data['danh_muc_id'] === (string) $dm['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($dm['ten_danh_muc'], ENT_QUOTES, 'UTF-8') ?>
                                        · <?= strtoupper(htmlspecialchars($dm['loai'], ENT_QUOTES, 'UTF-8')) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="field">
                            <label for="so_tien">Số tiền <span>*</span></label>
                            <div class="amount-input">
                                <input id="so_tien" type="number" name="so_tien" min="1" step="any"
                                       placeholder="Ví dụ: 50000"
                                       value="<?= htmlspecialchars($form_data['so_tien'], ENT_QUOTES, 'UTF-8') ?>" required>
                                <span>VND</span>
                            </div>
                        </div>

                        <fieldset class="field scope-field">
                            <legend>Phạm vi giao dịch <span>*</span></legend>
                            <div class="scope-options">
                                <label class="scope-option">
                                    <input type="radio" name="doi_tuong" value="ca_nhan"
                                        <?= $form_data['doi_tuong'] === 'ca_nhan' ? 'checked' : '' ?>>
                                    <span class="scope-icon" aria-hidden="true">C</span>
                                    <span class="scope-label">Cá nhân</span>
                                </label>
                                <label class="scope-option">
                                    <input type="radio" name="doi_tuong" value="gia_dinh"
                                        <?= $form_data['doi_tuong'] === 'gia_dinh' ? 'checked' : '' ?>>
                                    <span class="scope-icon" aria-hidden="true">G</span>
                                    <span class="scope-label">Gia đình</span>
                                </label>
                            </div>
                        </fieldset>

                        <div class="field">
                            <label for="ghi_chu">Ghi chú <small>Không bắt buộc</small></label>
                            <input id="ghi_chu" type="text" name="ghi_chu" placeholder="Ví dụ: Ăn sáng"
                                   value="<?= htmlspecialchars($form_data['ghi_chu'], ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div style="display: flex; gap: 10px;">
                            <button class="submit-button" type="submit" name="btn_luu">
                                <span aria-hidden="true"><?= $edit_mode ? '✎' : '＋' ?></span> 
                                <?= $edit_mode ? 'Cập nhật' : 'Lưu giao dịch' ?>
                            </button>
                            <?php if ($edit_mode): ?>
                                <a href="index.php" class="submit-button" style="background:#6c757d; text-align:center; text-decoration:none;">Hủy sửa</a>
                            <?php endif; ?>
                        </div>
                        <p class="form-footnote">Các trường có dấu * là bắt buộc.</p>
                    </form>
                </section>
                <?php endif; ?>

                <section class="card history-card" <?= $view === 'trash' ? 'style="grid-column: 1 / -1;"' : '' ?>>
                    <div class="history-heading">
                        <div>
                            <h2>Lịch sử giao dịch</h2>
                            <p>Các khoản thu chi của bạn.</p>
                        </div>
                        <div class="header-actions">
                            <?php if ($view === 'main'): ?>
                                <a href="?view=trash">🗑 Thùng rác</a>
                            <?php else: ?>
                                <a href="index.php">⬅ Trở về</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (count($lich_su) > 0): ?>
                        <div class="table-scroll">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Ngày</th>
                                        <th>Danh mục</th>
                                        <th>Phạm vi</th>
                                        <th>Số tiền</th>
                                        <th>Ghi chú</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lich_su as $row): ?>
                                        <?php
                                        $is_income = $row['loai'] === 'thu';
                                        $css_class = $is_income ? 'thu' : 'chi';
                                        $dau = $is_income ? '+' : '-';
                                        $is_family = $row['doi_tuong'] === 'gia_dinh';
                                        ?>
                                        <tr>
                                            <td class="date-cell"><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                            <td><span class="category-name"><?= htmlspecialchars($row['ten_danh_muc'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                            <td>
                                                <span class="scope-chip <?= $is_family ? 'scope-family' : 'scope-personal' ?>">
                                                    <?= $is_family ? 'Gia đình' : 'Cá nhân' ?>
                                                </span>
                                            </td>
                                            <td class="amount-cell <?= $css_class ?>">
                                                <?= $dau . number_format($row['so_tien'], 0, ',', '.') ?> đ
                                            </td>
                                            <td class="note-cell">
                                                <?php if (trim($row['ghi_chu'] ?? '') !== ''): ?>
                                                    <?= htmlspecialchars($row['ghi_chu'], ENT_QUOTES, 'UTF-8') ?>
                                                <?php else: ?>
                                                    <span class="muted">—</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="action-links">
                                                <?php if ($view === 'main'): ?>
                                                    <a class="edit" href="?action=edit&id=<?= $row['id'] ?>">Sửa</a>
                                                    <a class="delete" href="?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Bạn có chắc muốn chuyển giao dịch này vào thùng rác?');">Xóa</a>
                                                <?php else: ?>
                                                    <a class="restore" href="?action=restore&id=<?= $row['id'] ?>">Khôi phục</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-icon" aria-hidden="true">₫</div>
                            <h3>Chưa có giao dịch nào</h3>
                            <p><?= $view === 'trash' ? 'Thùng rác trống.' : 'Giao dịch đầu tiên của bạn sẽ xuất hiện tại đây.' ?></p>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </main>
        <footer class="footer">Sổ thu chi <span>·</span> Quản lý chi tiêu dễ dàng hơn mỗi ngày</footer>
    </div>
</body>
</html>