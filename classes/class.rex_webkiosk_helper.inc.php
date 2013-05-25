<?php

class rex_webkiosk_helper {

  function get_checkout_info() {
    global $REX;

    $sql = rex_sql::factory();
    $db_table = $REX['TABLE_PREFIX'].'webkiosk_settings';
    $qry = "SELECT * FROM ".$db_table;
    $sql->setQuery($qry);

    return $sql->getArray();
  }

  function get_translation($str) {
    global $REX; 
    
    $lang = new i18n("de_de_utf8", $REX['INCLUDE_PATH']."/addons/webkiosk/lang");
    $lang->loadTexts();

    return $lang->msg($str);
  }

}

?>