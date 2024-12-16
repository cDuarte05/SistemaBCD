-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/12/2024 às 20:14
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
-- Banco de dados: `sistemabcd`
--
CREATE DATABASE IF NOT EXISTS `sistemabcd` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sistemabcd`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE `alunos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sexo` enum('M','F') NOT NULL,
  `data_nascimento` date NOT NULL,
  `contato` varchar(100) DEFAULT NULL,
  `turma_id` int(11) DEFAULT NULL,
  `declaracao_medica` varchar(255) DEFAULT NULL,
  `observacoes_medicas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alunos`
--

INSERT INTO `alunos` (`id`, `nome`, `sexo`, `data_nascimento`, `contato`, `turma_id`, `declaracao_medica`, `observacoes_medicas`) VALUES
(67, 'Luis Miguel', 'M', '2005-12-03', '19984583377', 5, '67declaracao_medica.txt', ''),
(68, 'Henrique Duarte', 'M', '2005-10-12', '19946256849', 5, '68declaracao_medica.txt', ''),
(69, 'Roberto', 'M', '2004-02-12', '19932415648', 5, NULL, 'Possui asma'),
(70, 'Anderson', 'M', '2005-08-24', '199231654862', 5, '70declaracao_medica.txt', ''),
(71, 'Yasmin', 'F', '1998-12-24', '19942356842', 6, '71declaracao_medica.txt', 'Anemia'),
(72, 'Gabriela', 'F', '2005-12-16', '19432654865', 6, '72declaracao_medica.txt', ''),
(73, 'Helen', 'F', '1998-04-08', '199765863265', 6, '73declaracao_medica.txt', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `frequencias`
--

CREATE TABLE `frequencias` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `status` enum('presente','ausente') NOT NULL,
  `observacoes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `frequencias`
--

INSERT INTO `frequencias` (`id`, `aluno_id`, `data`, `status`, `observacoes`) VALUES
(190, 71, '2024-12-16', 'presente', NULL),
(191, 73, '2024-12-16', 'presente', NULL),
(192, 72, '2024-12-16', 'ausente', NULL),
(193, 71, '2024-12-15', 'presente', NULL),
(194, 72, '2024-12-15', 'presente', NULL),
(195, 73, '2024-12-15', 'ausente', NULL),
(196, 71, '2024-12-14', 'presente', NULL),
(197, 72, '2024-12-14', 'presente', NULL),
(198, 73, '2024-12-14', 'presente', NULL),
(199, 71, '2024-12-11', 'presente', NULL),
(200, 73, '2024-12-11', 'presente', NULL),
(201, 72, '2024-12-11', 'presente', 'Atestado Médico'),
(202, 67, '2024-12-15', 'presente', NULL),
(203, 68, '2024-12-15', 'presente', NULL),
(204, 69, '2024-12-15', 'presente', NULL),
(205, 70, '2024-12-15', 'presente', NULL),
(206, 67, '2024-12-14', 'presente', NULL),
(207, 68, '2024-12-14', 'presente', NULL),
(208, 69, '2024-12-14', 'presente', NULL),
(209, 70, '2024-12-14', 'ausente', NULL),
(210, 67, '2024-12-13', 'presente', NULL),
(211, 68, '2024-12-13', 'presente', NULL),
(212, 69, '2024-12-13', 'presente', NULL),
(213, 70, '2024-12-13', 'presente', 'Falecimento de parente.'),
(214, 67, '2024-12-11', 'presente', NULL),
(215, 68, '2024-12-11', 'presente', NULL),
(216, 70, '2024-12-11', 'presente', NULL),
(217, 69, '2024-12-11', 'ausente', NULL),
(218, 67, '2024-12-09', 'presente', NULL),
(219, 68, '2024-12-09', 'presente', NULL),
(220, 69, '2024-12-09', 'presente', NULL),
(221, 70, '2024-12-09', 'presente', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensalidades`
--

CREATE TABLE `mensalidades` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_vencimento` date NOT NULL,
  `status` enum('pago','pendente') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `mensalidades`
--

INSERT INTO `mensalidades` (`id`, `aluno_id`, `valor`, `data_vencimento`, `status`) VALUES
(11, 67, 400.00, '2024-12-18', 'pendente'),
(12, 68, 400.00, '2024-12-18', 'pendente'),
(13, 69, 400.00, '2024-12-18', 'pendente'),
(14, 70, 400.00, '2024-12-18', 'pendente'),
(15, 71, 400.00, '2024-12-18', 'pendente'),
(16, 72, 400.00, '2024-12-18', 'pendente'),
(17, 73, 400.00, '2024-12-18', 'pendente'),
(18, 68, 250.00, '2024-12-12', 'pendente'),
(19, 69, 250.00, '2024-12-12', 'pendente'),
(20, 73, 250.00, '2024-12-12', 'pendente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `professores`
--

CREATE TABLE `professores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `especialidade` varchar(100) DEFAULT NULL,
  `contato` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professores`
--

INSERT INTO `professores` (`id`, `nome`, `especialidade`, `contato`) VALUES
(4, 'Ricardo', 'Alongamento', '19964385648'),
(5, 'Daniela', 'Yoga', '19926575686');

-- --------------------------------------------------------

--
-- Estrutura para tabela `turmas`
--

CREATE TABLE `turmas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sexo` enum('M','F') NOT NULL,
  `professor_id` int(11) DEFAULT NULL,
  `horario` varchar(50) DEFAULT NULL,
  `capacidade` int(11) DEFAULT 8
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `turmas`
--

INSERT INTO `turmas` (`id`, `nome`, `sexo`, `professor_id`, `horario`, `capacidade`) VALUES
(5, 'Turma A', 'M', 4, '14:00', 8),
(6, 'Turma B', 'F', 5, '12:00', 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `IDprofessor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `senha`, `IDprofessor`) VALUES
(3, 'admin', '123456', NULL),
(4, 'rcardo', 'ricardo123', 4),
(5, 'daniy', 'daniela123', 5);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `turma_id` (`turma_id`);

--
-- Índices de tabela `frequencias`
--
ALTER TABLE `frequencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`);

--
-- Índices de tabela `mensalidades`
--
ALTER TABLE `mensalidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`);

--
-- Índices de tabela `professores`
--
ALTER TABLE `professores`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDprofessor` (`IDprofessor`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de tabela `frequencias`
--
ALTER TABLE `frequencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT de tabela `mensalidades`
--
ALTER TABLE `mensalidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `professores`
--
ALTER TABLE `professores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `turmas`
--
ALTER TABLE `turmas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `alunos`
--
ALTER TABLE `alunos`
  ADD CONSTRAINT `alunos_ibfk_1` FOREIGN KEY (`turma_id`) REFERENCES `turmas` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `frequencias`
--
ALTER TABLE `frequencias`
  ADD CONSTRAINT `frequencias_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `alunos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `mensalidades`
--
ALTER TABLE `mensalidades`
  ADD CONSTRAINT `mensalidades_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `alunos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `turmas`
--
ALTER TABLE `turmas`
  ADD CONSTRAINT `turmas_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `professores` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`IDprofessor`) REFERENCES `professores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
