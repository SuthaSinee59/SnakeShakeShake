<?php
session_start();
include('../includes/db.php');

$error = '';
$login_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        if //(password_verify($password, $hashed_password)) อันนี้เป็นverifyรหัสแฮชนะคะ หนูเอามาใส่เพื่อทดลองฐานข้อมูลว่ารหัสยูเซอจะแปลงได้มั้ย ซึ่งมันยากต่อการแปลงกลับมาของแอดมินเพื่อแก้ไขรหัสมากค่ะ ก็เลยคั่น//ไปก่อนค่ะ5555 🙏

            ($password === $hashed_password) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $login_success = true;
        } else {
            $error = "ไม่ใช่ละพี่ เอาใหม่ใส่ให้ถูกกก 😅";
        }
    } else {
        $error = "ไม่ใช่ละพี่ เอาใหม่ใส่ให้ถูกกก 😅";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Login - SnakeShakeShake</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mitr&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background: linear-gradient(135deg, #fce4ec, #e0f7fa);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        h2 {
            color: #ba68c8;
            margin-bottom: 20px;
        }
        form {
            background: #ffffff;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        input {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        button {
            width: 95%;
            padding: 12px;
            background-color: #ff99cc;
            border: none;
            border-radius: 10px;
            color: #333;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #ff66b2;
        }
        .error {
            color: red;
            margin-bottom: 10px;
            font-weight: bold;
        }
        a {
            color: #6a1b9a;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }

        /* Popup */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .popup-box {
            font-family: 'Mitr', sans-serif;
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            animation: pop 0.8s ease;
            text-align: center;
            color: #333;
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
    <?php if ($login_success): ?>
        <meta http-equiv="refresh" content="3;url=dashboard.php">
    <?php endif; ?>
</head>
<body>

<?php if ($login_success): ?>
    <div class="overlay">
        <div class="popup-box">
            <div class="emoji">🚀</div>
            <h2>กำลังเข้าสู่ระบบ...</h2>
            <div class="text">ขอให้สนุกกับงูสุดเฟี้ยววว! 🐍</div>
            <div class="text">กำลังพาไปยังหน้าหลักจั๊ฟ...</div>
        </div>
    </div>
<?php else: ?>

    <h2>เข้าสู่ระบบ SnakeShakeShake 🐍</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="ชื่อผู้ใช้" required><br>
        <input type="password" name="password" placeholder="รหัสผ่าน" required><br>
        <button type="submit">✨ ล็อกอิน ✨</button>
    </form>

    <p style="margin-top: 15px;">ยังไม่มีบัญชี? <a href="register.php">ลงทะเบียนเลยจ้า</a></p>

<?php endif; ?>
</body>
</html>
