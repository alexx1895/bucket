<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
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





<div class="overlay_comp">
  <div class="popup_comp">
    <a href="" id="comp_close">&times;</a>
    <h2>СРАВНИВАТЕЛЬ БУКЕТОВ</h2>
    <div class="steps">
      <div class="step"> <span class="num current">1.</span> Укажите желаемую дату доставки 
      <select name="settime" id="">
        <option value="">Выбор</option>
        <option value="">Сегодня</option>
        <option value="">Завтра</option>
        <option value="">Другая дата</option>
      </select> 
      <div class="cheked" id="ctime" style="display: none;">Сегодня</div>
      <div class="subtext">
        от этого завист ассортимент цветов, который мы можем предложить
      </div></div>
      <div class="step"> <span class="num">2.</span> Выберите цветы для букета и их количество
      <div class="cheked" id="composition" style="display: none;">Состав определен</div>
      <div class="instep" id="secondstep" style="display: none;">
        <div class="flowers-list components">

          <input type="hidden" name="product_id" value="81">
          <input type="hidden" name="quantity" value="1">
        </div>
        <div class="groups">
                <? foreach($flowers as $key=>$item){ ?>
                <div class="group">
                <img src="<? echo $groups_images[$key] ?>" alt="" title="<? echo $key; ?>">
                 <div class="items">
                 <? foreach($item as $value){ ?>
                 <div class="item" data-group="<? echo $key ?>" data-id="<? echo $value['id']; ?>" data-price="<? echo $value['price']; ?>"><? echo $value['name']; ?></div>
                 <? } ?>
                  
                 </div>
                </div>
              <? } ?>
                <div class="group">
                <img src="image/catalog/up.png" alt="" title="" class="up">
                 <div class="items">
              <? foreach($options as $option){ ?>
                 <? foreach($option['product_option_value'] as $option_value){ ?>
                 <div class="flow component option item<? echo $option['product_option_id'] ."-". $option_value['product_option_value_id']; ?> <?php if ($option['type'] == 'select') { ?>uniq <? } ?>" data-oid="option<? echo $option['product_option_id']; ?>" data-opt="<? echo $option['product_option_id'] ."-". $option_value['product_option_value_id']; ?>" data-price="<? echo $option_value['price']; ?>"  ><div class="fname"><span class="count"></span> <? echo $option_value['name']; ?></div><div class="del"><a href="javascript:void(0)" class="rem"></a></div>
                  <input type="hidden" name="option[<? echo $option['product_option_id']; ?>]<?php if ($option['type'] != 'select') { ?>[]<? } ?>" value="<? echo $option_value['product_option_value_id']; ?>">
                 </div>
                 <? } ?>
                  
              <? } ?>
                 </div>
                </div>
        </div>
        <div class="showitems">

        </div>
        <a href="javascript:void(0)" class="done">ГОТОВО</a>
      </div>
      </div>
      <div class="step"> <span class="num">3.</span> РАСЧИТАЙТЕ ЦЕНУ И ОФОРМИТЕ ЗАКАЗ
      <div class="instep" id="thirdstep" style="display: none;">
        <div class="ourptice">
        В нашем магазине такой букет будет стоить:<span id="sp">0</span> руб.
        </div>
        <div class="link">
        Укажите ссылку на предложение конкурента (не обязательно)
        <br>
          <input type="text" name="link">
          <input type="hidden" name="iscomp" value="1">
        </div>
        <a href="javascript:void(0)" class="buy_flow">Оформить заказ</a>
      </div>
      </div>
    </div>
  </div>
