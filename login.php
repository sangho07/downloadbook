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

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sách hay miễn phí</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
</head>
<body>
    <!--Header-->
    <div class="header">

        <div class="header-1">
            <a href="#" class="logo">
                <img src="./image/logo.png" alt="Logo">
                <span class="logo-text">SÁCH HAY</span>
            </a>

            <div class="button">
                 <a href="login.php" class="btn-login" id="login-btn">Đăng nhập</a>
            </div>
        </div>

        <div class="header-2">
            <div class="navbarr">
                <a href="index.php">Trang chủ</a>
                <a href="add-book.php">Thêm sách</a>
                <a href="add-category.php">Thêm danh mục</a>
                <a href="add-author.php">Thêm tác giả</a>
            </div>
        </div>
    </div>

    <div id="login" class="login-form" >

        <form method="POST" action="./php/auth.php">
            <h2>Đăng nhập</h2>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
			    <?=htmlspecialchars($_GET['error']); ?>
		        </div>
		    <?php } ?>
            <div class="input-box">
                <label label for="">Email</label>
                <input type="email" name="email" id="" placeholder="Tên đăng nhập">
            </div>

        <div class="input-box">
            <label for="">Password</label>
            <input type="password" name="password" id=""  placeholder="Mật khẩu">
        </div>

        <button type="submit" class="btn-login">Đăng nhập</button>
        </form>

       
    </div>


      <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="./js/script.js"></script>
    
</body>
</html>