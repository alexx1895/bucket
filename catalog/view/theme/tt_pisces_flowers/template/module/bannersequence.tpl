<?php
$slides = $bannersequences;
$config = $slide_setting[0]; 

?>
<div id="sequence-theme">
	<div id="sequence">
	<?php if($config['nextback']) { ?> 
	    <ul class="controls">
		<li><a class="sequence-prev">Prev</a></li>
		<li><a class="sequence-next">Next</a></li>
	    </ul>
	<?php } ?>	
	  
	    <ul class="sequence-canvas">
		<?php foreach ($slides as $slide): ?>
			<?php if($slide['type'] == 1) { ?>
		     <li class="<?php echo $animate; ?> effect1">
				<h2 class ="title"><?php if($slide['title']) echo $slide['title']; ?></h2>
				<!--<h3 class ="subtitle1"><?php if($slide['sub_title']) echo $slide['sub_title']; ?></h3>-->
				<div class="intro subtitle">
					<?php $description = ""; ?>
					<?php if($slide['description']) $description =  $slide['description']; ?>
					<?php echo nl2br($description); ?>
				</div>
				<?php if($slide['image']) { ?>							
				   <img class="slider-bg" src="<?php echo $slide['image']; ?>" alt="Image" />
				<?php } ?>
				<?php if($slide['image1']) { ?>
					<img class="model" src="<?php echo $slide['image1']; ?>" alt="Image" />
				<?php } ?>
				<?php if ($slide['link']) { ?>
					<div class ="link subtitle">
					<a <?php if($slide['link'] == "/index.php?route=product/compare_comp"){ ?> class="getcomp" <?} else {?>href ="<?php echo $slide['link']; ?>" <? } ?> ><?php if($slide['sub_title']){ echo $slide['sub_title']; } else { echo 'Shop now'; } ?></a>
					</div>
				<?php } ?>
			    </li>
			<?php } ?>
			<?php if($slide['type'] == 2) { ?>
						 <li class="<?php echo $animate; ?> effect2">
							<h2 class ="title-slider2"><?php if($slide['title']) echo $slide['title']; ?></h2>
								<!--<h3 class ="subtitle1-slider2"><?php if($slide['sub_title']) echo $slide['sub_title']; ?></h3>-->
								<div class="intro-slider2 subtitle-slider2">
									<?php $description = ""; ?>
									<?php if($slide['description']) $description =  $slide['description']; ?>
									<?php echo nl2br($description); ?>
								</div>
								<?php if($slide['image']) { ?>							
									<img class="slider-bg" src="<?php echo $slide['image']; ?>" alt="Image" />
								<?php } ?>
								<?php if($slide['image1']) { ?>
									<img class="model-slider2" src="<?php echo $slide['image1']; ?>" alt="Image" />
								<?php } ?>
							<?php if ($slide['link']) { ?>
								<div class ="link-slider2 subtitle-slider2">
								<a href ="<?php echo $slide['link']; ?>"><?php echo 'Shop now'; ?></a>
								</div>
							<?php } ?>
							</li>
						<?php } ?>
			<?php if($slide['type'] == 3) { ?>
						 <li class="<?php echo $animate; ?> effect3">
								<h2 class ="title-slider3"><?php if($slide['title']) echo $slide['title']; ?></h2>
								<!--<h3 class ="subtitle-slider3"><?php if($slide['sub_title']) echo $slide['sub_title']; ?></h3>-->
								<div class="intro-slider3 subtitle-slider3">
									<?php $description = ""; ?>
									<?php if($slide['description']) $description =  $slide['description']; ?>
									<?php echo nl2br($description); ?>
								</div>
								<?php if($slide['image']) { ?>							
									<img class="slider-bg" src="<?php echo $slide['image']; ?>" alt="Image" />
								<?php } ?>
								<?php if($slide['image1']) { ?>
									<img class="model-slider3" src="<?php echo $slide['image1']; ?>" alt="Image" />
								<?php } ?>
							<?php if ($slide['link']) { ?>
								<div class ="link-slider3 subtitle-slider3">
								<a href ="<?php echo $slide['link']; ?>"><?php echo 'Shop now'; ?></a>
								</div>
							<?php } ?>
							</li>
						<?php } ?>			
    <?php endforeach; ?>

	<? $pag = array('Распродажа', 'Букеты больше — цены ниже', 'Скидка за шейр', 'Гарантия доставки', 'Сравнение цен'); ?>
	    </ul>
	    <?php if($config['contrl']) { ?>
	      <ul class="sequence-pagination">
		<?php
		    $count=0;
		    foreach ($slides as $slide): 
	       ?>
		  <li><a href="javascript:void(0)"><?php echo $pag[$count]; ?> </a></li>
		  <? $count ++; ?>
		<?php endforeach; ?>
	    </ul>
		<?php } ?>
	</div>
</div>
<script type ="text/javascript">

    //<![CDATA[
    $(document).ready(function(){
        //$jqstatus = $jq(".status");
         var options = {
				autoPlay: <?php if($config['auto'] ==1) { echo 'true';} else { echo 'false'; } ?>,
				autoPlayDelay: <?php if($config['delay'] >0) { echo $config['delay']; } else { echo 4000; } ?>,
				pauseOnHover: <?php if($config['hover'] ==1) {echo 'true';} else { echo 'false'; } ?>,
				hidePreloaderDelay: 500,
				nextButton: true,
				prevButton: true,
				pauseButton: true,
				preloader: true,
				pagination:true,
				hidePreloaderUsingCSS: false,                   
				animateStartingFrameIn: true,    
				navigationSkipThreshold: 750,
				preventDelayWhenReversingAnimations: true,
				customKeyEvents: {
					80: "pause"
				}
			};


        var sequence = $("#sequence").sequence(options).data("sequence");

           
    });
    //]]>

</script>


<div class="container advantage">
	<div class="col-sm-4 col-xs-12 adv_item"><div class="image"></div>
	<div class="text">
		<div class="title_adv">Бесплатная доставка</div>
		<div class="desc">Бесплатная доставка в пределах МКАД на все букеты! 100% гарантия доставки! <a href="">Узнать подробности.</a> </div>
	</div></div>
	<div class="col-sm-4 col-xs-12 adv_item"><div class="image"></div>
	<div class="text">
		<div class="title_adv">Максимальная свежесть</div>
		<div class="desc">Свежесть наших букетов контролируется продуманными алгоритмами! <a href="">Подробнее</a></div>
	</div></div>
	<div class="col-sm-4 col-xs-12 adv_item"><div class="image"></div>
	<div class="text">
		<div class="title_adv">Цены до 25% ниже рынка</div>
		<div class="desc">Эффективность наших процессов позволяет давать очень привлекательные цены!<a href="javascript:void(0)" class = "getcomp"> Сравнить с конкурентами</a> </div>
	</div></div>
</div>