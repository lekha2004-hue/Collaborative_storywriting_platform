<?php
require 'config.php';

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $id = intval($data['id']);

    // Delete the block from the database
    $stmt = $db->prepare("DELETE FROM blocks WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Block not found.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No ID provided.']);
}
?>
