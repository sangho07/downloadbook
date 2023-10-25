<?php
session_start();

# Bao gồm tệp kết nối cơ sở dữ liệu
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_all_books($conn);

# Author helper function
include "php/func-author.php";
$authors = get_all_author($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);

include "php/search.php";

if (isset($_SESSION['user_id'])) {
    // Tiếp tục xử lý vì người dùng đã đăng nhập.
    $user_id = $_SESSION['user_id'];
    // ...
} else {
    // Đưa ra thông báo người dùng chưa đăng nhập nếu cần.
    echo "Người dùng chưa đăng nhập.";
    exit(); // Kết thúc mã nguồn
}

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    # Retrieve book details based on the book ID
    $book = get_book($conn, $book_id);

    $review_query = "SELECT reviews.rating, reviews.comment, users.username 
                    FROM reviews 
                    INNER JOIN users ON reviews.user_id = users.id 
                    WHERE reviews.book_id = ?";

    $review_query = $conn->prepare($review_query);
    $review_query->execute([$book_id]);
    $reviews = $review_query->fetchAll(PDO::FETCH_ASSOC);
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
            <a href="user.php" class="logo">
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
            <div class="navbar">
                <a href="user.php">Trang chủ</a>
                <?php foreach ($categories as $category) { ?>
                    <a href="category.php?id=<?= $category['id'] ?>">
                    <?= $category['name'] ?>
                 </a>
                <?php } ?>
            </div>
        </div>
    </div>
    
    <?php
        $totalRating = 0;
        $averageRating = 0;
    foreach ($reviews as $review) {
        $totalRating += $review['rating'];
    }

    if (count($reviews) > 0) {
        $averageRating = $totalRating / count($reviews);
    }
    ?>


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
                        <?php
                        $averageRating = round($averageRating); // Làm tròn trung bình rating
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $averageRating) {
                                echo '<i class="filled fas fa-star"></i>';
                            } else {
                            echo '<i class="fas fa-star"></i>';
                        }
                    }
                    ?>
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
                    <a>
                        <form class="submit-favorite" action="./php/add_to_favorites.php" method="POST">
                            <input type="hidden" name="book_id" value="<?=$book_id?>">
                            <button type="submit" name="add_to_favorites">Thêm vào ưa thích</button>
                        </form>          
                    </a>
                </div>

                    <div class="review">
                        <h3>Đánh giá</h3>                              
                        <form action="./php/submit_review.php" method="POST">
                            <input type="hidden" name="book_id" value="<?=$book_id?>">
                            <label for="rating">Điểm đánh giá:</label>
                            <select name="rating" id="rating">
                                <option value="1">1 sao</option>
                                <option value="2">2 sao</option>
                                <option value="3">3 sao</option>
                                <option value="4">4 sao</option>
                                <option value="5">5 sao</option>
                            </select>
                                <label for="comment">Nhận xét:</label>
                                <textarea name="comment" id="comment" rows="4"></textarea>
                                <button type="submit">Gửi đánh giá</button>
                        </form>
                    </div> 
                    <?php
                        foreach ($reviews as $review) {
                        ?>
                            <div class="review-item">
                                <p class="rating">Điểm đánh giá: <?=$review['rating']?> sao</p>
                                <p class="comment">Nhận xét: <?=$review['comment']?></p>
                                <p class="username">Người đánh giá: <?=$review['username']?></p>
                            </div>
                            <?php
                        }
                        ?>
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