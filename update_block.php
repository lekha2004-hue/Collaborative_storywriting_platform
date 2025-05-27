<?php
require 'config.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['id']);
$content = $conn->real_escape_string($data['content'] ?? '');

$conn->query("UPDATE blocks SET content = '$content' WHERE id = $id");
echo json_encode(["status" => "ok"]);
