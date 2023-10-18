<?php 
session_start();

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_all_books($conn);

# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);

include "php/searchauca.php";

# Get the book ID from the URL parameter
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    # Retrieve book details based on the book ID
    $book = get_book($conn, $book_id);


} else {
    # Handle the case where no book ID is provided in the URL
    echo "Vui lòng chọn một cuốn sách để xem chi tiết.";
    exit(); // Kết thúc mã nguồn
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sách hay miễn phí</title>
    <link rel="stylesheet" href="./css/detail2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    
</head>
<body>
    <!--Header-->
    <div class="header">

        <div class="header-1">
            <a href="index.php" class="logo">
                <img src="./image/logo.png" alt="Logo">
                <span class="logo-text">SÁCH HAY</span>
            </a>
        
            <form action="search.php" class="form-box">
                <input type="search" id="search-box" name="key" placeholder="Tìm kiếm sách...">
                <button type="submit" class="fas fa-search search-button" id="search-box" ></button>
            </form>

            <div class="button">
                 <a href="registeruser.php" class="btn-register" id="register-btn">Đăng ký</a>
                 <a href="loginuser.php" class="btn-login" id="login-btn">Đăng nhập</a>
            </div>
        </div>

        <div class="header-2">
            <div class="navbar">
                <a href="index.php">Trang chủ</a>
                <?php foreach ($categories as $category) { ?>
                    <a href="category.php?id=<?= $category['id'] ?>">
                    <?= $category['name'] ?>
                 </a>
                <?php } ?>
            </div>
        </div>
    </div>
    
    <div class="detail">
    <h2>Chi tiết</h2>
        <div class="detail_card">
            <div class="detail_image">
                <img src="uploads/cover/<?=$book['cover']?>">
            </div>
            <div class="detail_content">
                <div class="detail_tags">
                    <h1><?=$book['title']?></h1>
                    <div class="rate">
                        <i class="filled fas fa-star"></i>
                        <i class="filled fas fa-star"></i>
                        <i class="filled fas fa-star"></i>
                        <i class="filled fas fa-star"></i>
                        <i class="filled fas fa-star"></i>
                    </div>
                    <div class="author">Tên tác giả:<span>
                    <?php foreach($authors as $author){ 
                            if ($author['id'] == $book['author_id']) {
                                echo $author['name'];
                                break;
                            }
                        }?>
                    </span>
                </div>
                    <div class="category">Thể loại: <span>
                        <?php foreach($categories as $category){ 
                            if ($category['id'] == $book['category_id']) {
                                echo $category['name'];
                                break;
                            }
                        }?>
                        </span>
                    </div>
                </div>

                <div class="description">Nội dung:  
                    <p><?=$book['description']?>
                    </p>
                </div>
                <div class="options">
                    <a href="uploads/files/<?=$book['file']?>" download="<?=$book['title']?>">Tải xuống</a>
                    <a href="uploads/files/<?=$book['file']?>" >Đọc ngay</a>
                </div>
            </div>

            
        </div>    
    </div>


    <!--Footer-->

    <footer>
        <div class="footer_main">

            <div class="tag">
                <img src="image/logo.png">

            </div>

            <div class="tag">
                <h1>Thông tin</h1>
                <a href="#"><i class="fa-solid fa-phone"></i>+84 976 712 464</a>
                <a href="#"><i class="fa-solid fa-phone"></i>+84 978 327 293</a>
                <a href="#"><i class="fa-solid fa-envelope"></i>bookstore123@gmail.com</a>
                
            </div>

            <div class="tag">
                <h1>Theo dõi </h1>
                <div class="social_link">
                    <i class="fa-brands fa-facebook-f"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-linkedin-in"></i>
                </div>
                
            </div>

            <div class="tag">
                <h1>Nhận xét</h1>
                <div class="search_bar">
                    <input type="text" placeholder="Đánh giá website">
                    <button type="submit">Đánh giá</button>
                </div>                
            </div>            
            
        </div>

        <p class="end">Design By<span><i class="fa-solid fa-face-grin"></i> Minh Sang</span></p>

    </footer>




      <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="./js/script.js"></script>
    
</body>
</html>