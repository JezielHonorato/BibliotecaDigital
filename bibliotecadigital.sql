-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 31/01/2024 às 01:44
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
(1, 'Machado de Assis'),
(2, 'Franz Kafka'),
(3, ''),
(4, 'Dante Alighieri'),
(5, 'Lima Barreto'),
(6, 'Aluísio Azevedo'),
(7, 'José De Alencar'),
(8, 'Olavo Bilac'),
(9, 'Raul Pompeia');

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
(1, 'Crisálidas', 1964, 1, 5, 3, 'Jeziel Honorato'),
(2, 'Dom Casmurro', 1899, 1, 6, 3, 'Jeziel Honorato'),
(3, 'Helena', 1876, 1, 6, 3, 'Jeziel Honorato'),
(4, 'Memórias Póstumas De Brás Cubas', 1881, 1, 6, 3, 'Jeziel Honorato'),
(6, 'O Cortiço', 1890, 6, 6, 3, 'Jeziel Honorato'),
(8, 'Iracema', 1892, 7, 6, 3, 'Jeziel Honorato'),
(9, 'Triste Fim De Policarpo Quaresma', 1915, 5, 6, 3, 'Jeziel Honorato'),
(10, 'Diario Intimo', 1953, 5, 6, 3, 'admin'),
(13, 'Senhora', 1874, 7, 6, 3, 'admin'),
(14, 'Diva', 1864, 7, 6, 3, 'admin'),
(15, 'Os Deuses De Casaca', 1865, 1, 7, 3, 'admin'),
(16, 'Papéis Avulsos', 1882, 1, 2, 3, 'admin'),
(17, 'O Ateneu', 1888, 9, 6, 3, 'Jeziel Honorato'),
(18, 'A Divina Comédia', 1314, 4, 5, 18, 'Jeziel Honorato'),
(19, 'Espumas Flutuantes', 1870, 9, 5, 3, 'Jeziel Honorato');

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
(0, ''),
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
(17, 'República Tcheca'),
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
(1, 'Jeziel Honorato', 'Aleatória', 3),
(6, 'estagiario', 'estagiario', 1);

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
  MODIFY `idLivro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `tbpais`
--
ALTER TABLE `tbpais`
  MODIFY `idPais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `tbusuarios`
--
ALTER TABLE `tbusuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
