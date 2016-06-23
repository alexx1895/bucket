<!--
<div class="overlay_comp">
	<div class="popup_comp">
		<a href="" id="comp_close">&times;</a>
		<h2>СРАВНИВАТЕЛЬ БУКЕТОВ</h2>
		<div class="steps">
			<div class="step"> <span class="num current">1.</span> Укажите желаемую дату доставки 
			<select name="" id="">
				<option value="">Сегодня</option>
				<option value="">Завтра</option>
				<option value="">Другая дата</option>
			</select> 
			<div class="subtext">
				от этого завист ассортимент цветов, который мы можем предложить
			</div></div>
			<div class="step"> <span class="num">2.</span> Выберите цветы для букета и их количество
			<div class="instep">
				<div class="flowers-list">
					<div class="flow">
						<div class="fname"> Розы красные</div>
						<div class="min"><a href="javascript:void(0)" onclick=""></a></div>
						<div class="quan"><input type="text" value="1"></div>
						<div class="plus"><a href="javascript:void(0)" onclick=""></a></div>
						<div class="del"><a href="javascript:void(0)" class="rem"></a></div>
					</div>
				</div>
			</div>
			</div>
			<div class="step"> <span class="num">3.</span> РАСЧИТАЙТЕ ЦЕНУ И ОФОРМИТЕ ЗАКАЗ
			<div class="instep">
				<div class="ourptice">
				В нашем магазине такой букет будет стоить:<span id="sp">1504</span> руб.
				</div>
				<div class="link">
				Укажите ссылку на предложение конкурента (не обязательно)
				<br>
					<input type="text">
				</div>
				<a href="javascript:void(0)" class="buy_flow">Оформить заказ</a>
			</div>
			</div>
		</div>
	</div>
</div>
-->

<script>
	$(".getcomp").on('click', function(){
	    $.ajax({
        url: 'index.php?route=common/header/comp',
        dataType: 'json',
        beforeSend: function() {
   },      
        complete: function() {
        },          
        success: function(html) {
          console.log(html);
            $('body').append(html['form']);
      
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            //alert("Оплата этим способом невозможна");
            console.log(xhr.responseText);
        }
    });
	});
</script>

<div class="footer">
	<div class="container">
    <div class="row">

<? if(isset($home)){ ?>
<div class="how">
	<div class="container">
		<div class="column col col-xs-12 col-sm-6 col-md-3">
			<div class="num">1</div>
			<div class="text">
Вы делаете
заказ на сайте.
			</div>
		</div>
		<div class="column col col-xs-12 col-sm-6 col-md-3">
			<div class="num">2</div>
			<div class="text">
Цветы поступают
нам с оптового склада.
			</div>
		</div>
		<div class="column col col-xs-12 col-sm-6 col-md-3">
			<div class="num">3</div>
			<div class="text">
Мы собираем их в букет
и передаем на доставку.
			</div>
		</div>
		<div class="column col col-xs-12 col-sm-6 col-md-3">
			<div class="num">4</div>
			<div class="text">
Адресат получает
букет!
			</div>
		</div>
	</div>
</div>

<div>
	<div class="container">
		<div class="row">
			<a href="" class="howmore">УЗНАТЬ ПОДРОБНОСТИ</a>
		</div>
	</div>
</div>
<? } ?>

    </div>
  </div>
</div>
<div class="powered">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-sms-12">
				<div class="left-powered"><h2><?php echo $powered; ?></h2></div>
			</div>
			<div class="col-md-6 col-sm-6 col-sms-12">
				<div class="right-powered">
				</div>
			</div>
		</div>
	</div>
</div>
<div id="back-top" class="hidden-phone" style="display: block;"> </div>

<!-- Theme created by Welford Media for OpenCart 2.0 www.welfordmedia.co.uk -->
<script type="text/javascript">
	$(document).ready(function(){

	 // hide #back-top first
	 $("#back-top").hide();
	 
	 // fade in #back-top
	 $(function () {
	  $(window).scroll(function () {
	   if ($(this).scrollTop() > 100) {
		$('#back-top').fadeIn();
	   } else {
		$('#back-top').fadeOut();
	   }
	  });
	  // scroll body to 0px on click
	  $('#back-top').click(function () {
	   $('body,html').animate({
		scrollTop: 0
	   }, 800);
	   return false;
	  });
	 });

	});
</script>

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'k9zEnANPKl';var d=document;var w=window;function l(){
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
<!-- {/literal} END JIVOSITE CODE -->

<!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter37845650 = new Ya.Metrika({ id:37845650, clickmap:true, trackLinks:true, accurateTrackBounce:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/37845650" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-79018038-1', 'auto');
ga('send', 'pageview');
</script>
</body></html>