<?php

  $sql = rex_sql::factory();
  $sql->setQuery("SELECT id FROM ".$REX['TABLE_PREFIX']."webkiosk_bill_status WHERE final_stat = 1 LIMIT 1");
  $result = $sql->getArray();

  if(rex_request('func', 'string') == '') {
    echo "<div style='margin-bottom: 10px'>";
    if(rex_request('def_status') == 0) {
      echo "<div style='padding: 5px; float:left; background: #2C8EC0; margin-right: 5px;'><a style='color: #ffffff; font-weight: bold;' href='index.php?page=webkiosk&subpage=orders&def_status=0'>neue Bestellungen</a></div>";
      echo "<div style='padding: 5px; float:left; background: #DFE9E9; margin-right: 5px;'><a style='color: #2C8EC0; font-weight: bold;' href='index.php?page=webkiosk&subpage=orders&def_status=1'>erledigte Bestellungen</a></div>";
    } else {
      echo "<div style='padding: 5px; float:left; background: #DFE9E9; margin-right: 5px;'><a style='color: #2C8EC0; font-weight: bold;' href='index.php?page=webkiosk&subpage=orders&def_status=0'>neue Bestellungen</a></div>";
      echo "<div style='padding: 5px; float:left; background: #2C8EC0; margin-right: 5px;'><a style='color: #ffffff; font-weight: bold;' href='index.php?page=webkiosk&subpage=orders&def_status=1'>erledigte Bestellungen</a></div>";
    }
      echo "<div style='clear:both;'></div>";
    echo "</div>";
  }

$func = rex_request('func', 'string');
$id = rex_request('id', 'int');
$def_status = rex_request('def_status', 'int');

if($def_status == 0) {
  $qry = "SELECT id,DATE_FORMAT(createdate,'%d.%m.%Y - %H:%i Uhr') as datum,name,first_name,invoice_no,status,
    (SELECT name FROM ".$REX['TABLE_PREFIX']."webkiosk_bill_status WHERE id = status) as stat_name
  FROM ".$REX['TABLE_PREFIX']."webkiosk_orders WHERE status != ".$result[0]['id']." order by createdate DESC";
} else {
  $qry = "SELECT id,DATE_FORMAT(createdate,'%d.%m.%Y - %H:%i Uhr') as datum,name,first_name,invoice_no,status,
    (SELECT name FROM ".$REX['TABLE_PREFIX']."webkiosk_bill_status WHERE id = status) as stat_name
  FROM ".$REX['TABLE_PREFIX']."webkiosk_orders WHERE status = ".$result[0]['id']." order by createdate DESC";
}

