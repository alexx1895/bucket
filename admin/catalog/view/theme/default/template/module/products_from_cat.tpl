<div class="viewed">
<div class="container">
  <div class="row">
  <div class="col-md-3 col-sm-3">
  <div class="viewed_text">
  Просмотренные товары
  </div>
  </div>
  </div>
  <div class="row">
  <div class="col-md-11 col-sm-12">
  <? if($products){ ?>


        <? $row = 0; ?>
        <?php foreach ($products as $product) { ?>
        <? if($row == 0){ ?>
        <div class="row">
        <? } ?>

          <div class="col-md-3 col-sm-6">
              <div class="product prodact_viewed">
              <div class="pull-left">
              <div class="name">
                <?php echo $product['name']; ?>
              </div>
              <div class="prise">
                ₽ <?php echo $product['price']; ?>
              </div>
              </div>
              <div class="pull-right buttons">
              <a href="javascript:void(0)" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');">
              <div class="korzina">
              </div>
              </a>
              <a href="javascript:void(0)" onclick="wishlist.add('<?php echo $product['product_id']; ?>');">
              <div class="like_grey">
              </div>
              </a>
              </div>
              <a href="<?php echo $product['href']; ?>">
              <div class="kartinka img_viewed">
              <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>">
              </div>
              </a>
              </div>
          </div>

        <? if($row == 3){ ?>
        <? $row = 0; ?>
          </div>
        <? }else{ ?>
        <? $row++; } ?>
        <?php } ?>

        <? if($row < 3){ ?>
          </div>
        <? } ?>
<? } ?>
  </div>
  </div>
  </div>
  </div>