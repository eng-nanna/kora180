-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 30, 2018 at 08:29 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `football`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(70) NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`) VALUES
(1, 'demo_admin', '$2y$10$N1v8OPyFs5y3H6XUL9brD.uffAVWfo4P2nk92eOl1NjHecf8P6AuS');

-- --------------------------------------------------------

--
-- Table structure for table `blogger`
--

DROP TABLE IF EXISTS `blogger`;
CREATE TABLE IF NOT EXISTS `blogger` (
  `blogger_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(75) NOT NULL,
  `publish_date` date NOT NULL,
  `img` varchar(70) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`blogger_id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blogger`
--

INSERT INTO `blogger` (`blogger_id`, `title`, `publish_date`, `img`, `content`) VALUES
(2, 'مقالة لآراء حرة', '2018-04-07', 'pic.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(3, 'مقال جديد', '2018-04-10', 'avatar.png', 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق. إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع. ومن هنا وجب على المصمم أن يضع نصوصا مؤقتة على التصميم ليظهر للعميل الشكل كاملاً،دور مولد النص العربى أن يوفر على المصمم عناء البحث عن نص بديل لا علاقة له بالموضوع الذى يتحدث عنه التصميم فيظهر بشكل لا يليق. هذا النص يمكن أن يتم تركيبه على أي تصميم دون مشكلة فلن يبدو وكأنه نص منسوخ، غير منظم، غير منسق، أو حتى غير مفهوم. لأنه مازال نصاً بديلاً ومؤقتاً.');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category`) VALUES
(1, 'أهداف المباريات'),
(3, 'ملخص المباريات'),
(2, 'مهارات خاصة');

-- --------------------------------------------------------

--
-- Table structure for table `leagues`
--

DROP TABLE IF EXISTS `leagues`;
CREATE TABLE IF NOT EXISTS `leagues` (
  `league_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `league_name` varchar(80) NOT NULL,
  `league_logo` varchar(80) NOT NULL,
  `league_year` varchar(8) NOT NULL,
  PRIMARY KEY (`league_id`),
  UNIQUE KEY `league_name` (`league_name`,`league_year`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `leagues`
--

INSERT INTO `leagues` (`league_id`, `league_name`, `league_logo`, `league_year`) VALUES
(1, 'الدوري المصري', 'Egy_League_logo.png', '2018'),
(2, 'الدوري الانجليزي', '533px-Premier_League_Logo.png', '2016'),
(3, 'الدوري الانجليزي', '533px-Premier_League_Logo.png', '2018'),
(4, 'دوري أوروبا', '', '2017');

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
CREATE TABLE IF NOT EXISTS `matches` (
  `match_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `league_id` int(10) UNSIGNED NOT NULL,
  `team1` int(10) UNSIGNED NOT NULL,
  `team2` int(10) UNSIGNED NOT NULL,
  `match_date` date NOT NULL,
  `match_time` time NOT NULL,
  `match_url` varchar(255) NOT NULL,
  PRIMARY KEY (`match_id`),
  UNIQUE KEY `match_url` (`match_url`),
  KEY `league_id` (`league_id`),
  KEY `team1` (`team1`),
  KEY `team2` (`team2`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`match_id`, `league_id`, `team1`, `team2`, `match_date`, `match_time`, `match_url`) VALUES
(11, 1, 1, 2, '2018-04-06', '16:00:00', 'https://www.youtube.com/watch?v=oFwbk_oIZ2Q'),
(12, 3, 9, 8, '2018-04-07', '20:00:00', 'https://www.youtube.com/watch?v=ik6m3sckzSE'),
(13, 1, 3, 1, '2018-04-07', '21:00:00', 'https://www.youtube.com/watch?v=55v1RSUcxxA'),
(14, 3, 4, 7, '2018-04-07', '12:00:00', 'https://www.youtube.com/watch?v=WW4Bg43afvk'),
(16, 1, 2, 3, '2018-04-08', '18:00:00', 'https://www.youtube.com/watch?v=p9QuQBrPTE8');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `publish_date` date NOT NULL,
  `img` varchar(40) NOT NULL,
  `details` text NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `title`, `publish_date`, `img`, `details`) VALUES
(1, 'خبر هام', '2018-03-15', '_100723680_hi045968071.jpg', 'ومن هنا وجب على المصمم أن يضع نصوصا مؤقتة على التصميم ليظهر للعميل الشكل كاملاً،دور مولد النص العربى أن يوفر على المصمم عناء البحث عن نص بديل لا علاقة له بالموضوع الذى يتحدث عنه التصميم فيظهر بشكل لا يليق.\r\nهذا النص يمكن أن يتم تركيبه على أي تصميم دون مشكلة فلن يبدو وكأنه نص منسوخ، غير منظم، غير منسق، أو حتى غير مفهوم. لأنه مازال نصاً بديلاً ومؤقتاً.'),
(2, 'خبر عاجل', '2018-03-15', '_100723680_hi045968071.jpg', 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.\r\nإذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.\r\nومن هنا وجب على المصمم أن يضع نصوصا مؤقتة على التصميم ليظهر للعميل الشكل كاملاً،دور مولد النص العربى أن يوفر على المصمم عناء البحث عن نص بديل لا علاقة له بالموضوع الذى يتحدث عنه التصميم فيظهر بشكل لا يليق.\r\nهذا النص يمكن أن يتم تركيبه على أي تصميم دون مشكلة فلن يبدو وكأنه نص منسوخ، غير منظم، غير منسق، أو حتى غير مفهوم. لأنه مازال نصاً بديلاً ومؤقتاً.');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

DROP TABLE IF EXISTS `scores`;
CREATE TABLE IF NOT EXISTS `scores` (
  `score_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `match_id` int(10) UNSIGNED NOT NULL,
  `team1` int(11) NOT NULL,
  `team2` int(11) NOT NULL,
  PRIMARY KEY (`score_id`),
  UNIQUE KEY `match_id` (`match_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`score_id`, `match_id`, `team1`, `team2`) VALUES
(6, 11, 1, 1),
(7, 16, 1, 3),
(8, 13, 1, 2),
(9, 12, 1, 3),
(10, 14, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `team_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_name` varchar(40) NOT NULL,
  `team_logo` varchar(80) NOT NULL,
  PRIMARY KEY (`team_id`),
  UNIQUE KEY `team_name` (`team_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`team_id`, `team_name`, `team_logo`) VALUES
(1, 'الأهلي المصري', 'Ahly_Fc_new_logo.png'),
(2, 'الزمالك', '270px-ZamalekSC.svg.png'),
(3, 'الاسماعيلي', 'El-Ismaily-Club-Logo.png'),
(4, 'برشلونة', '213px-Barcelona-logo.svg.png'),
(5, 'المريخ السوداني', ''),
(6, 'العربي القطري', ''),
(7, 'ريال مدريد', '642px-ريال_مدريد.svg.png'),
(8, 'ليفربول', 'Liverpool_FC_logo.png'),
(9, 'مانشستر سيتي', 'manchester.png');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos` (
  `video_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED NOT NULL,
  `video_title` varchar(150) NOT NULL,
  `video` varchar(255) NOT NULL,
  `video_date` datetime NOT NULL,
  PRIMARY KEY (`video_id`),
  UNIQUE KEY `video_title` (`video_title`),
  UNIQUE KEY `video` (`video`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`video_id`, `category_id`, `video_title`, `video`, `video_date`) VALUES
(41, 3, 'new video1', 'video1.mp4', '2018-04-07 11:17:56'),
(42, 2, 'new video2', 'dolbycanyon.mp4', '2018-04-07 11:18:21'),
(43, 2, 'new video3', 'video2.mp4', '2018-04-07 11:45:05');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`league_id`) REFERENCES `leagues` (`league_id`),
  ADD CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`team1`) REFERENCES `teams` (`team_id`),
  ADD CONSTRAINT `matches_ibfk_3` FOREIGN KEY (`team2`) REFERENCES `teams` (`team_id`);

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `matches` (`match_id`);

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
