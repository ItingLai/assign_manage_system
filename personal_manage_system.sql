-- --------------------------------------------------------
-- 主機:                           127.0.0.1
-- 伺服器版本:                        5.7.33 - MySQL Community Server (GPL)
-- 伺服器作業系統:                      Win64
-- HeidiSQL 版本:                  11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- 傾印 personal_manage_system 的資料庫結構
CREATE DATABASE
IF NOT EXISTS `personal_manage_system` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */;
USE `personal_manage_system`;

-- 傾印  資料表 personal_manage_system.announcement 結構
CREATE TABLE
IF NOT EXISTS `announcement`
(
  `title` text COLLATE utf8mb4_bin NOT NULL,
  `start` date NOT NULL,
  `
end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- 取消選取資料匯出。

-- 傾印  檢視 personal_manage_system.attend_data 結構
-- 建立臨時表格，以解決檢視依存性錯誤
CREATE TABLE `attend_data`
(
	`name` VARCHAR
(50) NOT NULL COLLATE 'utf8mb4_bin',
	`user_type` VARCHAR
(20) NOT NULL COLLATE 'utf8mb4_bin',
	`create_dt` DATETIME NULL,
	`date` DATE NOT NULL,
	`type` VARCHAR
(10) NOT NULL COLLATE 'utf8mb4_bin'
) ENGINE=MyISAM;

-- 傾印  資料表 personal_manage_system.calendar 結構
CREATE TABLE
IF NOT EXISTS `calendar`
(
  `date` date NOT NULL,
  `type` varchar
(10) COLLATE utf8mb4_bin NOT NULL,
  `remark` varchar
(50) COLLATE utf8mb4_bin NOT NULL,
  UNIQUE KEY `date`
(`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- 取消選取資料匯出。

-- 傾印  資料表 personal_manage_system.user 結構
CREATE TABLE
IF NOT EXISTS `user` (
  `id` int
(11) NOT NULL AUTO_INCREMENT,
  `type` varchar
(20) COLLATE utf8mb4_bin NOT NULL,
  `username` varchar
(50) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar
(100) COLLATE utf8mb4_bin NOT NULL,
  `name` varchar
(50) COLLATE utf8mb4_bin NOT NULL,
  `telephone` varchar
(50) COLLATE utf8mb4_bin NOT NULL,
  `address` text COLLATE utf8mb4_bin NOT NULL,
  `basic_salary` int
(11) NOT NULL DEFAULT '0',
  `create_dt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY
(`id`),
  UNIQUE KEY `unique`
(`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `user`
VALUES
  ('boss', 'bossuser', '$2y$10$qNzWbzRLvli.4vpOr8Wh4OSWPOUF/yPXoI1uy2jOylTghWw2m9/6m', 'boss', '0900000000', 'address', 26400);

-- 傾印  資料表 personal_manage_system.copy_leave 結構
CREATE TABLE
IF NOT EXISTS `copy_leave`
(
  `id` int
(11) NOT NULL,
  `user_id` int
(11) NOT NULL,
  `date` date NOT NULL,
  `start` date NOT NULL,
  `
end` date NOT NULL,
  `name` varchar
(50) COLLATE utf8mb4_bin NOT NULL,
  `type` varchar
(20) COLLATE utf8mb4_bin NOT NULL,
  `reason` text COLLATE utf8mb4_bin NOT NULL,
  `not_agree_reason` text COLLATE utf8mb4_bin,
  `status` int
(11) DEFAULT NULL,
  `add_type` varchar
(10) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY
(`id`),
  KEY `FK_copy_leave_user`
(`user_id`),
  CONSTRAINT `FK_copy_leave_user` FOREIGN KEY
(`user_id`) REFERENCES `user`
(`id`) ON
DELETE NO ACTION ON
UPDATE NO ACTION
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- 取消選取資料匯出。

-- 傾印  資料表 personal_manage_system.leave 結構
CREATE TABLE
IF NOT EXISTS `leave`
(
  `id` int
(11) NOT NULL AUTO_INCREMENT,
  `user_id` int
(11) NOT NULL,
  `date` date NOT NULL,
  `start` date NOT NULL,
  `
end` date NOT NULL,
  `name` varchar
(50) COLLATE utf8mb4_bin NOT NULL,
  `type` varchar
(20) COLLATE utf8mb4_bin NOT NULL,
  `reason` text COLLATE utf8mb4_bin NOT NULL,
  `not_agree_reason` text COLLATE utf8mb4_bin,
  `status` int
(11) DEFAULT NULL,
  `add_type` varchar
(10) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY
(`id`),
  KEY `FK__user`
(`user_id`),
  CONSTRAINT `FK__user` FOREIGN KEY
(`user_id`) REFERENCES `user`
(`id`) ON
DELETE CASCADE ON
UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET
=utf8mb4 COLLATE=utf8mb4_bin;

-- 取消選取資料匯出。

-- 傾印  資料表 personal_manage_system.salaryinfo 結構
CREATE TABLE
IF NOT EXISTS `salaryinfo`
(
  `month` date NOT NULL,
  `user_id` int
(11) NOT NULL,
  `name` varchar
(50) COLLATE utf8mb4_bin NOT NULL,
  `attend` int
(11) NOT NULL DEFAULT '0',
  `personal` int
(11) NOT NULL DEFAULT '0',
  `official` int
(11) NOT NULL DEFAULT '0',
  `sick` int
(11) NOT NULL DEFAULT '0',
  `absent` int
(11) NOT NULL DEFAULT '0',
  `not_entry` int
(11) NOT NULL DEFAULT '0',
  `basic` int
(11) NOT NULL DEFAULT '0',
  `perfect_attend_bonus` int
(11) NOT NULL DEFAULT '0',
  `sick_personal_deduction` int
(11) NOT NULL DEFAULT '0',
  `not_entry_deduction` int
(11) NOT NULL DEFAULT '0',
  `dock` int
(11) NOT NULL DEFAULT '0',
  `labor_health` int
(11) NOT NULL DEFAULT '0',
  `total` int
(11) NOT NULL DEFAULT '0',
  `is_check` bigint
(20) DEFAULT '0',
  KEY `FK_salaryinfo_user`
(`user_id`),
  CONSTRAINT `FK_salaryinfo_user` FOREIGN KEY
(`user_id`) REFERENCES `user`
(`id`) ON
DELETE CASCADE ON
UPDATE CASCADE
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- 取消選取資料匯出。



-- 取消選取資料匯出。

-- 傾印  觸發器 personal_manage_system.leave_before_delete 結構
SET @OLDTMP_SQL_MODE=@@SQL_MODE
, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `leave_before_delete` BEFORE
DELETE ON `leave` FOR EACH
ROW
BEGIN
  INSERT INTO `copy_leave` (`
  id`,`user_id
  `,`date`,`start`,`
end
`,`name`,`type`,`reason`,`not_agree_reason`,`status`) VALUES
(OLD.id,OLD.user_id,OLD.`date`,OLD.`start`,OLD.`
end`,OLD.`name`,OLD.`type`,OLD.`reason`,OLD.`not_agree_reason`,OLD.`status`);
END//
DELIMITER ;
SET SQL_MODE
=@OLDTMP_SQL_MODE;

-- 傾印  檢視 personal_manage_system.attend_data 結構
-- 移除臨時表格，並建立最終檢視結構
DROP TABLE IF EXISTS `attend_data`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `attend_data` AS
SELECT user.name,user.`type` AS user_type,user.create_dt,calendar.`date`,calendar.`type`
FROM user INNER JOIN `calendar ` ON 1=1
  LEFT JOIN `leave ` ON `leave`.user_id=user.id AND `calendar`.`date`>=`leave`.start AND `calendar`.`date`<=`leave`.
end
WHERE user.`type`!='boss' AND `calendar`.`type`!="dayOff" AND `leave`.id IS NULL ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
