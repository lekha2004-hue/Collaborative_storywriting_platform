<?php
session_start();
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

function generateCode($length = 4) {
    return substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, $length);
}

// Handle room creation with genre, title, max_users
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_room'])) {
    $room_code = generateCode();
    $title = $db->real_escape_string($_POST['title']);
    $genre = $db->real_escape_string($_POST['genre']);
    $max_users = intval($_POST['max_users']);

    $db->query("INSERT INTO rooms (user_id, room_code, title, genre, max_users) 
                VALUES ($user_id, '$room_code', '$title', '$genre', $max_users)");
    header("Location: dashboard.php");
    exit;
}

// Handle room deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_room_code'])) {
    $delete_room_code = $_POST['delete_room_code'];
    $db->query("DELETE FROM rooms WHERE user_id = $user_id AND room_code = '$delete_room_code'");
    header("Location: dashboard.php");
    exit;
}

// Handle logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

$rooms = $db->query("SELECT * FROM rooms WHERE user_id = $user_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<style>
  body {
    margin: 0;
    padding: 0;
    background: linear-gradient(#6C4AB6);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  header {
    background-color: #ffffffcc;
    width: 100%;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    position: relative;
  }

  header h1 {
    margin: 0;
    color: #333;
  }

  header .logout-button {
    position: absolute;
    right: 20px;
    top: 20px;
    background-color: #ff4b5c;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  header .logout-button:hover {
    background-color: #e8434d;
  }

  main {
    margin-top: 30px;
    width: 90%;
    max-width: 700px;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
  }

  h2 {
    text-align: center;
    color: #444;
    margin-bottom: 20px;
  }

  form label {
    font-weight: bold;
    display: block;
    margin-top: 15px;
    margin-bottom: 5px;
    color: #333;
  }

  input[type="text"], select, input[type="number"] {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border-radius: 8px;
    border: 1px solid #ccc;
    margin-bottom: 10px;
  }

  form button {
    background-color: #4e54c8;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 10px;
  }

  form button:hover {
    background-color: #5f66e0;
  }

  ul {
    list-style: none;
    padding: 0;
  }

  li {
    background: #ffffff;
    margin-bottom: 15px;
    padding: 15px 20px;
    border-radius: 12px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    flex-wrap: wrap;
  }

  li .room-info {
    max-width: 75%;
  }

  li .room-info a {
    color: #4e54c8;
    font-size: 18px;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 6px;
  }

  li .room-info a:hover {
    text-decoration: underline;
  }

  li .room-info .details {
    font-size: 14px;
    color: #555;
    background-color: #f3f4f8;
    padding: 6px 12px;
    border-radius: 8px;
    display: inline-block;
  }

  li form {
    display: inline;
  }

  li form button {
    background-color: #ff4b5c;
    padding: 8px 12px;
    font-size: 14px;
    margin-top: 4px;
  }

  li form button:hover {
    background-color: #e8434d;
  }

  .no-rooms {
    text-align: center;
    color: #666;
    margin-top: 20px;
    font-style: italic;
  }
</style>
</head>
<body>

<header>
  <h1>Welcome to Your Dashboard</h1>
  <form method="POST" class="logout-form">
    <button type="submit" name="logout" class="logout-button">Logout</button>
  </form>
</header>

<main>
  <h2>Create a New Story Room</h2>
  <form method="POST">
    <label for="title">Story Title</label>
    <input type="text" id="title" name="title" placeholder="Enter story title" required>

    <label for="genre">Genre</label>
    <select id="genre" name="genre" required>
      <option value="Fantasy">Fantasy</option>
      <option value="Mystery">Mystery</option>
      <option value="Horror">Horror</option>
      <option value="Comedy">Comedy</option>
      <option value="Sci-Fi">Sci-Fi</option>
      <option value="Romance">Romance</option>
    </select>

    <label for="max_users">Max Number of Users</label>
    <input type="number" id="max_users" name="max_users" min="1" max="5" value="5" required>

    <button type="submit" name="create_room" value="1">+ Create Room</button>
  </form>

  <h2>Your Rooms</h2>
  <?php if ($rooms->num_rows > 0): ?>
    <ul>
      <?php while ($room = $rooms->fetch_assoc()): ?>
        <li>
          <div class="room-info">
            <a href="room.php?code=<?= htmlspecialchars($room['room_code']) ?>">Room <?= htmlspecialchars($room['room_code']) ?></a>
            <div class="details">
              <?= htmlspecialchars($room['title']) ?> &nbsp;|&nbsp;
              Genre: <?= htmlspecialchars($room['genre']) ?> &nbsp;|&nbsp;
              Max Users: <?= $room['max_users'] ?>
            </div>
          </div>
          <form method="POST" onsubmit="return confirm('Are you sure you want to delete this room?');">
            <input type="hidden" name="delete_room_code" value="<?= htmlspecialchars($room['room_code']) ?>">
            <button type="submit">Delete</button>
          </form>
        </li>
      <?php endwhile; ?>
    </ul>
  <?php else: ?>
    <div class="no-rooms">
      You have no rooms yet.<br>Use the form above to create one!
    </div>
  <?php endif; ?>
</main>

</body>
</html>
