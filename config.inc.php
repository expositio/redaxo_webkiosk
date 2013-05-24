<?php

  // AddOn Name
  $ex_addon = 'webkiosk';

  //AddOn Sprachinstanz
  $I18N_webkiosk = new i18n($REX['LANG'], $REX['INCLUDE_PATH'].'/addons/'.$ex_addon.'/lang');

  //AddOn Key
  $REX['ADDON']['rxid'][$ex_addon] = '44805';

  //AddOn page-variable
  $REX['ADDON']['page'][$ex_addon] = $ex_addon;

  //AddOn Name - Navigationsmenü
  $REX['ADDON']['name'][$ex_addon] = 'WebKiosk';
  $REX['ADDON'][$ex_addon]['SUBPAGES'] = array(
    array("", "Bestellungen"),
    array("products", "Produkte"),
    array("cats", "Kategorien"),
    array("settings", "Einstellungen"),
    array("payment", "Bezahlmöglichkeiten"),
    array("status", "Rechnung Status"),
    array("setup", "Setup/Module/Template")
  );

  //AddOn Berechtigung - für jeden User einstellbar
  $REX['ADDON']['perm'][$ex_addon] = 'webkiosk[]';
  $REX['PERM'][] = 'webkiosk[]';

  //AddOn Version
  $REX['ADDON']['version'][$ex_addon] = '1.1';

  //AddOn Author
  $REX['ADDON']['author'][$ex_addon] = 'expositio.de - Manuel Körber';
  
  require_once($REX['INCLUDE_PATH']. '/addons/'.$ex_addon.'/classes/class.rex_webkiosk_settings.inc.php');  
  require_once($REX['INCLUDE_PATH']. '/addons/'.$ex_addon.'/classes/class.rex_webkiosk_manager.inc.php');
  require_once($REX['INCLUDE_PATH']. '/addons/'.$ex_addon.'/classes/class.rex_webkiosk_db_helper.inc.php');

?>