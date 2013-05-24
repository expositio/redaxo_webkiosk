DROP TABLE IF EXISTS `%TABLE_PREFIX%webkiosk_bill_status`;

CREATE TABLE `%TABLE_PREFIX%webkiosk_bill_status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `final_stat` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `%TABLE_PREFIX%webkiosk_bill_status` (`id`, `name`, `final_stat`)
VALUES
  (1,'Reklamation',0),
  (2,'Versendet',0),
  (3,'Rueckfrage',0),
  (4,'Rechnungsbetrag offen',0),
  (5,'Retour',0),
  (6,'Erledigt',1);

DROP TABLE IF EXISTS `%TABLE_PREFIX%webkiosk_cats`;

CREATE TABLE `%TABLE_PREFIX%webkiosk_cats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `top_cat_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `%TABLE_PREFIX%webkiosk_orders`;

CREATE TABLE `%TABLE_PREFIX%webkiosk_orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(20) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `first_name` varchar(128) DEFAULT NULL,
  `street` varchar(128) DEFAULT NULL,
  `zip` int(5) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `state` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `tel` varchar(128) DEFAULT NULL,
  `articles` text,
  `payment` int(11) DEFAULT NULL,
  `net_sum` varchar(11) DEFAULT '',
  `gross_sum` varchar(11) DEFAULT NULL,
  `createdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT NULL,
  `shipping_date` varchar(10) DEFAULT NULL,
  `alternate_address` varchar(3) DEFAULT NULL,
  `name_alt` varchar(128) DEFAULT NULL,
  `first_name_alt` varchar(128) DEFAULT NULL,
  `street_alt` varchar(128) DEFAULT NULL,
  `zip_alt` int(5) DEFAULT NULL,
  `city_alt` varchar(128) DEFAULT NULL,
  `state_alt` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `%TABLE_PREFIX%webkiosk_payment_methods`;

CREATE TABLE `%TABLE_PREFIX%webkiosk_payment_methods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `%TABLE_PREFIX%webkiosk_payment_methods` (`id`, `name`)
VALUES
  (1,'PayPal'),
  (2,'Rechnung');

DROP TABLE IF EXISTS `%TABLE_PREFIX%webkiosk_products`;

CREATE TABLE `r%TABLE_PREFIX%webkiosk_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `articlenr` varchar(11) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `name_details` varchar(128) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `fabric` varchar(128) DEFAULT NULL,
  `price` varchar(32) DEFAULT NULL,
  `details_1` text,
  `details_2` text,
  `details_3` text,
  `product_image` varchar(128) DEFAULT NULL,
  `product_image_2` varchar(128) DEFAULT NULL,
  `product_image_3` varchar(128) DEFAULT NULL,
  `product_image_4` varchar(128) DEFAULT NULL,
  `opt_field_1` varchar(128) DEFAULT NULL,
  `opt_field_var_1` varchar(11) DEFAULT NULL,
  `opt_field_2` varchar(128) DEFAULT NULL,
  `opt_field_var_2` varchar(11) DEFAULT NULL,
  `opt_field_3` varchar(128) DEFAULT NULL,
  `opt_field_var_3` varchar(11) DEFAULT NULL,
  `opt_field_4` varchar(128) DEFAULT NULL,
  `opt_field_var_4` varchar(11) DEFAULT NULL,
  `opt_field_5` varchar(128) DEFAULT NULL,
  `opt_field_var_5` varchar(11) DEFAULT NULL,
  `opt_field_6` varchar(128) DEFAULT NULL,
  `opt_field_var_6` varchar(11) DEFAULT NULL,
  `opt_field_7` varchar(128) DEFAULT NULL,
  `opt_field_8` varchar(128) DEFAULT NULL,
  `opt_field_9` varchar(128) DEFAULT NULL,
  `opt_field_10` varchar(128) DEFAULT NULL,
  `opt_field_11` varchar(128) DEFAULT NULL,
  `opt_field_12` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `%TABLE_PREFIX%webkiosk_settings`;

CREATE TABLE `%TABLE_PREFIX%webkiosk_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email_subject` varchar(128) DEFAULT NULL,
  `email_addr_1` varchar(128) DEFAULT NULL,
  `email_addr_2` varchar(128) DEFAULT NULL,
  `article_detail_page` int(11) DEFAULT NULL,
  `bezahlarten` varchar(128) DEFAULT NULL,
  `paypal_email` varchar(128) DEFAULT NULL,
  `checkout_site` int(11) DEFAULT NULL,
  `checkout_thanks` text,
  `shipping_cost` varchar(128) DEFAULT NULL,
  `conf_header_mail` text,
  `conf_footer_mail` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `%TABLE_PREFIX%webkiosk_settings` (`id`, `email_subject`, `email_addr_1`, `email_addr_2`, `article_detail_page`, `bezahlarten`, `paypal_email`, `checkout_site`, `checkout_thanks`, `shipping_cost`, `conf_header_mail`, `conf_footer_mail`)
VALUES
  (1,'E-Mail Betreff','E-Mail 1','E-Mail 2',0,'|1|2|','ihre-paypal@adresse.de',42,'<p>Danke für ihre Mail.</p>','4.90','Kopfzeile','Fußzeile');