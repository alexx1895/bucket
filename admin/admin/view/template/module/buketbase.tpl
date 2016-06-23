<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-carousel" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i>Редактирование</h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-carousel" class="form-horizontal">
					<div class="row">
						<div class="col-md-1">
							image
						</div>
						<div class="col-md-2">
							<input type="text" name="name[]" placeholder="Название цветка">
						</div>
						<div class="col-md-1">
							<input type="checkbox"><label for="">Поставщик</label>
						</div>
						<div class="col-md-2">
							<input type="text" placeholder="Стойкость общаяя">
						</div>
						<div class="col-md-2">
							<input type="text" placeholder="Масштаб">
						</div>
						<div class="col-md-1">
							color
						</div>
						<div class="col-md-1">
							stock
						</div>
						<div class="col-md-1">
							list
						</div>
						<div class="col-md-1">
							<a href="#">remove</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
$('input[name=\'categories\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				console.log(json);
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'categories\']').val('');

		$('#category-categories' + item['value']).remove();

		$('#category-categories').append('<div id="category-categories' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="categories[]" value="' + item['value'] + '" /></div>');
	}
});

$('#category-categories').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

</script>
<?php echo $footer; ?>