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

CREATE TABLE `%TABLE_PREFIX%webkiosk_products` (
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
  (1,'E-Mail Betreff','E-Mail 1','E-Mail 2',0,'|1|2|','ihre-paypal@adresse.de',42,'<p>Danke für ihre Bestellung.</p>','4.90','Kopfzeile','Fußzeile');

INSERT INTO `rex_679_types` (`id`, `status`, `name`, `description`)
VALUES
  (448051,0,'rex_webkiosk',''),
  (448052,0,'rex_webkiosk_product',''),
  (448053,0,'rex_webkiosk_product_small','');

INSERT INTO `rex_679_type_effects` (`type_id`, `effect`, `parameters`, `prior`, `updatedate`, `updateuser`, `createdate`, `createuser`)
VALUES
  (448051,'resize','a:8:{s:15:\"rex_effect_crop\";a:6:{s:21:\"rex_effect_crop_width\";s:0:\"\";s:22:\"rex_effect_crop_height\";s:0:\"\";s:28:\"rex_effect_crop_offset_width\";s:0:\"\";s:29:\"rex_effect_crop_offset_height\";s:0:\"\";s:20:\"rex_effect_crop_hpos\";s:6:\"center\";s:20:\"rex_effect_crop_vpos\";s:6:\"middle\";}s:22:\"rex_effect_filter_blur\";a:3:{s:29:\"rex_effect_filter_blur_amount\";s:2:\"80\";s:29:\"rex_effect_filter_blur_radius\";s:1:\"8\";s:32:\"rex_effect_filter_blur_threshold\";s:1:\"3\";}s:25:\"rex_effect_filter_sharpen\";a:3:{s:32:\"rex_effect_filter_sharpen_amount\";s:2:\"80\";s:32:\"rex_effect_filter_sharpen_radius\";s:3:\"0.5\";s:35:\"rex_effect_filter_sharpen_threshold\";s:1:\"3\";}s:15:\"rex_effect_flip\";a:1:{s:20:\"rex_effect_flip_flip\";s:1:\"X\";}s:23:\"rex_effect_insert_image\";a:5:{s:34:\"rex_effect_insert_image_brandimage\";s:0:\"\";s:28:\"rex_effect_insert_image_hpos\";s:4:\"left\";s:28:\"rex_effect_insert_image_vpos\";s:3:\"top\";s:33:\"rex_effect_insert_image_padding_x\";s:3:\"-10\";s:33:\"rex_effect_insert_image_padding_y\";s:3:\"-10\";}s:17:\"rex_effect_mirror\";a:5:{s:24:\"rex_effect_mirror_height\";s:0:\"\";s:33:\"rex_effect_mirror_set_transparent\";s:7:\"colored\";s:22:\"rex_effect_mirror_bg_r\";s:0:\"\";s:22:\"rex_effect_mirror_bg_g\";s:0:\"\";s:22:\"rex_effect_mirror_bg_b\";s:0:\"\";}s:17:\"rex_effect_resize\";a:4:{s:23:\"rex_effect_resize_width\";s:3:\"200\";s:24:\"rex_effect_resize_height\";s:0:\"\";s:23:\"rex_effect_resize_style\";s:7:\"maximum\";s:31:\"rex_effect_resize_allow_enlarge\";s:7:\"enlarge\";}s:20:\"rex_effect_workspace\";a:8:{s:26:\"rex_effect_workspace_width\";s:0:\"\";s:27:\"rex_effect_workspace_height\";s:0:\"\";s:25:\"rex_effect_workspace_hpos\";s:4:\"left\";s:25:\"rex_effect_workspace_vpos\";s:3:\"top\";s:36:\"rex_effect_workspace_set_transparent\";s:7:\"colored\";s:25:\"rex_effect_workspace_bg_r\";s:0:\"\";s:25:\"rex_effect_workspace_bg_g\";s:0:\"\";s:25:\"rex_effect_workspace_bg_b\";s:0:\"\";}}',1,1369425433,'root',1369425135,'root'),
  (448052,'resize','a:8:{s:15:\"rex_effect_crop\";a:6:{s:21:\"rex_effect_crop_width\";s:0:\"\";s:22:\"rex_effect_crop_height\";s:0:\"\";s:28:\"rex_effect_crop_offset_width\";s:0:\"\";s:29:\"rex_effect_crop_offset_height\";s:0:\"\";s:20:\"rex_effect_crop_hpos\";s:6:\"center\";s:20:\"rex_effect_crop_vpos\";s:6:\"middle\";}s:22:\"rex_effect_filter_blur\";a:3:{s:29:\"rex_effect_filter_blur_amount\";s:2:\"80\";s:29:\"rex_effect_filter_blur_radius\";s:1:\"8\";s:32:\"rex_effect_filter_blur_threshold\";s:1:\"3\";}s:25:\"rex_effect_filter_sharpen\";a:3:{s:32:\"rex_effect_filter_sharpen_amount\";s:2:\"80\";s:32:\"rex_effect_filter_sharpen_radius\";s:3:\"0.5\";s:35:\"rex_effect_filter_sharpen_threshold\";s:1:\"3\";}s:15:\"rex_effect_flip\";a:1:{s:20:\"rex_effect_flip_flip\";s:1:\"X\";}s:23:\"rex_effect_insert_image\";a:5:{s:34:\"rex_effect_insert_image_brandimage\";s:0:\"\";s:28:\"rex_effect_insert_image_hpos\";s:4:\"left\";s:28:\"rex_effect_insert_image_vpos\";s:3:\"top\";s:33:\"rex_effect_insert_image_padding_x\";s:3:\"-10\";s:33:\"rex_effect_insert_image_padding_y\";s:3:\"-10\";}s:17:\"rex_effect_mirror\";a:5:{s:24:\"rex_effect_mirror_height\";s:0:\"\";s:33:\"rex_effect_mirror_set_transparent\";s:7:\"colored\";s:22:\"rex_effect_mirror_bg_r\";s:0:\"\";s:22:\"rex_effect_mirror_bg_g\";s:0:\"\";s:22:\"rex_effect_mirror_bg_b\";s:0:\"\";}s:17:\"rex_effect_resize\";a:4:{s:23:\"rex_effect_resize_width\";s:3:\"400\";s:24:\"rex_effect_resize_height\";s:0:\"\";s:23:\"rex_effect_resize_style\";s:7:\"maximum\";s:31:\"rex_effect_resize_allow_enlarge\";s:7:\"enlarge\";}s:20:\"rex_effect_workspace\";a:8:{s:26:\"rex_effect_workspace_width\";s:0:\"\";s:27:\"rex_effect_workspace_height\";s:0:\"\";s:25:\"rex_effect_workspace_hpos\";s:4:\"left\";s:25:\"rex_effect_workspace_vpos\";s:3:\"top\";s:36:\"rex_effect_workspace_set_transparent\";s:7:\"colored\";s:25:\"rex_effect_workspace_bg_r\";s:0:\"\";s:25:\"rex_effect_workspace_bg_g\";s:0:\"\";s:25:\"rex_effect_workspace_bg_b\";s:0:\"\";}}',1,1369425424,'root',1369425424,'root'),
  (448053,'resize','a:8:{s:15:\"rex_effect_crop\";a:6:{s:21:\"rex_effect_crop_width\";s:0:\"\";s:22:\"rex_effect_crop_height\";s:0:\"\";s:28:\"rex_effect_crop_offset_width\";s:0:\"\";s:29:\"rex_effect_crop_offset_height\";s:0:\"\";s:20:\"rex_effect_crop_hpos\";s:6:\"center\";s:20:\"rex_effect_crop_vpos\";s:6:\"middle\";}s:22:\"rex_effect_filter_blur\";a:3:{s:29:\"rex_effect_filter_blur_amount\";s:2:\"80\";s:29:\"rex_effect_filter_blur_radius\";s:1:\"8\";s:32:\"rex_effect_filter_blur_threshold\";s:1:\"3\";}s:25:\"rex_effect_filter_sharpen\";a:3:{s:32:\"rex_effect_filter_sharpen_amount\";s:2:\"80\";s:32:\"rex_effect_filter_sharpen_radius\";s:3:\"0.5\";s:35:\"rex_effect_filter_sharpen_threshold\";s:1:\"3\";}s:15:\"rex_effect_flip\";a:1:{s:20:\"rex_effect_flip_flip\";s:1:\"X\";}s:23:\"rex_effect_insert_image\";a:5:{s:34:\"rex_effect_insert_image_brandimage\";s:0:\"\";s:28:\"rex_effect_insert_image_hpos\";s:4:\"left\";s:28:\"rex_effect_insert_image_vpos\";s:3:\"top\";s:33:\"rex_effect_insert_image_padding_x\";s:3:\"-10\";s:33:\"rex_effect_insert_image_padding_y\";s:3:\"-10\";}s:17:\"rex_effect_mirror\";a:5:{s:24:\"rex_effect_mirror_height\";s:0:\"\";s:33:\"rex_effect_mirror_set_transparent\";s:7:\"colored\";s:22:\"rex_effect_mirror_bg_r\";s:0:\"\";s:22:\"rex_effect_mirror_bg_g\";s:0:\"\";s:22:\"rex_effect_mirror_bg_b\";s:0:\"\";}s:17:\"rex_effect_resize\";a:4:{s:23:\"rex_effect_resize_width\";s:2:\"80\";s:24:\"rex_effect_resize_height\";s:2:\"80\";s:23:\"rex_effect_resize_style\";s:5:\"exact\";s:31:\"rex_effect_resize_allow_enlarge\";s:7:\"enlarge\";}s:20:\"rex_effect_workspace\";a:8:{s:26:\"rex_effect_workspace_width\";s:0:\"\";s:27:\"rex_effect_workspace_height\";s:0:\"\";s:25:\"rex_effect_workspace_hpos\";s:4:\"left\";s:25:\"rex_effect_workspace_vpos\";s:3:\"top\";s:36:\"rex_effect_workspace_set_transparent\";s:7:\"colored\";s:25:\"rex_effect_workspace_bg_r\";s:0:\"\";s:25:\"rex_effect_workspace_bg_g\";s:0:\"\";s:25:\"rex_effect_workspace_bg_b\";s:0:\"\";}}',1,1369425544,'root',1369425481,'root');
