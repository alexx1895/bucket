<div class="onsaleproducts-container">
<div class="onsale-title"><h3><?php echo $heading_title; ?></h3></div>
<div class="row">
<div class="owl-demo-specialproduct">
  <?php foreach ($products as $product) { ?>
  <div class="item_product">
    <div class="product-thumb transition item-onsale item-inner">
		<div class="box-item">
			<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
			<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
			<?php if($config_slide['f_show_des']){ ?>
			<p class="description"><?php echo $product['description']; ?></p>
			<?php } ?>
			<div class="review-price">
			<?php if($config_slide['f_show_price']){ ?>
			<?php if ($product['price']) { ?>
			<div class="price">
			<?php if (!$product['special']) { ?>
			<?php echo $product['price']; ?>
			<?php } else { ?>
			<span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
			<?php } ?>
			<?php if ($product['tax']) { ?>
			<span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
			<?php } ?>
			</div> <?php } ?>
			<?php } ?>
			<?php if (isset($product['rating'])) { ?>
			<!-- <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php //echo $product['rating']; ?>.png" alt="" /></div> -->
			<?php } ?>
			</div>
			<div class="actions">
				<div class="button-group">
					<div class="cart">
						<?php if($config_slide['f_show_addtocart']) { ?>
						<button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><span><?php echo $button_cart; ?></span></button>
						<?php } ?>
					</div>
					<div class="add-to-links">
						<div class="wishlist">
							<button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"></button>
						</div>
						<div class="compare">
							<button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"></button>
						</div>
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
  $(".owl-demo-specialproduct").owlCarousel({
		items : <?php if($config_slide['items']) { echo $config_slide['items'] ;} else { echo 3;} ?>,
		autoPlay : <?php if($config_slide['f_speed_slide']) { echo 'true' ;} else { echo 'false';} ?>,
		slideSpeed: <?php if($config_slide['f_ani_speed']) { echo $config_slide['f_ani_speed'] ;} else { echo 3000;} ?>,
		navigation : <?php if($config_slide['f_show_nextback']) { echo 'true' ;} else { echo 'false';} ?>,
		paginationNumbers : true,
		pagination : <?php if($config_slide['f_show_ctr']) { echo 'true' ;} else { echo 'false';} ?>,
		stopOnHover : false,
		items : 5,
		itemsDesktop : [1200,4],
		itemsDesktopSmall : [1000,3],
		itemsTablet: [680,2],
		itemsMobile : [460,1]
  });
 
});
</script>