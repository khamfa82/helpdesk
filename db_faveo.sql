-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 27, 2022 at 01:14 PM
-- Server version: 10.3.34-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 7.3.33-1+ubuntu20.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_faveo`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetClosedTicketsPerDept` (IN `dept_name` VARCHAR(50) CHARSET utf8)  NO SQL
BEGIN

            SET @deptID := (SELECT id from department
            where name LIKE dept_name COLLATE utf8_unicode_ci);

            SELECT * FROM  tickets_detailed ttd
            WHERE ttd.closed = 1 AND ttd.statusID <> 2
            AND ttd.is_deleted = 0 AND ttd.dept_id = @deptID;
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetDeletedTickets` (IN `departmentID` INT)  NO SQL
BEGIN
        	SELECT * FROM  tickets_detailed ttd
        	WHERE ttd.statusID = 5 AND ttd.is_deleted = 1 AND
                (
                  CASE
                    WHEN departmentID != '' THEN ttd.dept_id = departmentID ELSE TRUE END
                );
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetDeletedTicketsPerDept` (IN `dept_name` VARCHAR(50) CHARSET utf8)  NO SQL
BEGIN

            SET @deptID := (SELECT id from department
            where name LIKE dept_name COLLATE utf8_unicode_ci);

            SELECT * FROM  tickets_detailed ttd
          	WHERE ttd.statusID = 5 AND ttd.is_deleted = 1
            AND ttd.dept_id = @deptID;
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetDueTodayTickets` (IN `departmentID` INT)  NO SQL
BEGIN
        	SELECT * FROM  tickets_detailed ttd
        	WHERE
        		ttd.statusID = 1 AND ttd.isanswered = 0 AND ttd.is_deleted = 0 AND
                DATEDIFF(ttd.duedate, NOW()) = 0  AND (
                  CASE
                    WHEN departmentID != '' THEN ttd.dept_id = departmentID ELSE TRUE END
                );
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetInboxTickets` (IN `departmentID` INT, IN `assignedTo` INT)  NO SQL
BEGIN
        	SELECT * FROM  tickets_detailed ttd
        	WHERE ttd.is_deleted = 0 AND (
                  CASE
                    WHEN departmentID != '' THEN ttd.dept_id = departmentID ELSE TRUE END
                    OR
                  CASE
                    WHEN assignedTo != '' THEN ttd.assignedTo = assignedTo ELSE TRUE END
                );
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetMyTickets` (IN `assignedTo` INT)  NO SQL
BEGIN
        	SELECT * FROM  tickets_detailed ttd
        	WHERE ttd.statusID = 1 AND ttd.is_deleted = 0 AND ttd.closed <> 1 AND
                (
                  CASE
                    WHEN assignedTo != '' THEN ttd.assignedTo = assignedTo ELSE TRUE END
                );
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetOpenTicketsPerDept` (IN `dept_name` VARCHAR(50) CHARSET utf8)  NO SQL
BEGIN

            SET @deptID := (SELECT id from department
            where name LIKE dept_name COLLATE utf8_unicode_ci);

            SELECT * FROM  tickets_detailed ttd
        	WHERE ttd.closed <> 1 AND ttd.is_deleted = 0
            AND ttd.dept_id = @deptID;
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetOverdueTickets` (IN `departmentID` INT)  NO SQL
BEGIN
        	SELECT * FROM  tickets_detailed ttd
        	WHERE
        		ttd.statusID = 1 AND ttd.isanswered = 0 AND ttd.duedate < NOW() AND ttd.is_deleted = 0 AND (
                  CASE
                    WHEN departmentID != '' THEN ttd.dept_id = departmentID ELSE TRUE END);
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetResolvedTicketsPerDept` (IN `dept_name` VARCHAR(50) CHARSET utf8)  NO SQL
BEGIN

            SET @deptID := (SELECT id from department
            where name LIKE dept_name COLLATE utf8_unicode_ci);

            SELECT * FROM  tickets_detailed ttd
        	WHERE ttd.closed = 1 AND ttd.statusID = 2
            AND ttd.is_deleted = 0 AND ttd.dept_id = @deptID;
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetTickets` (IN `departmentID` INT, IN `assignedTo` INT)  NO SQL
BEGIN
        	SELECT * FROM  tickets_detailed ttd
        	WHERE
        		ttd.is_deleted = 0 AND (
                  CASE
                    WHEN departmentID != '' THEN ttd.dept_id = departmentID ELSE TRUE END
                    OR
                  CASE
                    WHEN assignedTo != '' THEN ttd.assignedTo = assignedTo ELSE TRUE END
                );
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetUnassignedTickets` (IN `departmentID` INT)  NO SQL
BEGIN
        	SELECT * FROM  tickets_detailed ttd
        	WHERE ttd.statusID = 1 AND (ttd.assignedTo IS NULL) AND ttd.is_deleted = 0 AND
                (
                  CASE
                    WHEN departmentID != '' THEN ttd.dept_id = departmentID ELSE TRUE END
                );
        END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `answered_tickets`
