-- SQL export placeholder
-- สร้างตาราง users สำหรับ SnakeShakeShake
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `profile_picture` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- เพิ่มผู้ใช้ทดสอบ
INSERT INTO `users` (`username`, `password`) VALUES
('testuser', '$2y$10$eImiTXuWVxfM37uY4JANjQ==');
