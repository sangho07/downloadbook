<?php
if (isset($_GET['key']) && !empty($_GET['key'])) {
    $key = $_GET['key'];

    # Perform the search based on the selected options
    $searchByAuthor = isset($_GET['searchByAuthor']);
    $searchByCategory = isset($_GET['searchByCategory']);

    $sql = "SELECT DISTINCT books.* 
            FROM books
            LEFT JOIN authors ON books.author_id = authors.id
            LEFT JOIN categories ON books.category_id = categories.id
            WHERE (books.title LIKE :key
                OR authors.name LIKE :key
                OR categories.name LIKE :key)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':key', $key, PDO::PARAM_STR);
    $stmt->execute();

    $books = $stmt->fetchAll();
}
?>