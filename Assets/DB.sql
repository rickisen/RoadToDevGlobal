-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `language`;
CREATE TABLE `language` (
  `steam_id` bigint(20) NOT NULL,
  `lang` enum('English','Swedish','Danish','German','French') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `steam_id` bigint(20) NOT NULL,
  `name` enum('entry_fragger','play_maker','strat_caller','support','awper','lurker') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `steam_id` bigint(20) unsigned NOT NULL,
  `rank` enum('silver_1','silver_2','silver_3','silver_4','silver_elite','silver_elite_master','gold_nova_1','gold_nova_2','gold_nova_3','gold_nova_master','master_guardian_1','master_guardian_2','master_guardian_elite','distinguished_master_guardian','legendary_eagle_master','supreme_master_first_class','the_global_elite','unknown') COLLATE utf8_bin NOT NULL,
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

INSERT INTO `user` (`steam_id`, `rank`, `nickname`, `hours_played`, `register_date`, `age`, `kills`, `deaths`, `bio`, `image_l`, `image_m`, `image_s`) VALUES
(76561198119133793,	'silver_1',	'Carl',	643,	'0000-00-00 00:00:00',	1337,	52508,	44792,	'hejhejhej',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/9a/9a908c6e1cec700e02115c8eea7e807a7b96b989_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/9a/9a908c6e1cec700e02115c8eea7e807a7b96b989_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/9a/9a908c6e1cec700e02115c8eea7e807a7b96b989.jpg'),
(76561197961825525,	'unknown',	'fxnKingsToe',	439,	'0000-00-00 00:00:00',	NULL,	26347,	23510,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fc/fc3f3b886b538125f7ac36cfc726866a1bae9e8c_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fc/fc3f3b886b538125f7ac36cfc726866a1bae9e8c_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fc/fc3f3b886b538125f7ac36cfc726866a1bae9e8c.jpg'),
(76561197960964569,	'silver_1',	'5UP3R51CK50UR54U549354UC3',	0,	'0000-00-00 00:00:00',	NULL,	0,	0,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/b1/b13194949f47fd062e145708c7126dfb42c4b853_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/b1/b13194949f47fd062e145708c7126dfb42c4b853_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/b1/b13194949f47fd062e145708c7126dfb42c4b853.jpg'),
(76561198010808320,	'silver_1',	'tussilago',	398,	'0000-00-00 00:00:00',	NULL,	18794,	18449,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f3/f36cf0db720deb546c6fc21c930fbf191df7564b_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f3/f36cf0db720deb546c6fc21c930fbf191df7564b_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f3/f36cf0db720deb546c6fc21c930fbf191df7564b.jpg'),
(76561197981707560,	'silver_1',	'jens',	1191,	'0000-00-00 00:00:00',	NULL,	78273,	64221,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/2b/2b6f5b94e843bfb801802303641b99c10dcb7d03_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/2b/2b6f5b94e843bfb801802303641b99c10dcb7d03_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/2b/2b6f5b94e843bfb801802303641b99c10dcb7d03.jpg'),
(76561198166994467,	'master_guardian_1',	'Aerte',	100,	'0000-00-00 00:00:00',	NULL,	6673,	6191,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fe/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fe/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fe/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb.jpg'),
(76561197963624696,	'silver_1',	'A.OK',	317,	'0000-00-00 00:00:00',	NULL,	16129,	13603,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/60/606a1bf667463a9195527d9f00ccc7d26d89c78a_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/60/606a1bf667463a9195527d9f00ccc7d26d89c78a_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/60/606a1bf667463a9195527d9f00ccc7d26d89c78a.jpg'),
(76561198147424033,	'gold_nova_3',	'chrisS [ãƒ„]',	598,	'0000-00-00 00:00:00',	NULL,	32139,	27814,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/1f/1f126990eb2325883f721f81095173c279487d2a_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/1f/1f126990eb2325883f721f81095173c279487d2a_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/1f/1f126990eb2325883f721f81095173c279487d2a.jpg'),
(76561198217983724,	'silver_3',	'z1nko',	89,	'0000-00-00 00:00:00',	NULL,	5487,	3538,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/a9/a9c7e39b48716c7098b7863357ce22c8d3ac41fe_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/a9/a9c7e39b48716c7098b7863357ce22c8d3ac41fe_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/a9/a9c7e39b48716c7098b7863357ce22c8d3ac41fe.jpg');

-- 2015-12-29 16:23:00
