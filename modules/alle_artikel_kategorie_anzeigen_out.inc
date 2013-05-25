<?php 

  $webkiosk = new rex_webkiosk_manager();

  $articles = $webkiosk->getArticleByCategory(intval("REX_VALUE[1]"));
  $article_page = $webkiosk->getDetailPage();
  if(sizeof($articles) == 0) { ?>
    <div class="listenartikel">
      In dieser Kategorie sind leider keine Artikel vorhanden.
    </div>
  <?php } else {
    $counter = 0;
    foreach($articles as $article):
      if($counter <= 3) {
  ?>
        <div class="listenartikel">
          <a href="<?=rex_getUrl($article_page, 0,array("article" => $article["id"]));?>">
            <?php
              if($article["product_image"] == "nopicture.jpg") {
            ?>
                <div style="width: 175px; height: 235px;"></div>
            <?php
              } else {
            ?>
              <img src="<?=$REX["HTDOCS_PATH"];?>index.php?rex_img_type=rex_webkiosk&rex_img_file=<?=$article["product_image"];?>" alt="">
            <?php
              }
            ?>
          </a>
          <div class="artikelbalken">
            <div class="artikelname"><?=$article["name"];?></div>
            <div class="artikelpreis"><?=number_format($article["price"], 2, ",", ".");?> &euro;</div>
          </div>
        </div>
  <?php 
    $counter++;
  } else {
    $counter = 0;
  ?>
    <div class="clear"></div>
    <div class="listenartikel">
      <a href="<?=rex_getUrl($article_page, 0,array("article" => $article["id"]));?>">
        <img src="<?=$REX["HTDOCS_PATH"];?>index.php?rex_img_type=rex_webkiosk&rex_img_file=<?=$article["product_image"]; ?>" alt="">
      </a>

      <div class="artikelbalken">
        <div class="artikelname"><?=$article["name"];?></div>
        <div class="artikelpreis"><?=number_format($article["price"], 2, ",", ".");?> &euro;</div>
      </div>
    </div>
  <?php
  $counter++;
  } 
  endforeach; 
} ?>
