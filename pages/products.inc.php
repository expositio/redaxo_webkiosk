<?php

$func = rex_request('func', 'string');
$id = rex_request('id', 'int');

if($func == '') {

  $qry = "SELECT id,articlenr,name,price,cat_id,
    (SELECT name FROM ".$REX['TABLE_PREFIX']."webkiosk_cats WHERE id = cat_id) as cat_name
  FROM ".$REX['TABLE_PREFIX']."webkiosk_products order by name";

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

  $list->removeColumn('cat_id');

  $list->setColumnLabel('id', 'ID');	
  $list->setColumnLabel('articlenr', 'Artikelnr.');
  $list->setColumnLabel('name', 'Name');
  $list->setColumnLabel('price', 'Preis');
  $list->setColumnLabel('cat_name', 'Kategorie');
  $list->setColumnParams($imgHeader, array('func' => 'edit', 'id' => '###id###'));
  $list->setColumnParams('name', array('func' => 'edit', 'id' => '###id###'));

  $list->show();
} elseif($func == 'add' || $func == 'edit') {
  $form = rex_form::factory($REX['TABLE_PREFIX'].'webkiosk_products',"Artikelnummer","id=".$id);
  
  $field = &$form->addTextField('articlenr');
  $field->setLabel('Artikelnummer');
  
  $form->addFieldset('Produktname');

  $field = &$form->addTextField('name');
  $field->setLabel('Produktname');
  
  $field = &$form->addTextField('name_details');
  $field->setLabel('Name (Details)');

  $field = &$form->addTextField('price');
  $field->setLabel('Preis');

  $form->addFieldset('Produktbilder');

  $field = &$form->addMediaField('product_image');
  $field->setLabel('Abbildung 1');

  $field = &$form->addMediaField('product_image_2');
  $field->setLabel('Abbildung 2');

  $field = &$form->addMediaField('product_image_3');
  $field->setLabel('Abbildung 3');

  $field = &$form->addMediaField('product_image_4');
  $field->setLabel('Abbildung 4');

  $form->addFieldset('Produktkategorie');

  $field = &$form->addSelectField('cat_id');
  $field->setLabel('Kategorie');
  $select = &$field->getSelect();
  $select->setSize(1);
  $query = 'SELECT name as label, id FROM '.$REX['TABLE_PREFIX'].'webkiosk_cats';
  $select->addSqlOptions($query);

  $form->addFieldset('Produktdetails');

  $field = &$form->addTextAreaField('details_1');
  $field->setLabel('Details 1');

  $field = &$form->addTextAreaField('details_2');
  $field->setLabel('Details 2');

  $field = &$form->addTextAreaField('details_3');
  $field->setLabel('Details 3');

  $form->addFieldset('Produktgrößen/Anzahl (wenn Einheitsgröße dann nur Größe 1 und Anzahl 1 ausfüllen)');

  $field = &$form->addTextField('opt_field_1');
  $field->setLabel('Größe 1');

  $field = &$form->addTextField('opt_field_var_1');
  $field->setLabel('Anzahl 1');

  $field = &$form->addTextField('opt_field_2');
  $field->setLabel('Größe 2');

  $field = &$form->addTextField('opt_field_var_2');
  $field->setLabel('Anzahl 2');

  $field = &$form->addTextField('opt_field_3');
  $field->setLabel('Größe 3');

  $field = &$form->addTextField('opt_field_var_3');
  $field->setLabel('Anzahl 3');

  $field = &$form->addTextField('opt_field_4');
  $field->setLabel('Größe 4');

  $field = &$form->addTextField('opt_field_var_4');
  $field->setLabel('Anzahl 4');

  $field = &$form->addTextField('opt_field_5');
  $field->setLabel('Größe 5');

  $field = &$form->addTextField('opt_field_var_5');
  $field->setLabel('Anzahl 5');

  $field = &$form->addTextField('opt_field_6');
  $field->setLabel('Größe 6');

  $field = &$form->addTextField('opt_field_var_6');
  $field->setLabel('Anzahl 6');

  $form->addFieldset('Produktfüllung (optional)');

  $field = &$form->addTextField('opt_field_7');
  $field->setLabel('Füllung 1');

  $field = &$form->addTextField('opt_field_8');
  $field->setLabel('Füllung 2');

  $field = &$form->addTextField('opt_field_9');
  $field->setLabel('Füllung 3');

  $field = &$form->addTextField('opt_field_10');
  $field->setLabel('Füllung 4');

  $field = &$form->addTextField('opt_field_11');
  $field->setLabel('Füllung 5');

  $field = &$form->addTextField('opt_field_12');
  $field->setLabel('Füllung 6');

  if($func == 'edit') {
    $form->addParam('id', $id);
  }
  
  $form->show();
}

?>