
SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `steam_id` bigint(20) unsigned NOT NULL,
  `rank` enum('silver_1','silver_2','silver_3','silver_4','silver_elite','silver_elite_master','gold_nova_1','gold_nova_2','gold_nova_3','gold_nova_master','master_guardian_1','master_guardian_2','master_guardian_elite','distinguished_master_guardian','legendary_eagle_master','supreme_master_first_class','the_global_elite') COLLATE utf8_bin NOT NULL,
  `nickname` varchar(50) COLLATE utf8_bin NOT NULL,
  `hours_played` int(10) unsigned NOT NULL,
  `register_date` datetime NOT NULL,
  `age` int(10) unsigned DEFAULT NULL,
  `kills` int(10) unsigned NOT NULL,
  `deaths` int(10) unsigned NOT NULL,
  `bio` text COLLATE utf8_bin,
  `image_l` varchar(2083) COLLATE utf8_bin NOT NULL,
  `image_m` varchar(2083) COLLATE utf8_bin NOT NULL,
  `image_s` varchar(2083) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;