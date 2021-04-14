CREATE TABLE `usuarios` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `senha` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
 `niveis_acesso_id` int(11) NOT NULL,
 `id_tipo_perfil` int(11) NOT NULL,
 `data_cadastro` date NOT NULL,
 `hora_cadastro` time NOT NULL,
 `thumb` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
 `sobre` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
 PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `chat` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `fatura` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `id_usuario` int(11) DEFAULT NULL,
 `id_projeto` int(11) DEFAULT NULL,
 `data_cadastro` date NOT NULL,
 `hora_cadastro` time NOT NULL,
 `valor` varchar(100) NOT NULL,
 `status` varchar(100) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `habilidades` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `nome` varchar(255) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `habilidades_usuarios` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `id_usuario` int(11) DEFAULT NULL,
 `habilidade` varchar(255) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `id_usuario_habilidade` (`id_usuario`),
 CONSTRAINT `habilidades_usuarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `mensagens` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `id_chat` int(11) DEFAULT NULL,
 `id_usuario` int(11) DEFAULT NULL,
 `mensagem` mediumtext COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`id`),
 KEY `id_chat` (`id_chat`),
 KEY `id_usuario` (`id_usuario`),
 CONSTRAINT `mensagens_ibfk_1` FOREIGN KEY (`id_chat`) REFERENCES `chat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `mensagens_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `projetos` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `titulo` text NOT NULL,
 `habilidades` varchar(255) NOT NULL,
 `descricao` mediumtext NOT NULL,
 `tipo_projeto` varchar(255) NOT NULL,
 `valor_projeto` varchar(255) NOT NULL,
 `tipo_profissional` varchar(255) NOT NULL,
 `id_usuario` int(11) DEFAULT NULL,
 `data_cadastro` date NOT NULL,
 `hora_cadastro` time NOT NULL,
 `status` int(11) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `id_interessado` (`id_usuario`),
 CONSTRAINT `projetos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `propostas` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `id_usuario` int(11) DEFAULT NULL,
 `id_projeto` int(11) DEFAULT NULL,
 `descricao` mediumtext NOT NULL,
 `data_cadastro` date NOT NULL,
 `hora_cadastro` time NOT NULL,
 `status` int(11) NOT NULL,
 `lido` int(11) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `publicacao` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `id_usuario` int(11) DEFAULT NULL,
 `busca` text COLLATE utf8_unicode_ci NOT NULL,
 `titulo` text COLLATE utf8_unicode_ci NOT NULL,
 `descricao` mediumtext COLLATE utf8_unicode_ci NOT NULL,
 `data_publicacao` datetime NOT NULL,
 PRIMARY KEY (`id`),
 KEY `id_usuario` (`id_usuario`),
 CONSTRAINT `publicacao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `subhabilidades` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `id_habilidades` int(11) DEFAULT NULL,
 `nome` varchar(255) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `id_habilidade` (`id_habilidades`),
 CONSTRAINT `subhabilidades_ibfk_1` FOREIGN KEY (`id_habilidades`) REFERENCES `habilidades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `subhabilidades_usuarios` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `id_usuario` int(11) DEFAULT NULL,
 `subhabilidade` varchar(255) DEFAULT NULL,
 `id_habilidades` int(11) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `visitas` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `id_visitante` int(11) DEFAULT NULL,
 `id_ND` int(11) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `id_visitante` (`id_visitante`),
 KEY `id_ND` (`id_ND`),
 CONSTRAINT `visitas_ibfk_1` FOREIGN KEY (`id_visitante`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `visitas_ibfk_2` FOREIGN KEY (`id_ND`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;