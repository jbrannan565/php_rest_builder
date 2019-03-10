<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/dbclass.php";
include_once "../entities/todo.php";

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

// create new todo instance
$todo = new Todo($connection);

$data = json_decode(file_get_contents("php://input"));

$todo->percent_done = $data->percent_done;
$todo->text = $data->text;
$todo->category_id = $data->category_id;


if (!$todo->percent_done ||!$todo->text ||!$todo->category_id) {
    http_response_code(400);
    echo "{";
        echo "'message': 'percent_done, text, category_id field required'";
    echo "}";
} elseif($todo->create()) {
    http_response_code(201);
    echo "{";
        echo "'message': 'todo was created.'";
    echo "}";
} else{
    http_response_code(400);
    echo "{";
        echo "'message': 'Unable to create todo.'";
    echo "}";
}
?>
