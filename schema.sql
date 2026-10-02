-- Database Schema for Aljon Reyes 3D Developer Portfolio

CREATE DATABASE IF NOT EXISTS `resumexportfolio` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `resumexportfolio`;

-- Admin Users Table
CREATE TABLE IF NOT EXISTS `admin_users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- About Info Table
CREATE TABLE IF NOT EXISTS `site_settings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(50) NOT NULL UNIQUE,
    `setting_value` TEXT NOT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Projects Table
CREATE TABLE IF NOT EXISTS `projects` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(150) NOT NULL,
    `category` VARCHAR(100) NOT NULL,
    `short_description` TEXT NOT NULL,
    `full_description` TEXT,
    `technologies` VARCHAR(255) NOT NULL,
    `image_url` VARCHAR(255) NOT NULL,
    `demo_url` VARCHAR(255) DEFAULT '#',
    `github_url` VARCHAR(255) DEFAULT '#',
    `featured` TINYINT(1) DEFAULT 1,
    `sort_order` INT DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Skills Table
CREATE TABLE IF NOT EXISTS `skills` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `category` VARCHAR(100) NOT NULL,
    `proficiency_display` VARCHAR(20) DEFAULT '90%',
    `description` TEXT,
    `sort_order` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Process Steps Table
CREATE TABLE IF NOT EXISTS `process_steps` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `step_number` VARCHAR(10) NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `description` TEXT NOT NULL,
    `sort_order` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contact Messages Table
CREATE TABLE IF NOT EXISTS `contact_messages` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `subject` VARCHAR(150) DEFAULT 'General Inquiry',
    `message` TEXT NOT NULL,
    `status` ENUM('unread', 'read', 'replied') DEFAULT 'unread',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Admin Users Table (accounts are created via setup.php on first install, not seeded here)


-- Default Site Settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('hero_title_1', 'FULL-STACK'),
('hero_title_accent', '& SOFTWARE'),
('hero_title_2', 'DEVELOPER'),
('hero_description', 'Transforming ideas into practical digital experiences through web development, mobile applications, and creative technology.'),
('about_heading', 'BUILDING MEANINGFUL APPLICATIONS & DIGITAL EXPERIENCES'),
('about_p1', 'Hey, I\'m Aljon, a Computer Science student specializing in Application Development at Western Mindanao State University (WMSU).'),
('about_p2', 'Currently pursuing my degree at WMSU, I enjoy turning complex ideas into practical working systems, designing intuitive interfaces, and developing robust database-driven applications that solve real-world problems.'),
('about_p3', 'My experience includes PHP 8+ and MySQL web architectures, REST APIs, cross-platform mobile development with React Native, 3D WebGL scenes, and software engineering principles.'),
('hero_portrait_img', 'assets/images/aljon-face-developer.svg')
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);

-- Default Projects
INSERT INTO `projects` (`title`, `category`, `short_description`, `full_description`, `technologies`, `image_url`, `demo_url`, `github_url`, `featured`, `sort_order`) VALUES
(
    'Zamboanga Tour Guide Booking System', 
    'Web Application', 
    'A PHP and MySQL booking platform connecting tourists with local tour guides, featuring booking management, user roles, and guide profiles.', 
    'This platform enables tourists to browse verified local tour guides in Zamboanga, schedule bookings, manage itineraries, and provide ratings. Built with custom PHP backend architecture, PDO prepared statements, and Bootstrap 5 responsive layout.', 
    'PHP, MySQL, PDO, Bootstrap, JavaScript', 
    'assets/images/project1.png', 
    '#', 
    '#', 
    1, 
    1
),
(
    'ERP Help Desk Ticketing System', 
    'Enterprise System', 
    'A web-based IT support system for managing help desk tickets, assignments, approvals, service requests, and ticket status tracking.', 
    'Designed for enterprise IT departments to streamline issue resolution. Includes automated ticket routing based on urgency, multi-tier admin approvals, real-time status updates, and reporting analytics.', 
    'Node.js, Express, MySQL, HTML, CSS, JavaScript', 
    'assets/images/project2.png', 
    '#', 
    '#', 
    1, 
    2
),
(
    'LipatDorm Moving & Cargo-Sharing Platform', 
    'Mobile & Web App', 
    'A proposed mobile and web platform for affordable dormitory moving and cargo-sharing services tailored for students and dormers.', 
    'LipatDorm solves student transport challenges by matching students moving to dormitories with registered cargo partners. Features route optimization, fare estimation, booking history, and real-time tracking concepts.', 
    'React Native, Node.js, Express, MySQL', 
    'assets/images/project3.png', 
    '#', 
    '#', 
    1, 
    3
),
(
    'Student Attendance & Academic Performance Management System', 
    'Academic Software', 
    'An academic management system for tracking student attendance, grades, and identifying students with failing academic performance.', 
    'Built for educational institutions to monitor student attendance trends, compute weighted grades automatically, flag students at risk of academic failure, and generate comprehensive student report cards.', 
    'PHP, MySQL, PDO, HTML5, CSS3, JavaScript', 
    'assets/images/project4.png', 
    '#', 
    '#', 
    1, 
    4
)
ON DUPLICATE KEY UPDATE `title` = VALUES(`title`);

-- Default Skills
INSERT INTO `skills` (`name`, `category`, `proficiency_display`, `description`, `sort_order`) VALUES
('PHP', 'Backend Development', '95%', 'Custom OOP PHP & PDO database access', 1),
('MySQL', 'Database Management', '90%', 'Normalized relational schema design & query optimization', 2),
('JavaScript', 'Frontend Development', '92%', 'Vanilla ES6+, DOM manipulation & async API integrations', 3),
('Three.js', '3D Web Development', '85%', 'WebGL 3D scenes, lighting, shaders & canvas rendering', 4),
('React Native', 'Mobile Development', '88%', 'Cross-platform mobile apps for iOS and Android', 5),
('Node.js', 'Backend & API Development', '90%', 'RESTful APIs with Express and asynchronous I/O', 6)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Default Process Steps
INSERT INTO `process_steps` (`step_number`, `title`, `description`, `sort_order`) VALUES
('01', 'PLAN & ANALYZE', 'Understand the problem, identify user needs, and define system requirements.', 1),
('02', 'DESIGN & PROTOTYPE', 'Create database structures, application layouts, and user-friendly interfaces.', 2),
('03', 'DEVELOP & INTEGRATE', 'Implement frontend functionality, PHP backend logic, APIs, and database integration.', 3),
('04', 'TEST & IMPROVE', 'Test system functionality, fix errors, and improve performance and usability.', 4)
ON DUPLICATE KEY UPDATE `title` = VALUES(`title`);
