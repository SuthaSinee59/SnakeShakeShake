<?php
include('../includes/auth.php');
include('../includes/db.php');

$user_id = $_SESSION['user_id'];
$error = $success = "";

// ดึงข้อมูลผู้ใช้
$stmt = $mysqli->prepare("SELECT username, display_name, profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $display_name, $profile_image);
$stmt->fetch();
$stmt->close();

// อัปโหลดรูปภาพ
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['profile_image']['tmp_name'];
    $fileName = $_FILES['profile_image']['name'];
    $fileSize = $_FILES['profile_image']['size'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($fileExt, $allowedExts)) {
        $error = "ประเภทไฟล์ไม่ถูกต้อง😰 (เฉพาะ JPG, PNG, GIF)";
    } elseif ($fileSize > 2 * 1024 * 1024) {
        $error = "ไฟล์ใหญ่เกิน 2MB😥";
    } else {
        $newFileName = uniqid() . "." . $fileExt;
        $uploadDir = __DIR__ . "/../uploads/";
        $uploadPath = $uploadDir . $newFileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($fileTmp, $uploadPath)) {
            $stmt = $mysqli->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
            $stmt->bind_param("si", $newFileName, $user_id);
            $stmt->execute();
            $stmt->close();
            $success = "อัปโหลดรูปสำเร็จแล้ว! 📸";
            $profile_image = $newFileName;
        } else {
            $error = "ไม่สำเร็จ😥";
        }
    }
}

// เปลี่ยนชื่อแสดง
if (isset($_POST['update_display'])) {
    $new_display = trim($_POST['display_name']);
    if ($new_display !== "") {
        $stmt = $mysqli->prepare("UPDATE users SET display_name = ? WHERE id = ?");
        $stmt->bind_param("si", $new_display, $user_id);
        if ($stmt->execute()) {
            $success = "อัปเดตชื่อเรียบร้อยแล้ว! ✨";
            $display_name = $new_display;
        }
        $stmt->close();
    } else {
        $error = "ชื่อผู้เล่นต้องไม่เว้นว่าง 👌";
    }
}

// เปลี่ยนรหัสผ่าน
if (isset($_POST['update_password'])) {
    $new_password = $_POST['password'];
    if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/', $new_password)) {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed, $user_id);
        if ($stmt->execute()) {
            $success = "อัปเดตรหัสผ่านเรียบร้อย! 🥰";
        }
        $stmt->close();
    } else {
        $error = "รหัสผ่านไม่ปลอดภัยพอ🐱‍👤 (ต้องมีตัวใหญ่ ตัวเล็ก ตัวเลข และอักขระพิเศษ อย่างน้อย 6 ตัว)";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตั้งค่าผู้ใช้</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background: linear-gradient(135deg, #fce4ec, #e0f7fa);
            text-align: center;
            padding: 20px;
        }
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px dashed #ff66b2;
            background-color: #fff;
            padding: 4px;
        }
        form {
            margin: 20px auto;
            width: 320px;
            background: #fff;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        input, button {
            width: 100%;
            margin: 10px 0;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        button {
            background-color: #ffc0cb;
            color: #333;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #ff99bb;
        }
        .popup {
            display: none;
            position: fixed;
            top: 25%;
            left: 50%;
            transform: translateX(-50%);
            background: #dfffd9;
            border: 2px solid #2ecc71;
            padding: 20px;
            border-radius: 10px;
            z-index: 1000;
        }
        .back-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h2>⚙️ ตั้งค่าบัญชีผู้เล่น</h2>
    <img src="../uploads/<?= htmlspecialchars($profile_image ?: 'default.png') ?>" alt="Profile" class="profile-img">

    <form method="post" enctype="multipart/form-data">
        <label>อัปโหลดรูปโปรไฟล์ใหม่:</label>
        <input type="file" name="profile_image" accept="image/*">
        <button type="submit">📸 อัปโหลด</button>
    </form>

    <form method="post">
        <label>ชื่อผู้ใช้ล็อกอิน: <strong><?= htmlspecialchars($username) ?></strong></label><br>
        <input type="text" name="display_name" value="<?= htmlspecialchars($display_name) ?>" placeholder="ชื่อที่แสดง">
        <button type="submit" name="update_display">💬 อัปเดตชื่อ</button>
    </form>

    <form method="post">
        <input type="password" name="password" placeholder="รหัสผ่านใหม่">
        <button type="submit" name="update_password">🔐 อัปเดตรหัสผ่าน</button>
    </form>

    <div class="back-btn">
        <a href="dashboard.php"><button>หน้าหลัก</button></a>
    </div>

    <?php if ($success): ?>
        <div class="popup" id="popup"><?= $success ?> เรียบร้อยแล้ว 🎉</div>
        <script>
            document.getElementById("popup").style.display = "block";
            setTimeout(() => document.getElementById("popup").style.display = "none", 3000);
        </script>
    <?php elseif ($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

</body>
</html>
