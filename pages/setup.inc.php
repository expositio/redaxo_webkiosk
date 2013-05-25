<?php
  $sql = rex_sql::factory();
  
  $page = rex_request('page', 'string');
  $subpage = rex_request('subpage', 'string');
  $module_in = null;
  $module_out = null;
  $module_name = null;

  if(OOAddon::isAvailable("webkiosk")) {
?>
    <div style="padding: 15px; width:700px;height:auto;border:1px solid #666;overflow:auto" class="warning">
      <strong>Module installieren</strong>
      <ul style="padding-left: 50px;list-style: none;line-height: 2.0em;">
        <li><a href="index.php?page=<?=$page?>&subpage=<?=$subpage?>&func=1">Alle Artikel anzeigen</a></li>
        <li><a href="index.php?page=<?=$page?>&subpage=<?=$subpage?>&func=2">Alle Artikel einer Kategorie anzeigen</a></li>
        <li><a href="index.php?page=<?=$page?>&subpage=<?=$subpage?>&func=3">Ein einzelnes Produkt anzeigen</a></li>
        <li><a href="index.php?page=<?=$page?>&subpage=<?=$subpage?>&func=5">Checkout Prozess</a></li>
        <li><a href="index.php?page=<?=$page?>&subpage=<?=$subpage?>&func=4">Template f&uuml;r das Warenkorb-Widget</a></li>
      </ul>
    </div>
<?php
  
  if(rex_get('func')) {
    global $REX;
    $func = rex_get('func');

    switch ($func) {
      case 1:
        $module_name = "webkiosk - Alle Produkte anzeigen";
        $module_in = rex_get_file_contents($REX["INCLUDE_PATH"]."/addons/webkiosk/modules/alle_artikel_anzeigen_in.inc");
        $module_out = rex_get_file_contents($REX["INCLUDE_PATH"]."/addons/webkiosk/modules/alle_artikel_anzeigen_out.inc");
      break;
      case 2:
        $module_name = "webkiosk - Alle Produkte einer Kategorie anzeigen";
        $module_in = rex_get_file_contents($REX["INCLUDE_PATH"]."/addons/webkiosk/modules/alle_artikel_kategorie_anzeigen_in.inc");
        $module_out = rex_get_file_contents($REX["INCLUDE_PATH"]."/addons/webkiosk/modules/alle_artikel_kategorie_anzeigen_out.inc");
      break;
      case 3:
        $module_name = "webkiosk - Ein Produkt anzeigen";
        $module_in = rex_get_file_contents($REX["INCLUDE_PATH"]."/addons/webkiosk/modules/ein_artikel_anzeigen_in.inc");
        $module_out = rex_get_file_contents($REX["INCLUDE_PATH"]."/addons/webkiosk/modules/ein_artikel_anzeigen_out.inc");
      break;
      case 4:
        $template_name = "webkiosk - Warenkorb-Widget";
        $template_code = rex_get_file_contents($REX["INCLUDE_PATH"]."/addons/webkiosk/templates/warenkorb_widget.inc");
      break;
      case 5:
        $module_name = "webkiosk - Checkout Prozess";
        $module_in = rex_get_file_contents($REX["INCLUDE_PATH"]."/addons/webkiosk/modules/checkout_in.inc");
        $module_out = rex_get_file_contents($REX["INCLUDE_PATH"]."/addons/webkiosk/modules/checkout_out.inc");
      break;
    }

    if($func != 4) {
      //search if module exists than delete and write new
      $sql->setQuery('SELECT * FROM rex_module WHERE name LIKE "%'.$module_name.'%"');
      $array_size = intval(sizeof($sql->getArray()));
      
      if($array_size >= 1) {
        $sql->setTable('rex_module');
        
        $sql->setWhere('name = "'.$module_name.'"');
        $sql->setValue('eingabe', $module_in);
        $sql->setValue('ausgabe', $module_out);
        $sql->setValue('updatedate', time());
        $sql->update();
        
        echo "<br /><br />Das Modul ist auf dem aktuellsten Stand.<br /><br />";
        
      } else if(sizeof($sql->getArray()) == 0) {
        $sql->setTable('rex_module');
        $sql->setValue('name', $module_name);
        $sql->setValue('eingabe', $module_in);
        $sql->setValue('ausgabe', $module_out);
        $sql->setValue('createuser','entwickler');
        $sql->setValue('updateuser','entwickler');
        $sql->setValue('createdate',time());
        $sql->setValue('updatedate', time());
        $sql->setValue('revision','0');
        $sql->insert();

        echo "<br /><br />Das Modul '".$module_name."' wurde erfolgreich installiert!<br /><br />";

      }
    } else {
      //search if template exists than update else write a new module
      $sql->setQuery('SELECT * FROM rex_template WHERE name LIKE "%'.$template_name.'%"');
      $array_size = intval(sizeof($sql->getArray()));
    
      if($array_size >= 1) {
        $sql->setTable('rex_template');
        $sql->setWhere('name = "'.$template_name.'"');
        $sql->setValue('content', $template_code);
        $sql->setValue('updatedate', time());
        $sql->update();
        
        echo "<br /><br />Das Template '".$template_name."' ist auf dem aktuellsten Stand.<br /><br />";
        
      }else if(sizeof($sql->getArray()) == 0) {
        $sql->setTable('rex_template');
        $sql->setValue('name', $template_name);
        $sql->setValue('content', $template_code);
        $sql->setValue('active', '0');
        $sql->setValue('createuser','entwickler');
        $sql->setValue('updateuser','entwickler');
        $sql->setValue('createdate',time());
        $sql->setValue('updatedate', time());
        $sql->setValue('attributes', 'a:3:{s:10:"categories";a:1:{s:3:"all";s:1:"1";}s:5:"ctype";a:0:{}s:7:"modules";a:1:{i:1;a:1:{s:3:"all";s:1:"1";}}}');
        $sql->setValue('revision','0');
        $sql->insert();

        echo "<br /><br />Das Template wurde erfolgreich installiert!<br /><br />";

      }
    }
  }
}
?>