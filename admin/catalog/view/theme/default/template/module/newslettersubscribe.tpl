<div id="boxes" class="newletter-container">
 <div style="" id="dialog" class="window">
    <div class="close"  ><a href="javascript:void()" >X</a></div>
	<div class="box">
	  <div class="newletter-title"><h2><?php echo $heading_title; ?></h2></div>
	  <div class="box-content newleter-content">
			<label><?php echo $newletter_lable; ?></label>
		  <div id="frm_subscribe">
			  <form name="subscribe" id="subscribe">
				  <table>
					   <tr>
						 <td><span class="required">*</span>&nbsp;<span><?php echo $entry_email; ?></span><br /><input type="text" value="" name="subscribe_email" id="subscribe_email"></td>
					   </tr>
					   <tr <?php if(!$thickbox) { ?> style="display:none" <?php } ?>>
						 <td><span><?php echo $entry_name; ?></span>&nbsp;<br /><input type="text" value="" name="subscribe_name" id="subscribe_name"> </td>
					   </tr>
					   <tr>
						 <td>
							<a class="button" onclick="email_subscribe()"><span><?php echo $entry_button; ?></span></a>
							<?php if($option_unsubscribe) { ?>
							<a class="button" onclick="email_unsubscribe()"><span><?php echo $entry_unbutton; ?></span></a>
							<?php } ?>    
						 </td>
					   </tr>
					   
				  </table>
			  </form>
		  </div><!-- /#frm_subscribe -->
		  <div id="notification"></div>
		</div><!-- /.box-content -->
 </div>
</div>	
  <div style="width: 2000px;top:-808px; height: 2000px; display: none; opacity: 0.7;" id="mask"> </div>
  <div class="bottom">&nbsp;</div>

  
<script type="text/javascript">
function email_subscribe(){
	$.ajax({
			type: 'post',
			url: 'index.php?route=module/newslettersubscribe/subscribe',
			dataType: 'html',
            data:$("#subscribe").serialize(),
			success: function (html) {
				eval(html);
			}}); 
	
	
}
function email_unsubscribe(){
	$.ajax({
			type: 'post',
			url: 'index.php?route=module/newslettersubscribe/unsubscribe',
			dataType: 'html',
            data:$("#subscribe").serialize(),
			success: function (html) {
				eval(html);
			}}); 
	$('html, body').delay( 1500 ).animate({ scrollTop: 0 }, 'slow'); 
	
}
</script>
<script type="text/javascript">
    $(document).ready(function() {
	 return ; 
        function setCookie(cname,cvalue,exdays)
        {
            var d = new Date();
            d.setTime(d.getTime()+(exdays*24*60*60*1000));
            var expires = "expires="+d.toGMTString();
            document.cookie = cname+"="+cvalue+"; "+expires;
        }
        function getCookie(cname)
        {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++)
            {
                var c = ca[i].trim();
                if (c.indexOf(name)==0) return c.substring(name.length,c.length);
            }
            return "";
        }

        //transition effect
        if(getCookie("shownewsletter") != 1){
            var id = '#dialog';
            //Get the screen height and width
            var maskHeight = $(document).height();
            var maskWidth = $(window).width();
            //Set heigth and width to mask to fill up the whole screen
            //transition effect
            //Get the window height and width
            var winH = $(window).height();
            var winW = $(window).width();
            //Set the popup window to center
            $(id).css('top',  winH/2-$(id).height()/2 -50);
            $(id).css('left', winW/2-$(id).width()/2);
            $('#mask').fadeIn(800);
            $('#mask').fadeTo("slow",0.8);
            $(id).fadeIn(500);
      
        }else {
            $('#advice-required-entry-newsletter').remove();

            $('#dialog').remove();
            $('#boxes').remove();
        }
        //if close button is clicked
        $('.window .close').click(function (e) {
            //Cancel the link behavior
            e.preventDefault();
            $('#mask').hide();
            $('.window').hide();
            setCookie("shownewsletter",'1',1);
        });

//if mask is clicked
        $('#mask').click(function () {
            $(this).preventDefault();
            $(this).hide();
            $('.window').hide();
            setCookie("shownewsletter",'1',1);
        });
    });
</script>


</div><!-- /.box -->
