
<?php echo $header; ?>
<div class="container">
    <div id="content"><?php echo $content_top; ?>
        <div class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php } ?>
        </div>
        <div>
            <h1><?php echo $heading_title; ?></h1>
            <?php if ($testimonials) { ?>
            <div class="testimonial-container">
                <?php foreach ($testimonials as $testimonial) { ?>
				<div class="row-testimonials">
					<div class="testimonial-images"><img src="<?php echo $testimonial['image']; ?>"></div>
					<div class="box-testimonial">
						<div class="testimonial-std"><?php echo $testimonial['content']; ?></div>
						<div class="testimonial-name"><h2><?php echo $testimonial['customer_name']; ?></h2></div>
					</div>
				</div>
                <?php } ?>
            </div>
            <div class="pagination"><?php echo $pagination; ?></div>
            <?php } else { ?>
            <div class="content"><?php echo $text_no_testimonials; ?> <?php echo $pagination; ?></div>
            <?php } ?>
        </div>
    </div>
    <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>