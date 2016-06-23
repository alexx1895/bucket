<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>



      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <?php foreach ($products as $product) { ?>
              <tr>
                <td class="text-center"><?php if ($product['thumb']) { ?>
                  <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
                  <?php } ?></td>
                <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                  <?php if (!$product['stock']) { ?>
                  <span class="text-danger">***</span>
                  <?php } ?>
                  <?php if ($product['option']) { ?>
                  <?php foreach ($product['option'] as $option) { ?>
                  <br />
                  <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                  <?php } ?>
                  <?php } ?>

                  <?php if ($product['flowers']) { ?>
                  <br>
                  Цветы:
                  <?php foreach ($product['flowers'] as $k => $flower) { ?>
                  <small><?php echo $flower; ?> <? if($k!=(count($product['flowers']) - 1)){ ?>, <?}?> </small>
                  <?php } ?>
                  <?php } ?>

                  <?php if ($product['reward']) { ?>
                  <br />
                  <small><?php echo $product['reward']; ?></small>
                  <?php } ?>
                  <?php if ($product['recurring']) { ?>
                  <br />
                  <span class="label label-info"><?php echo $text_recurring_item; ?></span> <small><?php echo $product['recurring']; ?></small>
                  <?php } ?></td>
                <td class="text-left quant"><div class="input-group btn-block" style="max-width: 100%;">
                    <div class="controlcart">
                      <button type="submit" data-toggle="tooltip" title="" class="btn btn-primary minus"><i class="fa fa-minus-circle"></i></button>
                      <input type="text" name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" class="form-control" />
                      <button type="submit" data-toggle="tooltip" title="" class="btn btn-primary plus"><i class="fa fa-plus-circle"></i></button>
                    
                    <span class="input-group-btn">
                    <button type="submit" data-toggle="tooltip" title="Обновить" class="btn btn-primary" style="display: none;"><i class="fa fa-refresh"></i></button>
                    <button type="button" style="margin-left: 20px;" data-toggle="tooltip" title="Удалить" class="btn btn-danger" onclick="cart.remove('<?php echo $product['key']; ?>');"><i class="fa fa-times-circle"></i></button></span>
                    </div>
                    </div></td>
                <td class="text-right"><?php echo $product['price']; ?></td>
                <td class="text-right"><?php echo $product['total']; ?></td>
              </tr>
              <?php } ?>

            </tbody>
          </table>
        </div>
      </form>
      <input type="hidden" value="<? echo $total_price ?>" name="total_price">
      <br />
      <div class="row">
        <div class="col-sm-4 col-sm-offset-8">
          <table class="table table-bordered">
            <?php foreach ($totals as $key => $total) { ?>
            <tr id="total-<? echo $key ?>">
              <td class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
              <td class="text-right"><?php echo $total['text']; ?></td>
            </tr>
            <?php } ?>
          </table>
        </div>
      </div>

      
      <div class="sharediscount" style="display: none;">
        Как только вы ввели свой телефон, наша система вспомнила, что нужно дать вам скидку в 20% за то, что поделились ссылкой на наш магазин со своими друзьями. Спасибо вам! =)
      </div>

    <div class="panel-group client_data">

        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">Контактные данные</h4>
          </div>
            
          <div class="panel-collapse collapse11111" id="collapse-checkout-option">
            <div class="panel-body">

