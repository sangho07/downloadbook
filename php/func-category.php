<?php  

# Get all Categories function
function get_all_categories($con){
   $sql  = "SELECT * FROM categories";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $categories = $stmt->fetchAll();
   }else {
      $categories = 0;
   }

   return $categories;
}


# Get category by ID
function get_category($con, $id){
   $sql  = "SELECT * FROM categories WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $category = $stmt->fetch();
   }else {
      $category = 0;
   }

   return $category;
}

function search_books_by_category($con, $categoryName){
   $categoryName = "%{$categoryName}%";

   $sql = "SELECT books.* 
           FROM books
           INNER JOIN categories ON books.category_id = categories.id
           WHERE categories.name LIKE ?";

   $stmt = $con->prepare($sql);
   $stmt->execute([$categoryName]);

   if ($stmt->rowCount() > 0) {
       $books = $stmt->fetchAll();
   } else {
       $books = 0;
   }

   return $books;
}