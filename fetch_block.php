<?php
require 'config.php';
$page_id = intval($_GET['page_id']);
$result = $db->query("SELECT id, content FROM blocks WHERE page_id = $page_id ORDER BY id ASC");
$blocks = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($blocks);
