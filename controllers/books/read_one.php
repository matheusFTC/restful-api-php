<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
include_once '../../configurations/core.php';
include_once '../../configurations/database.php';
include_once '../../models/book.php';

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);
 
$book->id = isset($_GET['id']) ? $_GET['id'] : die();

$book->readOne();
 
$book_arr = array(
    "id" =>  $book->id,
    "name" => $book->name,
    "author" => $book->author,
    "publishing_company" => $book->publishing_company
);
 
print_r(json_encode($book_arr));
?>