DROP TABLE IF EXISTS `multisafepay_transactions`;
CREATE TABLE `multisafepay_transactions` (

  `id` int(11) unsigned NOT NULL auto_increment,
  `ewallet_id` int(11) unsigned default NULL,
  `status` char(15) default NULL,
  `created` int(11) unsigned NOT NULL,
  `updated` int(11) unsigned NOT NULL,
  `order_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `signature` char(32) default NULL,
  `ga_account` char(12) default NULL,
  `error_code` int(7) default NULL,   
  `error_description` mediumtext default NULL,

  `t_id` varchar(50) default NULL,
  `t_currency` char(3) default NULL,
  `t_amount` int(11) unsigned default 0,
  `t_description` text default NULL,
  `t_var1` varchar(100) default NULL,
  `t_var2` varchar(100) default NULL,
  `t_var3` varchar(100) default NULL,
  `t_items` text default NULL,
  `t_manual` bit(1) default NULL,
  `t_gateway` varchar(50) default NULL,
  `t_daysactive` int(3) unsigned default 0,
  `t_payment_url` mediumtext default NULL,

  `m_account_id` varchar(32) default NULL,
  `m_site_id` varchar(32) default NULL,
  `m_secure_code` varchar(32) default NULL,
  `m_notification_url` mediumtext default NULL,
  `m_cancel_url` mediumtext default NULL,
  `m_redirect_url` mediumtext default NULL,
  `m_close_window` bit(1) default NULL,

  `c_locale` char(5) default NULL,
  `c_ipaddress` char(16) default NULL,
  `c_forwardedip` char(15) default NULL,
  `c_firstname` char(25) default NULL,
  `c_lastname` char(25) default NULL,
  `c_address1` char(64) default NULL,
  `c_address2` char(64) default NULL,
  `c_housenumber` char(10) default NULL,
  `c_zipcode` char(10) default NULL,
  `c_city` char(50) default NULL,
  `c_state` char(50) default NULL,
  `c_country` char(2) default NULL,
  `c_phone` char(25) default NULL,
  `c_email` char(50) default NULL,
  `c_currency` char(3) default NULL,
  `c_amount` int(11) unsigned default 0,
  `c_exchange_rate` float(9,4) default NULL,

  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `multisafepay_logs`;
CREATE TABLE `multisafepay_logs` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `transaction_id` varchar(50) default NULL,
  `date` int(11) unsigned NOT NULL,
  `url` varchar(255) default NULL,
  `duration` float(11,6) default NULL,
  `error` text default NULL,
  `request` text default NULL,
  `response` mediumtext default NULL,
  `backtrace` text default NULL,
  `ip` char(16) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
