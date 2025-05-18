<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>ออกจากระบบ...</title>
  <meta http-equiv="refresh" content="3;url=login.php">
  <style>
    body {
      font-family: 'Mitr', sans-serif;
      background: linear-gradient(135deg, #fdfbfb, #ebedee);
      text-align: center;
      padding: 100px;
      color: #333;
    }
    .logout-box {
      background: #fff;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      display: inline-block;
      animation: pop 0.8s ease;
    }
    @keyframes pop {
      0% { transform: scale(0.8); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }
    .emoji {
      font-size: 50px;
      margin-bottom: 20px;
    }
    .text {
      font-size: 20px;
      margin-top: 10px;
    }
  </style>
  <link href="https://fonts.googleapis.com/css2?family=Mitr&display=swap" rel="stylesheet">
</head>
<body>
  <div class="logout-box">
    <div class="emoji">👋</div>
    <h2>กำลังออกจากระบบ...</h2>
    <div class="text">เจอกันใหม่นะคับเตงงงง 😘</div>
    <div class="text">กำลังพากลับไปยังหน้าเข้าสู่ระบบ...</div>
  </div>
</body>
</html>
