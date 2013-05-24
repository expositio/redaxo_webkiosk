<?php

  class rex_webkiosk_manager {

    var $START_SUM = 0.00;
    var $START_AMT = 0;
    var $SUBJECT_MAIL = "";
    var $SENDER_MAIL = "";
    var $COPY_RECIPIENT_MAIL = "";
    var $TAX = 1.19;
    var $TAX_STRING = "19%";

    function rex_webkiosk_manager() {
      $settings = new rex_webkiosk_settings();
      if(!isset($_SESSION['webkiosk']) && $_SESSION['webkiosk'] == false) {
        $_SESSION['webkiosk']['cart']['amt'] = $START_AMT;
        $_SESSION['webkiosk']['cart']['sum'] = $START_SUM;
        $_SESSION['webkiosk']['cart']['items'] = array();
      }

      $SUBJECT_MAIL = rex_webkiosk_settings::getMailSubject();
      $SENDER_MAIL = rex_webkiosk_settings::getMailAdress();
      $COPY_RECIPIENT_MAIL = rex_webkiosk_settings::getMailAdressCopy();
    }

    function addArticleToCart($a_id = 0, $amount = 0, $size = '') {
      global $REX;
      $sql = rex_sql::factory();
      $db_table = $REX['TABLE_PREFIX']."webkiosk_products";
      
      $sql->setQuery("SELECT `id`,`articlenr`,`price` FROM $db_table WHERE `id`=$a_id");

      $result = $sql->getArray();
      $result = $result[0];

      $_SESSION['webkiosk']['cart']['amt'] += intval($amount, 10);

      if(strpos($result['price'], ',')) {
        $itemPrice = explode(",",$result['price']);
      } else {
        $itemPrice = explode(".",$result['price']);
      }

      if(count($itemPrice) == 1) {
        $_SESSION['webkiosk']['cart']['sum'] += floatval($itemPrice[0]*$amount);
      } else {
        $_SESSION['webkiosk']['cart']['sum'] += floatval($itemPrice[0]*$amount);
        $_SESSION['webkiosk']['cart']['sum'] += floatval(($itemPrice[1] / 100.0)*$amount);
      }

      if(array_key_exists($result['id'], $_SESSION['webkiosk']['cart']['items'])) {
        if(array_key_exists($size, $_SESSION['webkiosk']['cart']['items'][$result['id']])) {
          $_SESSION['webkiosk']['cart']['items'][$result['id']][$size]['amt'] += $amount;
        } else {
          $_SESSION['webkiosk']['cart']['items'][$result['id']][$size] = array();
          $_SESSION['webkiosk']['cart']['items'][$result['id']][$size]['amt'] = $amount;
        }
      } else {
        $_SESSION['webkiosk']['cart']['items'][$result['id']] = $result;
        if(array_key_exists($size, $_SESSION['webkiosk']['cart']['items'][$result['id']])) {
          $_SESSION['webkiosk']['cart']['items'][$result['id']]['size']['amt'] += $amount;
        } else {
          $_SESSION['webkiosk']['cart']['items'][$result['id']][$size] = array();
          $_SESSION['webkiosk']['cart']['items'][$result['id']][$size]['amt'] = $amount;
        }
      }
    }

    function updateShoppingCart($a_id = 0, $amount = 0, $size = '') {
      global $REX;

      $deltaAmount = $_SESSION['webkiosk']['cart']['items'][$a_id][$size]['amt'];
      $deltaPrice = $_SESSION['webkiosk']['cart']['items'][$a_id]['price'];

      $_SESSION['webkiosk']['cart']['amt'] -= $deltaAmount;

      if(strpos($deltaPrice, ',')) {
        $deltaPrice = explode(",",$deltaPrice);
      } else {
        $deltaPrice = explode(".",$deltaPrice);
      }

      if(count($deltaPrice) == 1) {
        $_SESSION['webkiosk']['cart']['sum'] -= floatval($deltaPrice[0]*$deltaAmount);
      } else {
        $_SESSION['webkiosk']['cart']['sum'] -= floatval($deltaPrice[0]*$deltaAmount);
        $_SESSION['webkiosk']['cart']['sum'] -= floatval(($deltaPrice[1] / 100.0)*$deltaAmount);
      }

      $_SESSION['webkiosk']['cart']['amt'] += $amount;

      if(count($deltaPrice) == 1) {
        $_SESSION['webkiosk']['cart']['sum'] += floatval($deltaPrice[0]*$amount);
      } else {
        $_SESSION['webkiosk']['cart']['sum'] += floatval($deltaPrice[0]*$amount);
        $_SESSION['webkiosk']['cart']['sum'] += floatval(($deltaPrice[1] / 100.0)*$amount);
      }

      $_SESSION['webkiosk']['cart']['items'][$a_id][$size]['amt'] = $amount;
    }

    function deleteFromShoppingCart($a_id = 0, $size = '') {
      $deltaAmount = $_SESSION['webkiosk']['cart']['items'][$a_id][$size]['amt'];
      $deltaPrice = $_SESSION['webkiosk']['cart']['items'][$a_id]['price'];

      $_SESSION['webkiosk']['cart']['amt'] -= $deltaAmount;

      if(strpos($deltaPrice, ',')) {
        $deltaPrice = explode(",",$deltaPrice);
      } else {
        $deltaPrice = explode(".",$deltaPrice);
      }

      if(count($deltaPrice) == 1) {
        $_SESSION['webkiosk']['cart']['sum'] -= floatval($deltaPrice[0]*$deltaAmount);
      } else {
        $_SESSION['webkiosk']['cart']['sum'] -= floatval($deltaPrice[0]*$deltaAmount);
        $_SESSION['webkiosk']['cart']['sum'] -= floatval(($deltaPrice[1] / 100.0)*$deltaAmount);
      }

      unset($_SESSION['webkiosk']['cart']['items'][$a_id][$size]);
    }

    function getAllArticle() {
      global $REX;

      $sql = rex_sql::factory();
      $db_table = $REX['TABLE_PREFIX'].'webkiosk_products';
      $sql->setQuery("SELECT * FROM $db_table");

      return $sql->getArray();
    }

    function getArticleByCategory($c_id = 0) {
      global $REX;

      $sql = rex_sql::factory();
      $db_table = $REX['TABLE_PREFIX'].'webkiosk_products';

      $sql->setQuery("SELECT * FROM ".$db_table." WHERE cat_id = ".$c_id);
      
      return $sql->getArray();

    }

    function displayVar() {
      echo "<pre style='background: #b0c4de;'>";
      print_r($_SESSION['webkiosk']);
      echo "</pre>";
    }

    function getShoppingCartWidget() {
      global $REX;

      if($_SESSION['webkiosk'] == true) {
        echo "<div class='webkiosk_cart_visible_widget'>";
          echo "<div id='warenkorbtext'>";
            if($_SESSION['webkiosk']['cart']['amt'] == 1) {
              echo "In Ihrem Warenkorb ist <b>".$_SESSION['webkiosk']['cart']['amt']."</b> Produkt</br>";
            } else {
              echo "In Ihrem Warenkorb sind <b>".$_SESSION['webkiosk']['cart']['amt']."</b> Produkte</br>";
            }
            echo "Gesamtsumme <b>".number_format($_SESSION['webkiosk']['cart']['sum'], 2, ',', '.')."</b> &euro;";
          echo "</div>";
        echo "</div>";
        echo "<div id='kassenblock'>";
          echo "<a class='rg_big' href='".rex_getUrl(rex_webkiosk_settings::getCheckoutSite())."'><span class='rg_blau'>&raquo;</span> <b>zur Kasse</b></a><br />";
          echo "<a class='rg_blau toggle_cart' href='javascript:toggleCart();'>Details Warenkorb anzeigen</a>";
        echo "</div>";
        echo "<div class='clear'></div>";
      }
    }

    function getShoppingCart() {
      global $REX;

      $sql = rex_sql::factory();
      $db_table = $REX['TABLE_PREFIX']."webkiosk_products";

      echo "<div class='webkiosk_cart_widget_toggle'><form action='".rex_getUrl($REX['ARTICLE_ID'], false, array('article' => rex_get('article')))."' method='post'>";

        echo "<div id='cart_detailed_header'><span>Ihr Warenkorb</span></div>";
        echo "<div id='cart_detailed_body'>";
        if($_SESSION['webkiosk']['cart']['amt'] == 0) {
          echo 'Ihr Warenkorb ist leer.<br/>'; 
        } else {
          $counter = 0;
          foreach($_SESSION['webkiosk']['cart']['items'] as $item) {
            $sql->setTable($db_table);
            $sql->setWhere('id = '.$item['id']);
            $sql->select('name');
            $sizeArr = $this->getSizeArray($item['id']);

            for($k = 0; $k <= 5; $k++) {
              if(isset($sizeArr[$k]) && $item[$sizeArr[$k]] != '') {
                echo "<div class='webkiosk_cart_widget_toggle_item'><table><tr><td width='330' class='lin_hotline2'>";
                  echo $sql->getValue('name')." ( ".$sizeArr[$k]." ) </td><td width=55> ".number_format($item['price'], 2, ',', '.')." &euro;</td>";
                  // echo "Anzahl &auml;ndern";
                  echo "<td><input type='text' width='30' class='change_amount' name='amount[".$counter."]' value='".$item[$sizeArr[$k]]['amt']."'></td>";
                  echo "<td width='16'><img onclick=\"javascript: deleteItem(".$item['id'].",'".$sizeArr[$k]."');\" style='cursor: pointer;' src='".$REX['HTDOCS_PATH']."files/button_delete.png' width='15px' height='16px' /></td>";
                  echo "<input type='hidden' name='a_id[".$counter."]' value='".$item['id']."'>";
                  echo "<input type='hidden' name='size[".$counter."]' value='".$sizeArr[$k]."'></tr></table>";
                echo "</div>";
              } //if Ende
              $counter++;
            } //for Ende
          } //foreach Ende
        } //if Ende

        echo "</div>"; //#cart_detailed_body
        
        echo "<div id='cart_detailed_footer'>";

          echo "<div id='cart_sum'>";
            echo "<div id='cart_sum_left'>";
              echo "<span>alle Artikel</span><br />";
              echo "<span>zzgl. Versandkosten</span>";
            echo "</div>";
            echo "<div id='cart_sum_right'>";
              echo "<span><b>".number_format($_SESSION['webkiosk']['cart']['sum'], 2, ',', '.')." &euro;</b></span><br/>";
              echo "<span>".number_format($this->getShippingCost(), 2, ',', '.')." &euro;</span>";
            echo "</div>";
            echo "<div class='clear'></div>";
          echo "</div>";
          
          echo "<div class='webkiosk_cart_widget_toggle_right'>";
            echo "<br/>";
            if(intval($_SESSION['webkiosk']['cart']['amt']) == 0) {
              echo "<br/><br/>";
            } else {
              echo "<div class='cart_refresh'><input type='submit' name='update' class='button_refresh' value='&raquo; Aktualisieren'></div>";
            }
          echo "<input type='hidden' name='id' value='".$item['id']."'>";
          echo "<input type='hidden' name='update_item' value='true'>";
          echo "</div>"; //</form>

          echo "<div class='clear'></div>";
        echo "</div>"; //#cart_detailed_footer
      echo "</form></div>";
    }
    
    function getArticle($a_id = null) {
      global $REX;
      $sql = rex_sql::factory();
      $db_table = $REX['TABLE_PREFIX'].'webkiosk_products';
      
      if($a_id == null) 
      {
        return "<div class='webkiosk_error'>Kein Artikel gefunden.</div>";
      } 
      else 
      {
        $sql->setQuery("SELECT * FROM $db_table WHERE `id` = ".$a_id);
        $result = $sql->getArray();
        $result = $result[0];
        return $result;
      }
    }

    function checkout() {
      if(rex_post('step')) {
        if(rex_post('alternate_adress')) {
          $step = 11;
        } else {
          if(rex_post('step') == 11) {
            $step = 2;
          } else {
            $step = rex_post('step');
          }
        }
      } 
      
      if(!rex_post('step')) {
        $step = 1;
      }
      
      if($_SESSION['webkiosk']['cart']['amt'] <= 0) {
        echo "<div class='webkiosk_empty_shoppingcart'>Ihr Warenkorb ist leer.</div>";
      } else {
        switch($step) {
          case 1:
            $this->checkoutStepOne(); 
            break;
          case 11:
            $this->checkoutStepOneAlternate();
            break;
          case 2:
            $this->checkoutStepTwo();
            break;
          case 3:
            $this->checkoutStepThree();
            break;
          case 4:
            $this->checkoutStepFour();
            break;
          case 5:
            $this->checkoutStepFive();
            break;
          default:
            $this->checkoutStepOne();
            break;
        }
      }
    }
  
    //Adresseingabe
    function checkoutStepOne() {
      global $REX;
      echo '<div style="margin-left:25px;"><img src="files/bestellbalken1.png"/><br/><br/><div class="checkout_headeline">';
        echo '<span class="lin_hotline">Lieferanschrift</span><br/><br/>';
      echo '</div>';

      echo '<form action="'.rex_getUrl($REX['ARTICLE_ID']).'" id="checkoutAdress" method="POST" onsubmit="return validateAdress();">';
      echo '<div class="check_address">';
        echo '<div class="adress_right">';
          echo '<label for="name" class="name">Name</label>';
          echo '<input tabindex="1" type="text" id="name" name="name" class="inputStandard">';
          echo '<div class="clear"></div>';
        echo '</div>';
        echo '<div class="address_left">';
          echo '<label for="prename" class="prename">Vorname</label>';
          echo '<input tabindex="2" type="text" id="prename" name="prename" class="inputStandard">';
          echo '<div class="clear"></div>';
        echo '</div>';
        echo '<div class="clear"></div>';
          echo '<label for="street" class="street">Anschrift</label>';
          echo '<input tabindex="3" type="text" id="street" name="street" class="inputStandard">';
          echo '<div class="clear"></div>';
        echo '<div class="address_left">';
          echo '<label for="zip" class="zip">PLZ</label>';
          echo '<input tabindex="4" type="text" maxlength="5" id="zip" name="zip" class="inputStandard">';
          echo '<div class="clear"></div>';
        echo '</div>';
        echo '<div class="adress_right">';
          echo '<label for="city" class="city">Ort</label>';
          echo '<input tabindex="5" type="text" id="city" name="city" class="inputStandard">';
          echo '<div class="clear"></div>';
        echo '</div>';
        echo '<div class="adress_right">';
          echo '<label for="phone" class="phone">Telefon</label>';
          echo '<input tabindex="6" type="text" id="phone" name="phone" class="inputStandard">';
          echo '<div class="clear"></div>';
        echo '</div>';
        echo '<div class="clear"></div>';
        echo '<div class="address_left">';
          echo '<label for="email" class="email">E-Mail</label>';
          echo '<input tabindex="7" type="text" id="email" name="email" class="inputStandard">';
          echo '<div class="clear"></div>';
        echo '</div>';
        echo '<div class="adress_right">';
          echo '<label for="email2" class="email2">E-Mail wiederholen</label>';
          echo '<input tabindex="8" type="text" id="email2" name="email2" class="inputStandard">';
          echo '<div class="clear"></div>';
        echo '</div>';
        echo '<div class="adress_right">';
           echo '<input tabindex="9" type="checkbox" id="alternate_adress" name="alternate_adress" value="true" class="inputStandard">';
          echo '<label for="alternate_adress" class="alternate_adress">abweichende Rechnungsadresse</label>';
          echo '<div class="clear"></div>';
        echo '</div>';
        echo '<div class="adress_right">';
           echo '<input tabindex="10" type="checkbox" id="agb" name="agb" value="true">';
          echo '<label for="agb" class="agb">Bitte stellen Sie sicher, dass Sie <br>die Bedingungen unserer <a href="#" class="lin_footer">Datenschutzrichtlinie</a> sowie <a href="#" class="lin_footer">AGB</a> gelesen haben und Ihnen zustimmen. Danke! </label>';
          echo '<div class="clear"></div>';
        echo '</div>';
        echo '<div class="clear"></div>';
        echo '<div class="adress_right">';
          echo '&nbsp;';
        echo '</div>';
      echo '</div>';
      echo '<div class="next">';
        echo '<input type="hidden" name="checkout" value="true" />';
        echo '<input type="hidden" name="step" value="11" />';
        echo '<input type="submit" name="submit" value="Weiter" class="nextAdressSubmit">';
      echo '</div></div>';
    }
    
    //Alternative Rechnungsadresse
    function checkoutStepOneAlternate() {
      global $REX;
      $this->initializeShippingAdress();

      echo '<div style="margin-left:25px;"><img src="files/bestellbalken1.png"/><br/><br/><div class="checkout_headeline">';
        echo '<b>Bitte geben Sie die Rechnungsadresse an:</b><br/><br/>';
      echo '</div>';

      echo '<form action="'.rex_getUrl($REX['ARTICLE_ID']).'" id="checkoutAdress" method="POST" onsubmit="return validateAlternateAdress();">';
      echo '<div class="check_address">';
        echo '<div class="adress_right">';
          echo '<label for="alt_name" class="alt_name">Name</label>';
          echo '<input tabindex="1" type="text" id="alt_name" name="alt_name" class="inputStandard">';
          echo '<div class="clear"></div>';
        echo '</div>';
        echo '<div class="address_left">';
          echo '<label for="alt_prename" class="alt_prename">Vorname</label>';
          echo '<input tabindex="2" type="text" id="alt_prename" name="alt_prename" class="inputStandard">';
          echo '<div class="clear"></div>';
        echo '</div>';
        echo '<div class="adress_right">';
          echo '<label for="alt_street" class="alt_street">Anschrift</label>';
          echo '<input tabindex="3" type="text" id="alt_street" name="alt_street" class="inputStandard">';
          echo '<div class="clear"></div>';
        echo '</div>';
        echo '<div class="address_left">';
          echo '<label for="alt_zip" class="alt_zip">PLZ</label>';
          echo '<input tabindex="4" type="text" maxlength="5" id="alt_zip" name="alt_zip" class="inputStandard">';
          echo '<div class="clear"></div>';
        echo '</div>';
        echo '<div class="adress_right">';
          echo '<label for="alt_city" class="alt_city">Ort</label>';
          echo '<input tabindex="5" type="text" id="alt_city" name="alt_city" class="inputStandard">';
          echo '<div class="clear"></div>';
        echo '</div>';
        echo '<div class="clear"></div>';
      echo '</div>';
      echo '<div class="next">';
        echo '<input type="hidden" name="alt_adress" value="true" />';
        echo '<input type="hidden" name="step" value="2" />';
        echo '<input type="submit" name="submit" value="Weiter" class="nextAdressSubmit">';
      echo '</div></div>';
    }

    function checkoutStepTwo() {
      global $REX;
      if(rex_post('alt_adress')) {
        $this->initializeAlternateShippingAdress();
      }
      if(rex_post('email')) {
        $this->initializeShippingAdress();
      }
      
      echo '<div style="margin-left:25px;"><img src="files/bestellbalken2.png"/><br/><br/><div class="check_headline">';
        echo '<span class="lin_hotline">Zahlungsart</span>';
      echo '</div>';

      echo '<div class="check_address">';
        
        echo '<b>Wählen Sie Ihre gew&uuml;nschte Zahlungsart:</b><br/><br/>';
        
        echo '<span class="lin_hotline3">1. Zahlen via PayPal</span><br/>';
        echo 'Hier werden Sie auf die Seite von PayPal geleitet und sollten dann wieder <br />';
         echo 'zur&uuml;ckgehen &uuml;ber Link, um den Bestellvorgang abzuschlie&szlig;en. <br/><i>Auch ohne PayPal-Konto möglich per Kreditkarte oder Lastschrift.</i><br />';
        echo '<form action="'.rex_getUrl($REX['ARTICLE_ID']).'" method="POST">';
          echo '<input type="hidden" name="payment" value="paypal">';
          echo '<input type="hidden" name="step" value="3">';
          echo '<p><input type="submit" id="button_paypal" name="submit" value="&raquo; jetzt mit PayPal bezahlen"></p>';
        echo '</form>';
        
        echo '<br/><br/><span class="lin_hotline3">2. Zahlen per Vorkasse</span><br/>';
        echo 'Sie erhalten eine E-Mail mit unserer Bankverbindung zum Überweisen des Rechnungsbetrages.<br /><br />';
        echo '<form action="'.rex_getUrl($REX['ARTICLE_ID']).'" method="post">';
          echo '<input type="hidden" name="payment" value="prepayment">';
          echo '<input type="hidden" name="step" value="3">';
          echo '<input type="submit" id="button_vorkasse" name="submit" value="&raquo; per Vorkasse bezahlen">';
        echo '</form>';
      echo '</div></div>';

    }

    function checkoutStepThree() {
      $payment = rex_post('payment');
      if($payment != null && $payment != '') {
        if($payment == 'prepayment') {
          $_SESSION['webkiosk']['checkout']['payment'] = 'Vorkasse';
          $this->checkoutStepFour();
        } else if($payment == 'paypal') {
          $_SESSION['webkiosk']['checkout']['payment'] = 'PayPal';
          $this->checkoutStepPaypal();
        }
      }
    }

    function checkoutStepFour() {
      global $REX;
      $sql = rex_sql::factory();
      
      echo '<div style="margin-left:25px;"><img src="files/bestellbalken3.png"/><br/><br/><div class="check_headline">';
        echo '<span class="lin_hotline">Bitte &uuml;berpr&uuml;fen Sie Ihre Bestellung</span><br/><br/>';
      echo '</div>';
      
      $db_products = $REX['TABLE_PREFIX'].'webkiosk_products';
      $db_checkout = $REX['TABLE_PREFIX'].'webkiosk_settings';

      $sql->setQuery("SELECT * FROM $db_checkout");
      $result_checkout = $sql->getArray();
      $result_checkout = $result_checkout[0];

      foreach($_SESSION['webkiosk']['cart']['items'] as $item):
        $sql->setQuery("SELECT * FROM $db_products WHERE `id`=".$item['id']);
        $result = $sql->getArray();
        for($j = 1; $j <= 6; $j++) {
          $size = $result[0]['opt_field_'.$j];
          $size_amount = $result[0]['opt_field_var_'.$j];
          if(isset($item[$size]) && $item[$size] != '') {
            $oldAmt = $size_amount;
            $newAmt = $oldAmt-$item[$size]['amt'];

            $sql->setTable($db_products);
            $sql->setWhere('id = '.$item['id']);
            $sql->setValue('opt_field_var_'.$j, $newAmt);
            
            if($item[$size]['amt'] != '') {
              echo "<div style='float_left; width:450px; clear:both; margin-left:20px; padding-bottom:5px; margin-bottom:5px;'><div class='webkiosk_checkout_name'><img class='webkiosk_thumb_list_view' src='files/".$result[0]['product_image']."''></div>";
              echo "<div class='webkiosk_checkout_name'><b>".$result[0]['name']."</b> ( ".$size." )</div>";
              echo "<br/><div class='webkiosk_checkout_amount'>".$item[$size]['amt']."</div>";
              echo "<div class='webkiosk_checkout_price'> x ".number_format(floatval(str_replace(',','.',$result[0]['price'])), 2, ',', '.')." &euro;</div></div><br/>";
            }
          } //if end
        } //for end
       endforeach;
       
       $grossSum = floatval(str_replace(',','.',$_SESSION['webkiosk']['cart']['sum']));
       $netSum = (float)$grossSum / ($this->TAX);
       
       echo "<div class='overviewkorb'><div class='webkiosk_checkout_all_items'>Alle Artikel</div>";
       echo "<div class='webkiosk_checkout_all_items_amount'>".intval($_SESSION['webkiosk']['cart']['amt'])."</div><br/>";
       echo "<div class='webkiosk_checkout_all_items'>Nettopreis</div>";
       echo "<div class='webkiosk_checkout_all_items_price'>".number_format($netSum, 2, ',', '.')." &euro;</div>";
       echo "<div class='clear'></div>";
       echo "<div class='webkiosk_checkout_all_items_mwst'>".$this->TAX_STRING." MwSt.</div>";
       echo "<div class='webkiosk_checkout_all_items_mwst_price'>".number_format((float)$grossSum-(float)$netSum, 2, ',', '.')." &euro;</div>";
       echo "<div class='clear'></div>";
       echo "<div class='webkiosk_checkout_all_items_mwst'>Versandkosten</div>";
       echo "<div class='webkiosk_checkout_all_items_mwst_price'>".$result_checkout['shipping_cost']." &euro;</div>";
       echo "<div class='clear'></div>";
       echo "<div class='webkiosk_checkout_all_items_sum'><b>Gesamtpreis</b></div>";
       echo "<div class='webkiosk_checkout_all_items_sum_price'> ".number_format(floatval(str_replace(',','.',$_SESSION['webkiosk']['cart']['sum']))+floatval(str_replace(',','.',$result_checkout['shipping_cost'])), 2, ',', '.')." &euro;</div><br/><br/>";
       echo "<div class='clear'></div>";

       echo '<form action="'.rex_getUrl($REX['ARTICLE_ID']).'" method="POST">';
        echo '<input type="hidden" name="step" value="5">';
        echo '<input type="submit" id="submit_button_checkout" name="submit" value="&raquo; Jetzt zum genannten Preis bestellen">';
       echo '</form></div>';
       
       echo "<div class='lin_footer'><br/><br/>Wenn Sie noch Fragen haben, k&ouml;nnen Sie auch anrufen unter 089 - 411 77 367.</div></div>";
      
    }
    
    function checkoutStepFive() {
      $this->buildMail();

      $this->unsetSession();
    }

    function checkoutStepFiveThankYou() {
      global $REX;

      $sql = rex_sql::factory();
      
      $db_checkout = $REX['TABLE_PREFIX'].'webkiosk_settings';

      $sql->setQuery("SELECT checkout_thanks FROM $db_checkout");
      $result_checkout = $sql->getArray();
      
      echo $result_checkout[0]['checkout_thanks'];
    }

    function checkoutStepPaypal() {
      global $REX;

      $sql = rex_sql::factory();
      $db_checkout = $REX['TABLE_PREFIX'].'webkiosk_checkout';
      $db_products = $REX['TABLE_PREFIX'].'webkiosk_products';

      $sql->setQuery("SELECT `paypal_acc`, `shipping_cost` FROM $db_checkout");
      $result_checkout = $sql->getArray();
      $paypal_account = $result_checkout[0]['paypal_acc'];
      $shipping_cost = $result_checkout[0]['shipping_cost'];

      $this->writeOrderToDatabase();

      echo '<form name="ppform" action="https://www.paypal.com/cgi-bin/webscr" method="post">';

        echo '<input type="hidden" name="cmd" value="_cart">';
        echo '<input type="hidden" name="upload" value="1">';
        echo '<input type="hidden" name="custom" value="paypal_payment_passthrough"> ';
        echo '<input type="hidden" name="business" value="'.$paypal_account.'">';
        echo '<input type="hidden" name="currency_code" value="EUR">';
        echo '<input type="hidden" name="shipping_1" value="'.str_replace(',','.',$shipping_cost).'">';
        echo '<input type="hidden" name="return" value="http://'.$REX['SERVER'].'/index.php?article_id='.$REX['ARTICLE_ID'].'">';
        echo '<input type="hidden" name="email" value="'.$_SESSION['checkout']['email'].'">';
        echo '<input type="hidden" name="rm" value="2">';

          $cPay = 1;          
          foreach($_SESSION['webkiosk']['cart']['items'] as $item) {
            $sql->setQuery("SELECT * FROM $db_products WHERE `id` =".$item['id']);
            $result = $sql->getArray();
          
            for($j = 1; $j <= 6; $j++) {
              $size = $result[0]['size_'.$j];
              if(isset($item[$size])) {
              
                $price = str_replace(',','.',$result[0]['price']);
                $grossAmt = floatval($price); //(float)(100/119)*
                $tax = floatval(str_replace(',','.',$item['price']))-$grossAmt;
              
                echo "<input type='hidden' name='item_name_".$cPay."' value='".$result[0]['name']." ( ".$size." )'>";
                echo "<input type='hidden' name='amount_".$cPay."' value='".number_format((float)$grossAmt, 2, '.', ',')."'>";
                echo "<input type='hidden' name='tax_".$cPay." value='".number_format((float)$tax, 2, '.', ',')."'>";
                echo "<input type='hidden' name='quantity_".$cPay." value='".$item[$size]['amt']."'>";
                $cPay++;

              } //if end
            } //for end
          } //foreach end
      echo '</form>';
    }

    function buildMail() {
      global $REX;

      $sql = rex_sql::factory();
      
      $db_checkout = $REX['TABLE_PREFIX'].'webkiosk_settings';
      $db_products = $REX['TABLE_PREFIX'].'webkiosk_products';

      $sql->setQuery("SELECT * FROM $db_checkout");
      $result_checkout = $sql->getArray();
      $result_checkout = $result_checkout[0];

      $lieferadresse = "Ihre Lieferadresse:\n";
      $lieferadresse.= $_SESSION['webkiosk']['checkout']['name']." ".$_SESSION['webkiosk']['checkout']['prename']."\n";
      $lieferadresse.= $_SESSION['webkiosk']['checkout']['zip']." ".$_SESSION['webkiosk']['checkout']['city']."\n";
      $lieferadresse.= $_SESSION['webkiosk']['checkout']['street']."\n";

      $rechnungsadresse = "Ihre Rechnungsadresse:\n";
      if(isset($_SESSION['webkiosk']['checkout']['alt_name']) && $_SESSION['webkiosk']['checkout']['alt_name'] != '') {
        $rechnungsadresse.= $_SESSION['webkiosk']['checkout']['alt_name']." ".$_SESSION['webkiosk']['checkout']['alt_prename']."\n";
        $rechnungsadresse.= $_SESSION['webkiosk']['checkout']['alt_zip']." ".$_SESSION['webkiosk']['checkout']['alt_city']."\n";
        $rechnungsadresse.= $_SESSION['webkiosk']['checkout']['alt_street']."\n";
      } else {
        $rechnungsadresse.= $_SESSION['webkiosk']['checkout']['name']." ".$_SESSION['webkiosk']['checkout']['prename']."\n";
        $rechnungsadresse.= $_SESSION['webkiosk']['checkout']['zip']." ".$_SESSION['webkiosk']['checkout']['city']."\n";
        $rechnungsadresse.= $_SESSION['webkiosk']['checkout']['street']."\n";
      }

      $header = $result_checkout['conf_header_mail'];
      $header = str_replace("###name###", $_SESSION['webkiosk']['checkout']['name'], $header);
      $header = str_replace("###vorname###", $_SESSION['webkiosk']['checkout']['prename'], $header);
      $header = str_replace("###lieferadresse###", $lieferadresse, $header);
      $header = str_replace("###rechnungsadresse###", $rechnungsadresse, $header);

      $body = $header."\n\n";

      foreach($_SESSION['webkiosk']['cart']['items'] as $item):
        $sql->setQuery("SELECT * FROM $db_products WHERE `id`=".$item['id']);
        $result = $sql->getArray();
        for($j = 1; $j <= 6; $j++) {
          $size = $result[0]['opt_field_'.$j];
          $size_amount = $result[0]['opt_field_var_'.$j];
          if(isset($item[$size]) && $item[$size] != '') {
            $oldAmt = $size_amount;
            $newAmt = $oldAmt-$item[$size]['amt'];

            $sql->setTable($db_products);
            $sql->setWhere('id = '.$item['id']);
            $sql->setValue('opt_field_var'.$j, $newAmt);
            
            if($item[$size]['amt'] != '') {
              $body .= $item[$size]['amt']." x ";
              $body .= $result[0]['name']." ( ".$size." ) je ";
              $body .= number_format(floatval(str_replace(',','.',$result[0]['price'])), 2, ',', '.')." Euro\n";
            }
          } //if end
        } //for end
       endforeach;

        $body .= "__________________________\n";
        $body .= $_SESSION['webkiosk']['cart']['amt']." Artikel: ";
        $grossSum = floatval(str_replace(',','.',$_SESSION['webkiosk']['cart']['sum']));
        $netSum = (float)$grossSum / ($this->TAX);
        $body .= number_format($netSum, 2, ',', '.')." Euro\n";
        $body .= $this->TAX_STRING." MwSt.: ".number_format((float)$grossSum-(float)$netSum, 2, ',', '.')." Euro\n";
        $body .= "Versandkosten: ";
        $body .= $result_checkout['shipping_cost']." Euro\n";
        $body .= "Gesamt: ";
        $body .= number_format(floatval(str_replace(',','.',$_SESSION['webkiosk']['cart']['sum']))+floatval(str_replace(',','.',$result_checkout['shipping_cost'])), 2, ',', '.')." Euro\n";

        $body .= "\n";
        
        $footer = $result_checkout['conf_footer_mail'];
        $footer = str_replace("###name###", $_SESSION['webkiosk']['checkout']['name'], $footer);
        $footer = str_replace("###vorname###", $_SESSION['webkiosk']['checkout']['prename'], $footer);
        $footer = str_replace("###lieferadresse###", $lieferadresse, $footer);
        $footer = str_replace("###rechnungsadresse###", $rechnungsadresse, $footer);

        $body .= $footer;

        // $header_mail = 'From: '.$result_checkout['email_addr_1'];
        $to = $_SESSION['webkiosk']['checkout']['email'];
        $subject = $result_checkout['email_subject'];
        $copyto = $result_checkout['email_addr_2'];

        $mail = "<html><head><title>".$subject."</title></head><body>".$header.$body.$footer."</body></html>";

        // für HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
        $header_mail  = 'MIME-Version: 1.0'."\r\n";
        $header_mail .= 'Content-type: text/html; charset=utf-8'."\r\n";

        // zusätzliche Header
        $header_mail .= 'To: '.$to."\r\n";
        $header_mail .= 'From:'.$result_checkout['email_addr_1']."\r\n";

        $sent = mail($to, $subject, $mail, $header_mail).mail($copyto, $subject, $mail, $header_mail);
        //$sent = ;  //send copy to merchant

        if(!$sent){
          echo "<div class='webkiosk_checkout_error'>Es ist ein Fehler aufgetreten. Ihre E-Mail konnte nicht gesendet werden.</div>";
          die();
        } else {
          $this->checkoutStepFiveThankYou();
          $this->writeOrderToDatabase();
        }
    }
    
    function initializeShippingAdress() {
      $_SESSION['webkiosk']['checkout'] = array();

      if(rex_post('name'))
        $_SESSION['webkiosk']['checkout']['name'] = htmlspecialchars(rex_post('name'));

      if(rex_post('prename'))
        $_SESSION['webkiosk']['checkout']['prename'] = htmlspecialchars(rex_post('prename'));

      if(rex_post('street'))
        $_SESSION['webkiosk']['checkout']['street'] = htmlspecialchars(rex_post('street'));

      if(rex_post('zip'))
        $_SESSION['webkiosk']['checkout']['zip'] = htmlspecialchars(rex_post('zip'));

      if(rex_post('city'))
        $_SESSION['webkiosk']['checkout']['city'] = htmlspecialchars(rex_post('city'));

      if(rex_post('email'))
        $_SESSION['webkiosk']['checkout']['email'] = htmlspecialchars(rex_post('email'));

      if(rex_post('email2'))
        $_SESSION['webkiosk']['checkout']['email2'] = htmlspecialchars(rex_post('email2'));
    }
    
    function initializeAlternateShippingAdress() {
      if($_SESSION['webkiosk']['checkout'] == false ) {
        $_SESSION['webkiosk']['checkout'] = array();
      }

      if(rex_post('alt_name'))
        $_SESSION['webkiosk']['checkout']['alt_name'] = htmlspecialchars(rex_post('alt_name'));

      if(rex_post('alt_prename'))
        $_SESSION['webkiosk']['checkout']['alt_prename'] = htmlspecialchars(rex_post('alt_prename'));

      if(rex_post('alt_street'))
        $_SESSION['webkiosk']['checkout']['alt_street'] = htmlspecialchars(rex_post('alt_street'));

      if(rex_post('alt_zip'))
        $_SESSION['webkiosk']['checkout']['alt_zip'] = htmlspecialchars(rex_post('alt_zip'));

      if(rex_post('alt_city'))
        $_SESSION['webkiosk']['checkout']['alt_city'] = htmlspecialchars(rex_post('alt_city'));
    }

    function writeOrderToDatabase() {
      global $REX;

      $sql = rex_sql::factory();
      
      $db_table = $REX['TABLE_PREFIX'].'webkiosk_products';

      foreach($_SESSION['webkiosk']['cart']['items'] as $item):
        if(!empty($item)) {
          $sql->setQuery("SELECT * FROM $db_table WHERE `id`=".$item['id']);
          $result = $sql->getArray();
          for($j = 1; $j <= 6; $j++) {
            $size = $result[0]['opt_field_'.$j];
            $var  = $result[0]['opt_field_var_'.$j];

            if(isset($item[$size])) {
              $sql->setQuery("SELECT `opt_field_var_$j` FROM `$db_table` WHERE id=".$item['id']);
              $result2 = $sql->getArray();

              $oldAmt = $result2[0]['opt_field_var_'.$j];
              $newAmt = $oldAmt-$item[$size]['amt'];

              $sql->setQuery("UPDATE `$db_table` SET `opt_field_var_$j` = '$newAmt' WHERE `id`=".$item['id']);

            } //if end
          } //for end
        }
      endforeach;

      $artPSV = '';
      $itemcount = 1;
      foreach($_SESSION['webkiosk']['cart']['items'] as $item):
        $sql->setQuery("SELECT * FROM $db_table WHERE `id`=".$item['id']);
        $result = $sql->getArray();
        
        for($j = 1; $j <= 6; $j++) {
          $size = $result[0]['opt_field_'.$j];

          if(isset($item[$size])) {
            $resultName = $sql->getArray("SELECT * FROM $db_table");
            $artPSV .= $item['id'].'|'.$item[$size]['amt'].'|'.$item['price'].'|'.$item['articlenr'].'|'.$size;
            if(count($_SESSION['webkiosk']['cart']['items']) > $itemcount)
              $artPSV .= '|';
          } //if end
        } //for end
        $itemcount++;
      endforeach;

      $sql->setTable($REX['TABLE_PREFIX'].'webkiosk_orders');
      $sql->setValue('name', $_SESSION['webkiosk']['checkout']['name']);
      $sql->setValue('first_name', $_SESSION['webkiosk']['checkout']['prename']);
      $sql->setValue('street', $_SESSION['webkiosk']['checkout']['street']);
      $sql->setValue('zip', $_SESSION['webkiosk']['checkout']['zip']);
      $sql->setValue('city', $_SESSION['webkiosk']['checkout']['city']);
      $sql->setValue('state', 'Deutschland');
      $sql->setValue('email', $_SESSION['webkiosk']['checkout']['email']);
      $sql->setValue('articles', $artPSV);
      $sql->setValue('net_sum', $_SESSION['webkiosk']['cart']['sum']);
      $sql->setValue('gross_sum', number_format((floatval(str_replace(',','.',$_SESSION['webkiosk']['cart']['sum'])) / (1.19)), 2));
      
      if(isset($_SESSION['webkiosk']['checkout']['alt_name'])) {
        $sql->setValue('alternate_address', 'yes');
        $sql->setValue('name_alt', $_SESSION['webkiosk']['checkout']['alt_name']);
        $sql->setValue('first_name_alt', $_SESSION['webkiosk']['checkout']['alt_prename']);
        $sql->setValue('street_alt', $_SESSION['webkiosk']['checkout']['alt_street']);
        $sql->setValue('zip_alt', $_SESSION['webkiosk']['checkout']['alt_zip']);
        $sql->setValue('city_alt', $_SESSION['webkiosk']['checkout']['alt_city']);
      }
      
      if($_SESSION['webkiosk']['checkout']['payment'] == 'Vorkasse') {
        $sql->setValue('payment', 0);
      } else {
        $sql->setValue('payment', 1);
      }

      $sql->setValue('status', 4);
      $sql->insert();
    }

    function getAllCategories() {
      global $REX;
      $db_table = $REX['TABLE_PREFIX']."webkiosk_cats";
      $sql = rex_sql::factory();
      $sql->setQuery("SELECT * FROM ".$db_table);
      return $sql->getArray();
    }

    function getCategoryName($c_id = 0) {
      global $REX;

      $sql = rex_sql::factory();
      $sql->setTable($REX['TABLE_PREFIX'].'webkiosk_categories');
      $sql->setWhere('id = '.intval($c_id));
      $sql->select('name');
      if($sql->getRows())
        return $sql->getValue('name');
      else
        return 'Keine Kategorie';
    }

    function unsetSession() {
      unset($_SESSION['webkiosk']);
    }

    function getSizeArray($a_id) {
      global $REX;

      $sql = rex_sql::factory();
      $db_table = $REX['TABLE_PREFIX']."webkiosk_products";

      $sql->setQuery("SELECT opt_field_1,opt_field_2,opt_field_3,opt_field_4,opt_field_5,opt_field_6 FROM $db_table WHERE id = ".$a_id);
      $result = $sql->getArray();
      $array = array();

      if(isset($result[0]['opt_field_1']) && ($result[0]['opt_field_1']) != NULL) {
        $array[0] = $result[0]['opt_field_1'];
      }

      if(isset($result[0]['opt_field_2']) && ($result[0]['opt_field_2']) != NULL) {
        $array[1] = $result[0]['opt_field_2'];
      }

      if(isset($result[0]['opt_field_3']) && ($result[0]['opt_field_3']) != NULL) {
        $array[2] = $result[0]['opt_field_3'];
      }

      if(isset($result[0]['opt_field_4']) && ($result[0]['opt_field_4']) != NULL) {
        $array[3] = $result[0]['opt_field_4'];
      }

      if(isset($result[0]['opt_field_5']) && ($result[0]['opt_field_5']) != NULL) {
        $array[4] = $result[0]['opt_field_5'];
      }

      if(isset($result[0]['opt_field_6']) && ($result[0]['opt_field_6']) != NULL) {
        $array[5] = $result[0]['opt_field_6'];
      }

      return $array;
    }

    function getShippingCost() {
      global $REX;

      $sql = rex_sql::factory();
      $sql->setTable($REX['TABLE_PREFIX']."webkiosk_checkout");
      $sql->select('shipping_cost');
      $sql->getRows();
      return str_replace(',','.',$sql->getValue('shipping_cost'));
    }

    function getBillStatus($bid) {
      global $REX;

      $sql = rex_sql::factory();
      
      $sql->setTable($REX['TABLE_PREFIX']."webkiosk_bill_status");
      $sql->setWhere('id = '.intval($bid));
      $sql->select('name');
      $sql->getRows();
      return $sql->getValue('name'); 
    }
  }
?>