<div class="row">
  <div class="col-sm-4">
    <fieldset id="address1">
            <div class="checkbox hacc">
        <label class="control-label" for="input-hacc">Получать буду я</label>
        <input type="checkbox" name="hacc" id="input-hacc" class="" checked />
      </div>
      <div class="form-group required">

        <label class="control-label" for="input-name">Ваше имя</label>
        <input type="text" name="firstname" value="" placeholder="Ваше имя" id="input-name" class="form-control" />
      </div>
      <div class="form-group required">
        <label class="control-label" for="input-phone">Ваш телефон</label>
        <input type="text" name="telephone" value="" placeholder="Ваш телефон" id="input-phone" class="form-control" />
      </div>
      <div class="form-group">
        <label class="control-label" for="input-email">Ваш email</label>
        <input type="text" name="email" value="" placeholder="Ваш email" id="input-email" class="form-control" />
      </div>
      <div class="checkbox" id="wantspam" style="display: none;">
        <input type="checkbox" name="wantspam" id="input-wantspam" class="" checked />
        <label class="control-label" for="input-wantspam">Хочу получать информацию об акциях и предложениях, например о скидках на букеты рядом с моим адресом. Не чаще раза в сутки</label>
        
      </div>

      <div class="checkbox" id="surprise" style="display: none;">
        <input type="checkbox" name="surprice" id="input-surprise" class="" checked />
        <label class="control-label" for="input-surprise">Это сюрприз! Звонить только в крайнем случае</label>
      </div>
      <div class="form-group" id="namerec" style="display: none;">
        <label class="control-label" for="input-namerec">Имя получателя</label>
        <input type="text" name="namerec" value="" placeholder="Имя получателя" id="input-namerec" class="form-control" />
      </div>
      <div class="form-group" id="phonerec" style="display: none;">
        <label class="control-label" for="input-phonerec">Телефон получателя</label>
        <input type="text" name="telephonerec" value="" placeholder="Телефон получателя" id="input-phonerec" class="form-control" />
      </div>
      </fieldset>
      </div>
      <div class="col-sm-4">
      <fieldset>
      <div class="form-group">
        <label class="control-label" for="input-payment-postcode">Адрес доставки</label>
        <div class="addr">
        <input type="text" name="addres" value="" placeholder="Адрес доставки" id="input-addres" class="form-control" />
      
      <div class="checkbox">
        <label class="control-label" for="input-ismcad">Это в пределах МКАД</label>
        <input type="checkbox" name="ismcad" id="input-ismcad" class="" checked />
      </div>
      </div>
      </div>

      <div class="form-group">
        <label class="control-label" for="input-payment-postcode">Коментарий</label>
        <div class="addr">
        <textarea name="comment" value="" placeholder="" id="input-addres" class="form-control" style="height: 87px" ></textarea>
      
      </div>
      </div>

      </fieldset>
      </div>
      <div class="col-sm-4">
      <fieldset>
      <div class="select">
        <label class="control-label" for="input-del">Доставка</label>
        <br>
        <select name="when_del" id="del">
          <option value="1">Сегодня</option>
          <option value="2">Завтра</option>
          <option value="3">На другую дату</option>
        </select>
      </div>

      <div class="form-group" style="margin-top: 10px;">
        <label class="control-label">Временной интервал</label> <br>
        <div style="padding-left: 15px;"><input id="time_range" type="text" name="time_range"/></div>
        <script>
         var range = $("#time_range").slider({ min: 3, max: 23, value: 0, focus: true , range: true, value: [3, 23]});
           range.on("slide", function(){
           value = range.slider('getValue').toString();

           value = value.split(',');
           if(value[0] >=3 && value[1] <=5){
            $('.tdesc').fadeIn();
           } else {
            if($('select[name="when_del"').val()!=1){
               $('.tdesc').fadeOut();
            }
           }
           
  });
        </script>
        <div class="tdesc" style="display: none;">
          При выборе интервала до 13.00, либо менее 5 часов, стоимость доставки составляет <span id="dcost">200</span> <span id="dmcad"></span> рублей
        </div>
      </div>
<div class="select">
<label for="">Оплата</label>
<select name="payment_method" id="pay">
        <? foreach($payment_methods as $key => $method){ ?>
        <option value="<? echo $key ?>"><? echo $method['title'] ?></option>
                <? } ?>
</select>
</div>
      </div>
    </fieldset>
  </div>
</div>
            </div>
          </div>
        </div>
      <div id="payment-body"></div>
      <div class="form-group">
        <a href="javascript:void(0)" class="howmore" id="getPayment">ОФОРМИТЬ</a>
      </div>
    </div>


      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>

