-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 10 avr. 2025 à 15:22
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
-- Base de données : `membres`
--

-- --------------------------------------------------------

--
-- Structure de la table `recup_password`
--

CREATE TABLE `recup_password` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `recup_password`
--

INSERT INTO `recup_password` (`id`, `email`, `token`) VALUES
(3, 'bertin@gmail.com', 'UJJHAGfnUTNKfyUtiVf2'),
(4, 'berol@gmail.com', 'YpKRdZaazZanZ5j1A1gn');

-- --------------------------------------------------------

--
-- Structure de la table `table_membres`
--

CREATE TABLE `table_membres` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `token` varchar(20) NOT NULL,
  `validation` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `table_membres`
--

INSERT INTO `table_membres` (`id`, `username`, `email`, `password`, `token`, `validation`) VALUES
(11, 'tf2', 'bertinokuicheu@gmail.com', '$2y$10$3Vp658msu4sZNlSlpBxFvOFVZPGPKn8a3Ps7ZXj.Nk.nyLsBqXQ.u', 'valide', 1),
(12, 'unedic2', 'berolbertindjomo@gmail.com', '$2y$10$ERsBNW4amPrlnIge6ur0BeoRkyKM/oqMa0dXznrpMyc9biMR/iFRG', 'valide', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `recup_password`
--
ALTER TABLE `recup_password`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `table_membres`
--
ALTER TABLE `table_membres`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `recup_password`
--
ALTER TABLE `recup_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `table_membres`
--
ALTER TABLE `table_membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
