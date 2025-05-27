<?php

require 'config.php';
$code = $_GET['code'] ?? '';
$res = $db->query("SELECT id FROM rooms WHERE room_code = '$code'");
$room = $res->fetch_assoc();

if (!$room) {
    die("Room not found");
}

$page_id = $room['id']; // Use room ID as page_id
include 'editor.php'; // reuse the earlier editor logic but with this page_id
