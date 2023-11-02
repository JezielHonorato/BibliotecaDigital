-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/11/2023 às 23:11
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bibliotecadigital`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbautor`
--

CREATE TABLE `tbautor` (
  `idautor` int(11) NOT NULL,
  `autor` varchar(50) NOT NULL,
  `idpais` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbautor`
--

INSERT INTO `tbautor` (`idautor`, `autor`, `idpais`) VALUES
(1, 'Machado de Assis', 3),
(2, 'Franz Kafka', 17),
(3, '', NULL),
(4, 'Dante Alighieri', 18),
(5, 'Lima Barreto', 3),
(6, 'Aluísio Azevedo', 3),
(7, 'José De Alencar', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbcategoria`
--

CREATE TABLE `tbcategoria` (
  `idcategoria` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbcategoria`
--

INSERT INTO `tbcategoria` (`idcategoria`, `categoria`) VALUES
(1, 'Biografia'),
(2, 'Conto'),
(3, 'Crônica'),
(4, 'Ensaio'),
(5, 'Poesia'),
(6, 'Romance'),
(7, 'Teatro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblivro`
--

CREATE TABLE `tblivro` (
  `idlivro` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `publicadodata` int(11) DEFAULT NULL,
  `idautor` int(11) DEFAULT NULL,
  `idcategoria` int(11) DEFAULT NULL,
  `idpais` int(11) DEFAULT NULL,
  `arquivo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tblivro`
--

INSERT INTO `tblivro` (`idlivro`, `titulo`, `publicadodata`, `idautor`, `idcategoria`, `idpais`, `arquivo`) VALUES
(1, 'Crisálidas', 1964, 1, 5, 3, './assets/Crisálidas.pdf'),
(2, 'Dom Casmurro', 1899, 1, 6, 3, './assets/Dom Casmurro.pdf'),
(3, 'Helena', 1876, 1, 6, 3, './assets/Helena.pdf'),
(4, 'Memórias Póstumas De Brás Cubas', 1881, 1, 6, 3, './assets/Memórias Póstumas De Brás Cubas.pdf'),
(5, 'A Divina Comédia', 1472, 4, 5, 18, './assets/A Divina Comédia.pdf'),
(6, 'O Cortiço', 1890, 6, 6, 3, './assets/O Cortiço.pdf'),
(7, 'A Mortalha De Alzira', 1892, 6, 6, 3, './assets/A Mortalha De Alzira.pdf'),
(8, 'Iracema', 1892, 7, 6, 3, './assets/Iracema.pdf');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbpais`
--

CREATE TABLE `tbpais` (
  `idpais` int(11) NOT NULL,
  `pais` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbpais`
--

INSERT INTO `tbpais` (`idpais`, `pais`) VALUES
(0, NULL),
(1, 'Alemanha'),
(2, 'Austrália'),
(3, 'Brasil'),
(4, 'Colômbia'),
(5, 'Estados Unidos'),
(6, 'Inglaterra'),
(7, 'Japão'),
(8, 'Moçambique'),
(9, 'Portugal'),
(10, 'Rússia'),
(14, 'Noruega'),
(17, 'Tchéquia'),
(18, 'Itália');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbusuarios`
--

CREATE TABLE `tbusuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `senha` varchar(25) NOT NULL,
  `nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbusuarios`
--

INSERT INTO `tbusuarios` (`id`, `usuario`, `senha`, `nivel`) VALUES
(1, 'admin', 'admin', 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbautor`
--
ALTER TABLE `tbautor`
  ADD PRIMARY KEY (`idautor`),
  ADD KEY `idpais` (`idpais`);

--
-- Índices de tabela `tbcategoria`
--
ALTER TABLE `tbcategoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Índices de tabela `tblivro`
--
ALTER TABLE `tblivro`
  ADD PRIMARY KEY (`idlivro`),
  ADD KEY `idautor` (`idautor`),
  ADD KEY `idcategoria` (`idcategoria`),
  ADD KEY `idpais` (`idpais`);

--
-- Índices de tabela `tbpais`
--
ALTER TABLE `tbpais`
  ADD PRIMARY KEY (`idpais`);

--
-- Índices de tabela `tbusuarios`
--
ALTER TABLE `tbusuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbautor`
--
ALTER TABLE `tbautor`
  MODIFY `idautor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tbcategoria`
--
ALTER TABLE `tbcategoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT de tabela `tblivro`
--
ALTER TABLE `tblivro`
  MODIFY `idlivro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tbpais`
--
ALTER TABLE `tbpais`
  MODIFY `idpais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `tbusuarios`
--
ALTER TABLE `tbusuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tbautor`
--
ALTER TABLE `tbautor`
  ADD CONSTRAINT `idpais` FOREIGN KEY (`idpais`) REFERENCES `tbpais` (`idpais`);

--
-- Restrições para tabelas `tblivro`
--
ALTER TABLE `tblivro`
  ADD CONSTRAINT `tblivro_ibfk_1` FOREIGN KEY (`idautor`) REFERENCES `tbautor` (`idautor`),
  ADD CONSTRAINT `tblivro_ibfk_2` FOREIGN KEY (`idcategoria`) REFERENCES `tbcategoria` (`idcategoria`),
  ADD CONSTRAINT `tblivro_ibfk_3` FOREIGN KEY (`idpais`) REFERENCES `tbpais` (`idpais`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
