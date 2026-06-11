-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 04/06/2026 às 02:02
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ponto_de_escuta`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL,
  `nome_aluno` varchar(100) NOT NULL,
  `email_aluno` varchar(100) NOT NULL,
  `data_agendada` date NOT NULL,
  `hora_agendada` time NOT NULL,
  `status` varchar(20) DEFAULT 'Pendente',
  `aviso` text DEFAULT NULL,
  `status_agendamento` enum('pendente','confirmado','cancelado') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `nome_aluno`, `email_aluno`, `data_agendada`, `hora_agendada`, `status`, `aviso`, `status_agendamento`) VALUES
(6, 'João Victor Cassimiro de Andrade', 'joaocassimiro00789@gmail.com', '2026-06-04', '14:00:00', 'Pendente', NULL, 'pendente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamados_ajuda`
--

CREATE TABLE `chamados_ajuda` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pergunta` text NOT NULL,
  `resposta` text DEFAULT NULL,
  `publica` tinyint(1) DEFAULT 0,
  `status` enum('pendente','respondido') DEFAULT 'pendente',
  `data_envio` datetime DEFAULT current_timestamp(),
  `data_resposta` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `chamados_ajuda`
--

INSERT INTO `chamados_ajuda` (`id`, `email`, `pergunta`, `resposta`, `publica`, `status`, `data_envio`, `data_resposta`) VALUES
(1, 'joaocassimiro00789@gmail.com', 'Vc gosta de batata?', 'sim', 0, 'respondido', '2026-06-02 20:13:20', '2026-06-02 20:13:32'),
(2, 'canavarrocamile@gmail.com', 'oiiii', 'oi!!!!!!!!!!', 0, 'respondido', '2026-06-02 20:14:43', '2026-06-02 20:15:04'),
(3, 'joaocassimiro00789@gmail.com', 'a', 'b', 0, 'respondido', '2026-06-02 20:16:41', '2026-06-02 20:16:55'),
(4, 'joaocassimiro00789@gmail.com', 'a', 'a', 1, 'respondido', '2026-06-02 20:18:19', '2026-06-02 20:18:46'),
(5, 'joao@gmail.com', 'oi', 'oi oi', 0, 'respondido', '2026-06-02 20:25:11', '2026-06-02 20:25:42');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `data_cadastro`) VALUES
(1, 'João Victor Cassimiro de Andrade', 'joaocassimiro00789@gmail.com', '$2y$10$RGviDgSuOMBrBsGEGfR5FuuWA6oxZ0aCT1/OxARRzbB9ZQDPZ5Vu.', '2026-06-03 20:32:39');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `chamados_ajuda`
--
ALTER TABLE `chamados_ajuda`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `chamados_ajuda`
--
ALTER TABLE `chamados_ajuda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
