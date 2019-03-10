<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/dbclass.php";
include_once "../entities/%s.php";

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

// create new %s instance
$%s = new %s($connection);

$data = json_decode(file_get_contents("php://input"));

%s

if (%s) {
    http_response_code(400);
    echo "{";
        echo "'message': '%s field required'";
    echo "}";
} elseif($%s->create()) {
    http_response_code(201);
    echo "{";
        echo "'message': '%s was created.'";
    echo "}";
} else{
    http_response_code(400);
    echo "{";
        echo "'message': 'Unable to create %s.'";
    echo "}";
}
?>
