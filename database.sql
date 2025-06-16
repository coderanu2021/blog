-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 16, 2025 at 09:30 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog`
--

DROP TABLE IF EXISTS `tbl_blog`;
CREATE TABLE IF NOT EXISTS `tbl_blog` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `short_desc` text,
  `long_desc` longtext,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_blog`
--

INSERT INTO `tbl_blog` (`id`, `title`, `meta_title`, `short_desc`, `long_desc`, `image`, `category_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'The Future of Artificial Intelligence in 2024', 'AI Trends and Predictions for 2024', 'Explore the latest developments in AI technology and how they will shape our future. From machine learning to neural networks, discover what\'s next in the world of artificial intelligence.', 'Artificial Intelligence continues to evolve at an unprecedented pace. In 2024, we\'re seeing remarkable advancements in various AI domains. Machine learning models are becoming more sophisticated, capable of understanding and generating human-like text, images, and even code. Neural networks are achieving new levels of accuracy in pattern recognition and decision-making processes.\r\n\r\nThe integration of AI into everyday applications is becoming more seamless. From virtual assistants to autonomous vehicles, AI is transforming how we interact with technology. Companies are leveraging AI for predictive analytics, customer service automation, and process optimization.\r\n\r\nOne of the most exciting developments is the emergence of more accessible AI tools that allow businesses of all sizes to implement AI solutions. This democratization of AI technology is fostering innovation across industries.\r\n\r\nHowever, with these advancements come important considerations about ethics, privacy, and security. As AI becomes more prevalent, we must ensure that its development and implementation are guided by responsible practices and regulations.\r\n\r\nThe future of AI holds immense potential, but it\'s crucial that we approach its development with careful consideration of its impact on society.', 'assets/images/blog/ai-future.jpg', 1, 1, 1, '2025-05-31 05:28:20', '2025-05-31 05:28:20'),
(2, '10 Essential Healthy Habits for 2024', 'Healthy Living Tips and Habits', 'Discover the most important habits you should adopt for a healthier lifestyle in 2024. From nutrition to exercise, learn how to improve your overall well-being.', 'Maintaining good health is more important than ever in our fast-paced world. Here are ten essential habits that can significantly improve your quality of life:\r\n\r\n1. Regular Exercise\r\nMake physical activity a daily priority. Even 30 minutes of moderate exercise can boost your energy levels and improve your mood.\r\n\r\n2. Balanced Nutrition\r\nFocus on whole foods, plenty of vegetables, and lean proteins. Stay hydrated and limit processed foods and sugars.\r\n\r\n3. Quality Sleep\r\nAim for 7-9 hours of sleep each night. Establish a consistent sleep schedule and create a relaxing bedtime routine.\r\n\r\n4. Stress Management\r\nPractice mindfulness, meditation, or deep breathing exercises to manage stress effectively.\r\n\r\n5. Regular Health Check-ups\r\nStay on top of your health with regular check-ups and preventive screenings.\r\n\r\n6. Digital Wellness\r\nTake regular breaks from screens and maintain healthy boundaries with technology.\r\n\r\n7. Social Connections\r\nNurture meaningful relationships and maintain an active social life.\r\n\r\n8. Mental Health Care\r\nPrioritize your mental well-being and seek help when needed.\r\n\r\n9. Environmental Awareness\r\nBe mindful of your impact on the environment and make sustainable choices.\r\n\r\n10. Continuous Learning\r\nKeep your mind active by learning new skills and staying curious.\r\n\r\nRemember, small changes can lead to significant improvements in your overall health and well-being.', 'assets/images/blog/healthy-habits.jpg', 2, 1, 1, '2025-05-31 05:28:20', '2025-05-31 05:28:20'),
(3, 'Hidden Gems: Unexplored Travel Destinations', 'Off the Beaten Path Travel Spots', 'Discover amazing travel destinations that are off the beaten path. These hidden gems offer unique experiences away from tourist crowds.', 'Travel enthusiasts are always looking for new and exciting destinations to explore. While popular tourist spots have their charm, there\'s something special about discovering lesser-known places. Here are some hidden gems that deserve your attention:\r\n\r\n1. The Azores, Portugal\r\nThis archipelago in the middle of the Atlantic Ocean offers stunning volcanic landscapes, hot springs, and whale watching opportunities.\r\n\r\n2. Bhutan\r\nKnown as the \"Land of the Thunder Dragon,\" Bhutan offers a unique blend of ancient traditions and stunning Himalayan landscapes.\r\n\r\n3. Madagascar\r\nThis island nation is home to unique wildlife and diverse ecosystems that can\'t be found anywhere else in the world.\r\n\r\n4. Georgia (the country)\r\nWith its rich history, delicious cuisine, and beautiful Caucasus Mountains, Georgia is a hidden treasure in Eastern Europe.\r\n\r\n5. Raja Ampat, Indonesia\r\nThis remote archipelago offers some of the world\'s best diving spots and pristine beaches.\r\n\r\nEach of these destinations offers unique experiences and opportunities to connect with local cultures. Remember to travel responsibly and respect local customs and environments.', 'assets/images/blog/travel-destinations.jpg', 3, 1, 1, '2025-05-31 05:28:20', '2025-05-31 05:28:20'),
(4, 'Mastering the Art of Home Cooking', 'Cooking Tips and Techniques', 'Learn essential cooking techniques and tips to elevate your home cooking skills. From basic methods to advanced techniques, become a better cook.', 'Cooking at home can be both rewarding and challenging. Whether you\'re a beginner or an experienced cook, there\'s always room for improvement. Here are some essential tips and techniques to enhance your culinary skills:\r\n\r\n1. Knife Skills\r\nMastering basic knife techniques is fundamental to efficient cooking. Learn proper cutting methods for different ingredients.\r\n\r\n2. Understanding Heat\r\nDifferent cooking methods require different heat levels. Learn to control your stove and oven temperatures effectively.\r\n\r\n3. Seasoning\r\nUnderstanding how to balance flavors with salt, herbs, and spices is crucial for creating delicious dishes.\r\n\r\n4. Meal Planning\r\nPlan your meals ahead to save time and reduce food waste. Batch cooking can be a game-changer for busy households.\r\n\r\n5. Ingredient Selection\r\nLearn to choose the best quality ingredients and understand their characteristics.\r\n\r\n6. Basic Sauces\r\nMaster a few basic sauces that can elevate any dish.\r\n\r\n7. Food Safety\r\nUnderstand proper food handling and storage techniques to ensure safe cooking.\r\n\r\nRemember, cooking is both an art and a science. Don\'t be afraid to experiment and make mistakes – that\'s how you learn and improve.', 'assets/images/blog/cooking-tips.jpg', 4, 1, 1, '2025-05-31 05:28:20', '2025-05-31 05:28:20'),
(5, 'Minimalism: Living with Less', 'Minimalist Lifestyle Guide', 'Explore the benefits of minimalism and learn how to simplify your life. Discover practical tips for decluttering and living with intention.', 'Minimalism is more than just a design aesthetic – it\'s a lifestyle choice that can lead to greater happiness and fulfillment. Here\'s how to embrace minimalism in your life:\r\n\r\n1. Decluttering\r\nStart by removing unnecessary items from your living space. Keep only what adds value to your life.\r\n\r\n2. Digital Minimalism\r\nReduce digital clutter by organizing your digital files and limiting screen time.\r\n\r\n3. Mindful Consumption\r\nBe intentional about what you bring into your life. Quality over quantity is key.\r\n\r\n4. Time Management\r\nSimplify your schedule and focus on what truly matters.\r\n\r\n5. Financial Minimalism\r\nReduce expenses and focus on experiences rather than possessions.\r\n\r\nThe benefits of minimalism include:\r\n- Reduced stress and anxiety\r\n- More time for what matters\r\n- Better financial health\r\n- Increased focus and productivity\r\n- Environmental sustainability\r\n\r\nRemember, minimalism looks different for everyone. Find what works for you and your lifestyle.', 'assets/images/blog/minimalism.jpg', 5, 1, 1, '2025-05-31 05:28:20', '2025-05-31 05:28:20'),
(6, 'Digital Marketing Trends for 2024', 'Latest Marketing Strategies', 'Stay ahead of the curve with the latest digital marketing trends. Learn about new strategies and technologies shaping the marketing landscape.', 'Digital marketing continues to evolve rapidly, with new trends and technologies emerging constantly. Here are the key trends shaping the industry in 2024:\r\n\r\n1. AI-Powered Marketing\r\nArtificial intelligence is revolutionizing how businesses approach marketing, from personalized content to predictive analytics.\r\n\r\n2. Voice Search Optimization\r\nWith the growing popularity of voice assistants, optimizing for voice search is becoming increasingly important.\r\n\r\n3. Video Marketing\r\nShort-form video content continues to dominate social media platforms.\r\n\r\n4. Social Commerce\r\nThe integration of shopping features into social media platforms is transforming the e-commerce landscape.\r\n\r\n5. Sustainability Marketing\r\nConsumers are increasingly drawn to brands that demonstrate environmental and social responsibility.\r\n\r\n6. Personalization\r\nAdvanced data analytics enable more sophisticated personalization strategies.\r\n\r\n7. Privacy-First Marketing\r\nWith increasing privacy regulations, marketers must adapt their strategies to respect user privacy.\r\n\r\nSuccess in digital marketing requires staying informed about these trends and adapting strategies accordingly. Focus on creating authentic, valuable content that resonates with your target audience.', 'assets/images/blog/digital-marketing.jpg', 6, 1, 1, '2025-05-31 05:28:20', '2025-05-31 05:28:20'),
(8, 'teat', 'test', 'test', 'test', 'uploads/blog_684fe359ae241_1750066009.png', 3, 2, 1, '2025-06-16 09:26:49', '2025-06-16 09:26:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog_category`
--

DROP TABLE IF EXISTS `tbl_blog_category`;
CREATE TABLE IF NOT EXISTS `tbl_blog_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_blog_category`
--

INSERT INTO `tbl_blog_category` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Technology', NULL, '2025-05-31 05:23:58', '2025-05-31 05:23:58'),
(2, 'Health & Wellness', NULL, '2025-05-31 05:23:58', '2025-05-31 05:23:58'),
(3, 'Travel', NULL, '2025-05-31 05:23:58', '2025-05-31 05:23:58'),
(4, 'Food & Cooking', NULL, '2025-05-31 05:23:58', '2025-05-31 05:23:58'),
(5, 'Lifestyle', NULL, '2025-05-31 05:23:58', '2025-05-31 05:23:58'),
(6, 'Business', NULL, '2025-05-31 05:23:58', '2025-05-31 05:23:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

DROP TABLE IF EXISTS `tbl_comments`;
CREATE TABLE IF NOT EXISTS `tbl_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `blog_id` int NOT NULL,
  `user_id` int NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pending, 1=approved',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_comments`
--

INSERT INTO `tbl_comments` (`id`, `blog_id`, `user_id`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 'hii  i  like it ', 1, '2025-06-16 07:24:38', '2025-06-16 07:24:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscribers`
--

DROP TABLE IF EXISTS `tbl_subscribers`;
CREATE TABLE IF NOT EXISTS `tbl_subscribers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `status` tinyint(1) DEFAULT '1',
  `verification_token` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `name`, `email`, `password`, `phone_no`, `profile_photo`, `role`, `status`, `verification_token`, `is_verified`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, 'admin', 1, NULL, 0, '2025-05-31 05:23:58', '2025-05-31 05:23:58'),
(2, 'test', 'test@gmail.com', '$2y$10$T9oEEmtvq7HmJ9XMGSYjzekGEM0WKV40kwa.7L7/dfvYeEcxXNMQe', '123456789', NULL, 'admin', 1, NULL, 0, '2025-06-16 04:44:42', '2025-06-16 04:53:17');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
