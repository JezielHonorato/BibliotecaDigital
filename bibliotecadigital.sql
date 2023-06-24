CREATE TABLE `TbLivro` (
	`id_livro` int NOT NULL AUTO_INCREMENT,
	`data` DATE NOT NULL,
	`IdAutor` int NOT NULL,
	`idGenero` INT NOT NULL,
	`idCategoria` INT NOT NULL,
	PRIMARY KEY (`id_livro`)
);

CREATE TABLE `TbAutor` (
	`idAutor` int NOT NULL AUTO_INCREMENT,
	`nome` varchar(50) NOT NULL,
	PRIMARY KEY (`idAutor`)
);

CREATE TABLE `TbGenero` (
	`idGenero` int NOT NULL AUTO_INCREMENT,
	`nome` varchar(50) NOT NULL,
	PRIMARY KEY (`idGenero`)
);

CREATE TABLE `TbCategoria` (
	`idCategoria` int NOT NULL AUTO_INCREMENT,
	`nome` varchar(50) NOT NULL,
	PRIMARY KEY (`idCategoria`)
);

ALTER TABLE `TbLivro` ADD CONSTRAINT `TbLivro_fk0` FOREIGN KEY (`IdAutor`) REFERENCES `TbAutor`(`idAutor`);

ALTER TABLE `TbLivro` ADD CONSTRAINT `TbLivro_fk1` FOREIGN KEY (`idGenero`) REFERENCES `TbGenero`(`idGenero`);

ALTER TABLE `TbLivro` ADD CONSTRAINT `TbLivro_fk2` FOREIGN KEY (`idCategoria`) REFERENCES `TbCategoria`(`idCategoria`);





