<?php
session_start();
include('../includes/db.php');

$error = '';
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!preg_match('/^[A-Za-z0-9]+$/', $username)) {
        $error = "ชื่อผู้ใช้ต้องเป็น A-Z, a-z, 0-9 เท่านั้นน้า~";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/', $password)) {
        $error = "รหัสผ่านต้องมี a-z, A-Z, ตัวเลข,  และอักขระพิเศษอย่างน้อย 1 ตัว น้า!";
    } else {
       // $hashed_password = password_hash($password, PASSWORD_DEFAULT); อันนี้เป็นรหัสแฮชนะคะ หนูเอามาใส่เพื่อทดลองฐานข้อมูลว่ารหัสยูเซอจะแปลงได้มั้ย ซึ่งมันยากต่อการแปลงกลับมาของแอดมินเพื่อแก้ไขรหัสมากค่ะ ก็เลยคั่น//ไปก่อนค่ะ5555 🙏
       // $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        //$stmt->bind_param("ss", $username, $hashed_password); 

        $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)"); //จึงเลือกการเก็บรหัสผ่านแบบ plain text แทนนะคะ
        $stmt->bind_param("ss", $username, $password); 

        try {
            if ($stmt->execute()) {
                $success = true;
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $error = "ชื่อผู้ใช้นี้ถูกใช้แน้ว ลองชื่อใหม่ดูน้าา~";
            } else {
                $error = "เกิดข้อผิดพลาด: " . $e->getMessage();
            }
        }
    }
}
?>

<?php if ($success): ?>
<!-- 🎉 Splash สำหรับสมัครสมาชิกสำเร็จ -->
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สมัครสำเร็จแล้ว!</title>
    <meta http-equiv="refresh" content="3;url=login.php">
    <link href="https://fonts.googleapis.com/css2?family=Mitr&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Mitr', sans-serif;
            background: linear-gradient(135deg, #fef9f9, #f4f1fb);
            text-align: center;
            padding: 100px;
            color: #555;
        }
        .splash-box {
            background: #fff;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: inline-block;
            animation: pop 0.7s ease;
        }
        @keyframes pop {
            0% { transform: scale(0.85); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .emoji {
            font-size: 60px;
            margin-bottom: 15px;
        }
        h2 {
            margin: 0;
            font-size: 28px;
            color: #444;
        }
        .text {
            margin-top: 10px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="splash-box">
        <div class="emoji">🎉</div>
        <h2>สมัครสมาชิกสำเร็จแล้ว เย้~</h2>
        <div class="text">ยินดีต้อนรับเข้าสู่ SnakeShakeShake 🐍</div>
        <div class="text">กำลังพาไปล็อกอินนะค้าบบ... ⏳</div>
    </div>
</body>
</html>
<?php exit; endif; ?>

<!-- 🔄 ฟอร์มสมัครสมาชิก -->
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สมัครสมาชิก - SnakeShakeShake</title>
    <link href="https://fonts.googleapis.com/css2?family=Mitr&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Mitr', sans-serif;
            background-color: #fdf6f8;
            text-align: center;
            padding: 80px;
            color: #333;
        }
        input, button {
            padding: 12px;
            margin: 8px;
            width: 250px;
            font-size: 16px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #ff8fb2;
            color: white;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #f06292;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .form-box {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>มาสมัครสมาชิกใหม่กันน 🐣</h2>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="ชื่อผู้ใช้ (A-Z, 0-9)" required><br>
            <input type="password" name="password" placeholder="รหัสผ่าน" required><br>
            <p>รหัสผ่านอย่างน้อย 6 ตัว ต้องมี a-z, A-Z, ตัวเลข, และอักขระพิเศษอย่างน้อย 1 ตัว</p>
            <button type="submit">ลงทะเบียนเลยงับ</button>
        </form>
        <p>มีบัญชีอยู่แล้ว? <a href="login.php">ล็อกอินที่นี่</a></p>
    </div>
</body>
</html>
