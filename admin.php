<?php  
session_start();
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

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
    <div class="tong">

    <!--Header-->
    <div class="header">

        <div class="header-1">
            <a href="admin.php" class="logo">
                <img src="./image/logo.png" alt="Logo">
                <span class="logo-text">SÁCH HAY</span>
            </a>
            <div class="button">
                 <a href="logout.php" class="btn-logout" >Đăng xuất</a>
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
    
    <?php  if ($books == 0) { ?>
			  Không có sách trong CSDL
		  </div>
        <?php }else {?>

    <h4>All Books</h4>
		<table class="table table-bordered shadow">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Author</th>
					<th>Description</th>
					<th>Category</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
                <?php  $i = 0;
			  foreach ($books as $book) {
			    $i++;
			   ?> 

                <tr>
					<td><?=$i?></td>

                    <td>
					<img width="100"
					     src="uploads/cover/<?=$book['cover']?>" >
					<a  class="link-dark d-block
					           text-center"
					    href="uploads/files/<?=$book['file']?>">
					   <?=$book['title']?>	
					</a>		
					</td>

                    <td>
					<?php if ($authors == 0) {
						echo "Undefined";}else{ 

					    foreach ($authors as $author) {
					    	if ($author['id'] == $book['author_id']) {
					    		echo $author['name'];
					    	}
					    }
					}
					?>
				    </td>

                    <td><?=$book['description']?></td>

                    <td>
					<?php if ($categories == 0) {
						echo "Undefined";}else{ 

					    foreach ($categories as $category) {
					    	if ($category['id'] == $book['category_id']) {
					    		echo $category['name'];
					    	}
					    }
					}
					?>
				    </td>

                    <td>
                        <a href="edit-book.php?id=<?=$book['id']?>" class="btn btn-warning">Edit</a>
                        <a href="php/delete-book.php?id=<?=$book['id']?>"  class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody> 
        </table>
        <?php } ?>

        <!-- Category -->
        <?php  if ($categories == 0) { ?>
			  Không có thể loại trong CSDL
		    </div>
        <?php }else {?>
	    <!-- List of all categories -->
		<h4 class="mt-5">All Categories</h4>
		<table class="table table-bordered shadow">
			<thead>
				<tr>
					<th>#</th>
					<th>Category Name</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$j = 0;
				foreach ($categories as $category ) {
				$j++;	
				?>
				<tr>
					<td><?=$j?></td>
					<td><?=$category['name']?></td>
					<td>
						<a href="edit-category.php?id=<?=$category['id']?>" 
						   class="btn btn-warning">
						   Edit</a>

						<a href="php/delete-category.php?id=<?=$category['id']?>" 
						   class="btn btn-danger">
					       Delete</a>
					</td>
				</tr>
			    <?php } ?>
			</tbody>
		</table>
	    <?php } ?>


        <!-- Author -->
        <?php  if ($authors == 0) { ?>
				 Không có tác giả trong CSDL
		    </div>
        <?php }else {?>
	    <!-- List of all Authors -->
		<h4 class="mt-5">All Authors</h4>
         <table class="table table-bordered shadow">
			<thead>
				<tr>
					<th>#</th>
					<th>Author Name</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$k = 0;
				foreach ($authors as $author ) {
				$k++;	
				?>
				<tr>
					<td><?=$k?></td>
					<td><?=$author['name']?></td>
					<td>
						<a href="edit-author.php?id=<?=$author['id']?>" 
						   class="btn btn-warning">
						   Edit</a>

						<a href="php/delete-author.php?id=<?=$author['id']?>" 
						   class="btn btn-danger">
					       Delete</a>
					</td>
				</tr>
			    <?php } ?>
			</tbody>
		</table> 
		<?php } ?>
	</div>

      <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="./js/script.js"></script>
    
</body>
</html>


<?php }else{
  header("Location: login.php");
  exit;
} ?>