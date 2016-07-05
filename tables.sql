-- Server-Version: 5.7.12-0ubuntu1.1
-- PHP-Version: 7.0.4-7ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `dsbmobile`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `klasse`
--

CREATE TABLE `klasse` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(64) CHARACTER SET latin1 NOT NULL,
  `lehrer` varchar(64) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `plan_heute`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `plan_heute` (
`stunde` varchar(12)
,`datum` date
,`art` enum('Statt-Vertretung','Raum-Vtr.','Veranst.','Vertretung','eigenverantwortliches Arbeiten','Freisetzung','Entfall')
,`fach` text
,`raum` text
,`txt` text
,`grund` text
,`bezeichnung` varchar(64)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `plan_morgen`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `plan_morgen` (
`stunde` varchar(12)
,`datum` date
,`art` enum('Statt-Vertretung','Raum-Vtr.','Veranst.','Vertretung','eigenverantwortliches Arbeiten','Freisetzung','Entfall')
,`fach` text
,`raum` text
,`txt` text
,`grund` text
,`bezeichnung` varchar(64)
);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `updates`
--

CREATE TABLE `updates` (
  `id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vertretung`
--

CREATE TABLE `vertretung` (
  `id` int(32) NOT NULL,
  `id_klasse` int(11) NOT NULL,
  `stunde` varchar(12) CHARACTER SET latin1 NOT NULL,
  `datum` date NOT NULL,
  `art` enum('Statt-Vertretung','Raum-Vtr.','Veranst.','Vertretung','eigenverantwortliches Arbeiten','Freisetzung','Entfall') CHARACTER SET latin1 NOT NULL,
  `fach` text CHARACTER SET latin1 NOT NULL,
  `raum` text CHARACTER SET latin1 NOT NULL,
  `txt` text CHARACTER SET latin1 NOT NULL,
  `grund` text CHARACTER SET latin1 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;
