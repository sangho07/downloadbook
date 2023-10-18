<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Người dùng chưa đăng nhập, bạn có thể thực hiện các xử lý chuyển hướng hoặc hiển thị thông báo lỗi ở đây
    header("Location: login.php");
    exit;
}

include "db_conn.php";

include "php/func-book.php";
$books = get_all_books($conn);

# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);

include "php/searchauca.php";


$user_id = $_SESSION['user_id'];

// Truy vấn danh sách sách yêu thích của người dùng
$sql_get_favorites = "SELECT b.title, b.description, b.category_id, b.cover, b.file, a.name AS author_name
                     FROM favorites AS f
                     INNER JOIN books AS b ON f.book_id = b.id
                     INNER JOIN authors AS a ON b.author_id = a.id
                     WHERE f.user_id = ?";
$stmt_get_favorites = $conn->prepare($sql_get_favorites);
$stmt_get_favorites->execute([$user_id]);
$favorite_books = $stmt_get_favorites->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sách hay miễn phí</title>
    <link rel="stylesheet" href="./css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    
</head>
<body>
<body>
    <!--Header-->
    <div class="header">
        <div class="header-1">
            <a href="user.php" class="logo">
                <img src="./image/logo.png" alt="Logo">
                <span class="logo-text">SÁCH HAY</span>
            </a>
        
            <form action="search.php" class="form-box">
                <input type="search" id="search-box" name="key" placeholder="Tìm kiếm sách...">
                <button type="submit" class="fas fa-search search-button" id="search-box" ></button>
            </form>
            
            <div class="button">
                <a href="favorites.php"><i class="fa fa-heart"></i></a>
                <a href="logoutuser.php" class="btn-logout" >Đăng xuất</a>
            </div>
        </div>

        <div class="header-2">
            <div class="navbarr">
                <a href="user.php">Trang chủ</a>
                <?php foreach ($categories as $category) { ?>
                    <a href="category.php?id=<?= $category['id'] ?>">
                    <?= $category['name'] ?>
                 </a>
                <?php } ?>
            </div>
        </div>
    </div>

    <h1 class="favorites">Danh sách yêu thích</h1>

<div class="pdf-list d-flex flex-wrap">
        <?php foreach ($favorite_books as $book) : ?>
        <div class="card m-1" style="width: 30rem;">
            <img src="uploads/cover/<?=$book['cover']?>" class="card-img-top" alt="Book Cover">
            <div class="card-body">
                <h5 class="card-title"><?=$book['title']?></h5>
                <p class="card-text">
                    <i><b>By: <?= $book['author_name'] ?>
                    </b></i>
                    <br>
                    <?=$book['description']?>
                    <br>
                    <i><b>Category:
                        <?php foreach($categories as $category){ 
                            if ($category['id'] == $book['category_id']) {
                                echo $category['name'];
                                break;
                            }
                        }?>
                    </b></i>
                </p>
                <div class="d-grid gap-2">
                    <a href="uploads/files/<?=$book['file']?>" class="btn btn-success">Open</a>
                    <a href="uploads/files/<?=$book['file']?>" class="btn btn-primary" download="<?=$book['title']?>">Download</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="./js/script.js"></script>
    
</body>
</html>