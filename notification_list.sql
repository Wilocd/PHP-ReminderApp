-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-04-04 20:26:24
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `notification_list`
--

-- --------------------------------------------------------

--
-- 資料表結構 `notifications_ajax`
--

CREATE TABLE `notifications_ajax` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `remark` varchar(100) NOT NULL,
  `finish_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `notifications_ajax`
--

INSERT INTO `notifications_ajax` (`id`, `title`, `remark`, `finish_status`) VALUES
(2, '4/15', '8:00起床', 1),
(3, '4/25', '11:00的高鐵', 1),
(9, '4/28', '11:30聚餐', 1),
(10, '5/1', '14:30看電影', 0),
(11, '5/5', '18:00 幫朋友慶生', 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `notifications_ajax`
--
ALTER TABLE `notifications_ajax`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `notifications_ajax`
--
ALTER TABLE `notifications_ajax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
