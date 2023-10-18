<?php
session_start();

if (isset($_POST['book_id'])) {
    # Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (!isset($_SESSION['user_id'])) {
        $error_message = "Người dùng chưa đăng nhập";
    } else {
        # Kết nối đến cơ sở dữ liệu
        include "../db_conn.php";

        $book_id = $_POST['book_id'];
        $user_id = $_SESSION['user_id']; // ID của người dùng đã đăng nhập

        # Kiểm tra xem sách đã được thêm vào danh sách ưa thích của người dùng chưa
        $sql_check_favorite = "SELECT * FROM favorites WHERE user_id=? AND book_id=?";
        $stmt_check_favorite = $conn->prepare($sql_check_favorite);
        $stmt_check_favorite->execute([$user_id, $book_id]);

        if ($stmt_check_favorite->rowCount() === 0) {
            # Nếu sách chưa được thêm vào danh sách ưa thích, thêm nó vào
            $sql_add_to_favorites = "INSERT INTO favorites (user_id, book_id) VALUES (?, ?)";
            $stmt_add_to_favorites = $conn->prepare($sql_add_to_favorites);
            if ($stmt_add_to_favorites->execute([$user_id, $book_id])) {
                $success_message = "Thêm sách vào danh sách ưa thích thành công";
            } else {
                $error_message = "Không thể thêm sách vào danh sách ưa thích";
            }
        } else {
            $error_message = "Sách đã tồn tại trong danh sách ưa thích của bạn";
        }
    }
} else {
    $error_message = "Dữ liệu không hợp lệ";
}

// Bây giờ chúng ta sẽ gửi người dùng trở lại trang detailuser.php với thông báo
header("Location: ../detailuser.php?id=" . urlencode($book_id));
exit;
