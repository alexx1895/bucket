<div class="panel panel-default category-filter" style="display: none;">
<a href="javascript:void(0)" id="filterclose">&times;</a>
  <div class="panel-heading"><span>Фильтр</span></div>
  <div class="list-group">

<? if($min && $category_id!=168){ ?>
  <div class="filter-slider_wrap">
    <div class="filter-slider_inner">
    <div class="price-filter">
      <div class="pf-title"> Цена </div>
      <input type="text" value="<? echo (int)$start ?>" name="pf-from" class="form-control" id="pf-from">
        <input id="pf-slider" type="text"/>
        <input type="text" value="<? echo (int)$end ?>" name="pf-to" class="form-control" id="pf-to">
        <div class="pf-controll-group">
          
        </div>
    </div>


<script>
  var value = new Array(<? echo $min ?>, <? echo $max ?>);
  var pfslider = $("#pf-slider").slider({ id: "pfslider", min: <? echo $min ?>, max: <? echo $max ?>, range: true, value: [<? echo (int)$start ?>, <? echo (int)$end ?>] });
  pfslider.on("slideStop", function(){
    value = pfslider.slider('getValue').toString();
    value = value.split(',');
    
    $("#pf-from").val(value[0]);
    $("#pf-to").val(value[1]);

  });

  $(document).ready(function(){
    $('#pf-from, #pf-to').change(function(){
      val1 = parseInt($("#pf-from").val());
      val2 = parseInt($("#pf-to").val());
      value = val1 + ',' + val2;
      val_arr = new Array(val1, val2);
      pfslider.slider('setValue', val_arr);
    });
  });

</script>
  </div>
  </div>
  <? } ?>
    <?php foreach ($filter_groups as $filter_group) { ?>
	<div class="filter-content">
    <a class="list-group-item"><?php echo $filter_group['name']; ?></a>
    <div class="list-group-item">
      <div id="filter-group<?php echo $filter_group['filter_group_id']; ?>">
        <?php foreach ($filter_group['filter'] as $filter) { ?>
        <?php if (in_array($filter['filter_id'], $filter_category)) { ?>
        <label class="checkbox">
          <input name="filter[]" type="checkbox" value="<?php echo $filter['filter_id']; ?>" checked="checked" />
          <?php echo $filter['name']; ?></label>
        <?php } else { ?>
        <label class="checkbox">
          <input name="filter[]" type="checkbox" value="<?php echo $filter['filter_id']; ?>" />
          <?php echo $filter['name']; ?></label>
        <?php } ?>
        <?php } ?>
      </div>
    </div>
	</div>
    <?php } ?>
  
  </div>
  <div class="panel-footer text-right">
    <button type="button" id="button-filter" class="btn btn-primary"><?php echo $button_filter; ?></button>
  </div>
</div>
<script>
  $(document).ready(function(){
    $("#search").click(function(){
      $(".category-filter").toggle();
    });
    $('#filterclose').click(function(){
      $(".category-filter").hide();
    });
  });
</script>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	filter = [];

  prices = '&price_filter=' + $("#pf-from").val() + '_' + $("#pf-to").val();
	
	$('input[name^=\'filter\']:checked').each(function(element) {
		filter.push(this.value);
	});
	
	location = '<?php echo $action; ?>&filter=' + filter.join(',') + prices;
});
//--></script> 

