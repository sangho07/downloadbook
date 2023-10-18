
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
            <div class="navbarr">
                <a href="index.php">Trang chủ</a>
                <?php foreach ($categories as $category) { ?>
                    <a href="category.php?id=<?= $category['id'] ?>">
                    <?= $category['name'] ?>
                 </a>
                <?php } ?>
            </div>
        </div>
    </div>

     <!-- Đăng nhập -->
    
     <div id="login" class="login-form">

<form action="./php/user_login_process.php" method="POST">
    <i class="fa-solid fa-xmark" id="btn-close-login"></i>
    <h2>Đăng nhập</h2>
    <?php
      if (isset($_SESSION['error_message'])) {
        $error_message = $_SESSION['error_message'];
        echo "<div class='alert alert-danger'>$error_message</div>";
        unset($_SESSION['error_message']); 
    }
?>
        
    <div class="input-box">
        <label for="">Username</label>
        <input type="text" name="username" id="" required placeholder="Tên đăng nhập">
    </div>

    <div class="input-box">
        <label for="">Password</label>
        <input type="password" name="password" id="" required placeholder="Mật khẩu">
    </div>

    <div class="remember-forgot">
        <input type="checkbox" name="" id="remember-password">
        <label for="remember-password">Nhớ mật khẩu</label>
        <a href="">Quên mật khẩu</a>
    </div>

    <button type="submit" class="btn-login">Đăng nhập</button>

    <div class="login-register">
        <p>Bạn chưa có tài khoản <a id="register-link">Đăng ký ngay</a></p>
    </div>

</form>

    </div>




    <section class="home" id="home">
    <div class="row">

    <div class="content">
        <h1>SÁCH HAY MIỄN PHÍ<br><span>Dowload free</span></h1>

        <p>
            Sách Hay Miễn Phí là trang web tuyệt vời để tải về sách điện tử miễn phí, 
            với một bộ sưu tập đa dạng và công cụ tìm kiếm tiện lợi. 
            Đó là điểm đến hoàn hảo cho những ai thích đọc sách và muốn khám phá tri thức mà không phải trả bất kỳ khoản phí nào.
        </p>
    </div>

    <div class="swiper books-list" >

        <div class="swiper-wrapper">
            <a href="" class="swiper-slide"><img src="./image/book-1.jpg" alt=""></a>
            <a href="" class="swiper-slide"><img src="./image/book-2.jpg" alt=""></a>
            <a href="" class="swiper-slide"><img src="./image/book-3.jpg" alt=""></a>
            <a href="" class="swiper-slide"><img src="./image/book-4.jpg" alt=""></a>
            <a href="" class="swiper-slide"><img src="./image/book-5.jpg" alt=""></a>
            <a href="" class="swiper-slide"><img src="./image/book-6.jpg" alt=""></a>
            <a href="" class="swiper-slide"><img src="./image/book-7.jpg" alt=""></a>
        </div>

        <img src="./image/stand.png" class="stand" alt="">
        
    </div>
</div>

</section>
<!-- Dịch vụ -->
<div class="services">

<div class="services_box">

    <div class="services_card">
        <i class="fa-solid fa-hand-holding-dollar"></i>
        <h3>Hoàn toàn miễn phí</h3>
        <p>
            Không yêu cầu người dùng trả tiền để truy cập hoặc tải về sách.
    </div>

    <div class="services_card">
        <i class="fa-solid fa-book"></i>
        <h3>Đa dạng về nội dung </h3>
        <p>
            Thư viện sách đa dạng, phong phú với hàng ngàn cuốn sách khác nhau.
        </p>
    </div>

    <div class="services_card">
        <i class="fa-solid fa-wifi"></i>
        <h3>Di động và tiện lợi</h3>
        <p>
            Có thể truy cập và tải về sách từ bất kỳ thiết bị nào kết nối internet.
        </p>
    </div>

    <div class="services_card">
        <i class="fa-regular fa-comment"></i>
        <h3>Cộng đồng người dùng tích cực</h3>
        <p>
            Tương tác và thảo luận với người đọc khác về những cuốn sách bạn đã đọc
        </p>
    </div>

</div>

<div class="allbooktitle">
    <h1 >Toàn bộ sách</h1>  
</div>


</div>
    <div class="d-flex pt-3">
    <div class="pdf-list d-flex flex-wrap">
        <?php foreach ($books as $book) { ?>
        <div class="card m-1" style="width: 30rem;">
            <img src="uploads/cover/<?=$book['cover']?>" class="card-img-top" alt="Book Cover">
            <div class="card-body">
                <h5 class="card-title"><?=$book['title']?></h5>
                <p class="card-text">
                    <i><b>By:
                        <?php foreach($authors as $author){ 
                            if ($author['id'] == $book['author_id']) {
                                echo $author['name'];
                                break;
                            }
                        }?>
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
                    <a href="detail.php?id=<?=$book['id']?>" class="btn btn-success">Xem chi tiết</a>
                    <a href="uploads/files/<?=$book['file']?>" class="btn btn-primary" download="<?=$book['title']?>">Download</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <div class="category">
        <!-- List of categories -->
        <div class="list-group">
            <?php if ($categories == 0) {
                // do nothing
            } else { ?>
            <a href="#" class="list-group-item list-group-item-action active">Category</a>
            <?php foreach ($categories as $category) { ?>
                <a href="category.php?id=<?=$category['id']?>" class="list-group-item list-group-item-action">
                    <?=$category['name']?>
                </a>
            <?php } } ?>
        </div>

        <!-- List of authors -->
        <div class="list-group mt-5">
            <?php if ($authors == 0) {
                // do nothing
            } else { ?>
            <a href="#" class="list-group-item list-group-item-action active">Author</a>
            <?php foreach ($authors as $author) { ?>
                <a href="author.php?id=<?=$author['id']?>" class="list-group-item list-group-item-action">
                    <?=$author['name']?>
                </a>
            <?php } } ?>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="./js/script.js"></script>
 
    
</body>
</html>