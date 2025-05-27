<?php
// config.php
$db = new mysqli('localhost', 'root', '', 'test_2');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
$db->set_charset('utf8mb4');