</div>


    <div class="row" style="padding-left: 15px;">

    <script>

    function cplus(el){
      val = parseInt($(el).parent().prev().find('input').val());
      val += 1;
      $(el).parent().prev().find('input').val(val);
      updatePrice();
    }

    function cminus(el){
      val = parseInt($(el).parent().next().find('input').val());
      val -= 1;
      if(val<1){
        val = 1;
      }
      $(el).parent().next().find('input').val(val);
      updatePrice();
    }

    $(document).ready(function(){

      $('.group').click(function(e){
        e.stopPropagation();
        $('.showitems').empty();
        $(this).find('.items').clone().appendTo('.showitems');
      });
    
      $(document).on('click', '.showitems .item', function(e){
        if($(this).hasClass('option')){
          return false;
        }

        e.stopPropagation();
        $('.component' + $(this).data('id')).remove();

        $('.components').append('<div class="flow component' +  $(this).data('id') + '" data-price="'+$(this).data('price')+'" data-group="'+$(this).data('group')+'"><div class="fname"><span class="count"></span> ' + $(this).text() + ' <input type="hidden" name="flowers[]" value="' + $(this).data('id') + '" /></div><div class="min"><a href="javascript:void(0)" onclick="return cminus(this)"></a></div><div class="quan"><input type="text" class="fq" name="f_quantity['+ $(this).data('id')+'][]" value="1"></div><div class="plus"><a href="javascript:void(0)" onclick="return cplus(this)"></a></div><div class="del"><a href="javascript:void(0)" class="rem"></a></div></div>');
        
        counter();

        updatePrice();
      });

        $(document).on('click', '.showitems .option', function(e){

        e.stopPropagation();
        // если опция типа селект и содержит класс uniq ищем в компонентах опцию с этим id и удаляем
        if($(this).hasClass('uniq')){
          o_id = $(this).data('oid');
          $('.components .option[data-oid='+ o_id +']').remove();
        }

        $('.components .item' + $(this).data('opt')).remove();

        $(this).clone().appendTo('.components');
        counter();
        updatePrice();
      });


        $('select[name="settime"]').change(function(){
          $(this).hide();
          text = $("select[name=\"settime\"] option:selected").text();
          $("#ctime").text(text).show();
          $("#secondstep").show();
          $('.step').find('span.num').removeClass('current');
          $('.step').eq(1).find('span.num').addClass('current');
        });

    });


$('.components').delegate('.rem', 'click', function() {
  $(this).parent().parent().remove();
  var count = 0;

  $('.components .flow').map(function(i){
     count += 1;
     $(this).find('.count').text(count+'.');
  });
});

$('.done').click(function(){

  if($('.components div').length < 1){
    alert("Букет должен содержать цветы");
    return false;
  }

  $(this).hide();
  $('.showitems, .groups').hide();
  flformat();
  $('#composition').show();
  $('.step').find('span.num').removeClass('current');
  $('.step').eq(2).find('span.num').addClass('current');
});

  function counter(){
        var count = 0;

         $('.components .flow').map(function(i){
          count += 1;
          $(this).find('.count').text(count+'.');
         });
  }

  function flformat(){
         $('.components').addClass('cform');

         $('.components .flow').map(function(i){
         $(this).addClass('formated');
         quan = $(this).find('input.fq').val();
         if(quan){
          $(this).find('.fname').append(' ('+quan+' шт.)');
         }
         });

         $('#thirdstep').show();
  }

  function updatePrice(){
    var price = 0;
    var groups = Array();
    $('.components>div').map(function(i){
      data_price = parseInt($(this).data('price'));
      quantity = parseInt($(this).find('input.fq').val());
      if(!isNaN(quantity)){
        price += data_price * quantity;
      } else {
        price += data_price;
      }

      group = $(this).data('group');

      if(group!=undefined && (groups.indexOf(group)) < 0){
        groups.push(group);
      }
      
    });

      $('.components input[name="groups[]"]').remove();

    for (var i = 0; i < groups.length; i++) {
      $('.components').append('<input type="hidden" name="groups[]" value="' + groups[i] + '" />');
    }
      types = groups.length;

      perc = 0;

      switch(types){
        case 1 : perc = 0.1;
        break
        case 2 : perc = 0;
        break
        case 3: perc = 0.05;
        break
      }

    if(price<=1200){
      price += 850;
    } else if(price>=1201 && price<=1500){
      price += 920;
    } else if(price>1500){
      price +=980;
    }

    price += price * perc;


    $("#sp").text(price);
  }


$('.buy_flow').on('click', function() {
  $.ajax({
    url: 'index.php?route=checkout/cart/add',
    type: 'post',
    data: $('.components input, .link input'),
    dataType: 'json',
    beforeSend: function() {
      $('#button-cart').button('loading');
    },
    complete: function() {
      $('#button-cart').button('reset');
    },
    error: function(xhr, ajaxOptions, thrownError) {
        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        alert("Букет должен содержать цветы");
      },
    success: function(json) {
      console.log(json);
      $('.alert, .text-danger').remove();
      $('.form-group').removeClass('has-error');

      if (json['error']) {
        if (json['error']['option']) {
          for (i in json['error']['option']) {
            var element = $('#input-option' + i.replace('_', '-'));
            
            if (element.parent().hasClass('input-group')) {
              element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
            } else {
              element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
            }
          }
        }
        
        if (json['error']['recurring']) {
          $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
        }
        
        // Highlight any found errors
        $('.text-danger').parent().addClass('has-error');
      }
      
      if (json['success']) {
        $('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
        
        $('#cart-total').html(json['total']);
        
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        
        $('#cart > ul').load('index.php?route=common/cart/info ul li');
      }
    }

  });
});


    </script>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>