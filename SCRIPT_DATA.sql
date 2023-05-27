-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 27, 2023 lúc 01:47 PM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `_web`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `gender` enum('nam','nu') NOT NULL,
  `bday` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`name`, `username`, `gender`, `bday`, `email`, `password`, `image`) VALUES
('Nhân Thành', 'nhanht2502', 'nam', '2002-02-25', 'nhanht2502@gmail.com', 'nhanthanh123', 'nhanht2502-avt.jpg'),
('nhanht2502', 'nhanht25022', 'nu', '0021-04-23', 'huathanhnhan2002@gmail.com', '123', NULL),
('Hứa Thành Nhân', 'nhanthanh2502', 'nam', '0009-09-09', '123123@gmail.com', 'nhanthanh123', 'nhanthanh2502-avt.png'),
('Hứa Thành Nhân', 'nhanthanh250223412', 'nam', '2002-04-23', 'nhanthanh12w3@gmail.com', 'nhanthanh123', 'nhanthanh250223412-avt.png'),
('Nguyễn Phương Vy', 'vyvy24102002', 'nu', '2002-10-24', '1231@gmail.com', 'vyvy241002', 'vyvy24102002-avt.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `listtopic`
--

CREATE TABLE `listtopic` (
  `username` varchar(20) NOT NULL,
  `idTopic` varchar(40) NOT NULL,
  `titleTopic` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: private;\r\n1: public',
  `description` text DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `listtopic`
--

INSERT INTO `listtopic` (`username`, `idTopic`, `titleTopic`, `status`, `description`, `date`) VALUES
('nhanht2502', 'nhanht2502-1683438075', 'Phát triển ứng dụng web', 0, 'Demo PTUD Web', '2023-05-09 07:05:02'),
('nhanht2502', 'nhanht2502-1683613971', 'Chẳn hay lẻ', 1, '', '2023-05-09 13:51:10'),
('nhanht25022', 'nhanht25022-1683358157', 'Test', 0, '', '2023-05-06 14:29:17'),
('nhanht25022', 'nhanht25022-1683615149', 'test 9/5/2023', 0, '', '2023-05-09 13:53:20'),
('nhanthanh250223412', 'nhanthanh2502-1683356373', 'Test thử', 1, '', '2023-05-06 13:59:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quest`
--

CREATE TABLE `quest` (
  `idTopic` varchar(40) NOT NULL,
  `idQuest` varchar(50) NOT NULL,
  `nameQuest` text NOT NULL,
  `answer` text NOT NULL,
  `score` int(2) DEFAULT 10,
  `image` varchar(1024) DEFAULT NULL,
  `date-create` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `quest`
--

INSERT INTO `quest` (`idTopic`, `idQuest`, `nameQuest`, `answer`, `score`, `image`, `date-create`) VALUES
('nhanht2502-1683438075', 'nhanht2502-1683438075^Q1', 'Câu hỏi 1', 'Trả lời 1', 5, '', '2023-05-07 12:43:26'),
('nhanht2502-1683438075', 'nhanht2502-1683438075^Q10', 'Câu10', 'Trl10', 10, '', '2023-05-07 12:54:16'),
('nhanht2502-1683438075', 'nhanht2502-1683438075^Q2', 'Câu 2', 'Trl2', 10, '', '2023-05-07 12:53:11'),
('nhanht2502-1683438075', 'nhanht2502-1683438075^Q3', 'Câu 3', 'Trl3', 10, '', '2023-05-07 12:53:17'),
('nhanht2502-1683438075', 'nhanht2502-1683438075^Q4', 'Cau4', 'Trl4', 10, '', '2023-05-07 12:53:22'),
('nhanht2502-1683438075', 'nhanht2502-1683438075^Q5', 'Câu5', 'Trl5', 10, '', '2023-05-07 12:53:28'),
('nhanht2502-1683438075', 'nhanht2502-1683438075^Q6', 'Cau6', 'Trl6', 10, '', '2023-05-07 12:53:34'),
('nhanht2502-1683438075', 'nhanht2502-1683438075^Q7', 'cau8', 'Trl8', 10, '', '2023-05-07 12:53:42'),
('nhanht2502-1683438075', 'nhanht2502-1683438075^Q8', 'Câu9', 'Câu 9 trl9', 10, '', '2023-05-07 12:53:52'),
('nhanht2502-1683438075', 'nhanht2502-1683438075^Q9', 'Câu10', 'Trl10', 10, '', '2023-05-07 12:53:58'),
('nhanht2502-1683613971', 'nhanht2502-1683613971^Q1', '2', 'Chẵn', 10, '', '2023-05-09 13:33:38'),
('nhanht2502-1683613971', 'nhanht2502-1683613971^Q2', '3', 'Lẻ', 10, '', '2023-05-09 13:33:56'),
('nhanht2502-1683613971', 'nhanht2502-1683613971^Q3', '23', 'Lẻ', 10, '', '2023-05-09 13:34:07'),
('nhanht2502-1683613971', 'nhanht2502-1683613971^Q4', '32', 'Chẵn', 10, '', '2023-05-09 13:34:21'),
('nhanht2502-1683613971', 'nhanht2502-1683613971^Q5', '99', 'Lẻ', 10, '', '2023-05-09 13:34:39'),
('nhanht2502-1683613971', 'nhanht2502-1683613971^Q6', '998', 'Chẵn', 10, '', '2023-05-09 13:34:51'),
('nhanht2502-1683613971', 'nhanht2502-1683613971^Q7', '1898', 'Chẵn', 10, '', '2023-05-09 13:35:18'),
('nhanht2502-1683613971', 'nhanht2502-1683613971^Q8', '989', 'Lẻ', 10, '', '2023-05-09 13:35:31'),
('nhanht2502-1683613971', 'nhanht2502-1683613971^Q9', '12', 'Chẵn', 10, '', '2023-05-09 13:35:54'),
('nhanht25022-1683615149', 'nhanht25022-1683615149^Q1', 'Câu 1', 'Trl1', 10, 'nhanht25022-1683615149^Q1.png', '2023-05-09 13:52:57'),
('nhanthanh2502-1683356373', 'nhanthanh2502-1683356373^Q1', 'Câu hỏi 1', 'Đáp án 1', 10, '', '2023-05-06 14:01:39'),
('nhanthanh2502-1683356373', 'nhanthanh2502-1683356373^Q2', 'Câu hỏi 2', 'Đáp án 2', 15, 'nhanthanh2502-1683356373^Q2.png', '2023-05-06 14:01:58'),
('nhanthanh2502-1683356373', 'nhanthanh2502-1683356373^Q3', 'Câu 3', 'trả lời 3', 10, 'nhanthanh2502-1683356373^Q3.png', '2023-05-06 14:02:12'),
('nhanthanh2502-1683356373', 'nhanthanh2502-1683356373^Q4', 'Câu 4', 'Trl4', 20, '', '2023-05-06 14:02:22'),
('nhanthanh2502-1683356373', 'nhanthanh2502-1683356373^Q5', 'Câu 5', 'Câu   trả lời 5', 20, 'nhanthanh2502-1683356373^Q5.png', '2023-05-06 14:03:06'),
('nhanthanh2502-1683356373', 'nhanthanh2502-1683356373^Q6', 'Câu 6', '5 điểm', 5, '', '2023-05-06 14:03:20'),
('nhanthanh2502-1683356373', 'nhanthanh2502-1683356373^Q7', 'Câu 7', 'Mặc định', 10, '', '2023-05-06 14:03:30'),
('nhanthanh2502-1683356373', 'nhanthanh2502-1683356373^Q8', 'Câu 8', 'Trl', 10, '', '2023-05-06 14:03:50'),
('nhanthanh2502-1683356373', 'nhanthanh2502-1683356373^Q9', 'Câu9', 'trl 9', 10, '', '2023-05-06 14:03:58');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`username`),
  ADD KEY `username` (`username`);

--
-- Chỉ mục cho bảng `listtopic`
--
ALTER TABLE `listtopic`
  ADD PRIMARY KEY (`idTopic`),
  ADD KEY `username` (`username`);

--
-- Chỉ mục cho bảng `quest`
--
ALTER TABLE `quest`
  ADD PRIMARY KEY (`idQuest`),
  ADD KEY `idQuest` (`idTopic`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `listtopic`
--
ALTER TABLE `listtopic`
  ADD CONSTRAINT `listtopic_ibfk_1` FOREIGN KEY (`username`) REFERENCES `account` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `quest`
--
ALTER TABLE `quest`
  ADD CONSTRAINT `quest_ibfk_1` FOREIGN KEY (`idTopic`) REFERENCES `listtopic` (`idTopic`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
