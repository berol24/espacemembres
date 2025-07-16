-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 16 juil. 2025 à 11:52
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fruistore`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `adresse`, `email`, `telephone`) VALUES
(1, 'dada', 'Ernest', '1 Rue Julius et Ethel Rosenberg, 95870 Bezons', 'hello@gmail.com', '0134113775'),
(2, 'Dadi', 'Ernest', '14 RUE BOUSSOIS EPINAY', 'hello@gmail.com', '0789654123'),
(3, 'titi', 'tata', '1 Rue Julius et Ethel Rosenberg, 95870 Bezons', 'bertinkuicheu@gmail.com', '0134113775'),
(4, 'dada', 'dada', '14 RUE BOUSSOIS EPINAY', 'hello@gmail.com', '0134113775'),
(5, 'Alex', 'Dada', '14 RUE BOUSSOIS EPINAY', 'bertinkuicheu@gmail.com', '0134113775'),
(6, 'Lopez', 'martine', 'Champs sur marne', 'martine@gmail.com', '0610810795'),
(7, 'Fabien', 'KUICHEU', 'Champs sur marne', 'bertinkuicheu@gmail.com', '0789654123'),
(8, 'Ismael', 'Ernest', '14 RUE BOUSSOIS EPINAY SUR SEINE', '', '789654123'),
(9, 'Ismael', 'Ernest', '14 RUE BOUSSOIS EPINAY SUR SEINE', '', '789654123'),
(10, 'Ismael', 'Ernest', '1 Rue Julius et Ethel Rosenberg, 95870 Bezons', 'berolbertindjomo@gmail.com', '659545017'),
(11, 'dada', 'Ernest', '1 Rue Julius et Ethel Rosenberg, 95870 Bezons', 'berolbertindjomo@gmail.com', '0134113775'),
(12, 'dada', 'didi', '1 Rue Julius et Ethel Rosenberg, 95870 Bezons', '', '0789654123'),
(13, 'Jules', 'raoul', '1 Rue Julius et Ethel Rosenberg, 95870 Bezons', 'hello@gmail.com', '659545017');

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE `devis` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `date_devis` datetime NOT NULL,
  `total_ht` decimal(10,2) NOT NULL,
  `total_ttc` decimal(10,2) NOT NULL,
  `statut` varchar(50) DEFAULT 'en attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `devis`
--

INSERT INTO `devis` (`id`, `id_user`, `id_client`, `date_devis`, `total_ht`, `total_ttc`, `statut`) VALUES
(3, 1, 3, '2025-07-15 15:08:35', 6500.00, 7800.00, 'en attente'),
(6, 1, 6, '2025-07-15 16:01:01', 2500.00, 3000.00, 'en attente'),
(7, 2, 7, '2025-07-15 17:00:00', 94.50, 113.40, 'en attente'),
(10, 1, 10, '2025-07-16 10:42:47', 19.00, 22.80, 'en attente'),
(11, 1, 11, '2025-07-16 10:56:02', 8.00, 9.60, 'en attente'),
(12, 1, 12, '2025-07-16 11:08:51', 8.00, 9.60, 'en attente'),
(13, 1, 13, '2025-07-16 11:42:06', 8.00, 9.60, 'en attente');

-- --------------------------------------------------------

--
-- Structure de la table `devis_details`
--

CREATE TABLE `devis_details` (
  `id` int(11) NOT NULL,
  `id_devis` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  `tva` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `devis_details`
--

INSERT INTO `devis_details` (`id`, `id_devis`, `designation`, `quantite`, `prix_unitaire`, `tva`) VALUES
(3, 3, 'Ananas', 1, 0.00, 20.00),
(7, 6, 'Mangue', 1, 1000.00, 20.00),
(8, 6, 'Papaye', 2, 750.00, 20.00),
(9, 7, 'Goyave', 3, 7.50, 20.00),
(10, 7, 'Avocat', 5, 9.00, 20.00),
(11, 7, 'Pastèque', 1, 9.00, 20.00),
(12, 7, 'Banane', 3, 6.00, 20.00),
(19, 10, 'Ananas', 1, 8.00, 20.00),
(20, 10, 'Mandarine', 2, 5.50, 20.00),
(21, 11, 'Ananas', 1, 8.00, 20.00),
(22, 12, 'Ananas', 1, 8.00, 20.00),
(23, 13, 'Ananas', 1, 8.00, 20.00);

-- --------------------------------------------------------

--
-- Structure de la table `recup_password`
--

CREATE TABLE `recup_password` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `password` text NOT NULL,
  `token` varchar(20) NOT NULL,
  `validation` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `adresse`, `email`, `telephone`, `password`, `token`, `validation`) VALUES
(1, 'NielsenIQ', '1 Rue Julius et Ethel Rosenberg, 95870 Bezons', 'berolbertindjomo@gmail.com', '0789654123', '$2y$10$GXGF3MZW.ckMA8qSk5QAy.L92dzTV1IY9RM2KLpabULE1B3NSGrJq', 'valide', 1),
(2, 'Bertino', '14 RUE BOUSSOIS EPINAY', 'bertinkuicheu@gmail.com', '7896542123', '$2y$10$9O.PhdbsZnIEzaPxijdLwOr/UMFvrPtC1/Bg2KzW5cGaGqjG7kOra', 'valide', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `devis`
--
ALTER TABLE `devis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `devis_details`
--
ALTER TABLE `devis_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_devis` (`id_devis`);

--
-- Index pour la table `recup_password`
--
ALTER TABLE `recup_password`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `devis`
--
ALTER TABLE `devis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `devis_details`
--
ALTER TABLE `devis_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `recup_password`
--
ALTER TABLE `recup_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `devis_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `devis_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`);

--
-- Contraintes pour la table `devis_details`
--
ALTER TABLE `devis_details`
  ADD CONSTRAINT `devis_details_ibfk_1` FOREIGN KEY (`id_devis`) REFERENCES `devis` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
