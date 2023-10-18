<?php
session_start();

if (isset($_POST['book_id'])) {
    # Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (!isset($_SESSION['user_id'])) {
        $error_message = "Người dùng chưa đăng nhập";
        header("Location: detailuser.php?book_id=" . $_POST['book_id'] . "&error_message=" . $error_message);
        exit();
    }

    # Bao gồm tệp kết nối cơ sở dữ liệu
    include "../db_conn.php";

    $book_id = $_POST['book_id'];
    $user_id = $_SESSION['user_id']; // ID của người dùng đã đăng nhập

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $rating = $_POST["rating"];
        $comment = $_POST["comment"];

        # Thực hiện kiểm tra và xác thực dữ liệu đầu vào (ví dụ: kiểm tra rating nằm trong khoảng 1-5)
        if ($rating < 1 || $rating > 5) {
            $error_message = "Điểm đánh giá phải nằm trong khoảng từ 1 đến 5.";
            header("Location: detailuser.php?book_id=" . $book_id . "&error_message=" . $error_message);
            exit();
        }

        # Thêm đánh giá vào bảng "reviews" (sử dụng truy vấn SQL)
        $sql = "INSERT INTO reviews (book_id, user_id, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute([$book_id, $user_id, $rating, $comment])) {
            // Đánh giá đã được thêm thành công
            header("Location: detailuser.php?book_id=" . $book_id . "&success_message=Đánh giá đã được thêm thành công.");
            exit();
        } else {
            $error_message = "Lỗi khi thêm đánh giá: " . implode(" ", $stmt->errorInfo());
            header("Location: detailuser.php?book_id=" . $book_id . "&error_message=" . $error_message);
            exit();
        }
    }

    # Đóng kết nối đến cơ sở dữ liệu
    $conn = null;
} else {
    # Redirect to the appropriate page if data is not posted
    header("Location: index.php");
    exit();
}
?>