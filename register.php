<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $db->real_escape_string($_POST['username']);
    $email = $db->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $db->query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(#6C4AB6);
      height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      position: relative;
    }

    .bubbles {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      overflow: hidden;
      z-index: 0;
    }

    .bubble {
      position: absolute;
      bottom: -100px;
      background: rgba(255, 255, 255, 0.4);
      border-radius: 50%;
      animation: rise 20s infinite ease-in;
    }

    @keyframes rise {
      0% { transform: translateY(0) scale(1); }
      100% { transform: translateY(-1200px) scale(1.5); }
    }

    .register-container {
  background: white;
  padding: 50px 40px; /* Increased padding */
  border-radius: 15px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  width: 420px; /* Increased width */
  text-align: center;
  position: relative;
  z-index: 1;
  animation: fadeSlideUp 0.8s ease forwards;
  opacity: 0;
  transform: translateY(30px);
      }

    @keyframes fadeSlideUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .register-container h2 {
      margin-bottom: 20px;
      color: #333;
      font-weight: 600;
    }

    .register-container form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .register-container input {
  padding: 16px 18px; /* More padding */
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 17px; /* Larger text */
  transition: border-color 0.3s;
}

    .register-container input:focus {
      outline: none;
      border-color: #6c63ff;
      box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.2);
    }

    .register-container button {
  padding: 16px; /* Bigger button */
  background-color: #6c63ff;
  border: none;
  border-radius: 8px;
  color: white;
  font-size: 17px; /* Bigger text */
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
  margin-top: 5px;
}

    .register-container button:hover {
      background-color: #574b90;
      transform: translateY(-2px);
    }
  </style>

  <!-- PHP generated CSS for dynamic bubbles -->
  <style>
    <?php for ($i = 1; $i <= 25; $i++): ?>
    .bubble:nth-child(<?= $i ?>) {
      left: <?= rand(0, 100) ?>%;
      width: <?= rand(20, 50) ?>px;
      height: <?= rand(20, 50) ?>px;
      animation-duration: <?= rand(12, 25) ?>s;
      animation-delay: -<?= rand(0, 20) ?>s;
    }
    <?php endfor; ?>
  </style>

</head>
<body>

<div class="bubbles">
  <?php for ($i = 0; $i < 25; $i++): ?>
    <div class="bubble"></div>
  <?php endfor; ?>
</div>

<div class="register-container">
  <h2>Create Account ✨</h2>
  <form method="POST">
    <input name="username" type="text" placeholder="Username" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">Register</button>
  </form>
</div>

</body>
</html>
