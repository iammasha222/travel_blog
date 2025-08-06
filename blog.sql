-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 06. Aug 2025 um 13:14
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `blog`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `article`
--

CREATE TABLE `article` (
  `ID` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Text` text DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Author` varchar(100) DEFAULT NULL,
  `Online` tinyint(1) DEFAULT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `article`
--

INSERT INTO `article` (`ID`, `Title`, `Image`, `Text`, `Date`, `Author`, `Online`, `tags`) VALUES
(1, 'Zu Besuch im Alten Land', '../assets/img/Altes-Land.jpg', 'Weit hinten, hinter den Wortbergen, fern der Länder Vokalien und Konsonantien leben die Blindtexte. Abgeschieden wohnen sie in Buchstabhausen an der Küste des Semantik, eines großen Sprachozeans. Ein kleines Bächlein namens Duden fließt durch ihren Ort und versorgt sie mit den nötigen Regelialien. Es ist ein paradiesmatisches Land, in dem einem gebratene Satzteile in den Mund fliegen. Nicht einmal von der allmächtigen Interpunktion werden die Blindtexte beherrscht – ein geradezu unorthographisches Leben. Eines Tages aber beschloß eine kleine Zeile Blindtext, ihr Name war Lorem Ipsum, hinaus zu gehen in die weite Grammatik. Der große Oxmox riet ihr davon ab, da es dort wimmele von bösen Kommata, wilden Fragezeichen und hinterhältigen Semikoli, doch das Blindtextchen ließ sich nicht beirren. Es packte seine sieben Versalien, schob sich sein Initial in den Gürtel und machte sich auf den Weg. Als es die ersten Hügel des Kursivgebirges erklommen hatte, warf es einen letzten Blick zurück auf die Skyline seiner Heimatstadt Buchstabhausen, die Headline von Alphabetdorf und die Subline seiner eigenen Straße, der Zeilengasse. Wehmütig lief ihm eine rhetorische Frage über die Wange, dann setzte es seinen Weg fort. Unterwegs traf es eine Copy.', '0000-00-00', 'Jan Nordland', 1, 'Wochendausflug,Hamburg,Sommer,Städtetrip'),
(2, 'Urlaubsgrüße aus Florenz', '../assets/img/Florenz.jpg', 'Er hörte leise Schritte hinter sich. Das bedeutete nichts Gutes. Wer würde ihm schon folgen, spät in der Nacht und dazu noch in dieser engen Gasse mitten im übel beleumundeten Hafenviertel? Gerade jetzt, wo er das Ding seines Lebens gedreht hatte und mit der Beute verschwinden wollte! Hatte einer seiner zahllosen Kollegen dieselbe Idee gehabt, ihn beobachtet und abgewartet, um ihn nun um die Früchte seiner Arbeit zu erleichtern? Oder gehörten die Schritte hinter ihm zu einem der unzähligen Gesetzeshüter dieser Stadt, und die stählerne Acht um seine Handgelenke würde gleich zuschnappen? Er konnte die Aufforderung stehen zu bleiben schon hören. Gehetzt sah er sich um. Plötzlich erblickte er den schmalen Durchgang. Blitzartig drehte er sich nach rechts und verschwand zwischen den beiden Gebäuden. Beinahe wäre er dabei über den umgestürzten Mülleimer gefallen, der mitten im Weg lag. Er versuchte, sich in der Dunkelheit seinen Weg zu ertasten und erstarrte: Anscheinend gab es keinen anderen Ausweg aus diesem kleinen Hof als den Durchgang, durch den er gekommen war. Die Schritte wurden lauter und lauter, er sah eine dunkle Gestalt um die Ecke biegen. Fieberhaft irrten seine Augen durch die nächtliche Dunkelheit und suchten einen Ausweg.', '0000-00-00', 'Viola Meridiane', 1, 'Urlaub,Florenz,Sommer,Städtetrip'),
(3, 'Tagesausflug nach Bern', '../assets/img/Bern.jpg', 'Jemand musste Josef K. verleumdet haben, denn ohne dass er etwas Böses getan hätte, wurde er eines Morgens verhaftet. »Wie ein Hund!« sagte er, es war, als sollte die Scham ihn überleben. Als Gregor Samsa eines Morgens aus unruhigen Träumen erwachte, fand er sich in seinem Bett zu einem ungeheueren Ungeziefer verwandelt. Und es war ihnen wie eine Bestätigung ihrer neuen Träume und guten Absichten, als am Ziele ihrer Fahrt die Tochter als erste sich erhob und ihren jungen Körper dehnte. »Es ist ein eigentümlicher Apparat«, sagte der Offizier zu dem Forschungsreisenden und überblickte mit einem gewissermaßen bewundernden Blick den ihm doch wohlbekannten Apparat. Sie hätten noch ins Boot springen können, aber der Reisende hob ein schweres, geknotetes Tau vom Boden, drohte ihnen damit und hielt sie dadurch von dem Sprunge ab. In den letzten Jahrzehnten ist das Interesse an Hungerkünstlern sehr zurückgegangen. Aber sie überwanden sich, umdrängten den Käfig und wollten sich gar nicht fortrühren.Jemand musste Josef K. verleumdet haben, denn ohne dass er etwas Böses getan hätte, wurde er eines Morgens verhaftet. »Wie ein Hund!« sagte er, es war, als sollte die Scham ihn überleben.', '0000-00-00', 'Jan Nordland', 1, 'Wochendausflug,Bern,Frühjahr,Städtetrip'),
(4, 'Sommerurlaub in Portugal', '', 'Blitzartig drehte er sich nach rechts und verschwand zwischen den beiden Gebäuden. Beinahe wäre er dabei über den umgestürzten Mülleimer gefallen, der mitten im Weg lag.', '2025-07-31', 'Adora Viagem', 1, 'Urlaub,Portugal,Sommer,Rundreise'),
(5, 'Skiurlaub in Bad Gastein', '', 'Es ist ein paradiesmatisches Land, in dem einem gebratene Satzteile in den Mund fliegen. Nicht einmal von der allmächtigen Interpunktion werden die Blindtexte beherrscht – ein geradezu unorthographisches Leben. ', '0000-00-00', 'Jan Nordland', 0, 'Urlaub,Österreich,Winter,Skifahren'),
(8, 'Florenz', '../assets/img/Florenz.jpg', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,\r\n\r\n', '0000-00-00', 'Jan Nordland', 1, 'Bern,Urlaub,Reise'),
(9, 'Bern', '../assets/img/Bern.jpg', 'bernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbernbern', '0000-00-00', 'Viola Meridiane', 1, 'bern'),
(15, 'ges', '../assets/img/Bern.jpg', 'gdsx', '0000-00-00', 'Jan Nordland', 1, 'Bern,Urlaub,Reise'),
(16, 'Bern', '../assets/img/Florenz.jpg', 'BernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBernBern', '2024-07-12', 'Viola Meridiane', 1, 'Bern,Urlaub,Reise'),
(17, 'vafvga', '../assets/img/Altes-Land.jpg', 'b&lt;svbgs&lt;bb&lt;s', '2024-07-05', 'Bill Darent', 1, 'Bern,Urlaub,Reise'),
(19, 'Bernnnn', '../assets/img/Bern.jpg', 'hi', '0000-00-00', 'Viola Meridiane', 0, 'hi'),
(20, 'vdsvbg', '../assets/img/Florenz.jpg', 'bsdfb', '0000-00-00', 'viola_meridiane@gmail.com', 1, 'Bern,Urlaub,Reise'),
(21, 'hswre', '../assets/img/Bern.jpg', 'bsyxfbfrbhgdsye', '0000-00-00', 'viola_meridiane@gmail.com', 0, 'Bern,Urlaub,Reise'),
(22, 'vsdvs', '../assets/img/Florenz.jpg', 'bdsbyx', '0000-00-00', 'bill_darrent@gmail.com', 0, 'Bern,Urlaub,Reise'),
(27, 'vsdvsv', '../assets/img/Bern.jpg', 'vdsvdsv', '0000-00-00', 'bill_darrent@gmail.com', 0, 'bd'),
(28, 'Hi', '../assets/img/Altes-Land.jpg', 'gsrgdgs', '0000-00-00', 'Jan Nordland', 1, 'Bern,Urlaub,Reise'),
(30, 'bsdb', '../assets/img/Florenz.jpg', 'bsdbsb', '0000-00-00', 'Adora Viagem', 1, 'Bern,Urlaub,Reise'),
(34, 'Florenz2', '../assets/img/Florenz.jpg', 'fewfawf', '0000-00-00', 'Jan Nordland', 0, 'Bern,Urlaub,Reise'),
(38, 'Bern', '../assets/img/Bern.jpg', 'vdsvsvg', '0000-00-00', 'Jan Nordland', 0, 'Bern,Urlaub,Reise'),
(43, 'hi', '../assets/img/Florenz.jpg', 'hi', '2024-08-06', 'viola_meridiane@gmail.com', 1, 'Bern,Urlaub,Reise'),
(44, 'hi', '../assets/img/', 'hi', '2024-08-09', 'viola_meridiane@gmail.com', 1, 'vs'),
(47, 'f', '../assets/img/', 'fef', '2024-08-06', 'viola_meridiane@gmail.com', 0, 'fe'),
(48, 'v', '../assets/img/', 'v', '2024-08-06', 'Viola Meridiane', 1, 'v'),
(57, 'f', '../assets/img/', 'f', '2024-08-07', 'Jan Nordland', 0, 'f'),
(58, 'fff', '../assets/img/', 'f', '0000-00-00', 'Jan Nordland', 1, 'f'),
(61, 'gddf', '../assets/img/', 'fdfdfd', '2024-08-10', 'Jan Nordland', 0, 'Bern,Urlaub,Reise'),
(62, 'oiuztrew', '../assets/img/', 'f', '2024-08-07', 'Viola Meridiane', 1, 'f');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `article_tag`
--

CREATE TABLE `article_tag` (
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tag`
--

CREATE TABLE `tag` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`ID`, `email`, `password`, `name`) VALUES
(1, 'viola_meridiane@gmail.com', '12345', 'Viola Meridiane');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `article_tag`
--
ALTER TABLE `article_tag`
  ADD PRIMARY KEY (`article_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indizes für die Tabelle `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tag`
--
ALTER TABLE `tag`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `article_tag`
--
ALTER TABLE `article_tag`
  ADD CONSTRAINT `article_tag_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
