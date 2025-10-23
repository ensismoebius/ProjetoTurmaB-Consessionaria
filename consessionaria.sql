-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 24-Out-2025 às 00:10
-- Versão do servidor: 8.0.25
-- versão do PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `PRJ2DSB`
--
CREATE DATABASE IF NOT EXISTS `PRJ2DSB` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `PRJ2DSB`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ACESSOS`
--

DROP TABLE IF EXISTS `ACESSOS`;
CREATE TABLE IF NOT EXISTS `ACESSOS` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_AUTOR_F` int DEFAULT NULL,
  `ID_AUTOR_C` int DEFAULT NULL,
  `ID_ROTINA` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ROTINAS_ACESSOS` (`ID_ROTINA`),
  KEY `FUNCIONARIOS_ACESSOS` (`ID_AUTOR_F`),
  KEY `CARGOS_ACESSO` (`ID_AUTOR_C`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamento`
--

DROP TABLE IF EXISTS `agendamento`;
CREATE TABLE IF NOT EXISTS `agendamento` (
  `codigo_agendamento` int NOT NULL AUTO_INCREMENT,
  `data_agendamento` date DEFAULT NULL,
  `tipo` enum('Revisao','Vistoria') DEFAULT NULL,
  `id_cli` int DEFAULT NULL,
  PRIMARY KEY (`codigo_agendamento`),
  KEY `id_cli` (`id_cli`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Atendimento`
--

DROP TABLE IF EXISTS `Atendimento`;
CREATE TABLE IF NOT EXISTS `Atendimento` (
  `id_atendm` int NOT NULL AUTO_INCREMENT,
  `dt_atendm` date NOT NULL,
  `id_cli_atendm` int NOT NULL,
  `id_atendt_atendm` int DEFAULT NULL,
  PRIMARY KEY (`id_atendm`),
  KEY `fk_id_cli_atendm` (`id_cli_atendm`),
  KEY `id_atendt_atendm_atendm` (`id_atendt_atendm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `BANCO`
--

DROP TABLE IF EXISTS `BANCO`;
CREATE TABLE IF NOT EXISTS `BANCO` (
  `IDBANCO` int NOT NULL,
  `NOME_BANCO` varchar(100) NOT NULL,
  `CNPJ` varchar(20) DEFAULT NULL,
  `TELEFONE` varchar(20) DEFAULT NULL,
  `ENDEREÇO` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`IDBANCO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `CARGOS`
--

DROP TABLE IF EXISTS `CARGOS`;
CREATE TABLE IF NOT EXISTS `CARGOS` (
  `ID_cargo` int NOT NULL,
  `NomeCargo` varchar(150) NOT NULL,
  `departamento` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`ID_cargo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `CATEGORIAS`
--

DROP TABLE IF EXISTS `CATEGORIAS`;
CREATE TABLE IF NOT EXISTS `CATEGORIAS` (
  `id_categorias` int NOT NULL AUTO_INCREMENT,
  `nome_ctg` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id_categorias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `CLIENTES`
--

DROP TABLE IF EXISTS `CLIENTES`;
CREATE TABLE IF NOT EXISTS `CLIENTES` (
  `id_cli` int NOT NULL AUTO_INCREMENT,
  `cpf` char(12) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `data_nasc` date NOT NULL,
  `telefone` varchar(12) NOT NULL,
  `email` varchar(250) NOT NULL,
  `atendicli` varchar(250) NOT NULL,
  `endereco` varchar(250) NOT NULL,
  `financicli` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_cli`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `COMPRA`
--

DROP TABLE IF EXISTS `COMPRA`;
CREATE TABLE IF NOT EXISTS `COMPRA` (
  `id_compra` int NOT NULL,
  `data_compra` date NOT NULL,
  `valor_compra` double DEFAULT NULL,
  `id_fornecedor` int NOT NULL,
  `forma_pagamento` varchar(100) DEFAULT NULL,
  `venda_compra` varchar(100) DEFAULT NULL,
  `id_pedido` int NOT NULL,
  `id_estoque` int DEFAULT NULL,
  PRIMARY KEY (`id_compra`),
  KEY `PddCom` (`id_pedido`),
  KEY `CompEstoq` (`id_estoque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `CONTA_CORRENTE`
--

DROP TABLE IF EXISTS `CONTA_CORRENTE`;
CREATE TABLE IF NOT EXISTS `CONTA_CORRENTE` (
  `id_conta` int NOT NULL AUTO_INCREMENT,
  `banco` varchar(100) NOT NULL,
  `agencia` varchar(20) NOT NULL,
  `numero_conta` varchar(20) NOT NULL,
  `saldo` decimal(15,2) DEFAULT '0.00',
  `data_atualizacao` date DEFAULT NULL,
  PRIMARY KEY (`id_conta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `DESPESAS`
--

DROP TABLE IF EXISTS `DESPESAS`;
CREATE TABLE IF NOT EXISTS `DESPESAS` (
  `id_despesas` int NOT NULL AUTO_INCREMENT,
  `id_tipo_despesa` int NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_despesas` date DEFAULT NULL,
  `data_vencimento` date DEFAULT NULL,
  `data_pagamento` date DEFAULT NULL,
  PRIMARY KEY (`id_despesas`),
  KEY `id_tipo_despesa` (`id_tipo_despesa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `DOCUMENTOS`
--

DROP TABLE IF EXISTS `DOCUMENTOS`;
CREATE TABLE IF NOT EXISTS `DOCUMENTOS` (
  `CPF` varchar(14) NOT NULL,
  `RENAVAM` int NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cidadeLicenciado` varchar(30) NOT NULL,
  `placa` varchar(7) NOT NULL,
  `chasi` varchar(17) NOT NULL,
  `idModelos` int NOT NULL,
  `dataFabri` date NOT NULL,
  `cor` varchar(10) NOT NULL,
  `IPVA` double NOT NULL,
  `statusIPVA` varchar(15) NOT NULL,
  PRIMARY KEY (`CPF`,`RENAVAM`),
  KEY `idModelos` (`idModelos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ESTOQUE`
--

DROP TABLE IF EXISTS `ESTOQUE`;
CREATE TABLE IF NOT EXISTS `ESTOQUE` (
  `id_estoque` int NOT NULL,
  `id_prd` int NOT NULL,
  `quantidade` int NOT NULL,
  `data_atualizacao` double DEFAULT NULL,
  PRIMARY KEY (`id_estoque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `FINANCIAMENTO`
--

DROP TABLE IF EXISTS `FINANCIAMENTO`;
CREATE TABLE IF NOT EXISTS `FINANCIAMENTO` (
  `IDFINANC` int NOT NULL,
  `IDCLI` int NOT NULL,
  `IDVEICL` int NOT NULL,
  `ID_BANCO` int NOT NULL,
  `VALTTL` double DEFAULT NULL,
  `ENTRADA` double DEFAULT NULL,
  `PARCLS` double DEFAULT NULL,
  `VALPARCLS` double DEFAULT NULL,
  `DTINIC` date DEFAULT NULL,
  `DTFIM` date DEFAULT NULL,
  PRIMARY KEY (`IDFINANC`),
  KEY `FKFINANC_BANCO` (`ID_BANCO`),
  KEY `FKCLI_REFERENCES` (`IDCLI`),
  KEY `FKVEIC_FINANCIAMENTO` (`IDVEICL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Funcionarios`
--

DROP TABLE IF EXISTS `Funcionarios`;
CREATE TABLE IF NOT EXISTS `Funcionarios` (
  `IDFuncionario` int NOT NULL,
  `NomeCompleto` varchar(100) DEFAULT NULL,
  `Telefone` int DEFAULT NULL,
  `IDCargo` int DEFAULT NULL,
  `IDDepartamento` int DEFAULT NULL,
  `Salario` double DEFAULT NULL,
  PRIMARY KEY (`IDFuncionario`),
  KEY `IDCargo` (`IDCargo`),
  KEY `IDDepartamento` (`IDDepartamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `GANHOS`
--

DROP TABLE IF EXISTS `GANHOS`;
CREATE TABLE IF NOT EXISTS `GANHOS` (
  `id_ganhos` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_ganhos` date DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `tipo_renda` enum('Fixa','Variável') NOT NULL,
  PRIMARY KEY (`id_ganhos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Horario`
--

DROP TABLE IF EXISTS `Horario`;
CREATE TABLE IF NOT EXISTS `Horario` (
  `horarioEntrou` datetime DEFAULT NULL,
  `horarioSaiu` datetime DEFAULT NULL,
  `horarioAlmoço` datetime DEFAULT NULL,
  `IDFuncionario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `INTERACOES`
--

DROP TABLE IF EXISTS `INTERACOES`;
CREATE TABLE IF NOT EXISTS `INTERACOES` (
  `id_int` int NOT NULL AUTO_INCREMENT,
  `dt_int` date NOT NULL,
  `id_atendm_int` int NOT NULL,
  `motivo_int` varchar(200) DEFAULT NULL,
  `id_tp_probl_int` int NOT NULL,
  `dt_solucao_int` date DEFAULT NULL,
  `id_atendt_atual_int` int NOT NULL,
  PRIMARY KEY (`id_int`),
  KEY `id_atendm_int` (`id_atendm_int`),
  KEY `id_tp_probl_int` (`id_tp_probl_int`),
  KEY `id_atendt_atual_int` (`id_atendt_atual_int`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ITENS_NOTA`
--

DROP TABLE IF EXISTS `ITENS_NOTA`;
CREATE TABLE IF NOT EXISTS `ITENS_NOTA` (
  `id_itnf` int NOT NULL,
  `quantidade` int NOT NULL,
  `valor_unitario` double NOT NULL,
  `valor_total` double NOT NULL,
  PRIMARY KEY (`id_itnf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ITENS_PEDIDO`
--

DROP TABLE IF EXISTS `ITENS_PEDIDO`;
CREATE TABLE IF NOT EXISTS `ITENS_PEDIDO` (
  `id_itpd` int NOT NULL,
  `nome_pd` varchar(255) NOT NULL,
  `quantidade` int NOT NULL,
  `valor_unitario` double NOT NULL,
  `valor_total` double NOT NULL,
  PRIMARY KEY (`id_itpd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `ITENS_PEDIDO`
--

INSERT INTO `ITENS_PEDIDO` (`id_itpd`, `nome_pd`, `quantidade`, `valor_unitario`, `valor_total`) VALUES
(1, 'teste', 1, 10, 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `MODELOS`
--

DROP TABLE IF EXISTS `MODELOS`;
CREATE TABLE IF NOT EXISTS `MODELOS` (
  `idModelos` int NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `anoModelo` int NOT NULL,
  `potencia` int NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `valorFIPE` int NOT NULL,
  `dtFIPE` date NOT NULL,
  `idMontadoras` int NOT NULL,
  `idCombustivel` int NOT NULL,
  PRIMARY KEY (`idModelos`),
  KEY `idMontadoras` (`idMontadoras`),
  KEY `idCombustivel` (`idCombustivel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `MONTADORAS`
--

DROP TABLE IF EXISTS `MONTADORAS`;
CREATE TABLE IF NOT EXISTS `MONTADORAS` (
  `idMontadoras` int NOT NULL,
  `nomeMontadora` varchar(50) NOT NULL,
  `paisOrigem` varchar(20) NOT NULL,
  `anoFundacao` int NOT NULL,
  `CNPJ` varchar(14) NOT NULL,
  `contato` varchar(20) NOT NULL,
  PRIMARY KEY (`idMontadoras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `NOTAS_FISCAIS`
--

DROP TABLE IF EXISTS `NOTAS_FISCAIS`;
CREATE TABLE IF NOT EXISTS `NOTAS_FISCAIS` (
  `id_nota` int NOT NULL,
  `id_compra` int NOT NULL,
  `data_emissao` date NOT NULL,
  `valor_total` double DEFAULT NULL,
  `num_nota` varchar(20) NOT NULL,
  `id_pedido` int DEFAULT NULL,
  `id_itnf` int DEFAULT NULL,
  PRIMARY KEY (`id_nota`),
  KEY `CompFisc` (`id_compra`),
  KEY `NumPedido` (`id_pedido`),
  KEY `ItemNF` (`id_itnf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `PECAS`
--

DROP TABLE IF EXISTS `PECAS`;
CREATE TABLE IF NOT EXISTS `PECAS` (
  `id_peca` int NOT NULL AUTO_INCREMENT,
  `fornecedor` int NOT NULL,
  `tipo_peca` varchar(255) NOT NULL,
  PRIMARY KEY (`id_peca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `PEDIDOS`
--

DROP TABLE IF EXISTS `PEDIDOS`;
CREATE TABLE IF NOT EXISTS `PEDIDOS` (
  `id_pedido` int NOT NULL,
  `id_cliente` int NOT NULL,
  `data_venda` date NOT NULL,
  `valor_pedido` double DEFAULT NULL,
  `id_itpd` int DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `ItemPedido` (`id_itpd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `PRODUTOS`
--

DROP TABLE IF EXISTS `PRODUTOS`;
CREATE TABLE IF NOT EXISTS `PRODUTOS` (
  `id_prd` int NOT NULL AUTO_INCREMENT,
  `veiculos` int NOT NULL,
  `pecas` int NOT NULL,
  `nome_prd` varchar(256) DEFAULT NULL,
  `estoque` int NOT NULL,
  `preco` decimal(11,2) NOT NULL,
  `prd_ctg` int DEFAULT NULL,
  PRIMARY KEY (`id_prd`),
  KEY `fkcateg_prd` (`prd_ctg`),
  KEY `fkveiculo_prd` (`veiculos`),
  KEY `fkpeca_prd` (`pecas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `PROPOSTAS`
--

DROP TABLE IF EXISTS `PROPOSTAS`;
CREATE TABLE IF NOT EXISTS `PROPOSTAS` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `VEICULO_ID` int DEFAULT NULL,
  `NOME_CLIENTE` varchar(50) DEFAULT NULL,
  `EMAIL_CLIENTE` varchar(50) DEFAULT NULL,
  `TELEFONE_CLIENTE` char(15) DEFAULT NULL,
  `MENSAGEM` varchar(50) DEFAULT NULL,
  `DATA_PROPOSTA` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `IDVEIC_VEICULO` (`VEICULO_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `REVISAO`
--

DROP TABLE IF EXISTS `REVISAO`;
CREATE TABLE IF NOT EXISTS `REVISAO` (
  `ID_REVISAO` int NOT NULL AUTO_INCREMENT,
  `DATA_REVISAO` date DEFAULT NULL,
  `DATA_AGENDAMENTO` date DEFAULT NULL,
  `KM_VEICULO` int DEFAULT NULL,
  `PROXIMA_REVISAO_KM` int DEFAULT NULL,
  `PROXIMA_REVISAO_DATA` date DEFAULT NULL,
  `VALOR_TOTAL` decimal(10,2) DEFAULT NULL,
  `OBSERVACOES` text,
  `STATUS_VEICULO` enum('Agendada','Em_andamento','Cancelado','Concluido') DEFAULT NULL,
  `ID_CLIENTES` int DEFAULT NULL,
  `ID_VEICULO` int DEFAULT NULL,
  PRIMARY KEY (`ID_REVISAO`),
  KEY `FK_CLIENTES_REVISAO` (`ID_CLIENTES`),
  KEY `FK_VEICULO_REVISAO` (`ID_VEICULO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`id`, `nome`) VALUES
(1, 'pipoca');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ROTINAS`
--

DROP TABLE IF EXISTS `ROTINAS`;
CREATE TABLE IF NOT EXISTS `ROTINAS` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(255) NOT NULL,
  `DESCRICAO` text,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `SEGURADORA`
--

DROP TABLE IF EXISTS `SEGURADORA`;
CREATE TABLE IF NOT EXISTS `SEGURADORA` (
  `IDSEGURADORA` int NOT NULL,
  `NOME_SEGURADORA` varchar(100) NOT NULL,
  `CNPJ` varchar(20) DEFAULT NULL,
  `TELEFONE` varchar(20) DEFAULT NULL,
  `ENDERECO` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`IDSEGURADORA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `SEGURO`
--

DROP TABLE IF EXISTS `SEGURO`;
CREATE TABLE IF NOT EXISTS `SEGURO` (
  `IDSEGURO` int NOT NULL,
  `IDCLI` int NOT NULL,
  `IDVEICL` int NOT NULL,
  `VALSEGURO` double DEFAULT NULL,
  `TIPO_COBERTURA` enum('1,2,3') NOT NULL,
  `INICIO` date DEFAULT NULL,
  `FIM` date DEFAULT NULL,
  `STTS` varchar(100) DEFAULT NULL,
  `IDSEGURADORA` int NOT NULL,
  PRIMARY KEY (`IDSEGURO`),
  KEY `FKCLI_SEGURO` (`IDCLI`),
  KEY `FKVEI_SEGURO` (`IDVEICL`),
  KEY `SEGURADORA_SEGURO` (`IDSEGURADORA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Servicos`
--

DROP TABLE IF EXISTS `Servicos`;
CREATE TABLE IF NOT EXISTS `Servicos` (
  `id_servico` int NOT NULL AUTO_INCREMENT,
  `nome_servico` varchar(100) NOT NULL,
  `descricao` tinytext,
  `valor_base` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_servico`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `Servicos`
--

INSERT INTO `Servicos` (`id_servico`, `nome_servico`, `descricao`, `valor_base`) VALUES
(1, 'Troca de óleo e filtros', 'Substituição do óleo e filtros básicos', '150.00'),
(2, 'Substituição de Velas', 'Troca das velas do motor', '120.00'),
(3, 'Verificação dos fluidos', 'Checagem e ajuste dos níveis', '80.00'),
(4, 'Revisão de freios e suspensão', 'Inspeção e manutenção', '200.00'),
(5, 'Balanceamento e alinhamento', 'Ajuste das rodas e direção', '180.00'),
(6, 'Troca do filtro de ar', 'Substituição para melhor entrada de ar no motor', '70.00'),
(7, 'Troca do filtro do ar condicionado', 'Melhora a qualidade do ar intero', '100.00'),
(8, 'Troca do filtro de combustível', 'Mantém o combustível limpo e o motor eficiente', '90.00'),
(9, 'Troca do fluido de freio', 'Substituição periódica para segurança na frenagem', '130.00'),
(10, 'Troca de fluido do arrefecimento', 'Mantém a temperatura ideal do motor', '140.00'),
(11, 'Troca da correia dentada/serviços', 'Preventivo para evitar falhas graves', '350.00'),
(12, 'Troca do fluido da direção hidráulica', 'Melhora a resposta da direção', '120.00'),
(13, 'Checagem do sistema elétrico/bateria', 'Teste de carga e inspeção elétrica', '80.00'),
(14, 'Troca das palhetas do para-brisa', 'Substituição para melhor visibilidade', '60.00'),
(15, 'Inspesão de pneus', 'Verificação de desgaste e calibragem', '50.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `TIPO_COMBUSTIVEL`
--

DROP TABLE IF EXISTS `TIPO_COMBUSTIVEL`;
CREATE TABLE IF NOT EXISTS `TIPO_COMBUSTIVEL` (
  `idCombustivel` int NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idCombustivel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `TIPO_DESPESAS`
--

DROP TABLE IF EXISTS `TIPO_DESPESAS`;
CREATE TABLE IF NOT EXISTS `TIPO_DESPESAS` (
  `id_tipo_despesa` int NOT NULL AUTO_INCREMENT,
  `nome_tipo` varchar(100) NOT NULL,
  `descricao` text,
  `ativo` tinyint(1) DEFAULT '1',
  `data_criacao` date DEFAULT NULL,
  `data_atualizacao` date DEFAULT NULL,
  PRIMARY KEY (`id_tipo_despesa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `TIPO_PROBLEMA`
--

DROP TABLE IF EXISTS `TIPO_PROBLEMA`;
CREATE TABLE IF NOT EXISTS `TIPO_PROBLEMA` (
  `id_tp_probl` int NOT NULL AUTO_INCREMENT,
  `nome_tp_probl` char(50) DEFAULT NULL,
  `desc_tp_probl` char(255) DEFAULT NULL,
  `gravdd_tp_probl` int NOT NULL,
  PRIMARY KEY (`id_tp_probl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `TURNOS`
--

DROP TABLE IF EXISTS `TURNOS`;
CREATE TABLE IF NOT EXISTS `TURNOS` (
  `ID_turno` int NOT NULL,
  `NomeTurno` varchar(100) NOT NULL,
  `HorarioEntrada` datetime NOT NULL,
  `HorarioSaida` datetime NOT NULL,
  `DiaTurno` date DEFAULT NULL,
  PRIMARY KEY (`ID_turno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `USUARIOS`
--

DROP TABLE IF EXISTS `USUARIOS`;
CREATE TABLE IF NOT EXISTS `USUARIOS` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `senha` varchar(80) DEFAULT NULL,
  `role` int DEFAULT '2',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `VEICULOS`
--

DROP TABLE IF EXISTS `VEICULOS`;
CREATE TABLE IF NOT EXISTS `VEICULOS` (
  `id_veiculos` int NOT NULL AUTO_INCREMENT,
  `marca` varchar(256) NOT NULL,
  `modelo` varchar(256) NOT NULL,
  `ano` int NOT NULL,
  `cor` varchar(256) DEFAULT NULL,
  `veiculos` int DEFAULT NULL,
  PRIMARY KEY (`id_veiculos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `VISTORIA`
--

DROP TABLE IF EXISTS `VISTORIA`;
CREATE TABLE IF NOT EXISTS `VISTORIA` (
  `ID_VISTORIA` int NOT NULL AUTO_INCREMENT,
  `DATA_VISTORIA` date DEFAULT NULL,
  `km_veiculo` int DEFAULT NULL,
  `condicao_geral` enum('otima','boa','regular','ruim') DEFAULT NULL,
  `documentacao_ok` tinyint(1) DEFAULT NULL,
  `observacoes` text,
  `ID_VEICULO` int DEFAULT NULL,
  `ID_CLIENTES` int DEFAULT NULL,
  PRIMARY KEY (`ID_VISTORIA`),
  KEY `FK_CLIENTES_VISTORIA` (`ID_CLIENTES`),
  KEY `FK_VEICULOS_VISTORIA` (`ID_VEICULO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `ACESSOS`
--
ALTER TABLE `ACESSOS`
  ADD CONSTRAINT `CARGOS_ACESSO` FOREIGN KEY (`ID_AUTOR_C`) REFERENCES `CARGOS` (`ID_cargo`),
  ADD CONSTRAINT `FUNCIONARIOS_ACESSOS` FOREIGN KEY (`ID_AUTOR_F`) REFERENCES `Funcionarios` (`IDFuncionario`),
  ADD CONSTRAINT `ROTINAS_ACESSOS` FOREIGN KEY (`ID_ROTINA`) REFERENCES `ROTINAS` (`ID`);

--
-- Limitadores para a tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD CONSTRAINT `agendamento_ibfk_1` FOREIGN KEY (`id_cli`) REFERENCES `CLIENTES` (`id_cli`);

--
-- Limitadores para a tabela `Atendimento`
--
ALTER TABLE `Atendimento`
  ADD CONSTRAINT `fk_id_cli_atendm` FOREIGN KEY (`id_cli_atendm`) REFERENCES `CLIENTES` (`id_cli`),
  ADD CONSTRAINT `id_atendt_atendm_atendm` FOREIGN KEY (`id_atendt_atendm`) REFERENCES `Funcionarios` (`IDFuncionario`);

--
-- Limitadores para a tabela `COMPRA`
--
ALTER TABLE `COMPRA`
  ADD CONSTRAINT `CompEstoq` FOREIGN KEY (`id_estoque`) REFERENCES `ESTOQUE` (`id_estoque`),
  ADD CONSTRAINT `PddCom` FOREIGN KEY (`id_pedido`) REFERENCES `PEDIDOS` (`id_pedido`);

--
-- Limitadores para a tabela `DESPESAS`
--
ALTER TABLE `DESPESAS`
  ADD CONSTRAINT `DESPESAS_ibfk_1` FOREIGN KEY (`id_tipo_despesa`) REFERENCES `TIPO_DESPESAS` (`id_tipo_despesa`);

--
-- Limitadores para a tabela `DOCUMENTOS`
--
ALTER TABLE `DOCUMENTOS`
  ADD CONSTRAINT `DOCUMENTOS_ibfk_1` FOREIGN KEY (`idModelos`) REFERENCES `MODELOS` (`idModelos`);

--
-- Limitadores para a tabela `FINANCIAMENTO`
--
ALTER TABLE `FINANCIAMENTO`
  ADD CONSTRAINT `FKCLI_REFERENCES` FOREIGN KEY (`IDCLI`) REFERENCES `CLIENTES` (`id_cli`),
  ADD CONSTRAINT `FKFINANC_BANCO` FOREIGN KEY (`ID_BANCO`) REFERENCES `BANCO` (`IDBANCO`),
  ADD CONSTRAINT `FKVEIC_FINANCIAMENTO` FOREIGN KEY (`IDVEICL`) REFERENCES `VEICULOS` (`id_veiculos`);

--
-- Limitadores para a tabela `Funcionarios`
--
ALTER TABLE `Funcionarios`
  ADD CONSTRAINT `Funcionarios_ibfk_1` FOREIGN KEY (`IDCargo`) REFERENCES `CARGOS` (`ID_cargo`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Funcionarios_ibfk_2` FOREIGN KEY (`IDDepartamento`) REFERENCES `TURNOS` (`ID_turno`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `INTERACOES`
--
ALTER TABLE `INTERACOES`
  ADD CONSTRAINT `id_atendt_atual_int` FOREIGN KEY (`id_atendt_atual_int`) REFERENCES `Funcionarios` (`IDFuncionario`),
  ADD CONSTRAINT `INTERACOES_ibfk_1` FOREIGN KEY (`id_atendm_int`) REFERENCES `Atendimento` (`id_atendm`),
  ADD CONSTRAINT `INTERACOES_ibfk_2` FOREIGN KEY (`id_tp_probl_int`) REFERENCES `TIPO_PROBLEMA` (`id_tp_probl`);

--
-- Limitadores para a tabela `MODELOS`
--
ALTER TABLE `MODELOS`
  ADD CONSTRAINT `MODELOS_ibfk_1` FOREIGN KEY (`idMontadoras`) REFERENCES `MONTADORAS` (`idMontadoras`),
  ADD CONSTRAINT `MODELOS_ibfk_2` FOREIGN KEY (`idCombustivel`) REFERENCES `TIPO_COMBUSTIVEL` (`idCombustivel`);

--
-- Limitadores para a tabela `NOTAS_FISCAIS`
--
ALTER TABLE `NOTAS_FISCAIS`
  ADD CONSTRAINT `CompFisc` FOREIGN KEY (`id_compra`) REFERENCES `COMPRA` (`id_compra`),
  ADD CONSTRAINT `ItemNF` FOREIGN KEY (`id_itnf`) REFERENCES `ITENS_NOTA` (`id_itnf`),
  ADD CONSTRAINT `NumPedido` FOREIGN KEY (`id_pedido`) REFERENCES `PEDIDOS` (`id_pedido`);

--
-- Limitadores para a tabela `PEDIDOS`
--
ALTER TABLE `PEDIDOS`
  ADD CONSTRAINT `ItemPedido` FOREIGN KEY (`id_itpd`) REFERENCES `ITENS_PEDIDO` (`id_itpd`);

--
-- Limitadores para a tabela `PRODUTOS`
--
ALTER TABLE `PRODUTOS`
  ADD CONSTRAINT `fkcateg_prd` FOREIGN KEY (`prd_ctg`) REFERENCES `CATEGORIAS` (`id_categorias`),
  ADD CONSTRAINT `fkpeca_prd` FOREIGN KEY (`pecas`) REFERENCES `PECAS` (`id_peca`),
  ADD CONSTRAINT `fkveiculo_prd` FOREIGN KEY (`veiculos`) REFERENCES `VEICULOS` (`id_veiculos`);

--
-- Limitadores para a tabela `PROPOSTAS`
--
ALTER TABLE `PROPOSTAS`
  ADD CONSTRAINT `IDVEIC_VEICULO` FOREIGN KEY (`VEICULO_ID`) REFERENCES `VEICULOS` (`id_veiculos`);

--
-- Limitadores para a tabela `REVISAO`
--
ALTER TABLE `REVISAO`
  ADD CONSTRAINT `FK_CLIENTES_REVISAO` FOREIGN KEY (`ID_CLIENTES`) REFERENCES `CLIENTES` (`id_cli`),
  ADD CONSTRAINT `FK_VEICULO_REVISAO` FOREIGN KEY (`ID_VEICULO`) REFERENCES `VEICULOS` (`id_veiculos`);

--
-- Limitadores para a tabela `SEGURO`
--
ALTER TABLE `SEGURO`
  ADD CONSTRAINT `FKCLI_SEGURO` FOREIGN KEY (`IDCLI`) REFERENCES `CLIENTES` (`id_cli`),
  ADD CONSTRAINT `FKVEI_SEGURO` FOREIGN KEY (`IDVEICL`) REFERENCES `VEICULOS` (`id_veiculos`),
  ADD CONSTRAINT `SEGURADORA_SEGURO` FOREIGN KEY (`IDSEGURADORA`) REFERENCES `SEGURADORA` (`IDSEGURADORA`);

--
-- Limitadores para a tabela `USUARIOS`
--
ALTER TABLE `USUARIOS`
  ADD CONSTRAINT `USUARIOS_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`id`);

--
-- Limitadores para a tabela `VISTORIA`
--
ALTER TABLE `VISTORIA`
  ADD CONSTRAINT `FK_CLIENTES_VISTORIA` FOREIGN KEY (`ID_CLIENTES`) REFERENCES `CLIENTES` (`id_cli`),
  ADD CONSTRAINT `FK_VEICULOS_VISTORIA` FOREIGN KEY (`ID_VEICULO`) REFERENCES `VEICULOS` (`id_veiculos`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