<script>
$(document).ready(function(){

  var cod;

    $('.addr input').focus(function(){
      $(this).parent().addClass('outline');
    }).focusout(function(){
      $(this).parent().removeClass('outline');
    });

    $('.form-group>input').focus(function(){
      $(this).addClass('outline');
    }).focusout(function(){
      $(this).removeClass('outline');
    });

    $('.plus').click(function(e){
      e.preventDefault();
      value = parseInt($(this).prev('input').val());
      value = value + 1;
      $(this).prev('input').val(value);
      $(this).closest('form').submit();
    });

    $('.minus').click(function(e){
      e.preventDefault();
      value = parseInt($(this).next('input').val());
      value = value - 1;
      $(this).next('input').val(value);
      $(this).closest('form').submit();
    });

      $('#total-0').hide();
      $('#total-1').find('.text-right').eq(0).text('Итого с учетом доставки');

      $('.quant input').change(function(){
        $(this).closest('form').submit();
      });

      updateTotalPrice();

      $(document).on('input', 'input[name="telephone"]', function(){
          updateTotalPrice();
      });

      $('input[name="telephone"]').change(function(){
        if(!checkTel($(this).val())){
          alert('Номер телефона некоректный');
        }
      });
      $('input[name="time_range"]').change(function(){
        updateTotalPrice();
        if($(this).val()<5){
          cod =$('input[value="cod"]').closest('.radio').hide();
        } else {
          $('input[value="cod"]').closest('.radio').show();
        }
      });

      $('input[name="ismcad"]').click(function(){
        if(!$('input[name="ismcad"]').is(":checked") ){
          //$('.pricemcad').fadeIn(200);
          // cod = $('option[value="cod"]').detach();
          $('#total-0').find('.text-right').eq(0).text('Доставка за МКАД');
          $('#total-1').find('.text-right').eq(1).append('<span>+30р/км за МКАД</span>');
          $('#dmcad').text('+30р/км за МКАД');
        }else{
          //$('.pricemcad').fadeOut(200);
          // $('select[name="payment_method"]').append(cod);
          $('#total-0').find('.text-right').eq(0).text('Доставка');
          $('#total-1').find('.text-right').eq(1).find('span').remove();
          $('#dmcad').text('');
        }
      });

  $('#input-email').change(function(){
    if($(this).val() == ''){
      return false;
    }
    var r = /^[\w\.\d-_]+@[\w\.\d-_]+\.\w{2,4}$/i;
    if (!r.test($(this).val())){
      alert('Вы ввели некоректный email');
    }else{
      $('#wantspam').fadeIn(200);
    }
   });

  $('input[name="hacc"]').change(function(){
    if(!$(this).is(':checked') ){
      $('#surprise').fadeIn(200);
      $('#namerec').fadeIn(200);
      $('#phonerec').fadeIn(200);
    } else {
      $('#surprise').fadeOut(200);
      $('#namerec').fadeOut(200);
      $('#phonerec').fadeOut(200);
    }
  });
  $('#delivery_time input[type="radio"]').change(function(e){
    $('#delivery_time input[type="radio"]').prop('checked', false);
    $(this).prop('checked', true);
    $(this).parent().parent().parent().find('input[name="when"]').prop('checked', true);
    updateTotalPrice();
  });
  $('input[name="when"]').click(function(e){
    $(this).prop('checked', false);
  });


    // Select payment methods

    $('#getPayment').click(function(){
      if($('input[name="firstname"]').val()=='' || $('input[name="telephone"]').val()==''){
        alert('Заполните обязательные поля');
        return false;
      }
    $.ajax({
        url: 'index.php?route=checkout/checkout/doPayment',
        type: 'post',
        data: $('.client_data input[type="text"], .client_data input[type="radio"]:checked, .client_data input[type="checkbox"]:checked, select[name="payment_method"], textarea[name="comment"], select[name="when_del"]'),
        dataType: 'json',
        beforeSend: function() {
   },      
        complete: function() {
        },          
        success: function(html) {
          console.log(html);
            $('#payment-body').html(html['payment']);
      
        },
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            alert("Оплата этим способом невозможна");
            console.log(xhr.responseText);
        }
    });
    });

});

$('select[name="when_del"').change(function(){
  if($(this).val()!=1){
    $('.tdesc').hide();
  } else {
    $('.tdesc').show();
  }
});

function checkTel( tel ){
  if(tel == ''){
    return true;
  }
    var r = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i;
    if (!r.test(tel)){
      return false;
    }else{
      return true;
    }
}

function updateTotalPrice(){
$.ajax({
        url: 'index.php?route=checkout/checkout/updateDelivery',
        type: 'post',
        dataType: 'json',
        data: $('input[name="total_price"], input[name="telephone"], input[name="time_range"], input[name="when"]:checked, input[name="when_del"]:checked'),
        beforeSend: function() {
   },      
        complete: function() {
        },          
        success: function(html) {
          console.log(html);
          if(html.isBad){
            $('option[value="cod"]').remove();
          }

          if($('select[name="when_del"').val() == 1){
            $('.tdesc').show();
          }

          if(html.isShare){
            $('.sharediscount').fadeIn(200);
          } else {
            $('.sharediscount').fadeOut(200);
          }

          $('#total-0').find('.text-right').eq(1).text(html.cost+' руб');
          if(!$('input[name="ismcad"]').is(":checked") || !$('input[name="hacc"]').is(":checked") ){
              $('#total-0').find('.text-right').eq(0).text('Доставка за МКАД');
            }else{
              $('#total-0').find('.text-right').eq(0).text('Доставка');
            }
          $('#dcost').text(html.cost);
          $('#total-0').show();
          $('#total-1').find('.text-right').eq(1).text(html.total.total+' руб');      
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
</script>

<?php echo $content_block3; ?>
<?php echo $footer; ?>