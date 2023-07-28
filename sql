-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/07/2023 às 02:57
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
`nomeAutor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbautor`
--

INSERT INTO `tbautor` (`idAutor`, `nomeAutor`) VALUES
(1, 'MACHADO DE ASSIS'),
(2, 'ALVARES DE AZEVEDO'),
(3, 'FERNANDO PESSOA'),
(4, 'DANTE ALIGHIERI'),
(5, 'LIMA BARRETO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbcategoria`
--

CREATE TABLE `tbcategoria` (
`idCategoria` int(11) NOT NULL,
`nomeCategoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbcategoria`
--

INSERT INTO `tbcategoria` (`idCategoria`, `nomeCategoria`) VALUES
(1, 'Biografia'),
(2, 'Conto'),
(3, 'Crônica'),
(4, 'Ensaio'),
(5, 'Poesia'),
(6, 'Romance'),
(7, 'Teatro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbgenero`
--

CREATE TABLE `tbgenero` (
`idGenero` int(11) NOT NULL,
`nomeGenero` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbimagem`
--

CREATE TABLE `tbimagem` (
`idImagem` int(11) NOT NULL,
`link` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblivro`
--

CREATE TABLE `tblivro` (
`id_livro` int(11) NOT NULL,
`data` date NOT NULL,
`TbTitulo` int(11) NOT NULL,
`IdAutor` int(11) NOT NULL,
`idGenero` int(11) NOT NULL,
`idCategoria` int(11) NOT NULL,
`idImagem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbtitulo`
--

CREATE TABLE `tbtitulo` (
`idTitulo` int(11) NOT NULL,
`titulo` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Índices de tabela `tbgenero`
--
ALTER TABLE `tbgenero`
ADD PRIMARY KEY (`idGenero`);

--
-- Índices de tabela `tbimagem`
--
ALTER TABLE `tbimagem`
ADD PRIMARY KEY (`idImagem`);

--
-- Índices de tabela `tblivro`
--
ALTER TABLE `tblivro`
ADD PRIMARY KEY (`id_livro`),
ADD KEY `TbLivro_fk0` (`TbTitulo`),
ADD KEY `TbLivro_fk1` (`IdAutor`),
ADD KEY `TbLivro_fk2` (`idGenero`),
ADD KEY `TbLivro_fk3` (`idCategoria`),
ADD KEY `TbLivro_fk4` (`idImagem`);

--
-- Índices de tabela `tbtitulo`
--
ALTER TABLE `tbtitulo`
ADD PRIMARY KEY (`idTitulo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbautor`
--
ALTER TABLE `tbautor`
MODIFY `idAutor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tbcategoria`
--
ALTER TABLE `tbcategoria`
MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT de tabela `tbgenero`
--
ALTER TABLE `tbgenero`
MODIFY `idGenero` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbimagem`
--
ALTER TABLE `tbimagem`
MODIFY `idImagem` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tblivro`
--
ALTER TABLE `tblivro`
MODIFY `id_livro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbtitulo`
--
ALTER TABLE `tbtitulo`
MODIFY `idTitulo` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tblivro`
--
ALTER TABLE `tblivro`
ADD CONSTRAINT `TbLivro_fk0` FOREIGN KEY (`TbTitulo`) REFERENCES `tbtitulo` (`idTitulo`),
ADD CONSTRAINT `TbLivro_fk1` FOREIGN KEY (`IdAutor`) REFERENCES `tbautor` (`idAutor`),
ADD CONSTRAINT `TbLivro_fk2` FOREIGN KEY (`idGenero`) REFERENCES `tbgenero` (`idGenero`),
ADD CONSTRAINT `TbLivro_fk3` FOREIGN KEY (`idCategoria`) REFERENCES `tbcategoria` (`idCategoria`),
ADD CONSTRAINT `TbLivro_fk4` FOREIGN KEY (`idImagem`) REFERENCES `tbimagem` (`idImagem`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
