<?php
header('Content-Type: application/json');
require_once "function.php";
$name = sanitize($_GET['name']);
$data = getIconLink($name);
$response["status"] = true;
$response["message"] = "";
$response["data"]["name"] = $name;
$response["data"]["raw_link"] = $data;
echo json_encode($response);
?>