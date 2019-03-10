<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PATCH");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/dbclass.php";
include_once "../entities/category.php";

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$category = new Category($connection);
$category->id = intval($_GET['id']);

$data = json_decode(file_get_contents("php://input"));

$category->name = $data->name;


if($category->update()){
    echo "{";
        echo "'message': 'category was updated.'";
    echo "}";
}
else{
    http_response_code(400);
    echo "{";
        echo "'message': 'Unable to update category.'";
    echo "}";
}
?>
