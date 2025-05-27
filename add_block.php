<?php
require 'config.php';
$page_id = intval($_GET['page_id']);
$db->query("INSERT INTO blocks (page_id, content) VALUES ($page_id, '')");
$new_id = $db->insert_id;
echo '<div class="block" contenteditable="true" data-id="' . $new_id . '"></div>';
