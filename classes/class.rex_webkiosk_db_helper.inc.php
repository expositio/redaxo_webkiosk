<?php

class rex_webkiosk_db_helper {

  function get_checkout_info() {
    global $REX;

    $sql = rex_sql::factory();
    $db_table = $REX['TABLE_PREFIX'].'webkiosk_settings';
    $qry = "SELECT * FROM ".$db_table;
    $sql->setQuery($qry);

    return $sql->getArray();
  }

}

?>