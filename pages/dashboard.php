<?php
include('../includes/auth.php');
include('../includes/db.php');

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// ดึงข้อมูลผู้ใช้
$stmt = $mysqli->prepare("SELECT username, display_name, profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $display_name, $profile_image);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>SnakeShakeShake🐍 คับเตง</title>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Prompt', sans-serif;
      background: linear-gradient(135deg, #ffe6f0, #e0f7fa);
      color: #333;
      text-align: center;
      padding: 30px;
    }
    h2 {
      font-size: 28px;
      color: #ff66b2;
    }
    .profile {
      margin: 20px 0;
    }
    .profile-img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px dashed #ff66b2;
      background-color: #fff;
      padding: 4px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .btn-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
      margin-top: 30px;
    }
    .btn-container button {
      padding: 12px 30px;
      font-size: 16px;
      background-color: #ffccf2;
      color: #333;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: transform 0.2s, background-color 0.3s;
      width: 240px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .btn-container button:hover {
      background-color: #ffb3e6;
      transform: scale(1.05);
    }
    .logout {
      margin-top: 30px;
    }
    .logout a {
      color: #ff4444;
      text-decoration: none;
      font-weight: bold;
    }
    .logout a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <h2>สวัสดี <?= htmlspecialchars($display_name ?? $username) ?>!</h2>
  <div class="profile">
    <p>👤 ชื่อผู้ใช้: <strong><?= htmlspecialchars($username); ?></strong></p>
    <img src="../uploads/<?= htmlspecialchars($profile_image ?: 'default.png') ?>" alt="Profile" class="profile-img">
  </div>

  <div class="btn-container">
    <form action="../game/select_level.html" method="get">
      <button type="submit">🐍 เกม</button>
    </form>

    <form action="settings.php" method="get">
      <button type="submit">🌺 เปลี่ยนโปรไฟล์</button>
    </form>

    <form action="about.php" method="get">
      <button type="submit">ℹ🌸 เกี่ยวกับเกม</button>
    </form>
  </div>

  <div class="logout">
    <p><a href="logout.php">😘 ออกจากระบบ</a></p>
  </div>
</body>
</html>
