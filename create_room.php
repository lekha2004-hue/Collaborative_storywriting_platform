<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_name = $_POST['room_name'] ?? '';

    if (empty($room_name)) {
        die("Room name is required.");
    }

    // Insert room into database
    $stmt = $conn->prepare("INSERT INTO rooms (room_name) VALUES (?)");
    $stmt->bind_param("s", $room_name);
    $stmt->execute();

    // Get the newly created room's ID
    $new_room_id = $stmt->insert_id;

    // Redirect to the room page
    header("Location: room.php?id=" . $new_room_id);
    exit();
} else {
    die("Invalid Request.");
}
?>
