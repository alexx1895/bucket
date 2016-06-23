<div id="cart" class="btn-group btn-block">
	<button type="button" data-toggle="dropdown" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-inverse btn-block btn-lg dropdown-toggle">
		<span class="title-cart"><?php echo $title_cart; ?></span>
		<span id="cart-total"><?php echo $text_items; ?></span>
	</button>
<ul class="dropdown-menu pull-right">
    <?php if ($products || $vouchers) { ?>
	<li>
		<div class="div-sdiviped">
				<?php foreach ($products as $product) { ?>
				<div class="row-cart">
					<div class="image-cart text-center"><?php if ($product['thumb']) { ?>
						<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
						<?php } ?>
					</div>
					<div class="cart-content">
						<div class="product-name text-lef">
							<a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
							<?php if ($product['option']) { ?>
							<?php foreach ($product['option'] as $option) { ?>
							- <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
							<?php } ?>
							<?php } ?>
							<?php if ($product['recurring']) { ?>
							- <small><?php echo $text_recurring; ?> <?php echo $product['recurring']; ?></small>
							<?php } ?>
						</div>
						<strong class="text-right"><?php echo $product['quantity']; ?> x</strong>
						<span class="cart-price text-right"><?php echo $product['total']; ?></span >
						<div class="cart-button text-center"><button type="button" onclick="cart.remove('<?php echo $product['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times-circle"></i></button></div>
					</div>
				</div>
				<?php } ?>
				<?php foreach ($vouchers as $voucher) { ?>
				<div class="row1-cart">
				  <div class="text-center"></div>
				  <div class="text-left"><?php echo $voucher['description']; ?></div>
				  <div class="text-right">x&nbsp;1</div>
				  <div class="text-right"><?php echo $voucher['amount']; ?></div>
				  <div class="text-center text-danger"><button type="button" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></div>
				</div>
				<?php } ?>
		</div>
	</li>
	<li>
    <div class="row2-cart  div-bordered">
          <?php foreach ($totals as $total) { ?>
          <div class="box-cart">
            <span class="text text-right"><strong><?php echo $total['title']; ?> : </strong></span>
            <span class="text1 text-right"><?php echo $total['text']; ?></span>
          </div>
          <?php } ?>
        <div class="button-cart text-right"><!--<a href="<?php echo $cart; ?>"><strong><i class="fa fa-shopping-cart"></i> <?php echo $text_cart; ?></strong></a>--><a href="<?php echo $checkout; ?>"><strong><i class="fa fa-sign-in"></i> <?php echo $text_checkout; ?></strong></a></div>
    </div>
	</li>
    <?php } else { ?>
    <li>
      <p class="text-center"><?php echo $text_empty; ?></p>
    </li>
    <?php } ?>
  </ul>
</div>

<script>
	$(document).ready(function(){
		$('.box-cart').eq(0).hide();
	});
</script>