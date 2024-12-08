-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 12 oct. 2024 à 12:23
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chambre_lit`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id_admin`, `username`, `password`) VALUES
(2, 'NSENGIMANA', 'kaki2020');

-- --------------------------------------------------------

--
-- Structure de la table `bloc`
--

CREATE TABLE `bloc` (
  `id_bloc` int(11) NOT NULL,
  `nom_bloc` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bloc`
--

INSERT INTO `bloc` (`id_bloc`, `nom_bloc`, `description`) VALUES
(1, 'VIP', 'laboratoire'),
(2, 'VVIP', 'maternite1'),
(3, 'bloc2', 'maternite'),
(5, 'simple', 'laboratoire2'),
(6, 'simple', 'maternite'),
(7, 'simple', 'laboratoire'),
(8, 'simple', 'operatoire'),
(9, 'simple', 'operatoire'),
(10, 'vip', 'urgence');

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

CREATE TABLE `chambre` (
  `id_chambre` int(11) NOT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `statut` char(255) DEFAULT 'libre',
  `id_bloc` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`id_chambre`, `numero`, `type`, `statut`, `id_bloc`) VALUES
(2, '22', 'simple', 'occupe', 2),
(3, '95', 'vip', 'libre', 5),
(8, '11', 'vvip', 'libre', 1),
(6, '10', 'simple', 'libre', 5),
(7, '10', 'VVIP', 'occupe', 2),
(9, '11', 'simple', 'libre', 2),
(10, '12', 'vip', 'occupe', 1),
(11, '9', 'simple', 'occupe', 5),
(12, '10', 'simple', 'libre', 2);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id_contact` int(11) NOT NULL,
  `nom_contact` varchar(50) DEFAULT NULL,
  `relation` varchar(30) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id_contact`, `nom_contact`, `relation`, `telephone`) VALUES
(1, 'ECONET', 'sans', '62186999'),
(2, 'Lumitel', 'avec', '62158986'),
(3, 'leo', 'avec', '79842083');

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `id_employe` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `id_bloc` int(11) DEFAULT NULL,
  `id_ch` int(11) DEFAULT NULL,
  `id_lit` int(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`id_employe`, `nom`, `prenom`, `role`, `contact`, `id_bloc`, `id_ch`, `id_lit`) VALUES
(1, 'NSENGIMANA', 'Elie', 'medecin', '62186990', 1, 1, 1),
(2, 'keza', 'erica', 'medecin', '76389613', 1, 2, 12),
(3, 'NSENGIMANA', 'Eliezer', 'docteur', '62186990', 1, 2, 1),
(4, 'NKURUNZIZA', 'Lionnel', 'planton', '65342558', 2, 2, 1),
(5, 'Keke', 'divin', 'planton', '69798677', 6, 10, 16),
(6, 'Kamariza', 'Elianne', 'medecin', '78523695', 2, 8, 6),
(7, 'Dusabe', 'keria', 'docteur', '76389613', 2, 2, 12),
(8, 'Kiki', 'Titon', 'planton', '65785236', 1, 3, 6),
(9, 'NIYONKURU', 'Elie', 'docteur', '62186990', 10, 6, 6),
(10, 'NSENGIMANA', 'Reonidas', 'medecin', '78523695', 1, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `lit`
--

CREATE TABLE `lit` (
  `id_lit` int(11) NOT NULL,
  `numero_lit` varchar(10) DEFAULT NULL,
  `statut` varchar(255) DEFAULT 'libre',
  `id_bloc` int(11) DEFAULT NULL,
  `id_chambre` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `lit`
--

INSERT INTO `lit` (`id_lit`, `numero_lit`, `statut`, `id_bloc`, `id_chambre`) VALUES
(1, '3', 'occupe', 1, 2),
(6, '5', 'occupe', 1, 3),
(11, '5', 'libre', 1, 2),
(19, '3', 'occupe', 2, 3),
(12, '4', 'libre', 2, 2),
(20, '3', 'libre', 1, 3),
(21, '15', 'libre', 5, 7),
(16, '6', 'occupe', 1, 2),
(17, '7', 'libre', 2, 3),
(22, '12', 'libre', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `id_patient` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `date_naissance` varchar(255) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `id_bloc` int(11) DEFAULT NULL,
  `id_chambre` int(11) DEFAULT NULL,
  `id_lit` int(11) DEFAULT NULL,
  `id_employe` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`id_patient`, `nom`, `prenom`, `date_naissance`, `contact_id`, `id_bloc`, `id_chambre`, `id_lit`, `id_employe`) VALUES
(1, 'NKURUNZIZA', 'Etienne', '2023-08-11', 62186990, 6, 10, 16, 2),
(2, 'NKURUNZIZA', 'Etienne', '2023-08-11', 62186990, 6, 10, 16, 2),
(3, 'NKURUNZIZA', 'Etienne', '2023-08-11', 62186990, 6, 10, 16, 2),
(4, 'MUKAMANA', 'Sandrine', '2023-08-11', 62186990, 2, 2, 6, 4),
(5, 'MUKAMANA', 'Sandrine', '2023-08-11', 62186990, 2, 2, 6, 4),
(6, 'NISHIMWE', 'Titon', '2024-10-20', 22545879, 1, 2, 16, 4),
(7, 'NKURUNZIZA', 'Audace', '2024-10-05', 62186990, 2, 6, 6, 6),
(8, 'NIYONKURU', 'digne', '2024-10-10', 62186990, 2, 2, 6, 4),
(9, 'gakiza', 'Kevin', '2024-10-12', 62186990, 1, 3, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `publication`
--

CREATE TABLE `publication` (
  `id_publication` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `date_publication` date DEFAULT NULL,
  `contenu` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `publication`
--

INSERT INTO `publication` (`id_publication`, `titre`, `date_publication`, `contenu`, `created_at`) VALUES
(1, 'appel de candidature', '2024-10-18', 'hello', '2024-10-12 09:09:58'),
(2, 'appel d\'offre', '2024-10-13', ' bonjour', '2024-10-12 09:10:16');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id_admin`);

--
-- Index pour la table `bloc`
--
ALTER TABLE `bloc`
  ADD PRIMARY KEY (`id_bloc`);

--
-- Index pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD PRIMARY KEY (`id_chambre`),
  ADD KEY `id_bloc` (`id_bloc`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id_contact`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`id_employe`),
  ADD KEY `id_bloc` (`id_bloc`),
  ADD KEY `id_chambre` (`id_ch`),
  ADD KEY `id_lit` (`id_lit`);

--
-- Index pour la table `lit`
--
ALTER TABLE `lit`
  ADD PRIMARY KEY (`id_lit`),
  ADD KEY `id_bloc` (`id_bloc`),
  ADD KEY `id_chambre` (`id_chambre`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id_patient`),
  ADD KEY `id_employe` (`id_employe`),
  ADD KEY `id_bloc` (`id_bloc`),
  ADD KEY `id_chambre` (`id_chambre`),
  ADD KEY `id_lit` (`id_lit`);

--
-- Index pour la table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`id_publication`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `bloc`
--
ALTER TABLE `bloc`
  MODIFY `id_bloc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `chambre`
--
ALTER TABLE `chambre`
  MODIFY `id_chambre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `id_employe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `lit`
--
ALTER TABLE `lit`
  MODIFY `id_lit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `id_patient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `publication`
--
ALTER TABLE `publication`
  MODIFY `id_publication` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
