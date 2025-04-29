SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `richieste` (
  `id` int(11) NOT NULL,
  `nome_utente` varchar(100) NOT NULL,
  `email_utente` varchar(255) NOT NULL,
  `ingegnere` varchar(100) NOT NULL,
  `messaggio` text NOT NULL,
  `data_richiesta` timestamp NOT NULL DEFAULT current_timestamp(),
  `utente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `richieste`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utente_id` (`utente_id`);


ALTER TABLE `richieste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `richieste`
  ADD CONSTRAINT `richieste_ibfk_1` FOREIGN KEY (`utente_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
