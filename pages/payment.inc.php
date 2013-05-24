<?php

$func = rex_request('func', 'string');
$id = rex_request('id', 'int');

if($func == '') {
  $list = rex_list::factory('SELECT id,name from '.$REX['TABLE_PREFIX'].'webkiosk_payment_methods order by name');

  $imgHeader = '<a href="'. $list->getUrl(array('func' => 'add')) .'"><img src="media/metainfo_plus.gif" alt="add" title="add" /></a>';

  $list->addColumn(
    $imgHeader, 
    '<img src="media/metainfo.gif" alt="field" title="field" />',
    0,
    array( 
      '<th class="rex-icon">###VALUE###</th>',
      '<td class="rex-icon">###VALUE###</td>'
    )
  );

  $list->removeColumn('id');

  $list->setColumnLabel('name', 'Bezahlart');
  $list->setColumnSortable('name');
  $list->setColumnParams($imgHeader, array('func' => 'edit', 'id' => '###id###'));
  $list->setColumnParams('name', array('func' => 'edit', 'id' => '###id###'));

  $list->show();
} elseif($func == 'add' || $func == 'edit') {
  $form = rex_form::factory($REX['TABLE_PREFIX'].'webkiosk_payment_methods',"Neue Bezahlart","id=".$id);
  
  $field = &$form->addTextField('name');
  $field->setLabel('Bezahlart');

  if($func == 'edit') {
    $form->addParam('id', $id);
  }
  
  $form->show();
}

?>