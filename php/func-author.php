<?php 

# Get all Author function
function get_all_author($con){
   $sql  = "SELECT * FROM authors";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $authors = $stmt->fetchAll();
   }else {
      $authors = 0;
   }

   return $authors;
}


# Get  Author by ID function
function get_author($con, $id){
   $sql  = "SELECT * FROM authors WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $author = $stmt->fetch();
   }else {
      $author = 0;
   }

   return $author;
}

function search_books_by_author($con, $authorName){
   $authorName = "%{$authorName}%";

   $sql = "SELECT books.* 
           FROM books
           INNER JOIN authors ON books.author_id = authors.id
           WHERE authors.name LIKE ?";

   $stmt = $con->prepare($sql);
   $stmt->execute([$authorName]);

   if ($stmt->rowCount() > 0) {
       $books = $stmt->fetchAll();
   } else {
       $books = 0;
   }

   return $books;
}