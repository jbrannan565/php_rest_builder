<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/dbclass.php";
include_once "../entities/todo.php";

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

// create new todo instance
$todo = new Todo($connection);
// get id from input
$todo->id = intval($_GET['id']);

// try delete 
if($todo->delete()){
    echo "{";
        echo "'message': 'todo was deleted.'";
    echo "}";
}
else{
    http_response_code(400);
    echo "{";
        echo "'message': 'Unable to delete todo.'";
    echo "}";
}
?>
