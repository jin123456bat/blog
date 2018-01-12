<?php
use framework\core\assets;
use framework\core\http;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?=$setting['site_title']?> | 后台管理系统</title>
</head>
<link rel="stylesheet" href="<?=assets::css('backend/main.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('backend/tab.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('backend/datatables.css')?>" type="text/css" media="all" />
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
				<div class="tab">
					<div class="tab-header">
						<a href="#article_publish" class="tab-title active">已发布</a>
						<a href="#article_draft" class="tab-title">草稿</a>
						<a href="#article_dustbin" class="tab-title">垃圾箱</a>
					</div>
					<div class="tab-body">
						<div class="tab-page active" id="article_publish">
							<div class="line"></div>
							<table class="table" data-ajax-url="<?=http::url('datatables','article')?>">
								<thead>
									<tr>
										<th><input type="checkbox" class="all_checked"></th>
										<th>文章ID</th>
										<th>文章标题</th>
										<th>创建时间</th>
										<th>发布状态</th>
										<th>浏览次数</th>
										<th>所属分类</th>
										<th width="300px">操作</th>
									</tr>
								</thead>
								<tbody></tbody>
								<tfoot>
									<tr>
										<td id="split_page" colspan="8"></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="tab-page" id="article_draft">
							<div class="line"></div>
							<table class="table" data-ajax-url="<?=http::url('datatables','article')?>">
								<thead>
									<tr>
										<th><input type="checkbox" class="all_checked"></th>
										<th>文章ID</th>
										<th>文章标题</th>
										<th>创建时间</th>
										<th>发布状态</th>
										<th>浏览次数</th>
										<th>所属分类</th>
										<th width="300px">操作</th>
									</tr>
								</thead>
								<tbody></tbody>
								<tfoot>
									<tr>
										<td id="split_page" colspan="8"></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="tab-page" id="article_dustbin">
							<div class="line"></div>
							<table class="table" data-ajax-url="<?=http::url('datatables','article')?>">
								<thead>
									<tr>
										<th><input type="checkbox" class="all_checked"></th>
										<th>文章ID</th>
										<th>文章标题</th>
										<th>创建时间</th>
										<th>发布状态</th>
										<th>浏览次数</th>
										<th>所属分类</th>
										<th width="300px">操作</th>
									</tr>
								</thead>
								<tbody></tbody>
								<tfoot>
									<tr>
										<td id="split_page" colspan="8"></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			
			</div>
		
		</div>
	
	
	</div>
</div>

<?php include_once BACKEND.'common/footer.php';?>
<script type="text/javascript" src="<?=assets::js('jquery')?>"></script>
<script type="text/javascript" src="<?=assets::js('datatables.js')?>"></script>
<script type="text/javascript" src="<?=assets::js('backend/article_publish.js')?>"></script>
<script type="text/javascript" src="<?=assets::js('backend/article_draft.js')?>"></script>
<script type="text/javascript" src="<?=assets::js('backend/article_dustbin.js')?>"></script>
<script type="text/javascript" src="<?=assets::js('tab.js')?>"></script>
<script type="text/javascript" src="<?=assets::js('global.js')?>"></script>
<script type="text/javascript">
tab.on('tab.click.article_publish',function(){
	publish.clearAjaxParameter();
	publish.reload();
}).on('tab.click.article_draft',function(){
	draft.clearAjaxParameter();
	draft.reload();
}).on('tab.click.article_dustbin',function(){
	dustbin.clearAjaxParameter();
	dustbin.reload();
});

$('table').on('click','.look',function(){
	var id = $(this).data('id');
	window.open('<?=http::url('article','index')?>&id='+id);
}).on('click','.edit',function(){
	var id = $(this).data('id');
	window.location = '<?=http::url('admin','artice_edit')?>&id='+id;
});
</script>
</body>
</html>