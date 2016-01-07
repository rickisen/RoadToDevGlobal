-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `devglobal`;

DROP TABLE IF EXISTS `language`;
CREATE TABLE `language` (
  `steam_id` bigint(20) NOT NULL,
  `lang` enum('English','Swedish','Danish','German','French') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `lobby`;
CREATE TABLE `lobby` (
  `steam_id` bigint(20) NOT NULL,
  `lobby_id` varchar(240) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`steam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `player_looking_for_lobby`;
CREATE TABLE `player_looking_for_lobby` (
  `steam_id` bigint(20) unsigned NOT NULL,
  `started_looking` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`steam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `rank_img`;
CREATE TABLE `rank_img` (
  `rank` enum('silver_1','silver_2','silver_3','silver_4','silver_elite','silver_elite_master','gold_nova_1','gold_nova_2','gold_nova_3','gold_nova_master','master_guardian_1','master_guardian_2','master_guardian_elite','distinguished_master_guardian','legendary_eagle_master','supreme_master_first_class','the_global_elite','unknown') COLLATE utf8_bin NOT NULL,
  `img` varchar(250) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `rank_img` (`rank`, `img`) VALUES
('silver_1',	'http://s3.postimg.org/5z7msz3tv/image.png'),
('silver_2',	'http://s13.postimg.org/d21iyve2f/image.png'),
('silver_3',	'http://s28.postimg.org/x5zai2ie5/image.png'),
('silver_4',	'http://s8.postimg.org/hvv5id2np/image.png'),
('silver_elite',	'http://s17.postimg.org/sc8vqmjsv/image.png'),
('silver_elite_master',	'http://s17.postimg.org/w7yqizsfz/image.png'),
('gold_nova_1',	'http://s7.postimg.org/v734usakr/GN1.png'),
('gold_nova_2',	'http://s10.postimg.org/mk5v6lpvt/GN2.png'),
('gold_nova_3',	'http://s13.postimg.org/jdhun71wn/GN3.png'),
('gold_nova_master',	'http://s13.postimg.org/ecagltug7/GN4.png'),
('master_guardian_1',	'http://s1.postimg.org/863728x8f/mg1.png'),
('master_guardian_2',	'http://s28.postimg.org/f4pdznib1/mg2.png'),
('master_guardian_elite',	'http://s17.postimg.org/gpr5jjyzz/mge.png'),
('distinguished_master_guardian',	'http://s16.postimg.org/o3betagh1/dmg.png'),
('legendary_eagle_master',	'http://s2.postimg.org/5016j734p/image.png'),
('legendary_eagle_master',	'http://s23.postimg.org/npxi9uol7/LEM.png'),
('supreme_master_first_class',	'http://s9.postimg.org/eu769ua6n/SMFC.png'),
('the_global_elite',	'http://s22.postimg.org/4eiardx8x/image.png'),
('unknown',	'http://s15.postimg.org/4oh6jkezv/unknown.png');

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `steam_id` bigint(20) NOT NULL,
  `name` enum('entry_fragger','play_maker','strat_caller','support','awper','lurker') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `tool_tip`;
CREATE TABLE `tool_tip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `tool_tip` (`id`, `text`) VALUES
(1,	'As a lobby leader you are responsible for the team. It\'s your job to communicate with the other players and start a game.'),
(2,	'If you have any questions regarding the functionality on the website, feel fre to visit our FAQ.'),
(3,	'Tool tip för dig och här ska det stå något som jag inte pallar skriva. Kan vara bra att fylla på senare, tjohej.');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `steam_id` bigint(20) unsigned NOT NULL,
  `rank` enum('silver_1','silver_2','silver_3','silver_4','silver_elite','silver_elite_master','gold_nova_1','gold_nova_2','gold_nova_3','gold_nova_master','master_guardian_1','master_guardian_2','master_guardian_elite','distinguished_master_guardian','legendary_eagle','legendary_eagle_master','supreme_master_first_class','the_global_elite','unknown') COLLATE utf8_bin NOT NULL DEFAULT 'unknown',
  `nickname` varchar(50) COLLATE utf8_bin NOT NULL,
  `hours_played` int(10) unsigned NOT NULL,
  `register_date` datetime NOT NULL,
  `age` int(10) unsigned DEFAULT NULL,
  `country` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `primary_language` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `secondary_language` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `kills` int(10) unsigned NOT NULL,
  `deaths` int(10) unsigned NOT NULL,
  `bio` text COLLATE utf8_bin,
  `image_l` varchar(2083) COLLATE utf8_bin NOT NULL,
  `image_m` varchar(2083) COLLATE utf8_bin NOT NULL,
  `image_s` varchar(2083) COLLATE utf8_bin NOT NULL,
  `is_private_acc` varchar(5) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `user` (`steam_id`, `rank`, `nickname`, `hours_played`, `register_date`, `age`, `country`, `primary_language`, `secondary_language`, `kills`, `deaths`, `bio`, `image_l`, `image_m`, `image_s`, `is_private_acc`) VALUES
(76561198119133793,	'the_global_elite',	'Carl',	653,	'0000-00-00 00:00:00',	26,	'Sweden',	NULL,	NULL,	53357,	45397,	'               I AM VEry GUD PLÃ„YER PLS INVITE ME TO TIIM!! Var i Sola en gÃ¥ng 97.... har fortfarande inte fÃ¥tt bort bajslukten  ',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/9a/9a908c6e1cec700e02115c8eea7e807a7b96b989_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/9a/9a908c6e1cec700e02115c8eea7e807a7b96b989_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/9a/9a908c6e1cec700e02115c8eea7e807a7b96b989.jpg',	''),
(76561197961825525,	'the_global_elite',	'fxnKingsToe',	442,	'0000-00-00 00:00:00',	1987,	'Sweden',	NULL,	NULL,	26541,	23654,	'Hej jag heter Tobias och jag e GLOBALELELELELELELLEE   ',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fc/fc3f3b886b538125f7ac36cfc726866a1bae9e8c_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fc/fc3f3b886b538125f7ac36cfc726866a1bae9e8c_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fc/fc3f3b886b538125f7ac36cfc726866a1bae9e8c.jpg',	''),
(76561197960964569,	'silver_2',	'5UP3R51CK50UR54U549354UC3',	0,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	0,	0,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/b1/b13194949f47fd062e145708c7126dfb42c4b853_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/b1/b13194949f47fd062e145708c7126dfb42c4b853_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/b1/b13194949f47fd062e145708c7126dfb42c4b853.jpg',	'1'),
(76561198010808320,	'silver_2',	'tussilago',	408,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	19305,	18890,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f3/f36cf0db720deb546c6fc21c930fbf191df7564b_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f3/f36cf0db720deb546c6fc21c930fbf191df7564b_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f3/f36cf0db720deb546c6fc21c930fbf191df7564b.jpg',	'0'),
(76561197981707560,	'silver_2',	'jens',	1194,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	78450,	64415,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/2b/2b6f5b94e843bfb801802303641b99c10dcb7d03_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/2b/2b6f5b94e843bfb801802303641b99c10dcb7d03_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/2b/2b6f5b94e843bfb801802303641b99c10dcb7d03.jpg',	'0'),
(76561198166994467,	'silver_2',	'Aerte',	100,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	6673,	6191,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fe/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fe/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fe/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb.jpg',	'0'),
(76561197963624696,	'silver_1',	'A.OK',	319,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	16190,	13666,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/60/606a1bf667463a9195527d9f00ccc7d26d89c78a_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/60/606a1bf667463a9195527d9f00ccc7d26d89c78a_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/60/606a1bf667463a9195527d9f00ccc7d26d89c78a.jpg',	'0'),
(76561198147424033,	'gold_nova_3',	'chrisS [ãƒ„]',	618,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	33084,	28837,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/1f/1f126990eb2325883f721f81095173c279487d2a_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/1f/1f126990eb2325883f721f81095173c279487d2a_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/1f/1f126990eb2325883f721f81095173c279487d2a.jpg',	'0'),
(76561198217983724,	'silver_3',	'twinny van',	101,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	6201,	3959,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/a9/a9c7e39b48716c7098b7863357ce22c8d3ac41fe_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/a9/a9c7e39b48716c7098b7863357ce22c8d3ac41fe_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/a9/a9c7e39b48716c7098b7863357ce22c8d3ac41fe.jpg',	'0'),
(76561198071773272,	'master_guardian_1',	'Rickisen',	444,	'0000-00-00 00:00:00',	0,	NULL,	NULL,	NULL,	30156,	31639,	' ',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/71/715bb5a408ffae162e889d059a23fdb5f7f273a3_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/71/715bb5a408ffae162e889d059a23fdb5f7f273a3_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/71/715bb5a408ffae162e889d059a23fdb5f7f273a3.jpg',	'0'),
(76561198193558745,	'silver_4',	'(#2016) Zakeskz=DDD',	612,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	33536,	32046,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/5f/5fcf129fdcd317e1177f498943958db2b319e008_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/5f/5fcf129fdcd317e1177f498943958db2b319e008_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/5f/5fcf129fdcd317e1177f498943958db2b319e008.jpg',	'0'),
(76561198177806779,	'silver_4',	'VAC BANNED =  FUCKING GABE',	196,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	10196,	8036,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/5c/5cb5c2eafb8a4d0dd054ac98b4a0829e4dd2da00_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/5c/5cb5c2eafb8a4d0dd054ac98b4a0829e4dd2da00_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/5c/5cb5c2eafb8a4d0dd054ac98b4a0829e4dd2da00.jpg',	''),
(76561198185709861,	'silver_4',	'PussyCat',	191,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	14158,	13867,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/ec/ecad0be9a3063ab287ac48705d26bffa7d9f84a9_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/ec/ecad0be9a3063ab287ac48705d26bffa7d9f84a9_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/ec/ecad0be9a3063ab287ac48705d26bffa7d9f84a9.jpg',	'0'),
(76561198127537132,	'silver_4',	'Mr Dromedar [Second acc]',	297,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	25283,	17239,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/da/da67babb992e29473cf536bd9056ed43af899706_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/da/da67babb992e29473cf536bd9056ed43af899706_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/da/da67babb992e29473cf536bd9056ed43af899706.jpg',	'0'),
(76561198170008233,	'silver_4',	'Keepo',	502,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	19146,	30921,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/25/255b1d8eb9b04a4c903e304b472f102f2d612a46_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/25/255b1d8eb9b04a4c903e304b472f102f2d612a46_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/25/255b1d8eb9b04a4c903e304b472f102f2d612a46.jpg',	'0'),
(76561198079853120,	'silver_4',	'kamehameha',	305,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	13074,	13091,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/62/62bab63628095cc4160456747eefcd32a3dea8e8_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/62/62bab63628095cc4160456747eefcd32a3dea8e8_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/62/62bab63628095cc4160456747eefcd32a3dea8e8.jpg',	'0'),
(76561198023969636,	'master_guardian_2',	'Kaffia',	0,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	0,	0,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/bf/bf7b7029015fb98b52dc7de20e7f0b01a688c452_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/bf/bf7b7029015fb98b52dc7de20e7f0b01a688c452_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/bf/bf7b7029015fb98b52dc7de20e7f0b01a688c452.jpg',	'1'),
(76561198165835665,	'master_guardian_2',	'F0x | A/O',	151,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	6773,	6569,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/a1/a18209908519ec990e226600510164dbbda23949_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/a1/a18209908519ec990e226600510164dbbda23949_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/a1/a18209908519ec990e226600510164dbbda23949.jpg',	'0'),
(76561198121413467,	'master_guardian_2',	'DropTheBacon',	192,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	9733,	9571,	'',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/bb/bb5a97f8bfbc4cdd46225417853313d060d79906_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/bb/bb5a97f8bfbc4cdd46225417853313d060d79906_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/bb/bb5a97f8bfbc4cdd46225417853313d060d79906.jpg',	'0'),
(76561197964408980,	'master_guardian_2',	'Dr. Van Nostrand',	92,	'0000-00-00 00:00:00',	0,	NULL,	NULL,	NULL,	6178,	7149,	' ',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/b4/b43e2b3d174246b37a6719db2769a8805d31a5c8_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/b4/b43e2b3d174246b37a6719db2769a8805d31a5c8_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/b4/b43e2b3d174246b37a6719db2769a8805d31a5c8.jpg',	'0'),
(76561198004464720,	'the_global_elite',	'St0rkf4n',	102,	'0000-00-00 00:00:00',	2001,	'Germany',	NULL,	NULL,	5742,	5181,	'    Ich bin ein berliner!   ',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/4c/4c9cb369b91aa48bbdd3de8c6c8fe79ef6b02ee2_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/4c/4c9cb369b91aa48bbdd3de8c6c8fe79ef6b02ee2_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/4c/4c9cb369b91aa48bbdd3de8c6c8fe79ef6b02ee2.jpg',	'0'),
(76561197961109569,	'master_guardian_2',	'eyyyyyyyyyyyyyyy',	1028,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	66468,	44801,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/ca/cae1c866654aab2a3b87a3c143c29bf7e311219d_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/ca/cae1c866654aab2a3b87a3c143c29bf7e311219d_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/ca/cae1c866654aab2a3b87a3c143c29bf7e311219d.jpg',	''),
(76561197997562376,	'master_guardian_2',	'Ferre â™›',	761,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	49436,	57276,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/37/370072fb4556a95b2ab77b26db91d8338350e12d_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/37/370072fb4556a95b2ab77b26db91d8338350e12d_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/37/370072fb4556a95b2ab77b26db91d8338350e12d.jpg',	''),
(76561197967790391,	'distinguished_master_guardian',	'OatÂ§',	511,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	24425,	20792,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/07/07d36e028de90ae66576e1cc9231a2ace48021ee_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/07/07d36e028de90ae66576e1cc9231a2ace48021ee_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/07/07d36e028de90ae66576e1cc9231a2ace48021ee.jpg',	''),
(76561197960325993,	'distinguished_master_guardian',	'tufflax',	147,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	11870,	9729,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/ab/ab9054eebac4fc6f54dfd174af01facc747fbf9c_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/ab/ab9054eebac4fc6f54dfd174af01facc747fbf9c_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/ab/ab9054eebac4fc6f54dfd174af01facc747fbf9c.jpg',	''),
(76561197979337863,	'distinguished_master_guardian',	'â˜­ i are russian snip3r',	174,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	11147,	7402,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/01/017b3a586bde3ec40b2476624b5b33356443c6ab_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/01/017b3a586bde3ec40b2476624b5b33356443c6ab_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/01/017b3a586bde3ec40b2476624b5b33356443c6ab.jpg',	''),
(76561197967090145,	'distinguished_master_guardian',	'Captain Flint',	46,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	3241,	2437,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/63/63f994beede34baaa4aa7927e5122dfbb9722fc0_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/63/63f994beede34baaa4aa7927e5122dfbb9722fc0_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/63/63f994beede34baaa4aa7927e5122dfbb9722fc0.jpg',	''),
(76561198090730839,	'distinguished_master_guardian',	'I Suck At CSGO',	224,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	12474,	8511,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/af/af51e2720cb709a1abfdb30f59fb25426c3e6741_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/af/af51e2720cb709a1abfdb30f59fb25426c3e6741_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/af/af51e2720cb709a1abfdb30f59fb25426c3e6741.jpg',	''),
(76561197961395244,	'distinguished_master_guardian',	'Tarvold',	456,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	24065,	20032,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/60/60bd144dccb6abddd6d59e9365d37ce3869878ae_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/60/60bd144dccb6abddd6d59e9365d37ce3869878ae_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/60/60bd144dccb6abddd6d59e9365d37ce3869878ae.jpg',	''),
(76561197961049556,	'legendary_eagle_master',	'The Raptor Knight <3 CathyMay15',	84,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	5270,	4917,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/09/093fdfab88ca263b026e6d7b54a60cf67461c1b1_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/09/093fdfab88ca263b026e6d7b54a60cf67461c1b1_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/09/093fdfab88ca263b026e6d7b54a60cf67461c1b1.jpg',	''),
(76561198154156138,	'legendary_eagle_master',	'âœª Benedikt XVI',	41,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	2361,	1586,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/9c/9cd4f0a076971e76235db63868acf64c53c3dede_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/9c/9cd4f0a076971e76235db63868acf64c53c3dede_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/9c/9cd4f0a076971e76235db63868acf64c53c3dede.jpg',	''),
(76561198039027545,	'legendary_eagle_master',	'frillpan',	450,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	22065,	22868,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/56/563201be65a0edf150cd70b6341d1bc2819adb54_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/56/563201be65a0edf150cd70b6341d1bc2819adb54_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/56/563201be65a0edf150cd70b6341d1bc2819adb54.jpg',	''),
(76561198017223611,	'legendary_eagle_master',	'gargamel1133',	28,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	2624,	3471,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/ec/eca67b9aa8f001bf7fd7fc99c32f92d45fabd0b3_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/ec/eca67b9aa8f001bf7fd7fc99c32f92d45fabd0b3_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/ec/eca67b9aa8f001bf7fd7fc99c32f92d45fabd0b3.jpg',	''),
(76561197960670668,	'legendary_eagle_master',	'lajndd',	49,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	3019,	3013,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fb/fbb15bf27bbfc9eca3fafef94543c8ffef39a57d_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fb/fbb15bf27bbfc9eca3fafef94543c8ffef39a57d_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fb/fbb15bf27bbfc9eca3fafef94543c8ffef39a57d.jpg',	''),
(76561197960423662,	'legendary_eagle_master',	'mUFFJAEVEL',	71,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	3941,	3417,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/bd/bd3766f1b2432842ce95b2f4b6749f3118aff9cd_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/bd/bd3766f1b2432842ce95b2f4b6749f3118aff9cd_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/bd/bd3766f1b2432842ce95b2f4b6749f3118aff9cd.jpg',	''),
(76561197960329953,	'unknown',	'RaaTtheMD',	547,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	37664,	29416,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/91/9128e36bc9c35ed013376c94dd04d91a637946a6_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/91/9128e36bc9c35ed013376c94dd04d91a637946a6_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/91/9128e36bc9c35ed013376c94dd04d91a637946a6.jpg',	''),
(76561197992700833,	'unknown',	'Richie',	670,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	41708,	33708,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/39/39d763d6d13a8cb64f2e5863fb83cddbb828164e_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/39/39d763d6d13a8cb64f2e5863fb83cddbb828164e_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/39/39d763d6d13a8cb64f2e5863fb83cddbb828164e.jpg',	''),
(76561198004727120,	'unknown',	'RouniN',	0,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	0,	0,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/0a/0a12e464f05eec2368275f97a83ac633b49ebf04_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/0a/0a12e464f05eec2368275f97a83ac633b49ebf04_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/0a/0a12e464f05eec2368275f97a83ac633b49ebf04.jpg',	'1'),
(76561197978857993,	'unknown',	'Tom Selleck',	385,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	22692,	16435,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/30/307f51003bb5aef92c574fc70b56d0f93e038931_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/30/307f51003bb5aef92c574fc70b56d0f93e038931_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/30/307f51003bb5aef92c574fc70b56d0f93e038931.jpg',	''),
(76561198083924003,	'unknown',	'wuppe â™›',	928,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	78423,	46942,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/03/033a034a7a1f9656d4addbae0326c9fcd70e0d24_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/03/033a034a7a1f9656d4addbae0326c9fcd70e0d24_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/03/033a034a7a1f9656d4addbae0326c9fcd70e0d24.jpg',	''),
(76561197960815531,	'unknown',	'BeatForge',	1209,	'0000-00-00 00:00:00',	NULL,	NULL,	NULL,	NULL,	43766,	54699,	NULL,	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/30/3023e43df6a37e11e2792ef1e5456000bffc3394_full.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/30/3023e43df6a37e11e2792ef1e5456000bffc3394_medium.jpg',	'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/30/3023e43df6a37e11e2792ef1e5456000bffc3394.jpg',	'');

-- 2016-01-07 13:19:28
