<?php
use framework\core\assets;
use framework\core\http;
use framework\vendor\csrf;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?=$setting['site_title']?> | 后台管理系统</title>
</head>
<link rel="stylesheet" href="<?=assets::css('backend/main.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('backend/admin/category.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('font-awesome/css/font-awesome.min.css')?>" type="text/css" media="all" />
<body>

<?php include_once BACKEND.'common/header.php';?>

<div class="container">
	<?php include_once BACKEND.'common/sidebar.php';?>
	<div class="main">
	
		<div class="title">
			<div class="white-block">
  				<div class="wall-block">
					<p><?=$menu_sup['name']?> - <?=$menu_current['name']?></p>
				</div>
	  		</div>
  		</div>
		<div class="body">
			<div class="white-block">
				<div class="row">
					<div class="col-4">
						<div class="select-multiple-search">
							<input type="text" placeholder="输入名称查找" class="search">
							<div class="icon">
								<i class="fa fa-search"></i>
							</div>
						</div>
						<div class="select-multiple-create" data-parent_id="0">
							<div class="icon">
								<i class="fa fa-plus"></i>
							</div>
							添加一级分类
						</div>
						<div class="select-multiple">
							<?php foreach ($category as $key => $cate){?>
							<div class="option <?=$key==0?'active':''?>" data-id="<?=$cate['id']?>">
								<?=$cate['name']?>
								<div class="icon">
									<i class="fa fa-edit"></i><i class="fa fa-remove"></i>
								</div>
							</div>
							<?php }?>
						</div>
					</div>
					<div class="col-4">
						<div class="select-multiple-search">
							<input type="text" placeholder="输入名称查找" class="search">
							<div class="icon">
								<i class="fa fa-search"></i>
							</div>
						</div>
						<div class="select-multiple-create">
							<div class="icon">
								<i class="fa fa-plus"></i>
							</div>
							添加二级分类
						</div>
						<div class="select-multiple">
							
						</div>
					</div>
					<div class="col-4">
						<div class="select-multiple-search">
							<input type="text" placeholder="输入名称查找" class="search">
							<div class="icon">
								<i class="fa fa-search"></i>
							</div>
						</div>
						<div class="select-multiple-create">
							<div class="icon">
								<i class="fa fa-plus"></i>
							</div>
							添加三级分类
						</div>
						<div class="select-multiple">
							
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>

<div id="create_category_modal" class="modal">
	<div class="modal-header"></div>
	<div class="modal-body"></div>
	<div class="modal-footer"></div>
</div>

<?php include_once BACKEND.'common/footer.php';?>
<script type="text/javascript" src="<?=assets::js('jquery')?>"></script>
<script type="text/javascript" src="<?=assets::js('jquery.modal.js')?>"></script>
<script type="text/javascript">
$('.select-multiple .option').on('click',function(){
	$(this).siblings().removeClass('active');
	$(this).addClass('active');
});

$('.select-multiple-create').on('click',function(){
	$('#create_category_modal').modal();
});
</script>
<script type="text/javascript" src="<?=assets::js('global.js')?>"></script>
</body>
</html>