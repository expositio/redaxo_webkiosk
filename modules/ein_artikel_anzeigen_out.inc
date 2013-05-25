<?php
  $webkiosk = new rex_webkiosk_manager();
  if(!rex_get("article")) {
    echo "Kein Artikel ausgewählt";
  } else {
    $a_id = intval(rex_get("article"));
    $article = $webkiosk->getArticle($a_id);
    $image_1 = (string)$article["product_image"];
    $image_2 = (string)$article["product_image_2"];
    $image_3 = (string)$article["product_image_3"];
    $image_4 = (string)$article["product_image_4"];
?>

<div class="einzelartikel">
    <?php
      if(isset($image_1) && $image_1 != "nopicture.jpg") {
    ?>
        <a href="./files/<?=$image_1?>" id="imagelink_<?=$article["id"];?>" class="fancybox borderless">
          <img src="<?=$REX["HTDOCS_PATH"];?>index.php?rex_img_type=rex_webkiosk_product&rex_img_file=<?=$image_1?>" border="0" id="image_<?=$article["id"];?>" />
        </a>
    <?php
      } else {
    ?>
        <div class="webkiosk_product_noimage">Keine Bilder vorhanden.</div>
    <?php
      }
    ?>
  <br /><br />
  <div id="thumbpic">
    <?php if(isset($image_1) && $image_1 != "nopicture.jpg" && $image_1 != "") { ?>
      <a id="changelink_1" aid="<?=$article["id"]?>" image="<?=$image_1?>" class="borderless">
    <?php } else { ?>
        <a class="borderless">
    <?php } ?>
      <div class="minipic">
        <?php
          if(isset($image_1) && $image_1 != "nopicture.jpg" && $image_1 != "") { ?>
            <img src="<?=$REX["HTDOCS_PATH"];?>index.php?rex_img_type=rex_webkiosk_product_small&rex_img_file=<?=$image_1;?>" border="0"/>
        <?php         
          }
        ?>
      </div>
    </a>
    <?php if(isset($image_2) && $image_2 != "nopicture.jpg" && $image_2 != "") { ?>
      <a id="changelink_2" aid="<?=$article["id"]?>" image="<?=$image_2?>" class="borderless">
    <?php } else { ?>
        <a class="borderless">
    <?php } ?>
      <div class="minipic">
        <?php
          if(isset($image_2) && $image_2 != "nopicture.jpg" && $image_2 != "") { ?>
            <img src="<?=$REX["HTDOCS_PATH"];?>index.php?rex_img_type=rex_webkiosk_product_small&rex_img_file=<?=$image_2;?>" border="0"/>
        <?php } ?>
      </div>
    </a>
    <?php if(isset($image_3) && ($image_3 != "nopicture.jpg" || $image_3 != "")) { ?>
      <a id="changelink_3" aid="<?=$article["id"]?>" image="<?=$image_3?>" class="borderless">
    <?php } else { ?>
        <a class="borderless">
    <?php } ?>
       <div class="minipic">
        <?php
          if(isset($image_3) && $image_3 != "nopicture.jpg" && $image_3 != "") { ?>
            <img src="<?=$REX["HTDOCS_PATH"];?>index.php?rex_img_type=rex_webkiosk_product_small&rex_img_file=<?=$image_3;?>" border="0"/>
        <?php } ?>
      </div>
    </a>
    <?php if(isset($image_4) && $image_4 !== "nopicture.jpg" && $image_4 !== "") { ?>
      <a id="changelink_3" aid="<?=$article["id"]?>" image="<?=$image_4?>" class="borderless">
    <?php } else { ?>
        <a class="borderless">
    <?php } ?>
       <div class="minipic">
        <?php
          if(isset($image_4) && $image_4 !== "nopicture.jpg" && $image_4 !== "") { ?>
            <img src="<?=$REX["HTDOCS_PATH"];?>index.php?rex_img_type=rex_webkiosk_product_small&rex_img_file=<?=$image_4;?>" border="0"/>
        <?php } ?>
      </div>
    </a>
  </div>
</div>
          
<div id="artikeleinzeltext">
  <div id="artikelbezeichnung">
    <span class="name_details"><?=$article["name_details"];?></span><br><br />
    <span class="price"><?=number_format($article["price"], 2, ",", ".");?> &euro;</span>&nbsp; <a href="#" class="shipping_cost">zzgl. Versandkosten</a>
  </div>
  <div id="warenkorbbox">
    <form action="<?=rex_getUrl($REX["ARTICLE_ID"], 0, array("article" => $article["id"]));?>" method="post">
      <select name="size" id="select_size" class="modellopt">
        <option value="0">Wählen Sie ein Modell</option>
        <?php
        for($i = 1; $i <= 6; $i++): 
          if(isset($article["opt_field_".$i]) && $article["opt_field_".$i] != "") { ?>
            <option value="<?=$article["opt_field_".$i];?>"><?=$article["opt_field_".$i];?></option>
        <?php } endfor; ?>
      </select>
      <br />
      <input type="hidden" name="a_id" value="<?=$article["id"]?>" />
      <input type="hidden" name="amt" value="1" />
     <p> <input type="submit" class="wrkbutton" id="add" type="submit" name="submit" value="&raquo; in den Warenkorb"></p>
    </form>
  </div>
  <div class="trenner"></div>
  <table>
    <tr>
      <td width="80" class="details_1">Details</td>
      <td><?=$article["details_1"];?></td>
    </tr>
    <tr>
      <td width="80" class="details_2"></td>
      <td><?=$article["details_2"];?></td>
    </tr>
    <tr>
      <td width="80" class="details_3"></td>
      <td><?=$article["details_3"];?></td>
    </tr>
  </table>
</div>
<?php  
  }
?>

<script type="text/javascript">
  $(document).ready( function() {
    if($("#select_size").val() == 0){
      $("input[type=submit]#add").attr("disabled", "true");
    } else {
      $("input[type=submit]#add").removeAttr("disabled");
    }
  });

  $("#select_size").change(function() {
    if($("#select_size").val() == 0){
      $("input[type=submit]").attr("disabled", "true");
    } else {
      $("input[type=submit]").removeAttr("disabled");
    }
  });
</script>