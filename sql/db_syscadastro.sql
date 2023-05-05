-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 05-Maio-2023 às 18:12
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_syscadastro`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `syscadastro_item`
--

DROP TABLE IF EXISTS `syscadastro_item`;
CREATE TABLE IF NOT EXISTS `syscadastro_item` (
  `Item_id` int NOT NULL AUTO_INCREMENT,
  `Item_name` varchar(100) NOT NULL,
  `Item_email` varchar(100) NOT NULL,
  `Item_age` int NOT NULL,
  `Item_course_name` varchar(255) NOT NULL,
  `Item_created` varchar(255) NOT NULL,
  `Item_update` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `syscadastro_item`
--

INSERT INTO `syscadastro_item` (`Item_id`, `Item_name`, `Item_email`, `Item_age`, `Item_course_name`, `Item_created`, `Item_update`) VALUES
(1, 'Luidy Dos Reis Felix', 'luidyr300@gmail.com', 20, 'ADS', '2023-05-03 04:37:07', NULL),
(2, 'Luidy Dos Reis Felix', 'luidyr300@gmail.com', 50, 'asds', '2023-05-05 01:02:08', NULL),
(3, 'Luidy Dos Reis Felix', 'luidyr300@gmail.com', 50, 'asds', '2023-05-05 01:02:31', NULL),
(4, 'Luidy Felix', 'luidyr300@gmail.com', 50, 'ads', '2023-05-05 01:03:15', NULL),
(5, 'Luidy Felix', 'luidyr300@gmail.com', 50, 'ads', '2023-05-05 01:03:50', NULL),
(6, 'Luidy Felix', 'luidyr300@gmail.com', 50, 'ads', '2023-05-05 01:05:35', NULL),
(7, 'Luidy Felix', 'luidyr300@gmail.com', 50, 'ads', '2023-05-05 01:05:36', NULL),
(8, 'Luidy Dos Reis Felix', 'luidyr300@gmail.com', 60, 'ads', '2023-05-05 01:07:26', NULL),
(9, 'Luidy Felix', 'luidy@gmail.com', 15, 'ads', '2023-05-05 01:11:52', NULL),
(10, 'Portugues_br', 'matheusr400@gmail.com', 150, 'Pegadogira', '2023-05-05 01:53:29', NULL),
(11, 'Onnyx', 'luidy@gmail.com', 156, 'SADSASDAsd', '2023-05-05 02:46:06', '2023-05-05 14:00:00'),
(12, 'Eletrônicos', 'leltronicos@onnyx.com', 55, 'Pedagogia', '2023-05-05 05:39:34', NULL),
(13, 'Matheus', 'matheusr400@gmail.com', 20, 'Engenharia', '2023-05-05 02:42:26', NULL),
(14, 'Taina', 'luidy@gmail.com', 16, '2 ano', '2023-05-05 14:45:31', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
