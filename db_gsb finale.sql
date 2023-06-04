-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 02 juin 2023 à 01:44
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bd_gsb`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id_avis` int(11) NOT NULL,
  `id_trajet` int(11) NOT NULL,
  `createur_projet` varchar(255) NOT NULL,
  `commentaire_avis` varchar(255) NOT NULL,
  `note_avis` decimal(3,1) NOT NULL,
  `membre_donne_avis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `id_trajet`, `createur_projet`, `commentaire_avis`, `note_avis`, `membre_donne_avis`) VALUES
(1, 68, 'Matheo', 'hgggggggggg', 0.0, '0'),
(2, 68, 'Matheo', 'Bon conducteur, bonne conduite', 8.0, '0'),
(3, 68, 'Matheo', 'peu de discussion', 4.0, '0'),
(4, 68, 'Matheo', 'peu de discussion', 4.0, '0'),
(5, 68, 'Matheo', 'fgh', 5.0, '0'),
(6, 68, 'Matheo', 'Pas trop mal', 7.0, 'TestApou');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int(11) NOT NULL,
  `id_trajet` int(11) DEFAULT NULL,
  `pseudo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `id_trajet`, `pseudo`) VALUES
(1, 69, 'TestApou'),
(2, 69, 'Apou'),
(3, 69, 'Apou'),
(4, 69, 'Apou'),
(5, 73, 'TestApou'),
(6, 68, 'TestApou');

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

CREATE TABLE `trajet` (
  `id_trajet` int(11) NOT NULL,
  `cout_trajet` int(11) NOT NULL,
  `lieu_depart_trajet` text NOT NULL,
  `lieu_arrivee_trajet` text NOT NULL,
  `date_trajet` date DEFAULT NULL,
  `heure_depart_trajet` text NOT NULL,
  `heure_arrivee_trajet` text NOT NULL,
  `type_voiture_trajet` text NOT NULL,
  `modele_voiture_trajet` text NOT NULL,
  `nombre_place_trajet` text NOT NULL,
  `commentaire_trajet` varchar(80) NOT NULL,
  `createur_projet` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `trajet`
--

INSERT INTO `trajet` (`id_trajet`, `cout_trajet`, `lieu_depart_trajet`, `lieu_arrivee_trajet`, `date_trajet`, `heure_depart_trajet`, `heure_arrivee_trajet`, `type_voiture_trajet`, `modele_voiture_trajet`, `nombre_place_trajet`, `commentaire_trajet`, `createur_projet`) VALUES
(49, 20, 'Lyon', 'Paris', NULL, '10h', '22h', 'Profe', '307 peugeot', '1', 'Pause toutes les 2h', ''),
(50, 20, 'Lyon', 'Paris', NULL, '10h', '22h', 'Profe', '307 peugeot', '1', 'Pause toutes les 2h', ''),
(51, 5, 'f', 'f', NULL, 'f', 'f', 'f', 'f', 'f', 'f', ''),
(52, 9, 'Vesoul', 'Toulouse', NULL, '5h', '16h', 'Personnelle', 'Citroen', '2', '', ''),
(53, 5, 'vesoul', 'paris', NULL, '10h', '16h', 'personnelle', 'audi RS8', '3', 'Pas de fumeurs', ''),
(68, 24, 'Reims', 'Vesoul', '2023-05-10', '01h30', '05h30', 'Personnelle', 'GTR Nissan', '3', 'Pas de fumeur', 'Matheo'),
(69, 8, 'Paris', 'Vesoul', '2023-06-24', '02h30', '04h30', 'Personnelle', 'Alfa romeo Giulia', '0', '', 'Apou'),
(70, 4, 'Marseille', 'ozesdfg', '2023-06-22', '00h00', '00h00', 'Professionnelle', 'Peugeot 308', '8', '', 'TestApou'),
(71, 25, 'Paris', 'TestTrajet', '2023-06-17', '01h00', '06h30', 'Personnelle', 'Peugeot 4008', '9', '', 'TestApou'),
(72, 52, 'sdfg', 'vesoul', '0000-00-00', '00h00', '00h00', 'Personnelle', 'Supra Toyota', '15', 'Aucun', 'Apou'),
(73, 65, 'Belfort', 'Marseille', '2023-06-09', '00h00', '08h00', 'Personnelle', 'Alfa romeo Giulia', '3', '', 'Apou');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `pseudo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `phone`, `pseudo`) VALUES
(2, 'test1@gmail.com', '$2y$10$6NpigbWvcwgVEiLVY9XF9eYbEVvqg8Y1bQO4LHgntrTycfPekso6e', '0619926674', 'Apou'),
(3, 'test2@gmail.com', '$2y$10$vxT5bJ/KN9Saxqq0d9ctyuyqHZzFcjtz02XK9WxvFGQfsp0iNq9s6', '3515615', 'qer'),
(8, 'gagelintheo2@gmail.com', '$2y$10$PHk2yRsf3Ev/WiRuGW/U2e4NtzUjSKNtImoNygHCVQGtvMHqskEaO', '46464', 'TestApou');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id_avis`),
  ADD KEY `fk_avis_trajet` (`id_trajet`),
  ADD KEY `fk_avis_createur_projet` (`createur_projet`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `fk_reservation_trajet` (`id_trajet`),
  ADD KEY `fk_reservation_users` (`pseudo`);

--
-- Index pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD PRIMARY KEY (`id_trajet`),
  ADD KEY `idx_id_trajet` (`id_trajet`),
  ADD KEY `idx_createur_projet` (`createur_projet`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_pseudo` (`pseudo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id_avis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `trajet`
--
ALTER TABLE `trajet`
  MODIFY `id_trajet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `fk_avis_createur_projet` FOREIGN KEY (`createur_projet`) REFERENCES `trajet` (`createur_projet`),
  ADD CONSTRAINT `fk_avis_trajet` FOREIGN KEY (`id_trajet`) REFERENCES `trajet` (`id_trajet`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_trajet` FOREIGN KEY (`id_trajet`) REFERENCES `trajet` (`id_trajet`),
  ADD CONSTRAINT `fk_reservation_users` FOREIGN KEY (`pseudo`) REFERENCES `users` (`pseudo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
