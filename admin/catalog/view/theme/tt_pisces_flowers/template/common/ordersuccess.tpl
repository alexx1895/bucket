<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row" style="min-height: 395px"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1>Спасибо за заказ</h1>
      <? if(isset($order_id)) { ?> Его номер <? echo $order_id; ?>. <? } ?> В течение 15 минут вам перезвонит наш оператор и подтвердит все данные
      <? if( isset($share) && $share){ ?>
      <div class="sharevk" style="
    margin-top: 14px;
    font-weight: bold;
">
        Акция для новых клиентов! Поделись ссылкой на наш магазин во вКонтакте и получи скидку на следующий букет 20%!
      </div>
      <div class="share" style="margin-top: 20px;zoom:1.2">
        <script type="text/javascript">
document.write(VK.Share.button({
  url: 'http://mysite.com',
  title: 'Flowers',
  description: 'Flowers',
  image: 'http://mysite.com/mypic.jpg',
  noparse: true,},{
  type: 'button_nocount',
  text: 'Поделиться'
}));
</script>


<script>
  $(document).ready(function(){
    $('.share').click(function(){
          $.ajax({
        url: 'index.php?route=checkout/checkout/setDiscount',
        type: 'post',
        data: "telephone=<? echo $telephone; ?>",
        dataType: 'json',
        beforeSend: function() {
   },      
        complete: function() {
        },          
        success: function(html) {
          console.log(html);
      
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
    });
  });
</script>

      </div>
      <? } ?>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>