<?php
require 'config.php';
$page_id = intval($_GET['page_id'] ?? 1);

$res = $db->query("SELECT * FROM blocks WHERE page_id = $page_id ORDER BY id ASC");
$blocks = [];
while ($row = $res->fetch_assoc()) {
    $blocks[] = $row;
}
header('Content-Type: application/json');
echo json_encode($blocks);
