DROP TABLE IF EXISTS `tbl_business_book`;

CREATE TABLE `tbl_business_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_book_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tbl_business_book` VALUES("1","SEA-QUEEN-SALLARY"),
("2","JAMAL-COMPUTER"),
("3","WOODLAND-SALARY"),
("4","কোর্ট বিল্ডিং- আয় বিবরণী"),
("5","Anisur Rahman\'s business");



DROP TABLE IF EXISTS `tbl_ledger_book_transections`;

CREATE TABLE `tbl_ledger_book_transections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` text NOT NULL,
  `time` text NOT NULL,
  `description` text NOT NULL,
  `party_name` text NOT NULL,
  `accounts_head` text NOT NULL,
  `entry_by` text NOT NULL,
  `cash_in` int(11) NOT NULL,
  `cash_out` int(11) NOT NULL,
  `tbl_ledger_books_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=262 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tbl_ledger_book_transections` VALUES("1","06-Feb-25","2:30 PM","নগদ জমা- আবুল কালাম আজাদ","","CASH-DEPOSIT","Sea-Queen-Shipping-Agencies","50000","0","8"),
("2","15-Jun-25","11:25 AM","খোকন স্যার- নগদ অগ্রিম জমা","","","Anisur Rahman","0","200","8");



DROP TABLE IF EXISTS `tbl_ledger_books`;

CREATE TABLE `tbl_ledger_books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ledger_book_name` text NOT NULL,
  `tbl_business_book_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tbl_ledger_books` VALUES("1","SALARY-NOVEMBER-2024","1"),
("2","SALARY-DECEMBER-2024","1"),
("3","SALARY-JANUARY-2025","1"),
("4","SALARY-FEBRUARY-2025","1"),
("5","SALARY-MARCH-2025","1"),
("6","SALARY-APRIL-2025","1"),
("7","SALARY-MAY-2025","1"),
("8","SALARY-JUNE-2025","1");



DROP TABLE IF EXISTS `tbl_transection_accounts_head`;

CREATE TABLE `tbl_transection_accounts_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accounts_head_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




