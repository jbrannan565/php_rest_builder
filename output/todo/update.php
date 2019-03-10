<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PATCH");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/dbclass.php";
include_once "../entities/todo.php";

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$todo = new Todo($connection);
$todo->id = intval($_GET['id']);

$data = json_decode(file_get_contents("php://input"));

$todo->percent_done = $data->percent_done;
$todo->text = $data->text;
$todo->category_id = $data->category_id;


if($todo->update()){
    echo "{";
        echo "'message': 'todo was updated.'";
    echo "}";
}
else{
    http_response_code(400);
    echo "{";
        echo "'message': 'Unable to update todo.'";
    echo "}";
}
?>
