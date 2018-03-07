<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../configurations/core.php';
include_once '../../configurations/database.php';
include_once '../../models/book.php';

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

$keywords=isset($_GET["keywords"]) ? $_GET["keywords"] : "";
 
$stmt = $book->search($keywords);
$num = $stmt->rowCount();
 
if ($num > 0) {
    $books_arr=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $book_item=array(
            "id" => $id,
            "name" => $name,
            "author" => $author,
            "publishing_company" => $publishing_company
        );
 
        array_push($books_arr, $book_item);
    }
 
    echo json_encode($books_arr);
} else {
    echo json_encode(
        array("message" => "No books found.")
    );
}
?>