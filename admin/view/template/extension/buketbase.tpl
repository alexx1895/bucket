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
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i>Редактирование</h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-carousel" class="form-horizontal buketform">
					<div class="row head">
						<div class="col-md-1 col">
							Изображение
						</div>
						<div class="col-md-1 col">
							Название цветка
						</div>
						<div class="col-md-1 col">
							Польз. название
						</div>
						<div class="col-md-1 col">
							Поставщики
						</div>
						<div class="col-md-1 col">
							Стойкость
						</div>
						<div class="col-md-1 col">
							Площадь
						</div>
						<div class="col-md-1 col">
							Цвета
						</div>
						<div class="col-md-1 col">
							Заменители
						</div>
						<div class="col-md-1 col">
							Наличие
						</div>
						<div class="col-md-1 col">
							Цена
						</div>
						<div class="col-md-1 col">
							Букеты
						</div>
						<div class="col-md-1 col">
							Удалить
						</div>
					</div>
					<? $row = 0; ?>
					<? foreach($flowers as $result) { ?>
					<div class="row">
						<input type="hidden" name="bid[]" value="<? echo $result['id'] ?>">
						<div class="col-md-1 col">
							<a href="" id="thumb-image<? echo $row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $result['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
							<input type="hidden" name="b_item[<? echo $result['id'] ?>][image]" value="<?php echo $result['image']; ?>" id="input-image<? echo $row; ?>"/>
						</div>
						<div class="col-md-1 col">
							<input type="text" name="b_item[<? echo $result['id'] ?>][name]" placeholder="Название цветка" value="<? echo $result['name']; ?>">
							<select name="b_item[<? echo $result['id'] ?>][group]">
								<? foreach( $buket_groups as $group){ ?>
								<option value="<? echo $group['buket_group_id'] ?>" <? if($group['buket_group_id'] == $result['group']){?> selected <? } ?>><? echo $group['name']; ?></option>
								<?}?>
							</select>
						</div>
						<div class="col-md-1 col">
							<input type="text" name="b_item[<? echo $result['id'] ?>][customname]" placeholder="Пользовательское название" value="<? echo $result['custom_name']; ?>">
						</div>
						<div class="col-md-1 col providers">
							<div><input type="checkbox"><label for="">Поставщик</label></div>
							<div><input type="checkbox"><label for="">Поставщик2</label></div>
							<div><input type="checkbox"><label for="">Поставщик3</label></div>
							<div><input type="checkbox"><label for="">Поставщик</label></div>
							<div><input type="checkbox"><label for="">Поставщик2</label></div>
							<div><input type="checkbox"><label for="">Поставщик3</label></div>
						</div>
						<div class="col-md-1 col">
							<input type="text" placeholder="Стойкость общаяя" name="b_item[<? echo $result['id'] ?>][durability]" value="<? echo $result['durability']; ?>">
						</div>
						<div class="col-md-1 col">
							<input type="text" placeholder="Масштаб" name="b_item[<? echo $result['id'] ?>][area]" value="<? echo $result['area']; ?>">
						</div>
						<div class="col-md-1 col color">
							<?php foreach ($filters as $filter) { ?>
								<div><input type="checkbox" name="b_item[<? echo $result['id'] ?>][colors][]" value="<?php echo $filter['filter_id']; ?>" <? if(in_array($filter['filter_id'], $result['colors'])) { ?> checked <? } ?>><label for=""><?php echo $filter['filter_description'][3]['name']; ?></label></div>
							<? } ?>
						</div>
						<div class="col-md-1 col cross">
							<input type="text" name="b_item[<? echo $result['id'] ?>][cross]" value="" placeholder="" class="form-control ac" />
							<div class="well well-sm crosslist" style="height: 70px; overflow: auto;">
								<?php foreach ($result['cross'] as $item) { ?>
									<div class="crosslist<?php echo $item['id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $item['name']; ?>
										<input type="hidden" name="b_item[<? echo $result['id'] ?>][cross][]" value="<?php echo $item['id']; ?>" />
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="col-md-1 col">
							<input type="checkbox" name="b_item[<? echo $result['id'] ?>][stock]" <? if($result['stock']) {?> checked <? } ?> ><label for="">Наличие</label>
						</div>
						<div class="col-md-1 col">
							<input type="text" placeholder="Цена" name="b_item[<? echo $result['id'] ?>][price]" value="<? echo $result['price']; ?>">
						</div>
						<div class="col-md-1 col">
							<a href="index.php?route=catalog/product&token=<? echo $token ?>&filter_flower=<? echo $result['name']; ?>">Букеты</a>
						</div>
						<div class="col-md-1 col">
							<a href="index.php?route=extension/buketbase/delete&id=<? echo $result['id']; ?>&token=<? echo $token ?>">remove</a>
						</div>
					</div>
					<? $row++; ?>
					<? } ?>
					<input type="hidden" name="remove_cross" value="">
				</form>
				<div class="row">
					<a href="javascript:void(0)" class="add_flower" onclick="addRow()">Добавить</a>
				</div>
				<div class="row">
					<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

var row = <? echo $row; ?>

function addRow(){
	row = ++row;
	t = token();
	// $('#clone .row').clone().appendTo('.buketform')
	$('.buketform').append('<div class="row"><div class="col-md-1 col"><a href="" id="thumb-image' + row + '" data-toggle="image" class="img-thumbnail"><img src="<? echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="b_item[' + t + '][image]" value="" id="input-image'+ row +'"/></div><div class="col-md-1 col"><input type="text" name="b_item['+t+'][name]" placeholder="Название цветка" value=""><select name="b_item['+t+'][group]"><? foreach( $buket_groups as $group){ ?><option value="<? echo $group['buket_group_id'] ?>"><? echo $group['name'] ?></option><?}?></select></div><div class="col-md-1 col"><input type="text" name="b_item['+t+'][customname]" placeholder="Пользовательское название" value=""></div><div class="col-md-1 col providers"><div><input type="checkbox"><label for="">Поставщик</label></div><div><input type="checkbox"><label for="">Поставщик2</label></div><div><input type="checkbox"><label for="">Поставщик3</label></div><div><input type="checkbox"><label for="">Поставщик</label></div><div><input type="checkbox"><label for="">Поставщик2</label></div><div><input type="checkbox"><label for="">Поставщик3</label></div></div><div class="col-md-1 col"><input type="text" placeholder="Стойкость общаяя" name="b_item['+t+'][durability]" value=""></div><div class="col-md-1 col"><input type="text" placeholder="Масштаб" name="b_item['+t+'][area]" value=""></div><div class="col-md-1 col color"><?php foreach ($filters as $filter) { ?><div><input type="checkbox" name="b_item['+t+'][colors][]" value="<?php echo $filter["filter_id"]; ?>"><label for=""><?php echo $filter["filter_description"][3]["name"]; ?></label></div><? } ?></div><div class="col-md-1 col cross"><input type="text" name="b_item['+t+'][cross]" value="" placeholder="" class="form-control ac" /><div class="well well-sm crosslist" style="height: 70px; overflow: auto;"></div></div><div class="col-md-1 col"><input type="checkbox" name="b_item['+t+'][stock]" checked ><label for="">Наличие</label></div><div class="col-md-1 col"><input type="text" placeholder="Цена" name="b_item['+t+'][price]" value=""></div><div class="col-md-1 col"></div><div class="col-md-1 col"><a href="javascript:void(0)" onclick="$(this).parent().parent().remove();">remove</a></div></div>');
}

	// $('input.ac').bind('keyup.autocomplete',function(){alert();
	$(document).on('keyup.autocomplete','input.ac',function(){
		$(this).autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=extension/buketbase/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				console.log(json);
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$(this).val('');

		$(this).parent().find('.crosslist').find('.crosslist' + item['value']).remove();

		bid = $(this).parent().parent().find('input[name="bid[]"]').val();

		$(this).parent().find('.crosslist').append('<div class="crosslist' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="b_item[' + bid + '][cross][]" value="' + item['value'] + '" /></div>');
	}
});
	});

$('.crosslist').delegate('.fa-minus-circle', 'click', function() {
	id = $(this).next('input').val();
	$(this).parent().remove();
	rc = $('input[name="remove_cross"]').val();
	rc = rc + id + ',';
	$('input[name="remove_cross"]').val(rc);

});

var rand = function() {
	return Math.random().toString(36).substr(2);
};

var token = function() {
	return rand() + rand() + row; 
};

</script>



<?php echo $footer; ?>