-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/04/2024 às 13:18
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
  `idAutor` int(11) NOT NULL,
  `autor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbautor`
--

INSERT INTO `tbautor` (`idAutor`, `autor`) VALUES
(1, 'Dante Alighieri'),
(2, 'Machado de Assis'),
(3, 'Lima Barreto'),
(4, 'Raul Pompeia'),
(5, 'Franz Kafka'),
(6, 'Luíz Vaz de Camões'),
(7, 'Agostinho De Hipona'),
(8, 'George Orwell'),
(9, 'Platão');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbcategoria`
--

CREATE TABLE `tbcategoria` (
  `idCategoria` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbcategoria`
--

INSERT INTO `tbcategoria` (`idCategoria`, `categoria`) VALUES
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
  `idLivro` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `data` int(11) DEFAULT NULL,
  `idAutor` int(11) DEFAULT NULL,
  `idCategoria` int(11) DEFAULT NULL,
  `idPais` int(11) DEFAULT NULL,
  `usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tblivro`
--

INSERT INTO `tblivro` (`idLivro`, `titulo`, `data`, `idAutor`, `idCategoria`, `idPais`, `usuario`) VALUES
(1, 'A Divina Comedia', 1314, 1, 5, 1, 'Jeziel Honorato'),
(2, 'Dom Casmurro', 1899, 2, 6, 2, 'Jeziel Honorato'),
(3, 'Quase Ministro', 1864, 2, 7, 2, 'Jeziel Honorato'),
(4, 'O Triste Fim De Policarpo Quaresma', 1915, 3, 6, 2, 'Jeziel Honorato'),
(5, 'O Ateneu', 1888, 4, 6, 2, 'Jeziel Honorato'),
(6, 'A Metamorfose', 1915, 5, 6, 3, 'Jeziel Honorato'),
(7, 'Os Lusiadas', 1572, 6, 5, 4, 'Jeziel Honorato'),
(8, 'Confissoes', 397, 7, 1, 5, 'Jeziel Honorato'),
(9, '1984', 1949, 8, 6, 6, 'Jeziel Honorato'),
(10, 'A Republica', -380, 9, 4, 7, 'Jeziel Honorato');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbpais`
--

CREATE TABLE `tbpais` (
  `idPais` int(11) NOT NULL,
  `pais` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbpais`
--

INSERT INTO `tbpais` (`idPais`, `pais`) VALUES
(1, 'Italia'),
(2, 'Brasil'),
(3, 'Austria-Hungria'),
(4, 'Portugal'),
(6, 'India'),
(7, 'Grecia');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbusuario`
--

CREATE TABLE `tbusuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbusuario`
--

INSERT INTO `tbusuario` (`id`, `usuario`, `senha`, `nivel`) VALUES
(1, 'Jeziel Honorato', '$2y$10$SXHk8HNEXABSHvPQtc8.je5fVFht5TumRVO3/dgM1N.L4WVf87U2i', 3),
(4, 'Joao', '$2y$10$cFNxmBvdsVaE1/EgECe0auYKWlkeZTTC7h0Rj12lyy78EQ//GaA/K', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbautor`
--
ALTER TABLE `tbautor`
  ADD PRIMARY KEY (`idAutor`);

--
-- Índices de tabela `tbcategoria`
--
ALTER TABLE `tbcategoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Índices de tabela `tblivro`
--
ALTER TABLE `tblivro`
  ADD PRIMARY KEY (`idLivro`),
  ADD KEY `idautor` (`idAutor`),
  ADD KEY `idcategoria` (`idCategoria`),
  ADD KEY `idpais` (`idPais`);

--
-- Índices de tabela `tbpais`
--
ALTER TABLE `tbpais`
  ADD PRIMARY KEY (`idPais`);

--
-- Índices de tabela `tbusuario`
--
ALTER TABLE `tbusuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbautor`
--
ALTER TABLE `tbautor`
  MODIFY `idAutor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tbcategoria`
--
ALTER TABLE `tbcategoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT de tabela `tblivro`
--
ALTER TABLE `tblivro`
  MODIFY `idLivro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tbpais`
--
ALTER TABLE `tbpais`
  MODIFY `idPais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tbusuario`
--
ALTER TABLE `tbusuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
