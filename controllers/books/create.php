<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../configurations/core.php';
include_once '../../configurations/database.php';
include_once '../../models/book.php';

$database = new Database();
$db = $database->getConnection();
 
$book = new Book($db);
 
$data = json_decode(file_get_contents("php://input"));
 
$book->name = $data->name;
$book->author = $data->author;
$book->publishing_company = $data->publishing_company;
 
if ($book->create()) {
    echo '{ "message": "Book was created." }';
} else {
    echo '{ "message": "Unable to create book." }';
}
?>