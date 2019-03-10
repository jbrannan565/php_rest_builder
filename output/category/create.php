<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/dbclass.php";
include_once "../entities/category.php";

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

// create new category instance
$category = new Category($connection);

$data = json_decode(file_get_contents("php://input"));

$category->name = $data->name;


if (!$category->name) {
    http_response_code(400);
    echo "{";
        echo "'message': 'name field required'";
    echo "}";
} elseif($category->create()) {
    http_response_code(201);
    echo "{";
        echo "'message': 'category was created.'";
    echo "}";
} else{
    http_response_code(400);
    echo "{";
        echo "'message': 'Unable to create category.'";
    echo "}";
}
?>
