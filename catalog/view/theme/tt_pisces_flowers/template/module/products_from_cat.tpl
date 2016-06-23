<? if($products){ ?>
<div class="products-from-catd-container featured-container">
<div class="products-from-catd-sldier-title featured-sldier-title"><h2>Акции</h2></div>
<div class="row">
<div class="owl-demo-products-from-cat">
  <?php foreach ($products as $product) { ?>
  <div class="item_product">
    <div class="product-thumb transition item-inner">
    <div class="box-item">
      <?php if ($product['special']) { ?>
        <span class="sale"> Sale </span>
      <?php } ?>
      <?php if ($product['thumb']) { ?>
      <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
      <?php } else { ?>
      <div class="image"><a href="<?php echo $product['href']; ?>"><img src="image/cache/no_image-100x100.png" alt="<?php echo $product['name']; ?>" /></a></div>
      <?php } ?>
      <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>

      <div class="review-price">
        <?php if ($product['price']) { ?>
        <p class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
          <?php } ?>

        </p> <?php } ?>
      </div>
      <div class="actions">
        <div class="button-group">
          <div class="cart">
            <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><span>Купить</span></button>
          </div>

         </div>
      </div>
    </div>
    </div>
  </div>
  <?php } ?>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() { 
  $(".owl-demo-products-from-cat").owlCarousel({
    stopOnHover : false,
    items : 6,
    itemsDesktop : [1200,4],
    itemsDesktopSmall : [1000,3],
    itemsTablet: [680,2],
    itemsMobile : [460,1]
  });
 
});
</script>
<? } ?>