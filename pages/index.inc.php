<?php
$basedir = dirname(__FILE__);

$page = rex_request("page", "string");
$subpage = rex_request("subpage", "string");
$func = rex_request("func", "string");

include_once $REX["INCLUDE_PATH"]."/layout/top.php";

$subpages = array(
  array("", "Bestellungen"),
  array("products", "Produkte"),
  array("cats", "Kategorien"),
  array("settings", "Einstellungen"),
  array("payment", "Bezahlmöglichkeiten"),
  array("status", "Rechnung Status"),
  array("setup", "Setup/Module/Template")
);

rex_title("webkiosk", $subpages);

switch($subpage) {
  case '':
    require $basedir."/orders.inc.php";
  break;
  case 'products':
    require $basedir."/products.inc.php";
  break;
  case 'cats':
    require $basedir.'/cats.inc.php';
  break;
  case 'settings':
    require $basedir.'/settings.inc.php';
  break;
  case 'status':
    require $basedir.'/status.inc.php';
  break;
  case 'payment':
    require $basedir.'/payment.inc.php';
  break;
  case 'setup':
    require $basedir.'/setup.inc.php';
  break;
  default:
    require $basedir."/orders.inc.php";
}

include_once $REX["INCLUDE_PATH"]."/layout/bottom.php";
?>