<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $db->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $res = $db->query("SELECT * FROM users WHERE username = '$username'");
    $user = $res->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Login failed. Please check your username and password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
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
      background: rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      animation: rise 20s infinite ease-in;
    }

    @keyframes rise {
      0% { transform: translateY(0) scale(1); }
      100% { transform: translateY(-1200px) scale(1.5); }
    }

    .login-container {
  background: white;
  padding: 50px 40px; /* increased padding */
  border-radius: 15px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  width: 420px; /* increased width */
  text-align: center;
  position: relative;
  z-index: 1;
  animation: fadeSlideUp 0.8s ease forwards;
  opacity: 0;
  transform: translateY(30px);
}

.login-container input {
  padding: 16px 18px; /* more padding */
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 17px; /* larger font */
  transition: border-color 0.3s;
}

.login-container button {
  padding: 16px; /* bigger button */
  background-color: #6c63ff;
  border: none;
  border-radius: 8px;
  color: white;
  font-size: 17px; /* bigger text */
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

    @keyframes fadeSlideUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-container h2 {
      margin-bottom: 20px;
      color: #333;
      font-weight: 600;
    }

    .login-container form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .login-container input {
      padding: 12px 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
      transition: border-color 0.3s;
    }

    .login-container input:focus {
      outline: none;
      border-color: #6c63ff;
      box-shadow: 0 0 0 3px rgba(108,99,255,0.2);
    }

    .login-container button {
      padding: 12px;
      background-color: #6c63ff;
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .login-container button:hover {
      background-color: #574b90;
      transform: translateY(-2px);
    }

    .error-message {
      background: #ffe0e0;
      color: #d8000c;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 15px;
      font-size: 14px;
    }

  </style>

  <!-- Dynamic bubble generation -->
  <style>
    <?php for ($i = 1; $i <= 20; $i++): ?>
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
  <?php for ($i = 0; $i < 20; $i++): ?>
    <div class="bubble"></div>
  <?php endfor; ?>
</div>

<div class="login-container">
  <h2>Welcome Back 👋</h2>
  <?php if (isset($error)): ?>
    <div class="error-message"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
</div>

</body>
</html>
