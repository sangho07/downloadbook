<?php 
session_start();

if (isset($_SESSION['user_id'])) {
    // Tiếp tục xử lý vì người dùng đã đăng nhập.
    $user_id = $_SESSION['user_id'];
    // ...
} else {
    // Đưa ra thông báo người dùng chưa đăng nhập nếu cần.
    echo "Người dùng chưa đăng nhập.";
    exit(); // Kết thúc mã nguồn
}


# If search key is not set or empty
if (!isset($_GET['key']) || empty($_GET['key'])) {
	header("Location: index.php");
	exit;
}
$key = $_GET['key'];

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = search_books($conn, $key);

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
    <!--Header-->
    <div class="header">
        
        <div class="header-1">
            <a href="index.php" class="logo">
                <img src="./image/logo.png" alt="Logo">
                <span class="logo-text">SÁCH HAY</span>
            </a>
        
            <form action="searchuser.php" class="form-box">
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
    <br>
		<h2>Kết quả của <b><?=$key?></b></h2>

</div>
    <div class="d-flex pt-3">
    <?php if ($books == 0){ ?>
				<div class="alert alert-warning 
        	            text-center p-5 pdf-list" 
        	     role="alert">
        	     
        	     <br>
				  Không có kết quả của <b>"<?=$key?>"</b> 
			  </div>
			<?php }else{ ?>
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
                    <a href="uploads/files/<?=$book['file']?>" class="btn btn-success">Open</a>
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
        <?php } ?>
    </div>
</div>


      <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="./js/script.js"></script>
    
</body>
</html>