-- (See below for the actual view)
--
CREATE TABLE `answered_tickets` (
`id` int(10) unsigned
,`ticket_number` varchar(255)
,`duedate` datetime
,`dept_id` int(10) unsigned
,`assignedTo` int(10) unsigned
,`statusID` int(10) unsigned
,`isanswered` int(11)
,`isoverdue` int(11)
,`is_deleted` int(11)
,`is_transferred` tinyint(1)
,`follow_up` int(11)
,`closed` int(11)
,`reopened` int(11)
,`ticket_subject` varchar(255)
,`thread_id` int(10) unsigned
,`owner` text
,`assigned_to` text
,`status` varchar(255)
,`last_activity` timestamp
,`priority_color` varchar(255)
,`priority` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `api_settings`
--

CREATE TABLE `api_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `assigned_tickets`
-- (See below for the actual view)
--
CREATE TABLE `assigned_tickets` (
`id` int(10) unsigned
,`ticket_number` varchar(255)
,`duedate` datetime
,`dept_id` int(10) unsigned
,`assignedTo` int(10) unsigned
,`statusID` int(10) unsigned
,`isanswered` int(11)
,`isoverdue` int(11)
,`is_deleted` int(11)
,`is_transferred` tinyint(1)
,`follow_up` int(11)
,`closed` int(11)
,`reopened` int(11)
,`ticket_subject` varchar(255)
,`thread_id` int(10) unsigned
,`owner` text
,`assigned_to` text
,`status` varchar(255)
,`last_activity` timestamp
,`priority_color` varchar(255)
,`priority` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `banlist`
--

CREATE TABLE `banlist` (
  `id` int(10) UNSIGNED NOT NULL,
  `ban_status` tinyint(1) NOT NULL,
  `email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internal_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bar_notifications`
--

CREATE TABLE `bar_notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bar_notifications`
--

INSERT INTO `bar_notifications` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(14, 'new-version', '', '2022-04-27 07:54:07', '2022-04-27 07:54:07');

-- --------------------------------------------------------

--
-- Table structure for table `canned_response`
--

CREATE TABLE `canned_response` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `closed_tickets`
-- (See below for the actual view)
--
CREATE TABLE `closed_tickets` (
`id` int(10) unsigned
,`ticket_number` varchar(255)
,`duedate` datetime
,`dept_id` int(10) unsigned
,`assignedTo` int(10) unsigned
,`statusID` int(10) unsigned
,`isanswered` int(11)
,`isoverdue` int(11)
,`is_deleted` int(11)
,`is_transferred` tinyint(1)
,`follow_up` int(11)
,`closed` int(11)
,`reopened` int(11)
,`ticket_subject` varchar(255)
,`thread_id` int(10) unsigned
,`owner` text
,`assigned_to` text
,`status` varchar(255)
,`last_activity` timestamp
,`priority_color` varchar(255)
,`priority` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `closed_tickets_per_department`
-- (See below for the actual view)
--
CREATE TABLE `closed_tickets_per_department` (
`id` int(10) unsigned
,`ticket_number` varchar(255)
,`duedate` datetime
,`dept_id` int(10) unsigned
,`assignedTo` int(10) unsigned
,`statusID` int(10) unsigned
,`isanswered` int(11)
,`isoverdue` int(11)
,`is_deleted` int(11)
,`is_transferred` tinyint(1)
,`follow_up` int(11)
,`closed` int(11)
,`reopened` int(11)
,`ticket_subject` varchar(255)
,`thread_id` int(10) unsigned
,`owner` text
,`assigned_to` text
,`status` varchar(255)
,`last_activity` timestamp
,`priority_color` varchar(255)
,`priority` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `common_settings`
--

CREATE TABLE `common_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `option_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `option_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `optional_field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `common_settings`
--

INSERT INTO `common_settings` (`id`, `option_name`, `option_value`, `status`, `optional_field`, `created_at`, `updated_at`) VALUES
(1, 'itil', '', '0', '', NULL, NULL),
(2, 'ticket_token_time_duration', '1', '', '', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(3, 'enable_rtl', '', '', '', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(4, 'user_set_ticket_status', '', '1', '', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(5, 'send_otp', '', '0', '', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(6, 'email_mandatory', '', '1', '', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(7, 'user_priority', '', '0', '', '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `conditions`
--

CREATE TABLE `conditions` (
  `id` int(10) UNSIGNED NOT NULL,
  `job` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country_code`
--

CREATE TABLE `country_code` (
  `id` int(10) UNSIGNED NOT NULL,
  `iso` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nicename` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `iso3` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `numcode` smallint(6) NOT NULL,
  `phonecode` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `country_code`
--

INSERT INTO `country_code` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`, `created_at`, `updated_at`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', 'NUL', 0, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', 'NUL', 0, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', 'NUL', 0, 246, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', 'NUL', 0, 61, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', 'NUL', 0, 672, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(53, 'CI', 'COTE DIVOIRE', 'Cote DIvoire', 'CIV', 384, 225, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', 'NUL', 0, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', 'NUL', 0, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLES REPUBLIC OF', 'Korea, Democratic Peoples Republic of', 'PRK', 408, 850, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(116, 'LA', 'LAO PEOPLES DEMOCRATIC REPUBLIC', 'Lao Peoples Democratic Republic', 'LAO', 418, 856, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(137, 'YT', 'MAYOTTE', 'Mayotte', 'NUL', 0, 269, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', 'NUL', 0, 970, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', 'NUL', 0, 381, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', 'NUL', 0, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', 'NUL', 0, 670, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', 'NUL', 0, 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263, '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `custom_forms`
--

CREATE TABLE `custom_forms` (
  `id` int(10) UNSIGNED NOT NULL,
  `formname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_form_fields`
--

CREATE TABLE `custom_form_fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `forms_id` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `required` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `date_format`
--

CREATE TABLE `date_format` (
  `id` int(10) UNSIGNED NOT NULL,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `date_format`
--

INSERT INTO `date_format` (`id`, `format`) VALUES
(1, 'dd/mm/yyyy'),
(2, 'dd-mm-yyyy'),
(3, 'dd.mm.yyyy'),
(4, 'mm/dd/yyyy'),
(5, 'mm:dd:yyyy'),
(6, 'mm-dd-yyyy'),
(7, 'yyyy/mm/dd'),
(8, 'yyyy.mm.dd'),
(9, 'yyyy-mm-dd');

-- --------------------------------------------------------

--
-- Table structure for table `date_time_format`
--

CREATE TABLE `date_time_format` (
  `id` int(10) UNSIGNED NOT NULL,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `date_time_format`
--

INSERT INTO `date_time_format` (`id`, `format`) VALUES
(1, 'd/m/Y H:i:s'),
(2, 'd.m.Y H:i:s'),
(3, 'd-m-Y H:i:s'),
(4, 'm/d/Y H:i:s'),
(5, 'm.d.Y H:i:s'),
(6, 'm-d-Y H:i:s'),
(7, 'Y/m/d H:i:s'),
(8, 'Y.m.d H:i:s'),
(9, 'Y-m-d H:i:s'),
(10, 'd/m/Y H:i:s'),
(11, 'd.m.Y H:i:s'),
(12, 'd-m-Y H:i:s'),
(13, 'm/d/Y H:i:s'),
(14, 'm.d.Y H:i:s'),
(15, 'm-d-Y H:i:s'),
(16, 'Y/m/d H:i:s'),
(17, 'Y.m.d H:i:s'),
(18, 'Y-m-d H:i:s'),
(19, 'd/m/Y H:i:s'),
(20, 'd.m.Y H:i:s'),
(21, 'd-m-Y H:i:s'),
(22, 'm/d/Y H:i:s'),
(23, 'm.d.Y H:i:s'),
(24, 'm-d-Y H:i:s'),
(25, 'Y/m/d H:i:s'),
(26, 'Y.m.d H:i:s'),
(27, 'Y-m-d H:i:s'),
(28, 'd/m/Y H:i:s'),
(29, 'd.m.Y H:i:s'),
(30, 'd-m-Y H:i:s'),
(31, 'm/d/Y H:i:s'),
(32, 'm.d.Y H:i:s'),
(33, 'm-d-Y H:i:s'),
(34, 'Y/m/d H:i:s'),
(35, 'Y.m.d H:i:s'),
(36, 'Y-m-d H:i:s'),
(37, 'd/m/Y H:i:s'),
(38, 'd.m.Y H:i:s'),
(39, 'd-m-Y H:i:s'),
(40, 'm/d/Y H:i:s'),
(41, 'm.d.Y H:i:s'),
(42, 'm-d-Y H:i:s'),
(43, 'Y/m/d H:i:s'),
(44, 'Y.m.d H:i:s'),
(45, 'Y-m-d H:i:s');

-- --------------------------------------------------------

--
-- Stand-in structure for view `deleted_tickets`
-- (See below for the actual view)
--
CREATE TABLE `deleted_tickets` (
`id` int(10) unsigned
,`ticket_number` varchar(255)
,`duedate` datetime
,`dept_id` int(10) unsigned
,`assignedTo` int(10) unsigned
,`statusID` int(10) unsigned
,`isanswered` int(11)
,`isoverdue` int(11)
,`is_deleted` int(11)
,`is_transferred` tinyint(1)
,`follow_up` int(11)
,`closed` int(11)
,`reopened` int(11)
,`ticket_subject` varchar(255)
,`thread_id` int(10) unsigned
,`owner` text
,`assigned_to` text
,`status` varchar(255)
,`last_activity` timestamp
,`priority_color` varchar(255)
,`priority` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sla` int(10) UNSIGNED DEFAULT NULL,
  `manager` int(10) UNSIGNED DEFAULT NULL,
  `ticket_assignment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `outgoing_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template_set` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auto_ticket_response` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auto_message_response` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auto_response_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `recipient` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_access` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `department_sign` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `type`, `sla`, `manager`, `ticket_assignment`, `outgoing_email`, `template_set`, `auto_ticket_response`, `auto_message_response`, `auto_response_email`, `recipient`, `group_access`, `department_sign`, `created_at`, `updated_at`) VALUES
(1, 'Support', '1', 1, NULL, '', '', '', '', '', '', '', '', '', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(2, 'Sales', '1', 1, NULL, '', '', '', '', '', '', '', '', '', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(3, 'Operation', '1', 1, NULL, '', '', '', '', '', '', '', '', '', '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `id` int(10) UNSIGNED NOT NULL,
  `email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `department` int(10) UNSIGNED DEFAULT NULL,
  `priority` int(10) UNSIGNED DEFAULT NULL,
  `help_topic` int(10) UNSIGNED DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fetching_host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fetching_port` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fetching_protocol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fetching_encryption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mailbox_protocol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `imap_config` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `folder` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sending_host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sending_port` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sending_protocol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sending_encryption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_validate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_authentication` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internal_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auto_response` tinyint(1) NOT NULL,
  `fetching_status` tinyint(1) NOT NULL,
  `move_to_folder` tinyint(1) NOT NULL,
  `delete_email` tinyint(1) NOT NULL,
  `do_nothing` tinyint(1) NOT NULL,
  `sending_status` tinyint(1) NOT NULL,
  `authentication` tinyint(1) NOT NULL,
  `header_spoofing` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emails`
--

INSERT INTO `emails` (`id`, `email_address`, `email_name`, `department`, `priority`, `help_topic`, `user_name`, `password`, `fetching_host`, `fetching_port`, `fetching_protocol`, `fetching_encryption`, `mailbox_protocol`, `imap_config`, `folder`, `sending_host`, `sending_port`, `sending_protocol`, `sending_encryption`, `smtp_validate`, `smtp_authentication`, `internal_notes`, `auto_response`, `fetching_status`, `move_to_folder`, `delete_email`, `do_nothing`, `sending_status`, `authentication`, `header_spoofing`, `created_at`, `updated_at`) VALUES
(1, 'faveo@helpdesk.localhost', 'Helpdesk System', NULL, NULL, NULL, 'admin', 'eyJpdiI6InlISVwvSXZTS2k5ZnRxdzlId0s5UDNnPT0iLCJ2YWx1ZSI6ImJGVDNaZHpIR2RnZ0lQTTlXUlwvOGxqU3lvcG9LOWRBXC9ET3ZUNnltNllMND0iLCJtYWMiOiI5ODRkMDU2MzY2MDMxYTY4OTgwNmE2MGNlMDEyMDc0Y2M3NWE4ODI0NWQ0Yzk4NDE2ZGY4NjY3MjgxMTRjYjIzIn0=', '127.0.0.1', '1025', 'imap', '', 'novalidate-cert', '', '', '127.0.0.1', '1025', 'smtp', '', '', '', '', 0, 0, 0, 0, 0, 1, 0, 0, '2022-02-25 09:37:45', '2022-02-25 09:57:07');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faveo_mails`
--

CREATE TABLE `faveo_mails` (
  `id` int(10) UNSIGNED NOT NULL,
  `email_id` int(11) NOT NULL,
  `drive` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `faveo_mails`
--

INSERT INTO `faveo_mails` (`id`, `email_id`, `drive`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 'smtp', 'count', '1', '2022-02-25 09:57:07', '2022-02-25 09:57:07'),
(2, 1, 'smtp', 'sys_email', 'on', '2022-02-25 09:57:07', '2022-02-25 09:57:07');

-- --------------------------------------------------------

--
-- Table structure for table `faveo_queues`
--

CREATE TABLE `faveo_queues` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_id` int(11) NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `field_values`
--

CREATE TABLE `field_values` (
  `id` int(10) UNSIGNED NOT NULL,
  `field_id` int(10) UNSIGNED DEFAULT NULL,
  `child_id` int(10) UNSIGNED DEFAULT NULL,
  `field_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `field_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `follow_up_tickets`
-- (See below for the actual view)
--
CREATE TABLE `follow_up_tickets` (
`id` int(10) unsigned
,`ticket_number` varchar(255)
,`duedate` datetime
,`dept_id` int(10) unsigned
,`assignedTo` int(10) unsigned
,`statusID` int(10) unsigned
,`isanswered` int(11)
,`isoverdue` int(11)
,`is_deleted` int(11)
,`is_transferred` tinyint(1)
,`follow_up` int(11)
,`closed` int(11)
,`reopened` int(11)
,`ticket_subject` varchar(255)
,`thread_id` int(10) unsigned
,`owner` text
,`assigned_to` text
,`status` varchar(255)
,`last_activity` timestamp
,`priority_color` varchar(255)
,`priority` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_status` tinyint(1) NOT NULL,
  `can_create_ticket` tinyint(1) NOT NULL,
  `can_edit_ticket` tinyint(1) NOT NULL,
  `can_post_ticket` tinyint(1) NOT NULL,
  `can_close_ticket` tinyint(1) NOT NULL,
  `can_assign_ticket` tinyint(1) NOT NULL,
  `can_transfer_ticket` tinyint(1) NOT NULL,
  `can_delete_ticket` tinyint(1) NOT NULL,
  `can_ban_email` tinyint(1) NOT NULL,
  `can_manage_canned` tinyint(1) NOT NULL,
  `can_manage_faq` tinyint(1) NOT NULL,
  `can_view_agent_stats` tinyint(1) NOT NULL,
  `department_access` tinyint(1) NOT NULL,
  `admin_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `group_status`, `can_create_ticket`, `can_edit_ticket`, `can_post_ticket`, `can_close_ticket`, `can_assign_ticket`, `can_transfer_ticket`, `can_delete_ticket`, `can_ban_email`, `can_manage_canned`, `can_manage_faq`, `can_view_agent_stats`, `department_access`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 'Group A', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, '', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(2, 'Group B', 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, '', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(3, 'Group C', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `group_assign_department`
--

CREATE TABLE `group_assign_department` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `help_topic`
--

CREATE TABLE `help_topic` (
  `id` int(10) UNSIGNED NOT NULL,
  `topic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_topic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_form` int(10) UNSIGNED DEFAULT NULL,
  `department` int(10) UNSIGNED DEFAULT NULL,
  `ticket_status` int(10) UNSIGNED DEFAULT NULL,
  `priority` int(10) UNSIGNED DEFAULT NULL,
  `sla_plan` int(10) UNSIGNED DEFAULT NULL,
  `thank_page` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ticket_num_format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internal_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `auto_assign` int(10) UNSIGNED DEFAULT NULL,
  `auto_response` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `help_topic`
--

INSERT INTO `help_topic` (`id`, `topic`, `parent_topic`, `custom_form`, `department`, `ticket_status`, `priority`, `sla_plan`, `thank_page`, `ticket_num_format`, `internal_notes`, `status`, `type`, `auto_assign`, `auto_response`, `created_at`, `updated_at`) VALUES
(1, 'Support query', '', NULL, 1, 1, 2, 1, '', '1', '', 1, 1, NULL, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(2, 'Sales query', '', NULL, 2, 1, 2, 1, '', '1', '', 0, 1, NULL, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(3, 'Operational query', '', NULL, 3, 1, 2, 1, '', '1', '', 0, 1, NULL, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `immigration_offices`
--

CREATE TABLE `immigration_offices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TableID` bigint(20) UNSIGNED NOT NULL,
  `Office` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `OfficeType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Abbrev` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `hide` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kb_article`
--

CREATE TABLE `kb_article` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `publish_time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kb_article`
--

INSERT INTO `kb_article` (`id`, `name`, `slug`, `description`, `status`, `type`, `publish_time`, `created_at`, `updated_at`) VALUES
(1, 'Routing not occuring', 'routing-not-occuring', '<p>Restart Router</p>\r\n', 1, 1, '2022-04-08 10:20:00', '2022-04-08 09:20:45', '2022-04-08 09:20:45');

-- --------------------------------------------------------

--
-- Table structure for table `kb_article_relationship`
--

CREATE TABLE `kb_article_relationship` (
  `id` int(10) UNSIGNED NOT NULL,
  `article_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kb_article_relationship`
--

INSERT INTO `kb_article_relationship` (`id`, `article_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kb_category`
--

CREATE TABLE `kb_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `parent` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kb_category`
--

INSERT INTO `kb_category` (`id`, `name`, `slug`, `description`, `status`, `parent`, `created_at`, `updated_at`) VALUES
(1, 'Network Issues', 'network-issues', 'Networking issues', 1, 0, '2022-04-08 09:20:20', '2022-04-08 09:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `kb_comment`
--

CREATE TABLE `kb_comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `article_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kb_pages`
--

CREATE TABLE `kb_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `visibility` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kb_settings`
--

CREATE TABLE `kb_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `pagination` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kb_settings`
--

INSERT INTO `kb_settings` (`id`, `pagination`, `created_at`, `updated_at`) VALUES
(1, 10, '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `locale`) VALUES
(1, 'English', 'en'),
(2, 'Italian', 'it'),
(3, 'German', 'de'),
(4, 'French', 'fr'),
(5, 'Brazilian Portuguese', 'pt_BR'),
(6, 'Dutch', 'nl'),
(7, 'Spanish', 'es'),
(8, 'Norwegian', 'nb_NO'),
(9, 'Danish', 'da');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(10) UNSIGNED NOT NULL,
  `User` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `IP` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Attempts` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LastLogin` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `User`, `IP`, `Attempts`, `LastLogin`, `created_at`, `updated_at`) VALUES
(1, 'admin', '::1', '0', '2022-02-10 16:23:24', '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `log_notification`
--

CREATE TABLE `log_notification` (
  `id` int(10) UNSIGNED NOT NULL,
  `log` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `log_notification`
--

INSERT INTO `log_notification` (`id`, `log`, `created_at`, `updated_at`) VALUES
(1, 'NOT-1', '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `mailbox_protocol`
--

CREATE TABLE `mailbox_protocol` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mailbox_protocol`
--

INSERT INTO `mailbox_protocol` (`id`, `name`, `value`) VALUES
(1, 'IMAP', '/imap'),
(2, 'IMAP+SSL', '/imap/ssl'),
(3, 'IMAP+TLS', '/imap/tls'),
(4, 'IMAP+SSL/No-validate', '/imap/ssl/novalidate-cert');

-- --------------------------------------------------------

--
-- Table structure for table `mail_services`
--

CREATE TABLE `mail_services` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mail_services`
--

INSERT INTO `mail_services` (`id`, `name`, `short_name`, `created_at`, `updated_at`) VALUES
(1, 'SMTP', 'smtp', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(2, 'Php Mail', 'mail', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(3, 'Send Mail', 'sendmail', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(4, 'Mailgun', 'mailgun', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(5, 'Mandrill', 'mandrill', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(6, 'Log file', 'log', '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2016_02_16_140450_create_banlist_table', 1),
(2, '2016_02_16_140450_create_canned_response_table', 1),
(3, '2016_02_16_140450_create_custom_form_fields_table', 1),
(4, '2016_02_16_140450_create_custom_forms_table', 1),
(5, '2016_02_16_140450_create_date_format_table', 1),
(6, '2016_02_16_140450_create_date_time_format_table', 1),
(7, '2016_02_16_140450_create_department_table', 1),
(8, '2016_02_16_140450_create_emails_table', 1),
(9, '2016_02_16_140450_create_group_assign_department_table', 1),
(10, '2016_02_16_140450_create_groups_table', 1),
(11, '2016_02_16_140450_create_help_topic_table', 1),
(12, '2016_02_16_140450_create_kb_article_relationship_table', 1),
(13, '2016_02_16_140450_create_kb_article_table', 1),
(14, '2016_02_16_140450_create_kb_category_table', 1),
(15, '2016_02_16_140450_create_kb_comment_table', 1),
(16, '2016_02_16_140450_create_kb_pages_table', 1),
(17, '2016_02_16_140450_create_kb_settings_table', 1),
(18, '2016_02_16_140450_create_languages_table', 1),
(19, '2016_02_16_140450_create_log_notification_table', 1),
(20, '2016_02_16_140450_create_mailbox_protocol_table', 1),
(21, '2016_02_16_140450_create_organization_table', 1),
(22, '2016_02_16_140450_create_password_resets_table', 1),
(23, '2016_02_16_140450_create_plugins_table', 1),
(24, '2016_02_16_140450_create_settings_alert_notice_table', 1),
(25, '2016_02_16_140450_create_settings_auto_response_table', 1),
(26, '2016_02_16_140450_create_settings_company_table', 1),
(27, '2016_02_16_140450_create_settings_email_table', 1),
(28, '2016_02_16_140450_create_settings_ratings_table', 1),
(29, '2016_02_16_140450_create_settings_system_table', 1),
(30, '2016_02_16_140450_create_settings_ticket_table', 1),
(31, '2016_02_16_140450_create_sla_plan_table', 1),
(32, '2016_02_16_140450_create_team_assign_agent_table', 1),
(33, '2016_02_16_140450_create_teams_table', 1),
(34, '2016_02_16_140450_create_template_table', 1),
(35, '2016_02_16_140450_create_ticket_attachment_table', 1),
(36, '2016_02_16_140450_create_ticket_collaborator_table', 1),
(37, '2016_02_16_140450_create_ticket_form_data_table', 1),
(38, '2016_02_16_140450_create_ticket_priority_table', 1),
(39, '2016_02_16_140450_create_ticket_source_table', 1),
(40, '2016_02_16_140450_create_ticket_status_table', 1),
(41, '2016_02_16_140450_create_ticket_thread_table', 1),
(42, '2016_02_16_140450_create_tickets_table', 1),
(43, '2016_02_16_140450_create_time_format_table', 1),
(44, '2016_02_16_140450_create_timezone_table', 1),
(45, '2016_02_16_140450_create_user_assign_organization_table', 1),
(46, '2016_02_16_140450_create_users_table', 1),
(47, '2016_02_16_140450_create_version_check_table', 1),
(48, '2016_02_16_140450_create_widgets_table', 1),
(49, '2016_02_16_140454_add_foreign_keys_to_canned_response_table', 1),
(50, '2016_02_16_140454_add_foreign_keys_to_department_table', 1),
(51, '2016_02_16_140454_add_foreign_keys_to_emails_table', 1),
(52, '2016_02_16_140454_add_foreign_keys_to_group_assign_department_table', 1),
(53, '2016_02_16_140454_add_foreign_keys_to_help_topic_table', 1),
(54, '2016_02_16_140454_add_foreign_keys_to_kb_article_relationship_table', 1),
(55, '2016_02_16_140454_add_foreign_keys_to_kb_comment_table', 1),
(56, '2016_02_16_140454_add_foreign_keys_to_organization_table', 1),
(57, '2016_02_16_140454_add_foreign_keys_to_settings_system_table', 1),
(58, '2016_02_16_140454_add_foreign_keys_to_team_assign_agent_table', 1),
(59, '2016_02_16_140454_add_foreign_keys_to_teams_table', 1),
(60, '2016_02_16_140454_add_foreign_keys_to_ticket_attachment_table', 1),
(61, '2016_02_16_140454_add_foreign_keys_to_ticket_collaborator_table', 1),
(62, '2016_02_16_140454_add_foreign_keys_to_ticket_form_data_table', 1),
(63, '2016_02_16_140454_add_foreign_keys_to_ticket_thread_table', 1),
(64, '2016_02_16_140454_add_foreign_keys_to_tickets_table', 1),
(65, '2016_02_16_140454_add_foreign_keys_to_user_assign_organization_table', 1),
(66, '2016_02_16_140454_add_foreign_keys_to_users_table', 1),
(67, '2016_03_31_061239_create_notifications_table', 1),
(68, '2016_03_31_061534_create_notification_types_table', 1),
(69, '2016_03_31_061740_create_user_notification_table', 1),
(70, '2016_04_18_115852_create_workflow_name_table', 1),
(71, '2016_04_18_115900_create_workflow_rule_table', 1),
(72, '2016_04_18_115908_create_workflow_action_table', 1),
(73, '2016_05_10_102423_create_country_code_table', 1),
(74, '2016_05_10_102604_create_bar_notifications_table', 1),
(75, '2016_05_11_105244_create_api_settings_table', 1),
(76, '2016_05_19_055008_create_workflow_close_table', 1),
(77, '2016_06_02_072210_create_common_settings_table', 1),
(78, '2016_06_02_074913_create_login_attempts_table', 1),
(79, '2016_06_02_080005_create_ratings_table', 1),
(80, '2016_06_02_081020_create_rating_ref_table', 1),
(81, '2016_06_02_090225_create_settings_security_table', 1),
(82, '2016_06_02_090628_create_templates_table', 1),
(83, '2016_06_02_094409_create_template_sets_table', 1),
(84, '2016_06_02_094420_create_template_types_table', 1),
(85, '2016_06_02_095357_create_ticket_token_table', 1),
(86, '2016_06_28_141613_version1079table', 1),
(87, '2016_07_02_051247_create_jobs_table', 1),
(88, '2016_07_02_051439_create_failed_jobs_table', 1),
(89, '2016_07_19_071910_create_field_values_table', 1),
(90, '2016_07_26_084458_create_faveo_mails_table', 1),
(91, '2016_07_26_090201_create_faveo_queues_table', 1),
(92, '2016_07_26_094753_create_mail_services_table', 1),
(93, '2016_07_26_095020_create_queue_services_table', 1),
(94, '2016_07_29_113012_create_conditions_table', 1),
(95, '2016_08_08_095744_create_social_media_table', 1),
(96, '2016_08_12_104410_create_user_additional_infos_table', 1),
(97, '2016_08_16_104539_alter_ticket_source_table', 1),
(98, '2018_08_08_094653_alter_users_table_add_user_language_column', 1),
(99, '2018_08_13_075015_alter_emails_table_make_username_column_nullable', 1),
(100, '2020_09_23_112403_ticket_stored_functions', 1),
(101, '2020_09_23_112514_ticket_views', 1),
(102, '2020_09_24_102848_tickets_stored_procedure', 1),
(103, '2020_11_11_095510_create_immigration_offices_table', 1),
(104, '2020_11_11_182411_add_column_request_office_id_tickets_table', 1),
(105, '2020_11_25_154637_create_team_assignments_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `model_id` int(11) NOT NULL,
  `userid_created` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `model_id`, `userid_created`, `type_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, '2022-02-25 10:11:33', '2022-02-25 10:11:33'),
(2, 2, 1, 3, '2022-02-25 10:15:31', '2022-02-25 10:15:31'),
(3, 3, 1, 3, '2022-02-25 10:16:48', '2022-02-25 10:16:48'),
(4, 1, 2, 2, '2022-02-28 05:07:09', '2022-02-28 05:07:09'),
(5, 4, 2, 3, '2022-02-28 05:32:11', '2022-02-28 05:32:11'),
(6, 5, 1, 3, '2022-03-01 09:25:43', '2022-03-01 09:25:43'),
(7, 6, 2, 3, '2022-03-01 09:47:59', '2022-03-01 09:47:59');

-- --------------------------------------------------------

--
-- Table structure for table `notification_types`
--

CREATE TABLE `notification_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notification_types`
--

INSERT INTO `notification_types` (`id`, `message`, `type`, `icon_class`, `created_at`, `updated_at`) VALUES
(1, 'A new user is registered', 'registration', 'fa fa-user', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(2, 'You have a new reply on this ticket', 'reply', 'fa fa-envelope', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(3, 'A new ticket has been created', 'new_ticket', 'fa fa-envelope', '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Stand-in structure for view `open_tickets_per_department`
-- (See below for the actual view)
--
CREATE TABLE `open_tickets_per_department` (
`id` int(10) unsigned
,`ticket_number` varchar(255)
,`duedate` datetime
,`dept_id` int(10) unsigned
,`assignedTo` int(10) unsigned
,`statusID` int(10) unsigned
,`isanswered` int(11)
,`isoverdue` int(11)
,`is_deleted` int(11)
,`is_transferred` tinyint(1)
,`follow_up` int(11)
,`closed` int(11)
,`reopened` int(11)
,`ticket_subject` varchar(255)
,`thread_id` int(10) unsigned
,`owner` text
,`assigned_to` text
,`status` varchar(255)
,`last_activity` timestamp
,`priority_color` varchar(255)
,`priority` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `head` int(10) UNSIGNED DEFAULT NULL,
  `internal_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE `plugins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `queue_services`
--

CREATE TABLE `queue_services` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `queue_services`
--

INSERT INTO `queue_services` (`id`, `name`, `short_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Sync', 'sync', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(2, 'Database', 'database', 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(3, 'Beanstalkd', 'beanstalkd', 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(4, 'SQS', 'sqs', 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(5, 'Iron', 'iron', 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(6, 'Redis', 'redis', 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_order` int(11) NOT NULL,
  `allow_modification` int(11) NOT NULL,
  `rating_scale` int(11) NOT NULL,
  `rating_area` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restrict` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `name`, `display_order`, `allow_modification`, `rating_scale`, `rating_area`, `restrict`, `created_at`, `updated_at`) VALUES
(1, 'OverAll Satisfaction', 1, 1, 5, 'Helpdesk Area', '', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(2, 'Reply Rating', 1, 1, 5, 'Comment Area', '', '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `rating_ref`
--

CREATE TABLE `rating_ref` (
  `id` int(10) UNSIGNED NOT NULL,
  `rating_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `rating_value` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `reopened_tickets`
-- (See below for the actual view)
--
CREATE TABLE `reopened_tickets` (
`id` int(10) unsigned
,`ticket_number` varchar(255)
,`duedate` datetime
,`dept_id` int(10) unsigned
,`assignedTo` int(10) unsigned
,`statusID` int(10) unsigned
,`isanswered` int(11)
,`isoverdue` int(11)
,`is_deleted` int(11)
,`is_transferred` tinyint(1)
,`follow_up` int(11)
,`closed` int(11)
,`reopened` int(11)
,`ticket_subject` varchar(255)
,`thread_id` int(10) unsigned
,`owner` text
,`assigned_to` text
,`status` varchar(255)
,`last_activity` timestamp
,`priority_color` varchar(255)
,`priority` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `resolved_tickets_per_department`
-- (See below for the actual view)
--
CREATE TABLE `resolved_tickets_per_department` (
`id` int(10) unsigned
,`ticket_number` varchar(255)
,`duedate` datetime
,`dept_id` int(10) unsigned
,`assignedTo` int(10) unsigned
,`statusID` int(10) unsigned
,`isanswered` int(11)
,`isoverdue` int(11)
,`is_deleted` int(11)
,`is_transferred` tinyint(1)
,`follow_up` int(11)
,`closed` int(11)
,`reopened` int(11)
,`ticket_subject` varchar(255)
,`thread_id` int(10) unsigned
,`owner` text
,`assigned_to` text
,`status` varchar(255)
,`last_activity` timestamp
,`priority_color` varchar(255)
,`priority` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `settings_alert_notice`
--

CREATE TABLE `settings_alert_notice` (
  `id` int(10) UNSIGNED NOT NULL,
  `ticket_status` tinyint(1) NOT NULL,
  `ticket_admin_email` tinyint(1) NOT NULL,
  `ticket_department_manager` tinyint(1) NOT NULL,
  `ticket_department_member` tinyint(1) NOT NULL,
  `ticket_organization_accmanager` tinyint(1) NOT NULL,
  `message_status` tinyint(1) NOT NULL,
  `message_last_responder` tinyint(1) NOT NULL,
  `message_assigned_agent` tinyint(1) NOT NULL,
  `message_department_manager` tinyint(1) NOT NULL,
  `message_organization_accmanager` tinyint(1) NOT NULL,
  `internal_status` tinyint(1) NOT NULL,
  `internal_last_responder` tinyint(1) NOT NULL,
  `internal_assigned_agent` tinyint(1) NOT NULL,
  `internal_department_manager` tinyint(1) NOT NULL,
  `assignment_status` tinyint(1) NOT NULL,
  `assignment_assigned_agent` tinyint(1) NOT NULL,
  `assignment_team_leader` tinyint(1) NOT NULL,
  `assignment_team_member` tinyint(1) NOT NULL,
  `transfer_status` tinyint(1) NOT NULL,
  `transfer_assigned_agent` tinyint(1) NOT NULL,
  `transfer_department_manager` tinyint(1) NOT NULL,
  `transfer_department_member` tinyint(1) NOT NULL,
  `overdue_status` tinyint(1) NOT NULL,
  `overdue_assigned_agent` tinyint(1) NOT NULL,
  `overdue_department_manager` tinyint(1) NOT NULL,
  `overdue_department_member` tinyint(1) NOT NULL,
  `system_error` tinyint(1) NOT NULL,
  `sql_error` tinyint(1) NOT NULL,
  `excessive_failure` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings_alert_notice`
--

INSERT INTO `settings_alert_notice` (`id`, `ticket_status`, `ticket_admin_email`, `ticket_department_manager`, `ticket_department_member`, `ticket_organization_accmanager`, `message_status`, `message_last_responder`, `message_assigned_agent`, `message_department_manager`, `message_organization_accmanager`, `internal_status`, `internal_last_responder`, `internal_assigned_agent`, `internal_department_manager`, `assignment_status`, `assignment_assigned_agent`, `assignment_team_leader`, `assignment_team_member`, `transfer_status`, `transfer_assigned_agent`, `transfer_department_manager`, `transfer_department_member`, `overdue_status`, `overdue_assigned_agent`, `overdue_department_manager`, `overdue_department_member`, `system_error`, `sql_error`, `excessive_failure`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `settings_auto_response`
--

CREATE TABLE `settings_auto_response` (
  `id` int(10) UNSIGNED NOT NULL,
  `new_ticket` tinyint(1) NOT NULL,
  `agent_new_ticket` tinyint(1) NOT NULL,
  `submitter` tinyint(1) NOT NULL,
  `participants` tinyint(1) NOT NULL,
  `overlimit` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings_auto_response`
--

INSERT INTO `settings_auto_response` (`id`, `new_ticket`, `agent_new_ticket`, `submitter`, `participants`, `overlimit`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 0, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `settings_company`
--

CREATE TABLE `settings_company` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `landing_page` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `offline_page` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thank_page` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `use_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings_company`
--

INSERT INTO `settings_company` (`id`, `company_name`, `website`, `phone`, `address`, `landing_page`, `offline_page`, `thank_page`, `logo`, `use_logo`, `created_at`, `updated_at`) VALUES
(1, '', '', '', '', '', '', '', '', '', '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `settings_email`
--

CREATE TABLE `settings_email` (
  `id` int(10) UNSIGNED NOT NULL,
  `template` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sys_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alert_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_fetching` tinyint(1) NOT NULL,
  `notification_cron` tinyint(1) NOT NULL,
  `strip` tinyint(1) NOT NULL,
  `separator` tinyint(1) NOT NULL,
  `all_emails` tinyint(1) NOT NULL,
  `email_collaborator` tinyint(1) NOT NULL,
  `attachment` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings_email`
--

INSERT INTO `settings_email` (`id`, `template`, `sys_email`, `alert_email`, `admin_email`, `mta`, `email_fetching`, `notification_cron`, `strip`, `separator`, `all_emails`, `email_collaborator`, `attachment`, `created_at`, `updated_at`) VALUES
(1, 'default', '1', '', '', '', 1, 1, 0, 0, 1, 1, 1, '2021-11-23 13:25:14', '2022-02-25 09:37:45');

-- --------------------------------------------------------

--
-- Table structure for table `settings_ratings`
--

CREATE TABLE `settings_ratings` (
  `id` int(10) UNSIGNED NOT NULL,
  `rating_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `publish` int(11) NOT NULL,
  `modify` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_security`
--

CREATE TABLE `settings_security` (
  `id` int(10) UNSIGNED NOT NULL,
  `lockout_message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `backlist_offender` int(11) NOT NULL,
  `backlist_threshold` int(11) NOT NULL,
  `lockout_period` int(11) NOT NULL,
  `days_to_keep_logs` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings_security`
--

INSERT INTO `settings_security` (`id`, `lockout_message`, `backlist_offender`, `backlist_threshold`, `lockout_period`, `days_to_keep_logs`, `created_at`, `updated_at`) VALUES
(1, 'You have been locked out of application due to too many failed login attempts.', 0, 15, 15, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `settings_system`
--

CREATE TABLE `settings_system` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `log_level` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purge_log` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `api_enable` int(11) NOT NULL,
  `api_key_mandatory` int(11) NOT NULL,
  `api_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time_farmat` int(10) UNSIGNED DEFAULT NULL,
  `date_format` int(10) UNSIGNED DEFAULT NULL,
  `date_time_format` int(10) UNSIGNED DEFAULT NULL,
  `day_date_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time_zone` int(10) UNSIGNED DEFAULT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings_system`
--

INSERT INTO `settings_system` (`id`, `status`, `url`, `name`, `department`, `page_size`, `log_level`, `purge_log`, `api_enable`, `api_key_mandatory`, `api_key`, `name_format`, `time_farmat`, `date_format`, `date_time_format`, `day_date_time`, `time_zone`, `content`, `version`, `created_at`, `updated_at`) VALUES
(1, 1, '', '', '1', '', '', '', 0, 0, '', '', NULL, NULL, 1, '', 32, '', '', '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `settings_ticket`
--

CREATE TABLE `settings_ticket` (
  `id` int(10) UNSIGNED NOT NULL,
  `num_format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `num_sequence` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priority` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sla` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `help_topic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `max_open_ticket` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `collision_avoid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lock_ticket_frequency` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `captcha` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `claim_response` tinyint(1) NOT NULL,
  `assigned_ticket` tinyint(1) NOT NULL,
  `answered_ticket` tinyint(1) NOT NULL,
  `agent_mask` tinyint(1) NOT NULL,
  `html` tinyint(1) NOT NULL,
  `client_update` tinyint(1) NOT NULL,
  `max_file_size` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings_ticket`
--

INSERT INTO `settings_ticket` (`id`, `num_format`, `num_sequence`, `priority`, `sla`, `help_topic`, `max_open_ticket`, `collision_avoid`, `lock_ticket_frequency`, `captcha`, `status`, `claim_response`, `assigned_ticket`, `answered_ticket`, `agent_mask`, `html`, `client_update`, `max_file_size`, `created_at`, `updated_at`) VALUES
(1, '$$$$-####-####', 'sequence', '1', '2', '1', '', '2', '0', '', 1, 0, 0, 0, 0, 0, 0, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `sla_plan`
--

CREATE TABLE `sla_plan` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grace_period` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `transient` tinyint(1) NOT NULL,
  `ticket_overdue` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sla_plan`
--

INSERT INTO `sla_plan` (`id`, `name`, `grace_period`, `admin_note`, `status`, `transient`, `ticket_overdue`, `created_at`, `updated_at`) VALUES
(1, 'Sla 1', '6 Hours', '', 1, 0, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(2, 'Sla 2', '12 Hours', '', 1, 0, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(3, 'Sla 3', '24 Hours', '', 1, 0, 0, '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `social_media`
--

CREATE TABLE `social_media` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `team_lead` int(10) UNSIGNED DEFAULT NULL,
  `assign_alert` tinyint(1) NOT NULL,
  `admin_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `status`, `team_lead`, `assign_alert`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 'Level 1 Support', 1, NULL, 0, '', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(2, 'Level 2 Support', 1, NULL, 0, '', '2021-11-23 13:25:14', '2022-02-25 10:08:23'),
(3, 'Software Developers', 1, NULL, 0, '', '2021-11-23 13:25:14', '2022-02-25 10:08:16');

-- --------------------------------------------------------

--
-- Table structure for table `team_assignments`
--

CREATE TABLE `team_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_team_id` int(10) UNSIGNED NOT NULL,
  `to_team_id` int(10) UNSIGNED NOT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `hide` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `team_assignments`
--

INSERT INTO `team_assignments` (`id`, `from_team_id`, `to_team_id`, `remarks`, `active`, `hide`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, 1, 0, '2022-02-25 10:08:33', '2022-02-25 10:08:33'),
(2, 1, 3, NULL, 1, 0, '2022-02-25 10:08:47', '2022-02-25 10:08:47');

-- --------------------------------------------------------

--
-- Table structure for table `team_assign_agent`
--

CREATE TABLE `team_assign_agent` (
  `id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED DEFAULT NULL,
  `agent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `team_assign_agent`
--

INSERT INTO `team_assign_agent` (`id`, `team_id`, `agent_id`, `created_at`, `updated_at`) VALUES
(4, 1, 2, NULL, NULL),
(5, 2, 2, NULL, NULL),
(6, 3, 2, NULL, NULL),
(7, 2, 3, NULL, NULL),
(8, 3, 3, NULL, NULL),
(9, 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `template_set_to_clone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internal_note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `variable` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `set_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `variable`, `type`, `subject`, `message`, `description`, `set_id`, `created_at`, `updated_at`) VALUES
(1, 'This template is for sending notice to agent when ticket is assigned to them', '0', 1, '', '<div>Hello {!!$ticket_agent_name!!},<br /><br /><b>Ticket No:</b> {!!$ticket_number!!}<br />Has been assigned to you by {!!$ticket_assigner!!} <br/> Please check and resppond on the ticket.<br /> Link: {!!$ticket_link!!}<br /><br />Thank You<br />Kind Regards,<br /> {!!$system_from!!}</div>', '', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(2, 'This template is for sending notice to client with ticket link to check ticket without logging in to system', '1', 2, 'Check your Ticket', '<div>Hello {!!$user!!},<br/><br/>Click the link below to view your requested ticket<br/> {!!$ticket_link_with_number!!}<br/><br/>Kind Regards,<br/> {!!$system_from!!}</div>', '', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(3, 'This template is for sending notice to client when ticket status is changed to close', '0', 3, '', '<div>Hello,<br/><br/>This message is regarding your ticket ID {!!$ticket_number!!}. We are changing the status of this ticket to \"Closed\" as the issue appears to be resolved.<br/><br/>Thank you<br/>Kind regards,<br/> {!!$system_from!!}</div>', '', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(4, 'This template is for sending notice to client on successful ticket creation', '0', 4, '', '<div><span>Hello {!!$user!!}<br/><br/></span><span>Thank you for contacting us. This is an automated response confirming the receipt of your ticket. Our team will get back to you as soon as possible. When replying, please make sure that the ticket ID is kept in the subject so that we can track your replies.<br/><br/></span><span><b>Ticket ID:</b> {!!$ticket_number!!} <br/><br/></span><span> {!!$department_sign!!}<br/></span>You can check the status of or update this ticket online at: {!!$system_link!!}</div>', '', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(5, 'This template is for sending notice to agent on new ticket creation', '0', 5, '', '<div>Hello {!!$ticket_agent_name!!},<br/><br/>New ticket {!!$ticket_number!!}created <br/><br/><b>From</b><br/><b>Name:</b> {!!$ticket_client_name!!}   <br/><b>E-mail:</b> {!!$ticket_client_email!!}<br/><br/> {!!$content!!}<br/><br/>Kind Regards,<br/> {!!$system_from!!}</div>', '', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(6, 'This template is for sending notice to client on new ticket created by agent in name of client', '0', 6, '', '<div> {!!$content!!}<br><br> {!!$agent_sign!!}<br><br>You can check the status of or update this ticket online at: {!!$system_link!!}</div>', '', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(7, 'This template is for sending notice to client on new registration during new ticket creation for un registered clients', '1', 7, 'Registration Confirmation', '<p>Hello {!!$user!!}, </p><p>This email is confirmation that you are now registered at our helpdesk.</p><p><b>Registered Email:</b> {!!$email_address!!}</p><p><b>Password:</b> {!!$user_password!!}</p><p>You can visit the helpdesk to browse articles and contact us at any time: {!!$system_link!!}</p><p>Thank You.</p><p>Kind Regards,</p><p> {!!$system_from!!} </p>', '', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(8, 'This template is for sending notice to any user about reset password option', '1', 8, 'Reset your Password', 'Hello {!!$user!!},<br/><br/>You asked to reset your password. To do so, please click this link:<br/><br/> {!!$password_reset_link!!}<br/><br/>This will let you change your password to something new. If you didn\'t ask for this, don\'t worry, we\'ll keep your password safe.<br/><br/>Thank You.<br/><br/>Kind Regards,<br/> {!!$system_from!!}', '', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(9, 'This template is for sending notice to client when a reply made to his/her ticket', '0', 9, '', '<span></span><div><span></span><p> {!!$content!!}<br/></p><p> {!!$agent_sign!!} </p><p><b>Ticket Details</b></p><p><b>Ticket ID:</b> {!!$ticket_number!!}</p></div>', '', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(10, 'This template is for sending notice to agent when ticket reply is made by client on a ticket', '0', 10, '', '<div>Hello {!!$ticket_agent_name!!},<br/><b><br/></b>A reply been made to ticket {!!$ticket_number!!}<br/><b><br/></b><b>From<br/></b><b>Name: </b>{!!$ticket_client_name!!}<br/><b>E-mail: </b>{!!$ticket_client_email!!}<br/><b><br/></b> {!!$content!!}<br/><b><br/></b>Kind Regards,<br/> {!!$system_from!!}</div>', '', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(11, 'This template is for sending notice to client about registration confirmation link', '1', 11, 'Verify your email address', '<p>Hello {!!$user!!}, </p><p>This email is confirmation that you are now registered at our helpdesk.</p><p><b>Registered Email:</b> {!!$email_address!!}</p><p>Please click on the below link to activate your account and Login to the system {!!$password_reset_link!!}</p><p>Thank You.</p><p>Kind Regards,</p><p> {!!$system_from!!} </p>', '', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(12, 'This template is for sending notice to team when ticket is assigned to team', '1', 12, '', '<div>Hello {!!$ticket_agent_name!!},<br /><br /><b>Ticket No:</b> {!!$ticket_number!!}<br />Has been assigned to your team : {!!$team!!} by {!!$ticket_assigner!!} <br /><br />Thank You<br />Kind Regards,<br />{!!$system_from!!}</div>', '', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(13, 'This template is for sending notice to client when password is changed', '1', 13, 'Verify your email address', 'Hello {!!$user!!},<br /><br />Your password is successfully changed.Your new password is : {!!$user_password!!}<br /><br />Thank You.<br /><br />Kind Regards,<br /> {!!$system_from!!}', '', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(14, 'This template is to notify users when their tickets are merged.', '1', 14, 'Your tickets have been merged.', '<p>Hello {!!$user!!},<br />&nbsp;</p><p>Your ticket(s) with ticket number {!!$merged_ticket_numbers!!} have been closed and&nbsp;merged with <a href=\"{!!$ticket_link!!}\">{!!$ticket_number!!}</a>.&nbsp;</p><p>Possible reasons for merging tickets</p><ul><li>Tickets are duplicate</li<li>Tickets state&nbsp;the same issue</li><li>Another member from your organization has created a ticket for the same issue</li></ul><p><a href=\"{!!$system_link!!}\">Click here</a> to login to your account and check your tickets.</p><p>Regards,</p><p>{!!$system_from!!}</p>', '', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `template_sets`
--

CREATE TABLE `template_sets` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `template_sets`
--

INSERT INTO `template_sets` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'default', 1, '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `template_types`
--

CREATE TABLE `template_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `template_types`
--

INSERT INTO `template_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'assign-ticket', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(2, 'check-ticket', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(3, 'close-ticket', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(4, 'create-ticket', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(5, 'create-ticket-agent', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(6, 'create-ticket-by-agent', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(7, 'registration-notification', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(8, 'reset-password', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(9, 'ticket-reply', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(10, 'ticket-reply-agent', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(11, 'registration', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(12, 'team_assign_ticket', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(13, 'reset_new_password', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(14, 'merge-ticket-notification', '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `ticket_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `dept_id` int(10) UNSIGNED DEFAULT NULL,
  `team_id` int(10) UNSIGNED DEFAULT NULL,
  `priority_id` int(10) UNSIGNED DEFAULT NULL,
  `sla` int(10) UNSIGNED DEFAULT NULL,
  `help_topic_id` int(10) UNSIGNED DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT NULL,
  `rating` tinyint(1) NOT NULL,
  `ratingreply` tinyint(1) NOT NULL,
  `flags` int(11) NOT NULL,
  `ip_address` int(11) NOT NULL,
  `assigned_to` int(10) UNSIGNED DEFAULT NULL,
  `lock_by` int(11) NOT NULL,
  `lock_at` datetime DEFAULT NULL,
  `source` int(10) UNSIGNED DEFAULT NULL,
  `isoverdue` int(11) NOT NULL,
  `reopened` int(11) NOT NULL,
  `isanswered` int(11) NOT NULL,
  `html` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `closed` int(11) NOT NULL,
  `is_transferred` tinyint(1) NOT NULL,
  `transferred_at` datetime NOT NULL,
  `reopened_at` datetime DEFAULT NULL,
  `duedate` datetime DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  `last_message_at` datetime DEFAULT NULL,
  `last_response_at` datetime DEFAULT NULL,
  `approval` int(11) NOT NULL,
  `follow_up` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `immigration_office_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_number`, `user_id`, `dept_id`, `team_id`, `priority_id`, `sla`, `help_topic_id`, `status`, `rating`, `ratingreply`, `flags`, `ip_address`, `assigned_to`, `lock_by`, `lock_at`, `source`, `isoverdue`, `reopened`, `isanswered`, `html`, `is_deleted`, `closed`, `is_transferred`, `transferred_at`, `reopened_at`, `duedate`, `closed_at`, `last_message_at`, `last_response_at`, `approval`, `follow_up`, `created_at`, `updated_at`, `immigration_office_id`) VALUES
(1, 'AAAA-0000-0000', 1, 1, NULL, 1, 1, 1, 2, 0, 0, 0, 0, 2, 0, NULL, 3, 0, 0, 1, 0, 0, 1, 0, '0000-00-00 00:00:00', NULL, '2022-02-25 19:11:33', '2022-02-28 08:07:15', NULL, NULL, 0, 0, '2022-02-25 10:11:33', '2022-02-28 05:07:15', NULL),
(2, 'AAAA-0000-0001', 1, 1, NULL, 2, 1, 1, 1, 0, 0, 0, 0, 3, 0, NULL, 3, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', NULL, '2022-02-25 19:15:31', NULL, NULL, NULL, 0, 0, '2022-02-25 10:15:31', '2022-02-25 10:15:31', NULL),
(3, 'AAAA-0000-0002', 1, 1, NULL, 1, 1, 1, 1, 0, 0, 0, 0, NULL, 0, NULL, 3, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', NULL, '2022-02-25 19:16:48', NULL, NULL, NULL, 0, 0, '2022-02-25 10:16:48', '2022-02-25 10:16:48', NULL),
(4, 'AAAA-0000-0003', 2, 1, NULL, 2, 3, 1, 1, 0, 0, 0, 0, 3, 0, NULL, 3, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', NULL, '2022-03-01 08:32:11', NULL, NULL, NULL, 0, 0, '2022-02-28 05:32:11', '2022-02-28 05:32:11', NULL),
(5, 'AAAA-0000-0004', 1, 1, NULL, 2, 1, 1, 1, 0, 0, 0, 0, 2, 0, NULL, 3, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', NULL, '2022-03-01 18:25:43', NULL, NULL, NULL, 0, 0, '2022-03-01 09:25:43', '2022-03-01 09:25:43', NULL),
(6, 'AAAA-0000-0005', 2, 1, NULL, 1, 1, 1, 2, 0, 0, 0, 0, 3, 0, NULL, 3, 0, 0, 0, 0, 0, 1, 0, '0000-00-00 00:00:00', NULL, '2022-03-01 18:47:59', '2022-04-08 10:21:12', NULL, NULL, 0, 0, '2022-03-01 09:47:59', '2022-04-08 07:21:12', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `tickets_detailed`
-- (See below for the actual view)
--
CREATE TABLE `tickets_detailed` (
`id` int(10) unsigned
,`ticket_number` varchar(255)
,`duedate` datetime
,`dept_id` int(10) unsigned
,`assignedTo` int(10) unsigned
,`statusID` int(10) unsigned
,`isanswered` int(11)
,`isoverdue` int(11)
,`is_deleted` int(11)
,`is_transferred` tinyint(1)
,`follow_up` int(11)
,`closed` int(11)
,`reopened` int(11)
,`ticket_subject` varchar(255)
,`thread_id` int(10) unsigned
,`owner` text
,`assigned_to` text
,`status` varchar(255)
,`last_activity` timestamp
,`priority_color` varchar(255)
,`priority` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_attachment`
--

CREATE TABLE `ticket_attachment` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thread_id` int(10) UNSIGNED DEFAULT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `poster` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `file` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_collaborator`
--

CREATE TABLE `ticket_collaborator` (
  `id` int(10) UNSIGNED NOT NULL,
  `isactive` tinyint(1) NOT NULL,
  `ticket_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_form_data`
--

CREATE TABLE `ticket_form_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `ticket_id` int(10) UNSIGNED DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_priority`
--

CREATE TABLE `ticket_priority` (
  `priority_id` int(10) UNSIGNED NOT NULL,
  `priority` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priority_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priority_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priority_urgency` tinyint(1) NOT NULL,
  `ispublic` tinyint(1) NOT NULL,
  `is_default` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ticket_priority`
--

INSERT INTO `ticket_priority` (`priority_id`, `priority`, `status`, `priority_desc`, `priority_color`, `priority_urgency`, `ispublic`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Low', '1', 'Low', '#00a65a', 4, 1, '', NULL, NULL),
(2, 'Normal', '1', 'Normal', '#00bfef', 3, 1, '1', NULL, NULL),
(3, 'High', '1', 'High', '#f39c11', 2, 1, '', NULL, NULL),
(4, 'Emergency', '1', 'Emergency', '#dd4b38', 1, 1, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_source`
--

CREATE TABLE `ticket_source` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ticket_source`
--

INSERT INTO `ticket_source` (`id`, `name`, `value`, `css_class`) VALUES
(1, 'Web', 'Web', 'fa fa-globe'),
(2, 'Email', 'E-mail', 'fa fa-envelope'),
(3, 'Agent', 'Agent Panel', 'fa fa-user'),
(4, 'Facebook', 'Facebook', 'fa fa-facebook'),
(5, 'Twitter', 'Twitter', 'fa fa-twitter'),
(6, 'Call', 'Call', 'fa fa-phone'),
(7, 'Chat', 'Chat', 'fa fa-comment');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_status`
--

CREATE TABLE `ticket_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mode` int(11) NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flags` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `email_user` int(11) NOT NULL,
  `icon_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `properties` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ticket_status`
--

INSERT INTO `ticket_status` (`id`, `name`, `state`, `mode`, `message`, `flags`, `sort`, `email_user`, `icon_class`, `properties`, `created_at`, `updated_at`) VALUES
(1, 'Open', 'open', 3, 'Ticket have been Reopened by', 0, 1, 0, '', 'Open tickets.', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(2, 'Resolved', 'closed', 1, 'Ticket have been Resolved by', 0, 2, 0, '', 'Resolved tickets.', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(3, 'Closed', 'closed', 3, 'Ticket have been Closed by', 0, 3, 0, '', 'Closed tickets. Tickets will still be accessible on client and staff panels.', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(4, 'Archived', 'archived', 3, 'Ticket have been Archived by', 0, 4, 0, '', 'Tickets only adminstratively available but no longer accessible on ticket queues and client panel.', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(5, 'Deleted', 'deleted', 3, 'Ticket have been Deleted by', 0, 5, 0, '', 'Tickets queued for deletion. Not accessible on ticket queues.', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(6, 'Unverified', 'unverified', 3, 'User account verification required.', 0, 6, 0, '', 'Ticket will be open after user verifies his/her account.', '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(7, 'Request Approval', 'unverified', 3, 'Approval requested by', 0, 7, 0, '', 'Ticket will be approve  after Admin verifies  this ticket', '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_thread`
--

CREATE TABLE `ticket_thread` (
  `id` int(10) UNSIGNED NOT NULL,
  `ticket_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `poster` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `source` int(10) UNSIGNED DEFAULT NULL,
  `reply_rating` int(11) NOT NULL,
  `rating_count` int(11) NOT NULL,
  `is_internal` tinyint(1) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` longblob DEFAULT NULL,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ticket_thread`
--

INSERT INTO `ticket_thread` (`id`, `ticket_id`, `user_id`, `poster`, `source`, `reply_rating`, `rating_count`, `is_internal`, `title`, `body`, `format`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'client', NULL, 0, 0, 0, 'Test Ticket', 0x54657374205469636b6574, '', '', '2022-02-25 10:11:33', '2022-02-25 10:11:33'),
(2, 2, 1, 'client', NULL, 0, 0, 0, 'Test Ticket', 0x54657374205469636b6574, '', '', '2022-02-25 10:15:31', '2022-02-25 10:15:31'),
(3, 3, 1, 'client', NULL, 0, 0, 0, 'Test Ticket', 0x54657374205469636b6574, '', '', '2022-02-25 10:16:48', '2022-02-25 10:16:48'),
(4, 1, 2, 'support', NULL, 0, 0, 0, 'Test Ticket', 0x3c703e776f726b696e67206f6e2069743c2f703e0d0a, '', '', '2022-02-28 05:07:09', '2022-02-28 05:07:09'),
(5, 1, 2, '', NULL, 0, 0, 1, 'Test Ticket', 0x5469636b65742068617665206265656e205265736f6c76656420627920416c66726564204b696e67, '', '', '2022-02-28 05:07:15', '2022-02-28 05:07:15'),
(6, 4, 2, 'client', NULL, 0, 0, 0, 'a Chinese historian, Beijin', 0x3c703e3c7370616e3e6f722058752047756f71692c2061204368696e65736520686973746f7269616e2c204265696a696e67e28099732072656c756374616e636520746f2064656e6f756e636520566c6164696d697220507574696ee280997320696e766173696f6e206f66266e6273703b3c61207461726765743d225f626c616e6b222072656c3d226e6f666f6c6c6f772220687265663d2268747470733a2f2f7777772e746865677561726469616e2e636f6d2f776f726c642f756b7261696e65223e556b7261696e653c2f613e266e6273703b697320616c61726d696e672e20e2809c49e280996d206120686973746f7269616e206f662074686520666972737420776f726c64207761722e204575726f706520736c6565702d77616c6b656420696e746f2061206875676520636f6e666c696374206f766572203130302079656172732061676f2c20776869636820616c736f206861642068616420656e6f726d6f757320636f6e73657175656e63657320666f72204368696e612ce2809d20587520736169642e20e2809c54686520776f726c64206d61792062652061742074686520706f696e74206f66206e6f2072657475726e20616761696ee2809d2e3c2f7370616e3e3c2f703e3c6469763e3c7370616e3e3c62723e3c2f7370616e3e3c2f6469763e, '', '', '2022-02-28 05:32:11', '2022-02-28 05:32:11'),
(7, 5, 1, 'client', NULL, 0, 0, 0, 'Help test', 0x3c6469763e3c6469763e3c6469763e3c703e596f752068617665206e6f7420636f6e666967757265642073797374656d206d61696c2e20466176656f2063616e2774206665746368207469636b6574732066726f6d206d61696c206f722073656e64206d61696c20746f20757365727320776974686f75742069742e266e6273703b3c61207461726765743d225f626c616e6b222072656c3d226e6f666f6c6c6f772220687265663d22687474703a2f2f68656c706465736b2e6c6f63616c686f73742f656d61696c732f637265617465223e436c69636b206865726520746f20636f6e66696775726520746865206d61696c2e3c2f613e3c2f703e3c2f6469763e3c2f6469763e3c2f6469763e3c6469763e3c2f6469763e, '', '', '2022-03-01 09:25:43', '2022-03-01 09:25:43'),
(8, 6, 2, 'client', NULL, 0, 0, 0, 'Picha ya mtoto mkali', 0x3c696d6720616c743d22496d61676522207372633d2268747470733a2f2f7062732e7477696d672e636f6d2f6d656469612f464d70764d4f48584d415152644f313f666f726d61743d6a706726616d703b6e616d653d736d616c6c22207469746c653d22496d6167653a2068747470733a2f2f7062732e7477696d672e636f6d2f6d656469612f464d70764d4f48584d415152644f313f666f726d61743d6a706726616d703b6e616d653d736d616c6c223e3c62723e7069636861207961206d746f746f206d6b616c69, '', '', '2022-03-01 09:47:59', '2022-03-01 09:47:59'),
(9, 6, 1, '', NULL, 0, 0, 1, '', 0x5469636b65742068617665206265656e205265736f6c7665642062792053797374656d2041646d696e6973747261746f72, '', '', '2022-04-08 07:21:12', '2022-04-08 07:21:12');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_token`
--

CREATE TABLE `ticket_token` (
  `id` int(10) UNSIGNED NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timezone`
--

CREATE TABLE `timezone` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `timezone`
--

INSERT INTO `timezone` (`id`, `name`, `location`) VALUES
(1, 'Africa/Dar_es_Salaam', '(GMT+03:00) Dar_es_Salaam'),
(2, 'Pacific/Midway', '(GMT-11:00) Midway Island'),
(3, 'US/Samoa', '(GMT-11:00) Samoa'),
(4, 'US/Hawaii', '(GMT-10:00) Hawaii'),
(5, 'US/Alaska', '(GMT-09:00) Alaska'),
(6, 'US/Pacific', '(GMT-08:00) Pacific Time (US &amp; Canada)'),
(7, 'America/Tijuana', '(GMT-08:00) Tijuana'),
(8, 'US/Arizona', '(GMT-07:00) Arizona'),
(9, 'US/Mountain', '(GMT-07:00) Mountain Time (US &amp; Canada)'),
(10, 'America/Chihuahua', '(GMT-07:00) Chihuahua'),
(11, 'America/Mazatlan', '(GMT-07:00) Mazatlan'),
(12, 'America/Mexico_City', '(GMT-06:00) Mexico City'),
(13, 'America/Monterrey', '(GMT-06:00) Monterrey'),
(14, 'Canada/Saskatchewan', '(GMT-06:00) Saskatchewan'),
(15, 'US/Central', '(GMT-06:00) Central Time (US &amp; Canada)'),
(16, 'US/Eastern', '(GMT-05:00) Eastern Time (US &amp; Canada)'),
(17, 'US/East-Indiana', '(GMT-05:00) Indiana (East)'),
(18, 'America/Bogota', '(GMT-05:00) Bogota'),
(19, 'America/Lima', '(GMT-05:00) Lima'),
(20, 'America/Caracas', '(GMT-04:30) Caracas'),
(21, 'Canada/Atlantic', '(GMT-04:00) Atlantic Time (Canada)'),
(22, 'America/La_Paz', '(GMT-04:00) La Paz'),
(23, 'America/Santiago', '(GMT-04:00) Santiago'),
(24, 'Canada/Newfoundland', '(GMT-03:30) Newfoundland'),
(25, 'America/Buenos_Aires', '(GMT-03:00) Buenos Aires'),
(26, 'Greenland', '(GMT-03:00) Greenland'),
(27, 'Atlantic/Stanley', '(GMT-02:00) Stanley'),
(28, 'Atlantic/Azores', '(GMT-01:00) Azores'),
(29, 'Atlantic/Cape_Verde', '(GMT-01:00) Cape Verde Is.'),
(30, 'Africa/Casablanca', '(GMT) Casablanca'),
(31, 'Europe/Dublin', '(GMT) Dublin'),
(32, 'Europe/Lisbon', '(GMT) Lisbon'),
(33, 'Europe/London', '(GMT) London'),
(34, 'Africa/Monrovia', '(GMT) Monrovia'),
(35, 'Europe/Amsterdam', '(GMT+01:00) Amsterdam'),
(36, 'Europe/Belgrade', '(GMT+01:00) Belgrade'),
(37, 'Europe/Berlin', '(GMT+01:00) Berlin'),
(38, 'Europe/Bratislava', '(GMT+01:00) Bratislava'),
(39, 'Europe/Brussels', '(GMT+01:00) Brussels'),
(40, 'Europe/Budapest', '(GMT+01:00) Budapest'),
(41, 'Europe/Copenhagen', '(GMT+01:00) Copenhagen'),
(42, 'Europe/Ljubljana', '(GMT+01:00) Ljubljana'),
(43, 'Europe/Madrid', '(GMT+01:00) Madrid'),
(44, 'Europe/Paris', '(GMT+01:00) Paris'),
(45, 'Europe/Prague', '(GMT+01:00) Prague'),
(46, 'Europe/Rome', '(GMT+01:00) Rome'),
(47, 'Europe/Sarajevo', '(GMT+01:00) Sarajevo'),
(48, 'Europe/Skopje', '(GMT+01:00) Skopje'),
(49, 'Europe/Stockholm', '(GMT+01:00) Stockholm'),
(50, 'Europe/Vienna', '(GMT+01:00) Vienna'),
(51, 'Europe/Warsaw', '(GMT+01:00) Warsaw'),
(52, 'Europe/Zagreb', '(GMT+01:00) Zagreb'),
(53, 'Europe/Athens', '(GMT+02:00) Athens'),
(54, 'Europe/Bucharest', '(GMT+02:00) Bucharest'),
(55, 'Africa/Cairo', '(GMT+02:00) Cairo'),
(56, 'Africa/Harare', '(GMT+02:00) Harare'),
(57, 'Europe/Helsinki', '(GMT+02:00) Helsinki'),
(58, 'Europe/Istanbul', '(GMT+02:00) Istanbul'),
(59, 'Asia/Jerusalem', '(GMT+02:00) Jerusalem'),
(60, 'Europe/Kiev', '(GMT+02:00) Kyiv'),
(61, 'Europe/Minsk', '(GMT+02:00) Minsk'),
(62, 'Europe/Riga', '(GMT+02:00) Riga'),
(63, 'Europe/Sofia', '(GMT+02:00) Sofia'),
(64, 'Europe/Tallinn', '(GMT+02:00) Tallinn'),
(65, 'Europe/Vilnius', '(GMT+02:00) Vilnius'),
(66, 'Asia/Baghdad', '(GMT+03:00) Baghdad'),
(67, 'Asia/Kuwait', '(GMT+03:00) Kuwait'),
(68, 'Africa/Nairobi', '(GMT+03:00) Nairobi'),
(69, 'Asia/Riyadh', '(GMT+03:00) Riyadh'),
(70, 'Asia/Tehran', '(GMT+03:30) Tehran'),
(71, 'Europe/Moscow', '(GMT+04:00) Moscow'),
(72, 'Asia/Baku', '(GMT+04:00) Baku'),
(73, 'Europe/Volgograd', '(GMT+04:00) Volgograd'),
(74, 'Asia/Muscat', '(GMT+04:00) Muscat'),
(75, 'Asia/Tbilisi', '(GMT+04:00) Tbilisi'),
(76, 'Asia/Yerevan', '(GMT+04:00) Yerevan'),
(77, 'Asia/Kabul', '(GMT+04:30) Kabul'),
(78, 'Asia/Karachi', '(GMT+05:00) Karachi'),
(79, 'Asia/Tashkent', '(GMT+05:00) Tashkent'),
(80, 'Asia/Kolkata', '(GMT+05:30) Kolkata'),
(81, 'Asia/Kathmandu', '(GMT+05:45) Kathmandu'),
(82, 'Asia/Yekaterinburg', '(GMT+06:00) Ekaterinburg'),
(83, 'Asia/Almaty', '(GMT+06:00) Almaty'),
(84, 'Asia/Dhaka', '(GMT+06:00) Dhaka'),
(85, 'Asia/Novosibirsk', '(GMT+07:00) Novosibirsk'),
(86, 'Asia/Bangkok', '(GMT+07:00) Bangkok'),
(87, 'Asia/Ho_Chi_Minh', '(GMT+07.00) Ho Chi Minh'),
(88, 'Asia/Jakarta', '(GMT+07:00) Jakarta'),
(89, 'Asia/Krasnoyarsk', '(GMT+08:00) Krasnoyarsk'),
(90, 'Asia/Chongqing', '(GMT+08:00) Chongqing'),
(91, 'Asia/Hong_Kong', '(GMT+08:00) Hong Kong'),
(92, 'Asia/Kuala_Lumpur', '(GMT+08:00) Kuala Lumpur'),
(93, 'Australia/Perth', '(GMT+08:00) Perth'),
(94, 'Asia/Singapore', '(GMT+08:00) Singapore'),
(95, 'Asia/Taipei', '(GMT+08:00) Taipei'),
(96, 'Asia/Ulaanbaatar', '(GMT+08:00) Ulaan Bataar'),
(97, 'Asia/Urumqi', '(GMT+08:00) Urumqi'),
(98, 'Asia/Irkutsk', '(GMT+09:00) Irkutsk'),
(99, 'Asia/Seoul', '(GMT+09:00) Seoul'),
(100, 'Asia/Tokyo', '(GMT+09:00) Tokyo'),
(101, 'Australia/Adelaide', '(GMT+09:30) Adelaide'),
(102, 'Australia/Darwin', '(GMT+09:30) Darwin'),
(103, 'Asia/Yakutsk', '(GMT+10:00) Yakutsk'),
(104, 'Australia/Brisbane', '(GMT+10:00) Brisbane'),
(105, 'Australia/Canberra', '(GMT+10:00) Canberra'),
(106, 'Pacific/Guam', '(GMT+10:00) Guam'),
(107, 'Australia/Hobart', '(GMT+10:00) Hobart'),
(108, 'Australia/Melbourne', '(GMT+10:00) Melbourne'),
(109, 'Pacific/Port_Moresby', '(GMT+10:00) Port Moresby'),
(110, 'Australia/Sydney', '(GMT+10:00) Sydney'),
(111, 'Asia/Vladivostok', '(GMT+11:00) Vladivostok'),
(112, 'Asia/Magadan', '(GMT+12:00) Magadan'),
(113, 'Pacific/Auckland', '(GMT+12:00) Auckland'),
(114, 'Pacific/Fiji', '(GMT+12:00) Fiji');

-- --------------------------------------------------------

--
-- Table structure for table `time_format`
--

CREATE TABLE `time_format` (
  `id` int(10) UNSIGNED NOT NULL,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `time_format`
--

INSERT INTO `time_format` (`id`, `format`) VALUES
(1, 'H:i:s'),
(2, 'H.i.s');

-- --------------------------------------------------------

--
-- Stand-in structure for view `unanswered_tickets`
-- (See below for the actual view)
--
CREATE TABLE `unanswered_tickets` (
`id` int(10) unsigned
,`ticket_number` varchar(255)
,`duedate` datetime
,`dept_id` int(10) unsigned
,`assignedTo` int(10) unsigned
,`statusID` int(10) unsigned
,`isanswered` int(11)
,`isoverdue` int(11)
,`is_deleted` int(11)
,`is_transferred` tinyint(1)
,`follow_up` int(11)
,`closed` int(11)
,`reopened` int(11)
,`ticket_subject` varchar(255)
,`thread_id` int(10) unsigned
,`owner` text
,`assigned_to` text
,`status` varchar(255)
,`last_activity` timestamp
,`priority_color` varchar(255)
,`priority` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `unassigned_tickets`
-- (See below for the actual view)
--
CREATE TABLE `unassigned_tickets` (
`id` int(10) unsigned
,`ticket_number` varchar(255)
,`duedate` datetime
,`dept_id` int(10) unsigned
,`assignedTo` int(10) unsigned
,`statusID` int(10) unsigned
,`isanswered` int(11)
,`isoverdue` int(11)
,`is_deleted` int(11)
,`is_transferred` tinyint(1)
,`follow_up` int(11)
,`closed` int(11)
,`reopened` int(11)
,`ticket_subject` varchar(255)
,`thread_id` int(10) unsigned
,`owner` text
,`assigned_to` text
,`status` varchar(255)
,`last_activity` timestamp
,`priority_color` varchar(255)
,`priority` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ban` tinyint(1) NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `ext` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` int(11) NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `agent_sign` text COLLATE utf8_unicode_ci NOT NULL,
  `account_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assign_group` int(10) UNSIGNED DEFAULT NULL,
  `primary_dpt` int(10) UNSIGNED DEFAULT NULL,
  `agent_tzone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `daylight_save` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `limit_access` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `directory_listing` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vacation_mode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internal_note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_pic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_language` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `first_name`, `last_name`, `gender`, `email`, `ban`, `password`, `active`, `is_delete`, `ext`, `country_code`, `phone_number`, `mobile`, `agent_sign`, `account_type`, `account_status`, `assign_group`, `primary_dpt`, `agent_tzone`, `daylight_save`, `limit_access`, `directory_listing`, `vacation_mode`, `company`, `role`, `internal_note`, `profile_pic`, `remember_token`, `created_at`, `updated_at`, `user_language`) VALUES
(1, 'admin', 'System', 'Administrator', 0, 'faveo@example.com', 0, '$2y$10$q8vNrXf5V5W8sTSMjzqSMu/EtaDJpHVPXgumzpcSxzwtbokoajRl.', 1, 0, '', 0, '', NULL, '', '', '', 1, 1, '1', '', '', '', '', '', 'admin', '', '', '85HvefxOUILzf6ps3gNAvrwiuRALivH6ChIHElLZfRWYeGmwUJw4p2rtMDgu', '2021-11-23 13:25:14', '2022-02-25 10:11:17', NULL),
(2, 'user1', 'Alfred', 'King', 0, 'king@example.com', 0, '$2y$10$jBVCzlG8/A3F84CEPYxvzee.Ba2yWccALDRCQMjzFYLUSktcANjRC', 1, 0, '', 0, '', NULL, '', '', '', 1, 1, '1', '', '', '', '', '', 'agent', '', '', NULL, '2022-02-25 10:03:03', '2022-02-25 10:10:19', NULL),
(3, 'user2', 'Julian', 'Wagle', 0, 'wagle@example.com', 0, '$2y$10$jBVCzlG8/A3F84CEPYxvzee.Ba2yWccALDRCQMjzFYLUSktcANjRC', 1, 0, '', 0, '', NULL, '', '', '', 1, 1, '1', '', '', '', '', '', 'agent', '', '', NULL, '2022-02-25 10:03:03', '2022-02-25 10:10:58', NULL),
(4, 'user3', 'Miriam', 'Odemba', 0, 'odemba@example.com', 0, '$2y$10$jBVCzlG8/A3F84CEPYxvzee.Ba2yWccALDRCQMjzFYLUSktcANjRC', 1, 0, '', 0, '', NULL, '', '', '', 1, 1, '', '', '', '', '', '', 'agent', '', '', NULL, '2022-02-25 10:03:03', '2022-02-25 10:03:03', NULL),
(5, 'user4', 'John', 'Snow', 0, 'snow@example.com', 0, '$2y$10$jBVCzlG8/A3F84CEPYxvzee.Ba2yWccALDRCQMjzFYLUSktcANjRC', 1, 0, '', 0, '', NULL, '', '', '', 1, 1, '', '', '', '', '', '', 'agent', '', '', NULL, '2022-02-25 10:03:03', '2022-02-25 10:03:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_additional_infos`
--

CREATE TABLE `user_additional_infos` (
  `id` int(10) UNSIGNED NOT NULL,
  `owner` int(11) NOT NULL,
  `service` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_assign_organization`
--

CREATE TABLE `user_assign_organization` (
  `id` int(10) UNSIGNED NOT NULL,
  `org_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE `user_notification` (
  `id` int(10) UNSIGNED NOT NULL,
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_read` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_notification`
--

INSERT INTO `user_notification` (`id`, `notification_id`, `user_id`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 0, '2022-02-25 10:11:33', '2022-02-25 10:11:33'),
(2, 1, 3, 0, '2022-02-25 10:11:33', '2022-02-25 10:11:33'),
(3, 1, 4, 0, '2022-02-25 10:11:33', '2022-02-25 10:11:33'),
(4, 1, 5, 0, '2022-02-25 10:11:33', '2022-02-25 10:11:33'),
(5, 1, 1, 1, '2022-02-25 10:11:33', '2022-03-01 12:45:58'),
(6, 2, 2, 0, '2022-02-25 10:15:31', '2022-02-25 10:15:31'),
(7, 2, 3, 0, '2022-02-25 10:15:31', '2022-02-25 10:15:31'),
(8, 2, 4, 0, '2022-02-25 10:15:31', '2022-02-25 10:15:31'),
(9, 2, 5, 0, '2022-02-25 10:15:31', '2022-02-25 10:15:31'),
(10, 2, 1, 1, '2022-02-25 10:15:31', '2022-03-01 12:45:55'),
(11, 3, 2, 0, '2022-02-25 10:16:48', '2022-02-25 10:16:48'),
(12, 3, 3, 0, '2022-02-25 10:16:48', '2022-02-25 10:16:48'),
(13, 3, 4, 0, '2022-02-25 10:16:48', '2022-02-25 10:16:48'),
(14, 3, 5, 0, '2022-02-25 10:16:48', '2022-02-25 10:16:48'),
(15, 3, 1, 1, '2022-02-25 10:16:48', '2022-02-28 06:25:02'),
(16, 4, 2, 0, '2022-02-28 05:07:09', '2022-02-28 05:07:09'),
(17, 4, 3, 0, '2022-02-28 05:07:09', '2022-02-28 05:07:09'),
(18, 4, 4, 0, '2022-02-28 05:07:09', '2022-02-28 05:07:09'),
(19, 4, 5, 0, '2022-02-28 05:07:09', '2022-02-28 05:07:09'),
(20, 4, 1, 1, '2022-02-28 05:07:09', '2022-02-28 06:25:00'),
(21, 5, 2, 0, '2022-02-28 05:32:11', '2022-02-28 05:32:11'),
(22, 5, 3, 0, '2022-02-28 05:32:11', '2022-02-28 05:32:11'),
(23, 5, 4, 0, '2022-02-28 05:32:11', '2022-02-28 05:32:11'),
(24, 5, 5, 0, '2022-02-28 05:32:11', '2022-02-28 05:32:11'),
(25, 5, 1, 1, '2022-02-28 05:32:11', '2022-02-28 06:24:58'),
(26, 6, 2, 0, '2022-03-01 09:25:43', '2022-03-01 09:25:43'),
(27, 6, 3, 0, '2022-03-01 09:25:43', '2022-03-01 09:25:43'),
(28, 6, 4, 0, '2022-03-01 09:25:43', '2022-03-01 09:25:43'),
(29, 6, 5, 0, '2022-03-01 09:25:43', '2022-03-01 09:25:43'),
(30, 6, 1, 1, '2022-03-01 09:25:43', '2022-03-01 12:45:53'),
(31, 7, 2, 0, '2022-03-01 09:47:59', '2022-03-01 09:47:59'),
(32, 7, 3, 0, '2022-03-01 09:47:59', '2022-03-01 09:47:59'),
(33, 7, 4, 0, '2022-03-01 09:47:59', '2022-03-01 09:47:59'),
(34, 7, 5, 0, '2022-03-01 09:47:59', '2022-03-01 09:47:59'),
(35, 7, 1, 1, '2022-03-01 09:47:59', '2022-03-01 12:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `version_check`
--

CREATE TABLE `version_check` (
  `id` int(10) UNSIGNED NOT NULL,
  `current_version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `new_version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `version_check`
--

INSERT INTO `version_check` (`id`, `current_version`, `new_version`, `created_at`, `updated_at`) VALUES
(1, '', '', '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `widgets`
--

CREATE TABLE `widgets` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `widgets`
--

INSERT INTO `widgets` (`id`, `name`, `title`, `value`, `created_at`, `updated_at`) VALUES
(1, 'footer1', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(2, 'footer2', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(3, 'footer3', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(4, 'footer4', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(7, 'linkedin', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(8, 'stumble', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(9, 'google', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(10, 'deviantart', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(11, 'flickr', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(12, 'skype', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(13, 'rss', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(14, 'twitter', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(15, 'facebook', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(16, 'youtube', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(17, 'vimeo', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(18, 'pinterest', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(19, 'dribbble', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14'),
(20, 'instagram', NULL, NULL, '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `workflow_action`
--

CREATE TABLE `workflow_action` (
  `id` int(10) UNSIGNED NOT NULL,
  `workflow_id` int(10) UNSIGNED NOT NULL,
  `condition` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workflow_close`
--

CREATE TABLE `workflow_close` (
  `id` int(10) UNSIGNED NOT NULL,
  `days` int(11) NOT NULL,
  `condition` int(11) NOT NULL,
  `send_email` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `workflow_close`
--

INSERT INTO `workflow_close` (`id`, `days`, `condition`, `send_email`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 3, '2021-11-23 13:25:14', '2021-11-23 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `workflow_name`
--

CREATE TABLE `workflow_name` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `target` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internal_note` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workflow_rules`
--

CREATE TABLE `workflow_rules` (
  `id` int(10) UNSIGNED NOT NULL,
  `workflow_id` int(10) UNSIGNED NOT NULL,
  `matching_criteria` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `matching_scenario` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `matching_relation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `matching_value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `answered_tickets`
--
DROP TABLE IF EXISTS `answered_tickets`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `answered_tickets`  AS  select `ttd`.`id` AS `id`,`ttd`.`ticket_number` AS `ticket_number`,`ttd`.`duedate` AS `duedate`,`ttd`.`dept_id` AS `dept_id`,`ttd`.`assignedTo` AS `assignedTo`,`ttd`.`statusID` AS `statusID`,`ttd`.`isanswered` AS `isanswered`,`ttd`.`isoverdue` AS `isoverdue`,`ttd`.`is_deleted` AS `is_deleted`,`ttd`.`is_transferred` AS `is_transferred`,`ttd`.`follow_up` AS `follow_up`,`ttd`.`closed` AS `closed`,`ttd`.`reopened` AS `reopened`,`ttd`.`ticket_subject` AS `ticket_subject`,`ttd`.`thread_id` AS `thread_id`,`ttd`.`owner` AS `owner`,`ttd`.`assigned_to` AS `assigned_to`,`ttd`.`status` AS `status`,`ttd`.`last_activity` AS `last_activity`,`ttd`.`priority_color` AS `priority_color`,`ttd`.`priority` AS `priority` from `tickets_detailed` `ttd` where `ttd`.`closed` <> 1 and `ttd`.`isanswered` = 1 and `ttd`.`is_deleted` = 0 order by `ttd`.`id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `assigned_tickets`
--
DROP TABLE IF EXISTS `assigned_tickets`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `assigned_tickets`  AS  select `ttd`.`id` AS `id`,`ttd`.`ticket_number` AS `ticket_number`,`ttd`.`duedate` AS `duedate`,`ttd`.`dept_id` AS `dept_id`,`ttd`.`assignedTo` AS `assignedTo`,`ttd`.`statusID` AS `statusID`,`ttd`.`isanswered` AS `isanswered`,`ttd`.`isoverdue` AS `isoverdue`,`ttd`.`is_deleted` AS `is_deleted`,`ttd`.`is_transferred` AS `is_transferred`,`ttd`.`follow_up` AS `follow_up`,`ttd`.`closed` AS `closed`,`ttd`.`reopened` AS `reopened`,`ttd`.`ticket_subject` AS `ticket_subject`,`ttd`.`thread_id` AS `thread_id`,`ttd`.`owner` AS `owner`,`ttd`.`assigned_to` AS `assigned_to`,`ttd`.`status` AS `status`,`ttd`.`last_activity` AS `last_activity`,`ttd`.`priority_color` AS `priority_color`,`ttd`.`priority` AS `priority` from `tickets_detailed` `ttd` where `ttd`.`assignedTo` is not null and `ttd`.`is_deleted` = 0 order by `ttd`.`id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `closed_tickets`
--
DROP TABLE IF EXISTS `closed_tickets`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `closed_tickets`  AS  select `ttd`.`id` AS `id`,`ttd`.`ticket_number` AS `ticket_number`,`ttd`.`duedate` AS `duedate`,`ttd`.`dept_id` AS `dept_id`,`ttd`.`assignedTo` AS `assignedTo`,`ttd`.`statusID` AS `statusID`,`ttd`.`isanswered` AS `isanswered`,`ttd`.`isoverdue` AS `isoverdue`,`ttd`.`is_deleted` AS `is_deleted`,`ttd`.`is_transferred` AS `is_transferred`,`ttd`.`follow_up` AS `follow_up`,`ttd`.`closed` AS `closed`,`ttd`.`reopened` AS `reopened`,`ttd`.`ticket_subject` AS `ticket_subject`,`ttd`.`thread_id` AS `thread_id`,`ttd`.`owner` AS `owner`,`ttd`.`assigned_to` AS `assigned_to`,`ttd`.`status` AS `status`,`ttd`.`last_activity` AS `last_activity`,`ttd`.`priority_color` AS `priority_color`,`ttd`.`priority` AS `priority` from `tickets_detailed` `ttd` where `ttd`.`closed` = 1 and `ttd`.`is_deleted` = 0 order by `ttd`.`id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `closed_tickets_per_department`
--
DROP TABLE IF EXISTS `closed_tickets_per_department`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `closed_tickets_per_department`  AS  select `ttd`.`id` AS `id`,`ttd`.`ticket_number` AS `ticket_number`,`ttd`.`duedate` AS `duedate`,`ttd`.`dept_id` AS `dept_id`,`ttd`.`assignedTo` AS `assignedTo`,`ttd`.`statusID` AS `statusID`,`ttd`.`isanswered` AS `isanswered`,`ttd`.`isoverdue` AS `isoverdue`,`ttd`.`is_deleted` AS `is_deleted`,`ttd`.`is_transferred` AS `is_transferred`,`ttd`.`follow_up` AS `follow_up`,`ttd`.`closed` AS `closed`,`ttd`.`reopened` AS `reopened`,`ttd`.`ticket_subject` AS `ticket_subject`,`ttd`.`thread_id` AS `thread_id`,`ttd`.`owner` AS `owner`,`ttd`.`assigned_to` AS `assigned_to`,`ttd`.`status` AS `status`,`ttd`.`last_activity` AS `last_activity`,`ttd`.`priority_color` AS `priority_color`,`ttd`.`priority` AS `priority` from `tickets_detailed` `ttd` where `ttd`.`closed` = 1 and `ttd`.`statusID` <> 2 and `ttd`.`is_deleted` = 0 order by `ttd`.`id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `deleted_tickets`
--
DROP TABLE IF EXISTS `deleted_tickets`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `deleted_tickets`  AS  select `ttd`.`id` AS `id`,`ttd`.`ticket_number` AS `ticket_number`,`ttd`.`duedate` AS `duedate`,`ttd`.`dept_id` AS `dept_id`,`ttd`.`assignedTo` AS `assignedTo`,`ttd`.`statusID` AS `statusID`,`ttd`.`isanswered` AS `isanswered`,`ttd`.`isoverdue` AS `isoverdue`,`ttd`.`is_deleted` AS `is_deleted`,`ttd`.`is_transferred` AS `is_transferred`,`ttd`.`follow_up` AS `follow_up`,`ttd`.`closed` AS `closed`,`ttd`.`reopened` AS `reopened`,`ttd`.`ticket_subject` AS `ticket_subject`,`ttd`.`thread_id` AS `thread_id`,`ttd`.`owner` AS `owner`,`ttd`.`assigned_to` AS `assigned_to`,`ttd`.`status` AS `status`,`ttd`.`last_activity` AS `last_activity`,`ttd`.`priority_color` AS `priority_color`,`ttd`.`priority` AS `priority` from `tickets_detailed` `ttd` where `ttd`.`is_deleted` = 1 order by `ttd`.`id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `follow_up_tickets`
--
DROP TABLE IF EXISTS `follow_up_tickets`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `follow_up_tickets`  AS  select `ttd`.`id` AS `id`,`ttd`.`ticket_number` AS `ticket_number`,`ttd`.`duedate` AS `duedate`,`ttd`.`dept_id` AS `dept_id`,`ttd`.`assignedTo` AS `assignedTo`,`ttd`.`statusID` AS `statusID`,`ttd`.`isanswered` AS `isanswered`,`ttd`.`isoverdue` AS `isoverdue`,`ttd`.`is_deleted` AS `is_deleted`,`ttd`.`is_transferred` AS `is_transferred`,`ttd`.`follow_up` AS `follow_up`,`ttd`.`closed` AS `closed`,`ttd`.`reopened` AS `reopened`,`ttd`.`ticket_subject` AS `ticket_subject`,`ttd`.`thread_id` AS `thread_id`,`ttd`.`owner` AS `owner`,`ttd`.`assigned_to` AS `assigned_to`,`ttd`.`status` AS `status`,`ttd`.`last_activity` AS `last_activity`,`ttd`.`priority_color` AS `priority_color`,`ttd`.`priority` AS `priority` from `tickets_detailed` `ttd` where `ttd`.`statusID` = 1 and `ttd`.`follow_up` = 1 and `ttd`.`is_deleted` = 0 order by `ttd`.`id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `open_tickets_per_department`
--
DROP TABLE IF EXISTS `open_tickets_per_department`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `open_tickets_per_department`  AS  select `ttd`.`id` AS `id`,`ttd`.`ticket_number` AS `ticket_number`,`ttd`.`duedate` AS `duedate`,`ttd`.`dept_id` AS `dept_id`,`ttd`.`assignedTo` AS `assignedTo`,`ttd`.`statusID` AS `statusID`,`ttd`.`isanswered` AS `isanswered`,`ttd`.`isoverdue` AS `isoverdue`,`ttd`.`is_deleted` AS `is_deleted`,`ttd`.`is_transferred` AS `is_transferred`,`ttd`.`follow_up` AS `follow_up`,`ttd`.`closed` AS `closed`,`ttd`.`reopened` AS `reopened`,`ttd`.`ticket_subject` AS `ticket_subject`,`ttd`.`thread_id` AS `thread_id`,`ttd`.`owner` AS `owner`,`ttd`.`assigned_to` AS `assigned_to`,`ttd`.`status` AS `status`,`ttd`.`last_activity` AS `last_activity`,`ttd`.`priority_color` AS `priority_color`,`ttd`.`priority` AS `priority` from `tickets_detailed` `ttd` where `ttd`.`closed` <> 1 and `ttd`.`is_deleted` = 0 order by `ttd`.`id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `reopened_tickets`
--
DROP TABLE IF EXISTS `reopened_tickets`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reopened_tickets`  AS  select `ttd`.`id` AS `id`,`ttd`.`ticket_number` AS `ticket_number`,`ttd`.`duedate` AS `duedate`,`ttd`.`dept_id` AS `dept_id`,`ttd`.`assignedTo` AS `assignedTo`,`ttd`.`statusID` AS `statusID`,`ttd`.`isanswered` AS `isanswered`,`ttd`.`isoverdue` AS `isoverdue`,`ttd`.`is_deleted` AS `is_deleted`,`ttd`.`is_transferred` AS `is_transferred`,`ttd`.`follow_up` AS `follow_up`,`ttd`.`closed` AS `closed`,`ttd`.`reopened` AS `reopened`,`ttd`.`ticket_subject` AS `ticket_subject`,`ttd`.`thread_id` AS `thread_id`,`ttd`.`owner` AS `owner`,`ttd`.`assigned_to` AS `assigned_to`,`ttd`.`status` AS `status`,`ttd`.`last_activity` AS `last_activity`,`ttd`.`priority_color` AS `priority_color`,`ttd`.`priority` AS `priority` from `tickets_detailed` `ttd` where `ttd`.`reopened` = 1 and `ttd`.`is_deleted` = 0 order by `ttd`.`id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `resolved_tickets_per_department`
--
DROP TABLE IF EXISTS `resolved_tickets_per_department`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `resolved_tickets_per_department`  AS  select `ttd`.`id` AS `id`,`ttd`.`ticket_number` AS `ticket_number`,`ttd`.`duedate` AS `duedate`,`ttd`.`dept_id` AS `dept_id`,`ttd`.`assignedTo` AS `assignedTo`,`ttd`.`statusID` AS `statusID`,`ttd`.`isanswered` AS `isanswered`,`ttd`.`isoverdue` AS `isoverdue`,`ttd`.`is_deleted` AS `is_deleted`,`ttd`.`is_transferred` AS `is_transferred`,`ttd`.`follow_up` AS `follow_up`,`ttd`.`closed` AS `closed`,`ttd`.`reopened` AS `reopened`,`ttd`.`ticket_subject` AS `ticket_subject`,`ttd`.`thread_id` AS `thread_id`,`ttd`.`owner` AS `owner`,`ttd`.`assigned_to` AS `assigned_to`,`ttd`.`status` AS `status`,`ttd`.`last_activity` AS `last_activity`,`ttd`.`priority_color` AS `priority_color`,`ttd`.`priority` AS `priority` from `tickets_detailed` `ttd` where `ttd`.`closed` = 1 and `ttd`.`statusID` = 2 and `ttd`.`is_deleted` = 0 order by `ttd`.`id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `tickets_detailed`
--
DROP TABLE IF EXISTS `tickets_detailed`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tickets_detailed`  AS  select `tic`.`id` AS `id`,`tic`.`ticket_number` AS `ticket_number`,`tic`.`duedate` AS `duedate`,`tic`.`dept_id` AS `dept_id`,`tic`.`assigned_to` AS `assignedTo`,`tic`.`status` AS `statusID`,`tic`.`isanswered` AS `isanswered`,`tic`.`isoverdue` AS `isoverdue`,`tic`.`is_deleted` AS `is_deleted`,`tic`.`is_transferred` AS `is_transferred`,`tic`.`follow_up` AS `follow_up`,`tic`.`closed` AS `closed`,`tic`.`reopened` AS `reopened`,`ttr`.`title` AS `ticket_subject`,`ttr`.`id` AS `thread_id`,concat(`usr`.`first_name`,' ',`usr`.`last_name`,' <',`usr`.`email`,'> ') AS `owner`,concat(`usrr`.`first_name`,' ',`usrr`.`last_name`,' <',`usrr`.`email`,'> ') AS `assigned_to`,`tics`.`name` AS `status`,`ttr`.`created_at` AS `last_activity`,`ticp`.`priority_color` AS `priority_color`,`ticp`.`priority` AS `priority` from (((((`tickets` `tic` join `users` `usr` on(`tic`.`user_id` = `usr`.`id`)) join `ticket_thread` `ttr` on(`tic`.`id` = `ttr`.`ticket_id` and `ttr`.`poster` = 'client')) join `ticket_status` `tics` on(`tic`.`status` = `tics`.`id`)) join `ticket_priority` `ticp` on(`tic`.`priority_id` = `ticp`.`priority_id`)) left join `users` `usrr` on(`tic`.`assigned_to` = `usrr`.`id`)) order by `tic`.`id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `unanswered_tickets`
--
DROP TABLE IF EXISTS `unanswered_tickets`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `unanswered_tickets`  AS  select `ttd`.`id` AS `id`,`ttd`.`ticket_number` AS `ticket_number`,`ttd`.`duedate` AS `duedate`,`ttd`.`dept_id` AS `dept_id`,`ttd`.`assignedTo` AS `assignedTo`,`ttd`.`statusID` AS `statusID`,`ttd`.`isanswered` AS `isanswered`,`ttd`.`isoverdue` AS `isoverdue`,`ttd`.`is_deleted` AS `is_deleted`,`ttd`.`is_transferred` AS `is_transferred`,`ttd`.`follow_up` AS `follow_up`,`ttd`.`closed` AS `closed`,`ttd`.`reopened` AS `reopened`,`ttd`.`ticket_subject` AS `ticket_subject`,`ttd`.`thread_id` AS `thread_id`,`ttd`.`owner` AS `owner`,`ttd`.`assigned_to` AS `assigned_to`,`ttd`.`status` AS `status`,`ttd`.`last_activity` AS `last_activity`,`ttd`.`priority_color` AS `priority_color`,`ttd`.`priority` AS `priority` from `tickets_detailed` `ttd` where `ttd`.`closed` <> 1 and `ttd`.`isanswered` = 0 and `ttd`.`is_deleted` = 0 order by `ttd`.`id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `unassigned_tickets`
--
DROP TABLE IF EXISTS `unassigned_tickets`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `unassigned_tickets`  AS  select `ttd`.`id` AS `id`,`ttd`.`ticket_number` AS `ticket_number`,`ttd`.`duedate` AS `duedate`,`ttd`.`dept_id` AS `dept_id`,`ttd`.`assignedTo` AS `assignedTo`,`ttd`.`statusID` AS `statusID`,`ttd`.`isanswered` AS `isanswered`,`ttd`.`isoverdue` AS `isoverdue`,`ttd`.`is_deleted` AS `is_deleted`,`ttd`.`is_transferred` AS `is_transferred`,`ttd`.`follow_up` AS `follow_up`,`ttd`.`closed` AS `closed`,`ttd`.`reopened` AS `reopened`,`ttd`.`ticket_subject` AS `ticket_subject`,`ttd`.`thread_id` AS `thread_id`,`ttd`.`owner` AS `owner`,`ttd`.`assigned_to` AS `assigned_to`,`ttd`.`status` AS `status`,`ttd`.`last_activity` AS `last_activity`,`ttd`.`priority_color` AS `priority_color`,`ttd`.`priority` AS `priority` from `tickets_detailed` `ttd` where `ttd`.`assignedTo` is null and `ttd`.`is_deleted` = 0 order by `ttd`.`id` desc ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_settings`
--
ALTER TABLE `api_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banlist`
--
ALTER TABLE `banlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bar_notifications`
--
ALTER TABLE `bar_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `canned_response`
--
ALTER TABLE `canned_response`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `common_settings`
--
ALTER TABLE `common_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conditions`
--
ALTER TABLE `conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country_code`
--
ALTER TABLE `country_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_forms`
--
ALTER TABLE `custom_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_form_fields`
--
ALTER TABLE `custom_form_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `date_format`
--
ALTER TABLE `date_format`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `date_time_format`
--
ALTER TABLE `date_time_format`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sla` (`sla`),
  ADD KEY `manager_2` (`manager`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department` (`department`,`priority`,`help_topic`),
  ADD KEY `department_2` (`department`,`priority`,`help_topic`),
  ADD KEY `priority` (`priority`),
  ADD KEY `help_topic` (`help_topic`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faveo_mails`
--
ALTER TABLE `faveo_mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faveo_queues`
--
ALTER TABLE `faveo_queues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `field_values`
--
ALTER TABLE `field_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `field_values_field_id_foreign` (`field_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_assign_department`
--
ALTER TABLE `group_assign_department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `help_topic`
--
ALTER TABLE `help_topic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_form` (`custom_form`),
  ADD KEY `department` (`department`),
  ADD KEY `ticket_status` (`ticket_status`),
  ADD KEY `priority` (`priority`),
  ADD KEY `sla_plan` (`sla_plan`),
  ADD KEY `auto_assign_2` (`auto_assign`);

--
-- Indexes for table `immigration_offices`
--
ALTER TABLE `immigration_offices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `immigration_offices_key_unique` (`Key`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_reserved_at_index` (`queue`,`reserved`,`reserved_at`);

--
-- Indexes for table `kb_article`
--
ALTER TABLE `kb_article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kb_article_relationship`
--
ALTER TABLE `kb_article_relationship`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_relationship_article_id_foreign` (`article_id`),
  ADD KEY `article_relationship_category_id_foreign` (`category_id`);

--
-- Indexes for table `kb_category`
--
ALTER TABLE `kb_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kb_comment`
--
ALTER TABLE `kb_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_article_id_foreign` (`article_id`);

--
-- Indexes for table `kb_pages`
--
ALTER TABLE `kb_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kb_settings`
--
ALTER TABLE `kb_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_notification`
--
ALTER TABLE `log_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mailbox_protocol`
--
ALTER TABLE `mailbox_protocol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_services`
--
ALTER TABLE `mail_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_types`
--
ALTER TABLE `notification_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`),
  ADD KEY `head` (`head`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `plugins`
--
ALTER TABLE `plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue_services`
--
ALTER TABLE `queue_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating_ref`
--
ALTER TABLE `rating_ref`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings_alert_notice`
--
ALTER TABLE `settings_alert_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings_auto_response`
--
ALTER TABLE `settings_auto_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings_company`
--
ALTER TABLE `settings_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings_email`
--
ALTER TABLE `settings_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings_ratings`
--
ALTER TABLE `settings_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_ratings_slug_unique` (`slug`);

--
-- Indexes for table `settings_security`
--
ALTER TABLE `settings_security`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings_system`
--
ALTER TABLE `settings_system`
  ADD PRIMARY KEY (`id`),
  ADD KEY `time_farmat` (`time_farmat`),
  ADD KEY `date_format` (`date_format`),
  ADD KEY `date_time_format` (`date_time_format`),
  ADD KEY `time_zone` (`time_zone`);

--
-- Indexes for table `settings_ticket`
--
ALTER TABLE `settings_ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sla_plan`
--
ALTER TABLE `sla_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_media`
--
ALTER TABLE `social_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_lead` (`team_lead`);

--
-- Indexes for table `team_assignments`
--
ALTER TABLE `team_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_assignments_from_team_id_index` (`from_team_id`),
  ADD KEY `team_assignments_to_team_id_index` (`to_team_id`);

--
-- Indexes for table `team_assign_agent`
--
ALTER TABLE `team_assign_agent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `agent_id` (`agent_id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_sets`
--
ALTER TABLE `template_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_types`
--
ALTER TABLE `template_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `priority_id` (`priority_id`),
  ADD KEY `sla` (`sla`),
  ADD KEY `help_topic_id` (`help_topic_id`),
  ADD KEY `status` (`status`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `source` (`source`),
  ADD KEY `fk_immigration_office_id_tickets1_idx` (`immigration_office_id`);

--
-- Indexes for table `ticket_attachment`
--
ALTER TABLE `ticket_attachment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thread_id` (`thread_id`);

--
-- Indexes for table `ticket_collaborator`
--
ALTER TABLE `ticket_collaborator`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ticket_form_data`
--
ALTER TABLE `ticket_form_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `ticket_priority`
--
ALTER TABLE `ticket_priority`
  ADD PRIMARY KEY (`priority_id`);

--
-- Indexes for table `ticket_source`
--
ALTER TABLE `ticket_source`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_status`
--
ALTER TABLE `ticket_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_thread`
--
ALTER TABLE `ticket_thread`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id_2` (`ticket_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `source` (`source`);

--
-- Indexes for table `ticket_token`
--
ALTER TABLE `ticket_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timezone`
--
ALTER TABLE `timezone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_format`
--
ALTER TABLE `time_format`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`),
  ADD KEY `assign_group_3` (`assign_group`),
  ADD KEY `primary_dpt_2` (`primary_dpt`);

--
-- Indexes for table `user_additional_infos`
--
ALTER TABLE `user_additional_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_assign_organization`
--
ALTER TABLE `user_assign_organization`
  ADD PRIMARY KEY (`id`),
  ADD KEY `org_id` (`org_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_notification`
--
ALTER TABLE `user_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `version_check`
--
ALTER TABLE `version_check`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widgets`
--
ALTER TABLE `widgets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workflow_action`
--
ALTER TABLE `workflow_action`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workflow_action_1` (`workflow_id`);

--
-- Indexes for table `workflow_close`
--
ALTER TABLE `workflow_close`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workflow_name`
--
ALTER TABLE `workflow_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workflow_rules`
--
ALTER TABLE `workflow_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workflow_rules_1` (`workflow_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_settings`
--
ALTER TABLE `api_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banlist`
--
ALTER TABLE `banlist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bar_notifications`
--
ALTER TABLE `bar_notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `canned_response`
--
ALTER TABLE `canned_response`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `common_settings`
--
ALTER TABLE `common_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `conditions`
--
ALTER TABLE `conditions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country_code`
--
ALTER TABLE `country_code`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `custom_forms`
--
ALTER TABLE `custom_forms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_form_fields`
--
ALTER TABLE `custom_form_fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `date_format`
--
ALTER TABLE `date_format`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `date_time_format`
--
ALTER TABLE `date_time_format`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faveo_mails`
--
ALTER TABLE `faveo_mails`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faveo_queues`
--
ALTER TABLE `faveo_queues`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `field_values`
--
ALTER TABLE `field_values`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `group_assign_department`
--
ALTER TABLE `group_assign_department`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `help_topic`
--
ALTER TABLE `help_topic`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `immigration_offices`
--
ALTER TABLE `immigration_offices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `kb_article`
--
ALTER TABLE `kb_article`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kb_article_relationship`
--
ALTER TABLE `kb_article_relationship`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kb_category`
--
ALTER TABLE `kb_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kb_comment`
--
ALTER TABLE `kb_comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kb_pages`
--
ALTER TABLE `kb_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kb_settings`
--
ALTER TABLE `kb_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `log_notification`
--
ALTER TABLE `log_notification`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mailbox_protocol`
--
ALTER TABLE `mailbox_protocol`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mail_services`
--
ALTER TABLE `mail_services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notification_types`
--
ALTER TABLE `notification_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plugins`
--
ALTER TABLE `plugins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queue_services`
--
ALTER TABLE `queue_services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rating_ref`
--
ALTER TABLE `rating_ref`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings_alert_notice`
--
ALTER TABLE `settings_alert_notice`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings_auto_response`
--
ALTER TABLE `settings_auto_response`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings_company`
--
ALTER TABLE `settings_company`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings_email`
--
ALTER TABLE `settings_email`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings_ratings`
--
ALTER TABLE `settings_ratings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings_security`
--
ALTER TABLE `settings_security`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings_system`
--
ALTER TABLE `settings_system`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings_ticket`
--
ALTER TABLE `settings_ticket`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sla_plan`
--
ALTER TABLE `sla_plan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `social_media`
--
ALTER TABLE `social_media`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `team_assignments`
--
ALTER TABLE `team_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `team_assign_agent`
--
ALTER TABLE `team_assign_agent`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `template_sets`
--
ALTER TABLE `template_sets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `template_types`
--
ALTER TABLE `template_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ticket_attachment`
--
ALTER TABLE `ticket_attachment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_collaborator`
--
ALTER TABLE `ticket_collaborator`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_form_data`
--
ALTER TABLE `ticket_form_data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_priority`
--
ALTER TABLE `ticket_priority`
  MODIFY `priority_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ticket_source`
--
ALTER TABLE `ticket_source`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ticket_status`
--
ALTER TABLE `ticket_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ticket_thread`
--
ALTER TABLE `ticket_thread`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ticket_token`
--
ALTER TABLE `ticket_token`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timezone`
--
ALTER TABLE `timezone`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `time_format`
--
ALTER TABLE `time_format`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_additional_infos`
--
ALTER TABLE `user_additional_infos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_assign_organization`
--
ALTER TABLE `user_assign_organization`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_notification`
--
ALTER TABLE `user_notification`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `version_check`
--
ALTER TABLE `version_check`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `widgets`
--
ALTER TABLE `widgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `workflow_action`
--
ALTER TABLE `workflow_action`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workflow_close`
--
ALTER TABLE `workflow_close`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `workflow_name`
--
ALTER TABLE `workflow_name`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workflow_rules`
--
ALTER TABLE `workflow_rules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `canned_response`
--
ALTER TABLE `canned_response`
  ADD CONSTRAINT `canned_response_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`sla`) REFERENCES `sla_plan` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `department_ibfk_2` FOREIGN KEY (`manager`) REFERENCES `users` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `emails`
--
ALTER TABLE `emails`
  ADD CONSTRAINT `emails_ibfk_1` FOREIGN KEY (`department`) REFERENCES `department` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `emails_ibfk_2` FOREIGN KEY (`priority`) REFERENCES `ticket_priority` (`priority_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `emails_ibfk_3` FOREIGN KEY (`help_topic`) REFERENCES `help_topic` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `field_values`
--
ALTER TABLE `field_values`
  ADD CONSTRAINT `field_values_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `custom_form_fields` (`id`);

--
-- Constraints for table `group_assign_department`
--
ALTER TABLE `group_assign_department`
  ADD CONSTRAINT `group_assign_department_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `group_assign_department_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `help_topic`
--
ALTER TABLE `help_topic`
  ADD CONSTRAINT `help_topic_ibfk_1` FOREIGN KEY (`custom_form`) REFERENCES `custom_forms` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `help_topic_ibfk_2` FOREIGN KEY (`department`) REFERENCES `department` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `help_topic_ibfk_3` FOREIGN KEY (`ticket_status`) REFERENCES `ticket_status` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `help_topic_ibfk_4` FOREIGN KEY (`priority`) REFERENCES `ticket_priority` (`priority_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `help_topic_ibfk_5` FOREIGN KEY (`sla_plan`) REFERENCES `sla_plan` (`id`),
  ADD CONSTRAINT `help_topic_ibfk_6` FOREIGN KEY (`auto_assign`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `kb_article_relationship`
--
ALTER TABLE `kb_article_relationship`
  ADD CONSTRAINT `article_relationship_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `kb_article` (`id`),
  ADD CONSTRAINT `article_relationship_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `kb_category` (`id`);

--
-- Constraints for table `kb_comment`
--
ALTER TABLE `kb_comment`
  ADD CONSTRAINT `comment_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `kb_article` (`id`);

--
-- Constraints for table `organization`
--
ALTER TABLE `organization`
  ADD CONSTRAINT `organization_ibfk_1` FOREIGN KEY (`head`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `settings_system`
--
ALTER TABLE `settings_system`
  ADD CONSTRAINT `settings_system_ibfk_1` FOREIGN KEY (`time_zone`) REFERENCES `timezone` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `settings_system_ibfk_2` FOREIGN KEY (`time_farmat`) REFERENCES `time_format` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `settings_system_ibfk_3` FOREIGN KEY (`date_format`) REFERENCES `date_format` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `settings_system_ibfk_4` FOREIGN KEY (`date_time_format`) REFERENCES `date_time_format` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`team_lead`) REFERENCES `users` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `team_assignments`
--
ALTER TABLE `team_assignments`
  ADD CONSTRAINT `team_assignments_from_team_id_foreign` FOREIGN KEY (`from_team_id`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `team_assignments_to_team_id_foreign` FOREIGN KEY (`to_team_id`) REFERENCES `teams` (`id`);

--
-- Constraints for table `team_assign_agent`
--
ALTER TABLE `team_assign_agent`
  ADD CONSTRAINT `team_assign_agent_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `team_assign_agent_ibfk_2` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_immigration_office_id_tickets1_idx` FOREIGN KEY (`immigration_office_id`) REFERENCES `immigration_offices` (`Key`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`dept_id`) REFERENCES `department` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_4` FOREIGN KEY (`priority_id`) REFERENCES `ticket_priority` (`priority_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_5` FOREIGN KEY (`sla`) REFERENCES `sla_plan` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_6` FOREIGN KEY (`help_topic_id`) REFERENCES `help_topic` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_7` FOREIGN KEY (`status`) REFERENCES `ticket_status` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_8` FOREIGN KEY (`source`) REFERENCES `ticket_source` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_9` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `ticket_attachment`
--
ALTER TABLE `ticket_attachment`
  ADD CONSTRAINT `ticket_attachment_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `ticket_thread` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `ticket_collaborator`
--
ALTER TABLE `ticket_collaborator`
  ADD CONSTRAINT `ticket_collaborator_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `ticket_collaborator_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `ticket_form_data`
--
ALTER TABLE `ticket_form_data`
  ADD CONSTRAINT `ticket_form_data_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `ticket_thread`
--
ALTER TABLE `ticket_thread`
  ADD CONSTRAINT `ticket_thread_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `ticket_thread_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `ticket_thread_ibfk_3` FOREIGN KEY (`source`) REFERENCES `ticket_source` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`assign_group`) REFERENCES `groups` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`primary_dpt`) REFERENCES `department` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `user_assign_organization`
--
ALTER TABLE `user_assign_organization`
  ADD CONSTRAINT `user_assign_organization_ibfk_1` FOREIGN KEY (`org_id`) REFERENCES `organization` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_assign_organization_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `workflow_action`
--
ALTER TABLE `workflow_action`
  ADD CONSTRAINT `workflow_action_1` FOREIGN KEY (`workflow_id`) REFERENCES `workflow_name` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `workflow_rules`
--
ALTER TABLE `workflow_rules`
  ADD CONSTRAINT `workflow_rules_1` FOREIGN KEY (`workflow_id`) REFERENCES `workflow_name` (`id`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
