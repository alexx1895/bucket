<div id="search" class="input-group">
  



<div class="price-filter">
	
	<div class="col-sm-3">
	<div class="pf-title"> Цена </div>
	<input id="pf-slider" type="text"/><br/>
	<div class="pf-controll-group">
		<form action="" id="pf-form">
			<div class="col-xs-4 pf-from"><input type="text" value="0" name="pf-from" class="form-control" id="pf-from"></div>
			<div class="col-xs-2 pf-text"><span></span></div>
			<div class="col-xs-4 pf-from"><input type="text" value="100" name="pf-to" class="form-control" id="pf-to"></div>
			<div class="col-xs-12 pf-go"><input type="submit" value="" class="btn btn-default" id="pf-go"></div>
		</form>
	</div>
	</div>
	<div class="col-sm-3">
		<div class="pf-title"> Цветы </div>
		<div class="pf-controll-group">
		
		</div>
	</div>
	<div class="col-sm-3">
		<div class="pf-title"> Цветовая гамма </div>
		<div class="pf-controll-group">
		
		</div>
	</div>
	<div class="col-sm-3">
		<div class="pf-title"> Яркость </div>
		<div class="pf-controll-group">
		
		</div>
	</div>
</div>


<script>
	var value = new Array(0, 100);
	var pfslider = $("#pf-slider").slider({ id: "pfslider", min: 0, max: 100, range: true, value: [0, 100] });
	pfslider.on("slideStop", function(){
		value = pfslider.slider('getValue').toString();
		value = value.split(',');
		
		$("#pf-from").val(value[0]);
		$("#pf-to").val(value[1]);

	});

	$("#pf-form").submit(function(e){
		e.preventDefault();

		_href = location.href;
		_href = _href.split("&pf_from");
		href = _href[0];
		href += '&pf_from='+ value[0] +'&pf_to='+value[1];
		location.href = href;
	});
</script>







  <span class="input-group-btn">
    <button type="button" class="btn btn-default btn-lg"><i class="fa fa-sliders" aria-hidden="true"></i></button>
  </span>
</div>