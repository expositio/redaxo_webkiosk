<?php

$func = rex_request('func', 'string');
$id = rex_request('id', 'int');

if($func == '') {
  $qry = "SELECT *,CASE final_stat
            WHEN 1 THEN 'Ja'
            ELSE 'Nein'
          END as 'final' FROM ".$REX['TABLE_PREFIX']."webkiosk_bill_status order by name ASC";

  $list = rex_list::factory($qry);
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
  $list->removeColumn('final_stat');

  $list->setColumnLabel('name', 'Bezeichnung');
  $list->setColumnSortable('name');
  $list->setColumnLabel('final', 'Final');
  $list->setColumnParams($imgHeader, array('func' => 'edit', 'id' => '###id###'));
  $list->setColumnParams('name', array('func' => 'edit', 'id' => '###id###'));

  $list->show();
} elseif($func == 'add' || $func == 'edit') {
  $form = rex_form::factory($REX['TABLE_PREFIX'].'webkiosk_bill_status',"Neuen Status","id=".$id);
  
  $field = &$form->addTextField('name');
  $field->setLabel('Bezeichnung');

  $field = &$form->addSelectField('final_stat');
  $field->setLabel('Endstatus');
  $select = &$field->getSelect();
  $select->setSize(1);
  $select->addOption('Nein', 0);
  $select->addOption('Ja', 1);
  

  if($func == 'edit') {
    $form->addParam('id', $id);
  }
  
  $form->show();
}

?>