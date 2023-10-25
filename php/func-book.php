<?php  
# Get All books function
function get_all_books($con){
   $sql  = "SELECT * FROM books ORDER bY id DESC";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $books = $stmt->fetchAll();
   }else {
      $books = 0;
   }

   return $books;
}


# Get  book by ID function
function get_book($con, $id){
   $sql  = "SELECT * FROM books WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $book = $stmt->fetch();
   }else {
      $book = 0;
   }

   return $book;
}
# Search books function
function search_books($con, $key){
   $key = "%{$key}%";

   $sql  = "SELECT * FROM books 
            WHERE title LIKE ?
            OR description LIKE ?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$key, $key]);

   if ($stmt->rowCount() > 0) {
        $books = $stmt->fetchAll();
   }else {
      $books = 0;
   }

   return $books;
}

   # get books by category
   function get_books_by_category($con, $id){
      $sql  = "SELECT * FROM books WHERE category_id=?";
      $stmt = $con->prepare($sql);
      $stmt->execute([$id]);

      if ($stmt->rowCount() > 0) {
         $books = $stmt->fetchAll();
      }else {
         $books = 0;
      }

      return $books;
   }


# get books by author
function get_books_by_author($con, $id){
   $sql  = "SELECT * FROM books WHERE author_id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
        $books = $stmt->fetchAll();
   }else {
      $books = 0;
   }

   return $books;
}

function get_books_paginated($conn, $offset, $limit) {
   $sql = "SELECT * FROM books LIMIT :offset, :limit";
   $stmt = $conn->prepare($sql);
   $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
   $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
   $stmt->execute();

   $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

   return $books;
}

function count_all_books($conn) {
   $sql = "SELECT COUNT(*) as total FROM books";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   if (count($result) > 0) {
       return $result[0]['total'];
   } else {
       return 0;
   }
}
