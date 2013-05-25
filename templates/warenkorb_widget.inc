<?php 
  session_start();
  $webkiosk  = new rex_webkiosk_manager();
?>

<div id="shoppingcart">
  <?php 
    if(rex_post("submit") && rex_post("submit") == "» in den Warenkorb") {
      $webkiosk->addArticleToCart(rex_post("a_id"), rex_post("amt"), rex_post("size"));
    } else if(rex_post("delete_item")) {
      $webkiosk->deleteFromShoppingCart(intval(rex_post("a_id")), rex_post("size"));
    } else if(rex_post("update_item")) {
      $amount = rex_post("amount");
      $size = rex_post("size");
      $a_id = rex_post("a_id");
      foreach($amount as $key => $value) {
        if($amount[$key] == 0) {
          $webkiosk->deleteFromShoppingCart(intval($a_id[$key]), $size[$key]);
        } else {
          $webkiosk->updateShoppingCart($a_id[$key], $amount[$key], $size[$key]);
        }
      }
    }
    
    $webkiosk->getShoppingCartWidget();
  ?>
</div>

<div id="cart_detailed">
  <?php $webkiosk->getShoppingCart(); ?>
</div>