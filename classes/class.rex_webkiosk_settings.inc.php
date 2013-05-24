<?php

class rex_webkiosk_settings {

  function getMailSubject() {
    global $REX;
    
    $sql = rex_sql::factory();
    $db_table = $REX['TABLE_PREFIX'].'webkiosk_settings';

    $sql->setQuery("SELECT email_subject FROM ".$db_table);
    $result = $sql->getArray();

    return $result[0]['email_subject'];
  }
  
  function getMailAdress() {
    global $REX;
    
    $sql = rex_sql::factory();
    $db_table = $REX['TABLE_PREFIX'].'webkiosk_settings';

    $sql->setQuery("SELECT email_addr_1 FROM ".$db_table);
    $result = $sql->getArray();

    return $result[0]['email_addr_1'];
  }
  
  function getMailAdressCopy() {
    global $REX;
    
    $sql = rex_sql::factory();
    $db_table = $REX['TABLE_PREFIX'].'webkiosk_settings';

    $sql->setQuery("SELECT email_addr_2 FROM ".$db_table);
    $result = $sql->getArray();

    return $result[0]['email_addr_2'];
  }
  
  function getPayments() {
    global $REX;
    
    $sql = rex_sql::factory();
    $db_table = $REX['TABLE_PREFIX'].'webkiosk_settings';

    $sql->setQuery("SELECT email_addr_2 FROM ".$db_table);
    $result = $sql->getArray();

    return $result[0]['email_addr_2'];
  }

  function getCheckoutSite() {
    global $REX;
    
    $sql = rex_sql::factory();
    $db_table = $REX['TABLE_PREFIX'].'webkiosk_settings';

    $sql->setQuery("SELECT checkout_site FROM ".$db_table);
    $result = $sql->getArray();

    return $result[0]['checkout_site']; 
  }

  function textCheckoutThanks() {
    global $REX;
    
    $sql = rex_sql::factory();
    $db_table = $REX['TABLE_PREFIX'].'webkiosk_settings';

    $sql->setQuery("SELECT checkout_thanks FROM ".$db_table);
    $result = $sql->getArray();

    return $result[0]['checkout_tanks'];
  }

}

?>