if($func == '') {
  $list = rex_list::factory($qry);
  $imgHeader = '<img src="media/metainfo.gif" alt="add" title="add" />';

  $list->addColumn(
    $imgHeader, 
    '<img src="media/metainfo.gif" alt="field" title="field" />',
    0,
    array( 
      '<th class="rex-icon">###VALUE###</th>',
      '<td class="rex-icon">###VALUE###</td>'
    )
  );

  $list->removeColumn('name');
  $list->removeColumn('first_name');
  $list->removeColumn('status');
  $list->removeColumn('id');

  $list->addColumn('fullname', '###name###, ###first_name###', 1);
  $list->setColumnLabel('datum', 'Bestelldatum');
  $list->setColumnLabel('fullname', 'Name');
  $list->setColumnLabel('invoice_no', 'Bestellnummer');
  $list->setColumnLabel('stat_name', 'Status/Funktion');

  $list->setColumnParams($imgHeader, array('func' => 'edit', 'id' => '###id###'));
  $list->setColumnParams('fullname', array('func' => 'edit', 'id' => '###id###'));

  $list->show();
} elseif($func == 'edit') {
  
  $sql = rex_sql::factory();
  $qry = "SELECT * FROM ".$REX['TABLE_PREFIX']."webkiosk_orders WHERE id = ".$id;

  $sql->setQuery($qry);

  $result = $sql->getArray();
  $result = $result[0];

  $articleInfo = explode("|",$result['articles']);
  $articles = array();
  for($i = 0; $i < count($articleInfo); $i+=5 ){
    $articles[$articleInfo[$i]]['name'] = $articleInfo[$i];
    $articles[$articleInfo[$i]]['amt'] = $articleInfo[$i+1];
    $articles[$articleInfo[$i]]['price'] = $articleInfo[$i+2];
    $articles[$articleInfo[$i]]['articlenr'] = $articleInfo[$i+3];
    $articles[$articleInfo[$i]]['size'] = $articleInfo[$i+4];
  }
?>
<style type="text/css">
  .order_detail {
    padding: 15px; 
    width:700px;
    height:auto;
    border:1px solid #666;
    overflow:auto;
    line-height: 1.3em;
  }

  .order_header {
    padding-bottom: 10px;
    border-bottom: 1px solid #000;
    margin-bottom: 10px;
  }

  .order_footer {
    margin-top: 10px;
    padding-top: 10px;
  }

  .order_full_headline {
    font-weight: bolder;
  }

  .order_left_header {
    float: left;
    width: 200px;
    font-weight: bolder;
  }

  .order_right_header {
    float: left;
  }

  .order_product_box {
    border-bottom: 1px solid #666;
  }

  .order_product_col_1, .order_product_col_2, .order_product_col_3, .order_product_col_4 {
    float: left;
    padding-top: 5px;
    padding-bottom: 5px;
  }

  .order_product_col_1 {
    width: 100px;
  }

  .order_product_col_2 {
    width: 200px;
  }

  .order_product_col_3 {
    width: 200px;
  }

  .order_product_col_4 {
    width: 200px;
    text-align: right;
  }

  .without_mwst_right, .mwst_right, .shipping_right, .total_right, .without_mwst_left, .mwst_left, .shipping_left, .total_left {
    width: 100px;
    float: right;
    text-align: right;
  }

  .without_mwst_left, .mwst_left, .shipping_left, .total_left {
    font-weight: bolder;
  }

  .total_right {
    margin-left: 20px;
    width: 80px;
    border-top: 1px solid #666;
    margin-top: 2px;
  }

  .shipping_right {
    margin-left: 20px;
    width: 80px;
    border-bottom: 1px solid #666;
  }

  .header_bold {
    font-weight: bolder;
  }

  .pT10 {
    padding-top: 10px;
  }

  .pT20 {
    padding-top: 20px;
  }

  .mB10 {
    margin-bottom: 10px;
  }

  .flLeft {
    float: left;
  }

  .flRight {
    float: right;
  }

  .clear {
    clear: both;
  }

  .footer_link {
    font-weight: bolder;
    cursor: pointer;
  }
</style>

  <div class="order_detail">
    <div class="order_header">
      <div class="order_left_header">Bestellungs-Nr.:</div>
      <div class="order_right_header"><?=$result['invoice_no'];?></div>
      <div class="clear"></div>
      <div class="order_left_header">Rechnungs-Nr.:</div>
      <div class="order_right_header"><?=$result['invoice_no'];?></div>
      <div class="clear"></div>
      <div class="order_left_header">Versanddatum:</div>
      <div class="order_right_header"><?=$result['shipping_date'];?></div>
      <div class="clear"></div>
      <div class="order_left_header pT10">Status:</div>
      <div class="order_right_header pT10"><?=rex_webkiosk_manager::getBillStatus($result['status']);?></div>
      <div class="clear"></div>
    </div>
    <div class="order_client">
      <div class="order_full_headline mB10">Kunde: </div>
      <div class="order_full"><?=$result['first_name']?> <?=$result['name']?></div>
      <div class="order_full"><?=$result['street']?></div>
      <div class="order_full"><?=$result['zip']?> <?=$result['city']?></div>
      <div class="order_full"><?=$result['state']?></div>
      <br />
      <div class="order_full">E-Mail: <?=$result['email']?></div>
    </div>
    <div class="order_products">
      <div class="order_full_headline pT20 mB10">Bestellte Artikel: </div>
      <div class="order_product_box">
        <div class="order_product_col_1 header_bold">Anzahl</div>
        <div class="order_product_col_2 header_bold">Name</div>
        <div class="order_product_col_3 header_bold">Artikel-Nr</div>
        <div class="order_product_col_4 header_bold">Einzelpreis</div>
        <div class="clear"></div>
      </div>
      <div class="order_product_box">
      <?php
      $i = 1;
      foreach($articles as $article){

        $artId = $article['name'];
        
        $resName = $sql->getArray("SELECT * FROM rex_webkiosk_products WHERE id=$artId");
        
        
        if($i <= 0)
          echo '<div style="border-top: 1px dashed #666">';
        else 
          echo '<div>';
          
        echo '<div class="order_product_col_1">'.$article['amt'].' x Gr.: '.$article['size'].'</div>
              <div class="order_product_col_2">'.$resName[0]['name'].'</div>
              <div class="order_product_col_3">'.$article['articlenr'].'</div>
              <div class="order_product_col_4">'.$article['price'].' &euro;</div>
              <div class="clear"></div>';
        echo '</div>';
        $i--;
      }

      $gross_sum  = floatval(str_replace(',','.',$result['gross_sum']));
      $net_sum    = floatval(str_replace(',','.',$result['net_sum']));
      $mwst       = floatval(str_replace(',','.',$result['net_sum']))-floatval(str_replace(',','.',$result['gross_sum']));

      $coData = $sql->getArray("SELECT shipping_cost FROM ".$REX['TABLE_PREFIX']."webkiosk_settings");
      $coData = $coData[0];
      $shipCost = floatval(str_replace(',','.',$coData['shipping_cost']));
      $shipCost = number_format((float)$shipCost, 2, '.', ',');

      $total = $net_sum + $mwst + $shipCost;
      ?>
      </div>
      <div class="order_costs">
        <div class="without_mwst_right"><?=$net_sum?> &euro;</div>
        <div class="without_mwst_left"> </div>
        <div class="clear"></div>
        <div class="mwst_right"><?=$mwst?> &euro;</div>
        <div class="mwst_left">MwSt. 19%</div>
        <div class="clear"></div>
        <div class="shipping_right"><?=$shipCost?> &euro;</div>
        <div class="shipping_left">Versand</div>
        <div class="clear"></div>
        <div class="total_right"><?=$total?> &euro;</div>
        <div class="total_left">Summe</div>
        <div class="clear"></div>
      </div>
    </div>
    <div class="order_footer">
      <div class="flLeft"><a class="footer_link" href="javascript:history.back();">Zur&uuml;ck zur &Uuml;bersicht</a></div>
      <div class="flRight"><a class="footer_link" href="index.php?page=webkiosk&subpage=order&func=edit_user&id=<?=$result['id'];?>">Bestellung bearbeiten</a></div>
      <div class="clear"></div>
    </div>
  </div>

<?php

} elseif($func == 'edit_user') {
  $form = rex_form::factory($REX['TABLE_PREFIX'].'webkiosk_orders',"Bestellung bearbeiten","id=".$id);
  
  $field = &$form->addTextField('invoice_no');
  $field->setLabel('Bestellnr.');

    $field = &$form->addSelectField('status');
  $field->setLabel('Status');
  $select = &$field->getSelect();
  $select->setSize(1);
  $query = 'SELECT name as label, id FROM '.$REX['TABLE_PREFIX'].'webkiosk_bill_status';
  $select->addSqlOptions($query);


  if($func == 'edit_user') {
    $form->addParam('id', $id);
  }
  
  $form->show();
}

?>