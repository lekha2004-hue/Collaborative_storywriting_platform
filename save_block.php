<?php
require 'config.php';
$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['id']);
$content = $db->real_escape_string($data['content']);
$db->query("UPDATE blocks SET content = '$content' WHERE id = $id");
