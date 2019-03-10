<?php
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/dbclass.php";
include_once "../entities/todo.php";

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$todo = new Todo($connection);

$todo->id = intval($_GET["id"]);
$stmt = $todo->read();
$count = $stmt->rowCount();

if($count > 0){
    $output = array();
    $output["body"] = array();
    $output["count"] = $count;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $p  = array(
		"id" => intval($id),
		"percent_done" => floatval($percent_done),
		"text" => $text,
		"category_id" => intval($category_id)
        );

        array_push($output["body"], $p);
    }

    echo json_encode(array_values($output));
}

else {
    http_response_code(404);
    $val = array();
    $val["body"] = array();
    $val["count"] = 0;
    echo json_encode(
	array_values($val)
    );
}
?>
