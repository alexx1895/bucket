<h2> hozical megamenu </h2>

<div class="ma-nav-mobile-container visible-xs">
	<div class="container">
		<div class="navbar">
			<div id="navbar-inner" class="navbar-inner navbar-inactive">
                                <div class="menu-mobile">
                                    <a class="btn btn-navbar navbar-toggle">
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                    </a>
                                    <span class="brand navbar-brand"><?php echo 'Categories'; ?></span>
                                </div>
			
					<?php echo $_menu ?>
			</div>
		</div>
	</div>
</div>

<div class="nav-container visible-desktop">
	<div class="nav1">
		<div class="nav2">
			<div id="pt_custommenu" class="pt_custommenu">
			<?php echo $hozmegamenu; ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
var CUSTOMMENU_POPUP_EFFECT = <?php echo $effect; ?>;
var CUSTOMMENU_POPUP_TOP_OFFSET = <?php echo $top_offset ; ?>
//]]>
</script>