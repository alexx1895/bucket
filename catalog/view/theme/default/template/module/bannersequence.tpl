<?php
$slides = $bannersequences;
$config = $slide_setting[0]; 

?>
<div class="container">
    <div id="sequence-theme">
	<div id="sequence">
	<?php if($config['nextback']) { ?> 
	    <ul class="controls">
		<a class="sequence-prev">Prev</a>
		<a class="sequence-next">Next</a>
	    </ul>
	<?php } ?>	
	  
	    <ul class="sequence-canvas">
		<?php foreach ($slides as $slide): ?>

		     <li class="<?php echo $animate; ?>">
				<h2 class ="title"><?php if($slide['title']) echo $slide['title']; ?></h2>
				<h3 class ="subtitle"><?php if($slide['sub_title']) echo $slide['sub_title']; ?></h3>
				<div class="intro subtitle">
				    <?php $description = ""; ?>
					<?php if($slide['description']) $description =  $slide['description']; ?>
					<?php echo nl2br(html_entity_decode($description, ENT_QUOTES, 'UTF-8')); ?>
				</div>
							    <?php if($slide['image']) { ?>							
								    <img class="slider-bg" src="<?php echo $slide['image']; ?>" alt="Image" />
							    <?php } ?>
							    <?php if($slide['image1']) { ?>
								    <img class="model" src="<?php echo $slide['image1']; ?>" alt="Image" />
							    <?php } ?>

				<?php if ($slide['link']) { ?>
				    <div class ="link subtitle">
					<a href ="<?php echo $slide['link']; ?>"><?php echo 'Shop now'; ?></a>
				    </div>
				<?php } ?>
			    </li>
    <?php endforeach; ?>
	    </ul>
	    <?php if($config['contrl']) { ?>
	      <ul class="sequence-pagination">
		<?php
		    $count=0;
		    foreach ($slides as $slide): 
			$count ++;
	       ?>
		  <li><a href="javascript:void(0)"><?php echo $count; ?> </a></li>
		<?php endforeach; ?>
	    </ul>
		<?php } ?>
	</div>
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