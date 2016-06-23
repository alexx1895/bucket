<?php if (count($currencies) > 1) { ?>
<div class="pull-left">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="currency">
  <div class="btn-group">
    <label>Currency:</label>
	<button class="btn btn-link dropdown-toggle" data-toggle="dropdown">
    <?php foreach ($currencies as $currency) { ?>
    <?php if ($currency['symbol_left'] && $currency['code'] == $code) { ?>
    <strong><?php echo $currency['symbol_left']; ?></strong>
    <?php } elseif ($currency['symbol_right'] && $currency['code'] == $code) { ?>
    <strong><?php echo $currency['symbol_right']; ?></strong>
    <?php } ?>
    <?php } ?>
    <span></span> <i class="fa fa-caret-down"></i></button>
    <ul class="dropdown-currency">
		<?php foreach ($currencies as $currency) { ?>
		<?php if ($currency['symbol_left']) { ?>
		<li><button class="currency-select btn btn-link btn-block" type="button" name="<?php echo $currency['code']; ?>"><span><?php echo $currency['symbol_left']; ?></span></button></li>
		<?php } else { ?>
		<li><button class="currency-select btn btn-link btn-block" type="button" name="<?php echo $currency['code']; ?>"><span><?php echo $currency['symbol_right']; ?></span></button></li>
		<?php } ?>
		<?php } ?>
    </ul>
  </div>
  <input type="hidden" name="code" value="" />
  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
</div>
<?php } ?>