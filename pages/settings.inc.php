<?php

  $func = rex_request('func', 'string');
  $id = rex_request('id', 'int');

  $form = rex_form::factory($REX['TABLE_PREFIX'].'webkiosk_settings',"E-Mail / Bestellung","id=1");

  $field = &$form->addTextField('email_subject');
  $field->setLabel('E-Mail Betreff Bestellung');

  $field = &$form->addTextField('email_addr_1');
  $field->setLabel('E-Mail Adresse Bestellung');

  $field = &$form->addTextField('email_addr_2');
  $field->setLabel('E-Mail Adresse Bestellung (Kopie)');

  $form->addFieldset('Shop');

  $field = &$form->addLinkmapField('article_detail_page');
  $field->setLabel('Einzelartikel Seite');

  $field = &$form->addLinkmapField('checkout_site');
  $field->setLabel('zur Kasse - Seiten ID');

  $field = &$form->addTextAreaField('checkout_thanks');
  $field->setAttribute('class', 'tinyMCEEditor-webkiosk');
  $field->setLabel('Text nach Bestellvorgang');

  $form->addFieldset('Kaufabwicklung');
  $field = &$form->addTextField('shipping_cost');
  $field->setLabel('Versandkosten');

  $field = &$form->addTextAreaField('conf_header_mail');
  $field->setAttribute('class', 'tinyMCEEditor-webkiosk');
  $field->setLabel('Kopfzeile Bestätigungsmail');

  $field = &$form->addTextAreaField('conf_footer_mail');
  $field->setAttribute('class', 'tinyMCEEditor-webkiosk');
  $field->setLabel('Fußzeile Bestätigungsmail');

  $form->addFieldset('Bezahlarten');

  $field = &$form->addSelectField('bezahlarten');
  $field->setLabel('Bezahlarten');
  $field->setAttribute('multiple','multiple');
  $select = &$field->getSelect();
  $select->setSize(3);
  $query = 'SELECT name as label, id FROM '.$REX['TABLE_PREFIX'].'webkiosk_payment_methods ORDER BY name';
  $select->addSqlOptions($query);

  $field = &$form->addTextField('paypal_email');
  $field->setLabel('PayPal E-Mail Adresse (wenn PayPal ausgewählt)');

  $form->show();

?>