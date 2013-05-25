<?php
  $webkiosk = new rex_webkiosk_manager();

  $categories = $webkiosk->getAllCategories();
?>

<strong>Kategorie w&auml;hlen:</strong><br /><br />
<select name="VALUE[1]" id="categories">
  <?php foreach($categories as $cat):
  if($cat["id"] == "REX_VALUE[1]") { ?>
    <option value="<?=$cat["id"];?>" selected><?=$cat["name"];?></option>
  <?php } else { ?>
    <option value="<?=$cat["id"];?>"><?=$cat["name"];?></option>
  <?php } endforeach; ?>
</select>