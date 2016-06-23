<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/opentheme/owlcarousel/owl.carousel.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Raleway:400,100,200,600,500,700,800,900' rel='stylesheet' type='text/css' />
<link href="catalog/view/theme/tt_pisces_flowers/stylesheet/stylesheet.css" rel="stylesheet">
<link href="catalog/view/theme/tt_pisces_flowers/stylesheet/animate.css" rel="stylesheet" type="text/css">
<link href="catalog/view/theme/tt_pisces_flowers/stylesheet/opentheme/hozmegamenu/css/custommenu.css" rel="stylesheet">
<link href="catalog/view/theme/tt_pisces_flowers/stylesheet/opentheme/bannersequence/css/bannersequence.css" rel="stylesheet">
<script src="catalog/view/javascript/opentheme/hozmegamenu/custommenu.js" type="text/javascript"></script>
<script src="catalog/view/javascript/opentheme/hozmegamenu/mobile_menu.js" type="text/javascript"></script>
<link href="catalog/view/theme/tt_pisces_flowers/stylesheet/opentheme/css/owl.carousel.css" rel="stylesheet">

<script src="catalog/view/javascript/filter_price/bootstrap-slider.min.js" type="text/javascript"></script>
<link href="catalog/view/theme/tt_pisces_flowers/stylesheet/filter_price/bootstrap-slider.min.css" rel="stylesheet">

<script src="catalog/view/javascript/jquery/elevatezoom/jquery.elevatezoom.js" type="text/javascript"></script>
<script src="catalog/view/javascript/bannersequence/jquery.sequence.js" type="text/javascript"></script>
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<script type="text/javascript" src="http://vk.com/js/api/share.js?90" charset="windows-1251"></script>
<?php echo $google_analytics; ?>
</head>
<body class="<?php echo $class; ?>">
<header>
<div class="header-container">
	<div class="header">
	  <div class="container" style="position: relative;">
		<div class="header-content">
			<div class="row">
				<div class="col-md-4 col-sm-4 col-sms-12">
					<div id="logo">
					<?php if ($logo) { ?>
					  <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
					  <?php } else { ?>
					  <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
					  <?php } ?>
					</div>
				</div>
				<div class="col-md-8 col-sm-8 col-sms-12">
					<div class="header-box">
						<div id="top-links" class="nav pull-right">
							<ul class="list-inline links">
							<li><a href="/index.php?route=information/information&information_id=4">Как мы работаем</a></li>
							<li><a href="/index.php?route=information/information&information_id=6">Доставка и оплата</a></li>
							<li><a href="/index.php?route=information/contact">Контакты</a></li>
							  <!--<li class="dropdown"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown"><span><?php echo $text_account; ?></span> <span class="caret"></span></a>
								<ul class="dropdown-menu-right">
								  <?php if ($logged) { ?>
								  <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
								  <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
								  <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
								  <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
								  <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
								  <?php } else { ?>
								  <li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
								  <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
								  <?php } ?>
								</ul>
							  </li>
							  <li><a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>"></i> <span><?php echo $text_wishlist; ?></span></a></li>
							  <li><a class="shopping_cart" href="<?php echo $shopping_cart; ?>" title="<?php echo $text_shopping_cart; ?>"> <span><?php echo $text_shopping_cart; ?></span></a></li>
							  <li><a class="checkout" href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>"><span><?php echo $text_checkout; ?></span></a></li>-->
							</ul>
						</div>
						<div class="currency-language">
							<!--<?php echo $currency; ?>-->
							<?php echo $language; ?>
						</div>
							<div class="text-welcome"><p><?php echo $text_msg; ?></p></div>	
						<div class="search-cart">
							<div class="header-search">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-lg filtericon" id="search"></button>
								</span>
							</div>
							<div class="header-search" id="button_compare_comp" <? if(!$compare_show){ ?> style="display:none" <? } ?> >
								<span class="cs"><? echo $compare_show; ?></span>
								<span class="input-group-btn">
									<a  href="/index.php?route=product/compare" class="btn btn-default btn-lg"></a>

								</span>
							</div>
							<div class="top-cart">
								<?php echo $cart; ?>
							</div>
						</div>
					</div>
					<div class="header-static">
						<div class="col header-call">
							<h2>Позвоните нам</h2>
							<p><a href="tel:99999">9999999</a></p>
						</div>
						<div class="col header-time">
							<h2>Время работы</h2>
							<p>ежедневно, 10.00 - 21.00</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo $search; ?>

	  </div>
	</div>
	<?php echo $content_block; ?>
</div>
</header>
<?php if ($categories) { ?>
<?php } ?>
