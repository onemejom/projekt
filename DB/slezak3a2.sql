-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: Po 17.Jún 2024, 12:03
-- Verzia serveru: 10.4.32-MariaDB
-- Verzia PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `slezak3a2`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `t_kategoria`
--

CREATE TABLE `t_kategoria` (
  `id` int(11) NOT NULL,
  `kategoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `t_kategoria`
--

INSERT INTO `t_kategoria` (`id`, `kategoria`) VALUES
(1, 'Lacná'),
(2, 'Stredná'),
(3, 'Drahá');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `t_produkty`
--

CREATE TABLE `t_produkty` (
  `id` int(11) NOT NULL,
  `nazov` varchar(100) NOT NULL,
  `pocet` bigint(255) NOT NULL,
  `popis` varchar(255) DEFAULT NULL,
  `cena` decimal(10,2) DEFAULT NULL,
  `kategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `t_produkty`
--

INSERT INTO `t_produkty` (`id`, `nazov`, `pocet`, `popis`, `cena`, `kategoria`) VALUES
(1, 'Rapture COBRA', 200, 'Herná myš - bezdrôtová, optický senzor Pixart PAW3325, 800 – 1200 – 2000 – 3200 – 5000 DPI, odozva 1 ms, tracking speed 100 IPS, akcelerácia 20 G, RGB podsvietenie (7 režimov podsvietenia), 7 programovateľných tlačidiel, Omron spínače, životnost až 100000', 27.00, 1),
(2, 'Logitech G305 Recoil', 100, 'Herná myš – bezdrôtová, pre pravákov, optická, pripojenie cez bezdrôtový USB prijímač, na 1 AA batériu, citlivosť 12000 DPI, možná zmena DPI, odozva 1 ms, 6 tlačidiel, klasické koliesko, lightspeed prijímač súčasťou balenia, rozmery 3,82 × 6,215 × 11,66 c', 39.00, 1),
(3, 'Logitech G703 Lightspeed Hero', 50, 'Herná myš – bezdrôtová, pre pravákov, optická, pripojenie cez USB, bezdrôtový USB prijímač, citlivosť 25600 DPI, možná zmena DPI, odozva 1 ms, 6 tlačidiel, klasické koliesko, RGB podsvietenie', 84.00, 3),
(4, 'Razer VIPER ULTIMATE Wireless Gaming Mouse with Charging Dock', 240, 'Herná myš – bezdrôtová, symetrická, optická, pripojenie cez USB, bezdrôtový USB prijímač, citlivosť 20000 DPI, odozva 0,2 ms, 8 tlačidiel, klasické koliesko, RGB podsvietenie, dĺžka kábla 1,8 m, rozmery 3,78 × 6,62 × 12,67 cm (V×Š×H), hmotnosť 74 g', 131.00, 3),
(5, 'Razer Deathadder V2 X HyperSpeed', 20, 'Herná myš – bezdrôtová, pre pravákov, optická, pripojenie cez bluetooth, bezdrôtový USB prijímač, na 1 AA batériu, citlivosť 14000 DPI, 7 tlačidiel, maximálny dosah 10 m, unifying prijímač a batéria súčasťou balenia, rozmery 4,27 × 6,17 × 12,7 cm (V×Š×H),', 64.00, 2),
(6, 'Rapture PYTHON čierna', 88, 'Herná myš - drôtová, optický senzor Pixart PMW3327, 600 - 800 - 1200 - 1600 - 2400 - 3600 - 6200 DPI, odozva 1ms, tracking speed 220 IPS, akcelerácia 30G, RGB podsvietenie, životnosť až 10000000 kliknutí, Plug & Play, dĺžka kábla 1.8m, opletený kábel, hmo', 19.00, 1),
(7, 'Logitech G502 Hero', 13, 'Herná myš – až 25.600dpi, 400IPS, pamäť pre uloženie profilov, 11 programovateľných tlačidiel, snímač HERO 25k, Omron tlačidlá, podsvietená (G lightsync RGB)', 57.00, 2),
(8, 'Logitech G305 Recoil biela', 25, 'Herná myš – bezdrôtová, pre pravákov, optická, pripojenie cez bezdrôtový USB prijímač, na 1 AA batériu, citlivosť 12000 DPI, možná zmena DPI, odozva 1 ms, 6 tlačidiel, klasické koliesko, lightspeed prijímač súčasťou balenia, rozmery 3,82 × 6,215 × 11,66 c', 39.00, 1),
(9, 'Logitech G Pro Wireless', 8, 'Herná myš – bezdrôtová, symetrická, optická, pripojenie cez USB, bezdrôtový USB prijímač, citlivosť 25600 DPI, možná zmena DPI, odozva 1 ms, 8 tlačidiel, klasické koliesko, viacfarebné podsvietenie, rozmery 4 × 6,35 × 12,5 cm (V×Š×H), hmotnosť 80 g', 109.00, 3),
(10, 'Logitech G102 Lightsync, black', 66, 'Herná myš – drôtová, pre pravákov, optická, pripojenie cez USB, citlivosť 8000 DPI, možná zmena DPI, odozva 1 ms, 6 tlačidiel, klasické koliesko, RGB podsvietenie, dĺžka kábla 2,1 m, rozmery 3,82 × 6,215 × 11,66 cm (V×Š×H), hmotnosť 85 g', 29.00, 1);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `t_user`
--

CREATE TABLE `t_user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `t_user`
--

INSERT INTO `t_user` (`id`, `username`, `password`, `email`) VALUES
(1, 'Jozko', '123', 'jozko@gmail.com'),
(2, 'Paliak', '$2y$10$Pg0.BTAK4lfyd2jReoCwROUa5SU/RiskhwAqzhl38AiqoODrNorkK', 'paliak@gmail.com'),
(3, 'Pato', '$2y$10$XG8YBfvEut3Dx04nyPOb2edpEyWbXNFIrHyQi02AaGy.C4yMKAUzK', 'patoondrik@gmail.com'),
(4, 'Adam', '$2y$10$S2eQylYuVwY5HQxaXMmEbOS8PWdVVIEXVwpalqyYQK9sWVvyW4K.u', 'adam@gmail.com'),
(5, 'adam1', '$2y$10$WRYHNlXB17K9Qmt2GRLUpebVXTDsxdJwfWVwZs6oc8TZwlbLWTYOu', 'adam1@adam1.com');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `t_kategoria`
--
ALTER TABLE `t_kategoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `t_produkty`
--
ALTER TABLE `t_produkty`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `t_kategoria`
--
ALTER TABLE `t_kategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pre tabuľku `t_produkty`
--
ALTER TABLE `t_produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pre tabuľku `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
