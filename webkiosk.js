var anz = 0;

$(document).ready(function(){
  
  var ppform = document.ppform;
  if(!(ppform === null || ppform === undefined)){
    ppform.submit();
  }
  
  $('body').click(function(event) {
    if (!$(event.target).closest('#cart_detailed').length) {
      $('#cart_detailed').slideUp("slow");
    }
  });
  
  $('#changelink_1').click(function() {
    changeLink(1);
  });
  
  $('#changelink_2').click(function() {
    changeLink(2);
  });
  
  $('#changelink_3').click(function() {
    changeLink(3);
  });

  $('#changelink_4').click(function() {
    changeLink(4);
  });
    
});

function toggleCart() {  
  if($('#cart_detailed').is(":hidden") == true) {
    $('#cart_detailed').slideDown("slow");
  } else {
    $('#cart_detailed').slideUp("slow");
  }
}

function validateText(text){
  if($.trim(text) != '')
    return false;
  else
    return true;
}

function validateZip(zip){
  if(!isNaN(zip) && zip.length == 5)
    return false;
  else
    return true;
}

function validateMail(mail1, mail2){
  var trimmedMail1 = jQuery.trim(mail1);
  var trimmedMail2 = jQuery.trim(mail2);
  if (trimmedMail1 != "" && (trimmedMail1 == trimmedMail2))
    return false;
  else
    return true;
}

function validateAdress() {
  var checkForm = true;
  
  $("form label").each(function(index){
      $(this).addClass('input_correct');
  });
  
  if(validateText($('#name').val())) {
    $('.name').removeClass('input_correct');
    $('.name').addClass('input_error');
    checkForm = false;
  }
  
  if(validateText($('#prename').val())) {
    $('.prename').removeClass('input_correct');
    $('.prename').addClass('input_error');
    checkForm = false;
  }
  
  if(validateText($('#street').val())) {
    $('.street').removeClass('input_correct');
    $('.street').addClass('input_error');
    checkForm = false;
  }
  
  if(validateZip($('#zip').val())) {
    $('.zip').removeClass('input_correct');
    $('.zip').addClass('input_error');
    checkForm = false;
  }
  
  if(validateText($('#city').val())) {
    $('.city').removeClass('input_correct');
    $('.city').addClass('input_error');
    checkForm = false;
  }
  
  if(validateMail($('#email').val(), $('#email2').val())) {
    $('.email').removeClass('input_correct');
    $('.email2').removeClass('input_correct');
    $('.email').addClass('input_error');
    $('.email2').addClass('input_error');
    checkForm = false;
  }

  if($('#agb:checked').length == 0) {
    $('.agb').removeClass('input_correct');
    $('.agb').addClass('input_error');
    checkForm = false;
  }

  
  return checkForm;
}

function validateAlternateAdress() {
  var checkForm = true;
  
  $("form label").each(function(index){
      $(this).addClass('input_correct');
  });
  
  if(validateText($('#alt_name').val())) {
    $('.alt_name').removeClass('input_correct');
    $('.alt_name').addClass('input_error');
    checkForm = false;
  }
  
  if(validateText($('#alt_prename').val())) {
    $('.alt_prename').removeClass('input_correct');
    $('.alt_prename').addClass('input_error');
    checkForm = false;
  }
  
  if(validateText($('#alt_street').val())) {
    $('.alt_street').removeClass('input_correct');
    $('.alt_street').addClass('input_error');
    checkForm = false;
  }
  
  if(validateZip($('#alt_zip').val())) {
    $('.alt_zip').removeClass('input_correct');
    $('.alt_zip').addClass('input_error');
    checkForm = false;
  }
  
  if(validateText($('#alt_city').val())) {
    $('.alt_city').removeClass('input_correct');
    $('.alt_city').addClass('input_error');
    checkForm = false;
  }
  
  return checkForm;
}

function changeLink(link_id) {
  //Standard Link for fancybox images
  // var std_link = "index.php?rex_img_type=rex_webkiosk_product&rex_img_file="+img_name;
  var a_id = $('#changelink_'+link_id).attr('aid');
  var img_name = $('#changelink_'+link_id).attr('image');
  var std_link = "index.php?rex_img_type=rex_webkiosk_product&rex_img_file="+img_name;
  var std_link_a = "./files/"+img_name;
  
  $('#image_'+a_id).attr('src', std_link);
  $('#imagelink_'+a_id).attr('href', std_link_a);
}

function deleteItem(a_id, size) {
  var path = document.location.href;
  path.replace('#', '');

  $.post(path,{delete_item: true, a_id: a_id, size: size},function(data){
    window.location = document.location.href;
  });
}