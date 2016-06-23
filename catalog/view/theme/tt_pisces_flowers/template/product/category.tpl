<?php echo $header; ?>
<div class="container">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
		<ul class="breadcrumb">
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
			<?php } ?>
		</ul>
		<div class="category-top">
			<h2><?php echo $heading_title; ?></h2>
			<?php if ($thumb || $description) { ?>
			<?php if ($thumb) { ?>
			<div class="category-image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="img-thumbnail" /></div>
			<?php } ?>
			<?php if ($description) { ?>
			<div class="category-des"><?php echo $description; ?></div>
			<?php } ?>
			<?php } ?>
		</div>
	 <div class="category-list">
		  <?php if ($categories) { ?>
		  <h3><?php echo $text_refine; ?></h3>
		  <?php if (count($categories) <= 5) { ?>
		  <ul>
			<?php foreach ($categories as $category) { ?>
			<li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
			<?php } ?>
		  </ul>
		  <?php } else { ?>
			<?php foreach (array_chunk($categories, ceil(count($categories) / 4)) as $categories) { ?>
			  <ul>
				<?php foreach ($categories as $category) { ?>
				<li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
				<?php } ?>
			  </ul>
			<?php } ?>
		  <?php } ?>
		  <?php } ?>
	</div>
      <?php if ($products) { ?>
      <div class="row-compare"><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></div>
      <div class="product-filter">
		
    <div class="view-mode">
			<label class="control-label" for="input-mode"><?php echo $text_mode; ?></label>
			<div class="btn-group">
				<button type="button" id="list-view" class="btn btn-default"  title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
				<button type="button" id="grid-view" class="btn btn-default"  title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
			</div>
		</div>
        <div class="sort">
          <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
          <select id="input-sort" class="form-control col-sm-3" onchange="location = this.value;">
            <?php foreach ($sorts as $sorts) { ?>
            <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
            <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
        <div class="limit">
          <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
          <select id="input-limit" class="form-control" onchange="location = this.value;">
            <?php foreach ($limits as $limits) { ?>
            <?php if ($limits['value'] == $limit) { ?>
            <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div>


      </div>	  
      <div class="row products-category">
        <? if($share){ ?>
        	<div class="share_subscribe">
        		Хотите покупать букеты еще дешевле? <a href="javascript:void(0)" id="subscribe">Подпишитесь на акции!</a>
        	</div>
        	<div class="subscribe_overlay" style="display: none;">
        		<div class="subscribe_popup">
        			<input type="text" name="email" placeholder="Email">
        			<a href="javascript:void(0)" id="submit">Оформить подписку</a>
        		</div>
        	</div>
        	<script>
        		$("#subscribe").click(function(e){
        			$('.subscribe_overlay').show();
        		});
        		$(".subscribe_overlay").click(function(e){
        			$(this).hide();
        		});
        		$(".subscribe_popup").click(function(e){
        			e.stopPropagation();
        		});
        	</script>
        <? } ?>
        <?php foreach ($products as $product) { ?>
        <div class="product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-6 col-mobile">
		<div class="product-container">
			<div class="item-inner">
				<div class="box-item">
				  <div class="left-block">
					<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
				  </div>
				  <div class="right-block">
					  <div class="caption">
						<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
						<p class="description"><?php echo $product['description']; ?></p>
						<div class="review-price">
							<?php if ($product['price']) { ?>
							<p class="price">
							  <?php if (!$product['special']) { ?>
							  <?php echo $product['price']; ?>
							  <?php } else { ?>
							  <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
							  <?php } ?>
							  <?php if ($product['tax']) { ?>
							  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
							  <?php } ?>
							</p>
							<?php } ?>
							<!--<?php if (isset($product['rating'])) { ?>
							<div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png"  /></div>
							<?php } ?>-->
						</div>
					  </div>
					  <div class="actions">
						<div class="button-group">
							<div class="cart"><button type="button" title="<?php echo $button_cart; ?>" onclick="cart.add('<?php echo $product['product_id']; ?>');"><span><?php echo $button_cart; ?></span></button></div>
							<div class="add-to-links">
								<!--<div class="wishlist"><button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><span><?php echo $button_wishlist; ?></span></button></div>-->
								<div class="compare"><button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><span><?php echo $button_compare; ?></span></button></div>
							</div>
						</div>
					  </div>
					</div>
				</div>
			</div>
		</div>
		</div>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php //echo $results; ?></div>
      </div>
      <?php } ?>
      <?php if (!$categories && !$products) { ?>
              <? if($share){ ?>
        	<div class="share_subscribe">
        		Сейчас в разделе «Акция!» пусто. Это значит, что у нас остались только супер-свежие букеты по низким ценам =). Можете выбрать что-то из них, либо  <a href="javascript:void(0)" id="subscribe">подписаться на новые акции.</a>
        	</div>
        	<div class="subscribe_overlay" style="display: none;">
        		<div class="subscribe_popup">
        			<input type="text" name="email" placeholder="Email">
        			<a href="javascript:void(0)" id="submit">Оформить подписку</a>
        		</div>
        	</div>
        	<script>
        		$("#subscribe").click(function(e){
        			$('.subscribe_overlay').show();
        		});
        		$(".subscribe_overlay").click(function(e){
        			$(this).hide();
        		});
        		$(".subscribe_popup").click(function(e){
        			e.stopPropagation();
        		});
        	</script>
        <? } else {?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <? } ?>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $content_block3; ?>
<?php echo $footer; ?>