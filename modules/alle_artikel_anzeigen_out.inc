<?php
  if(OOAddon::isAvailable("webkiosk")) {
    $webkiosk = new rex_webkiosk_manager();
    $articles = $webkiosk->getAllArticle();
    echo "<pre>";
      print_r($articles);
    echo "</pre>";
    
    echo '<div class="webkiosk_alle_produkte">';
      foreach($articles as $article): ?>

<?php 
      endforeach;
    echo "</div>";
  }
?>