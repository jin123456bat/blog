<?php
use framework\core\assets;
?>
<link rel="stylesheet" href="<?=assets::css('backend/common/sidebar.css')?>" type="text/css" media="all">
<script type="text/javascript">
	function lpad(num, n) {  
		return Array(n>(''+num).length?(n-(''+num).length+1):0).join(0)+num;  
	}
</script>
<div class="sidebar">
	<div class="datetime">
		<div class="week">
			星期
			<script type="text/javascript">document.write(['日','一','二','三','四','五','六'][new Date().getDay()]);</script>
		</div>
		<div class="time">
			<script type="text/javascript">document.write(lpad(new Date().getHours(),2)+':'+lpad(new Date().getMinutes(),2));</script>
		</div>
		<div class="date">
			<script type="text/javascript">document.write(new Date().getFullYear()+'-'+lpad(new Date().getMonth()+1,2)+'-'+lpad(new Date().getDate(),2));</script>
		</div>
	</div>

	<div class="menu">
		<div class="menu1">
			<?php foreach ($menu1 as $m){?>
			<div class="menu1-item <?=$m['active']?'active':''?>">
				<a href="<?=$m['link']?>"> <img src="http://test.twillg.com/application/template/html/images/u11.png"> 
					<?=$m['name']?>
				</a>
			</div>
			<?php }?>
		</div>
		<div class="menu2">
			<?php foreach ($menu2 as $m){?>
			<div class="menu2-item <?=$m['active']?'active':''?>">
				<a href="<?=$m['link']?>"> •&nbsp;<?=$m['name']?></a>
			</div>
			<?php }?>
		</div>
	</div>
</div>