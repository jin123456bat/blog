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
<link rel="stylesheet" href="<?=assets::css('backend/admin/article_list.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('backend/tab.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('backend/datatables.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('spop.min.css')?>" type="text/css" media="all" />
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
										<th>标签</th>
										<th width="300px">操作</th>
									</tr>
								</thead>
								<tbody></tbody>
								<tfoot>
									<tr>
										<td colspan="2">
											<select class="form-control multi_do">
												<option value="">请选择</option>
												<option value="draft">草稿</option>
												<option value="remove">删除</option>
											</select>
										</td>
										<td id="split_page" colspan="10"></td>
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
										<th>标签</th>
										<th width="300px">操作</th>
									</tr>
								</thead>
								<tbody></tbody>
								<tfoot>
									<tr>
										<td colspan="2">
											<select class="form-control multi_do">
												<option value="">请选择</option>
												<option value="publish">发布</option>
												<option value="remove">删除</option>
											</select>
										</td>
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
										<th>标签</th>
										<th width="300px">操作</th>
									</tr>
								</thead>
								<tbody></tbody>
								<tfoot>
									<tr>
										<td colspan="2">
											<select class="form-control multi_do">
												<option value="">请选择</option>
												<option value="recovery">恢复</option>
												<option value="delete">永久删除</option>
											</select>
										</td>
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
<script type="text/javascript" src="<?=assets::js('spop.min.js')?>"></script>
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

$.ajaxSetup({
	headers: {
        '<?=csrf::$_X_CSRF_TOKEN_NAME?>': '<?=csrf::token()?>' ,
    } ,
});

$('.all_checked').on('click',function(){
	$(this).parents('table').find('tbody input[type=checkbox]').prop('checked',$(this).is(':checked'));
});

$('table').on('click','.look',function(){
	var id = $(this).data('id');
	window.open('<?=http::url('article','index')?>&id='+id);
}).on('click','.edit',function(){
	var id = $(this).data('id');
	window.location = '<?=http::url('admin','article_edit')?>&id='+id;
}).on('click','.publish',function(){
	$.post('<?=http::url('admin','article_update')?>',{id:$(this).data('id'),publish:1},function(response){
		if(response.code==1)
		{
			draft.reload();
		}
		spop({
		    template: response.message,
		    style: response.code==1?'success':'error',
		    autoclose: 3000,
		    position:'bottom-right',
		    icon:true,
		    group:false,
		});
	});
}).on('click','.draft',function(){
	$.post('<?=http::url('admin','article_update')?>',{id:$(this).data('id'),publish:0},function(response){
		if(response.code==1)
		{
			publish.reload();
		}
		spop({
		    template: response.message,
		    style: response.code==1?'success':'error',
		    autoclose: 3000,
		    position:'bottom-right',
		    icon:true,
		    group:false,
		});
	});
}).on('click','.remove',function(){
	var btn = $(this);
	$.post('<?=http::url('admin','article_update')?>',{id:$(this).data('id'),delete:1},function(response){
		if(response.code==1)
		{
			switch(btn.parents('.tab-page').attr('id'))
			{
				case 'article_publish':publish.reload();break;
				case 'article_draft':draft.reload();break;
			}
		}
		spop({
		    template: response.message,
		    style: response.code==1?'success':'error',
		    autoclose: 3000,
		    position:'bottom-right',
		    icon:true,
		    group:false,
		});
	});
}).on('click','.recovery',function(){
	$.post('<?=http::url('admin','article_update')?>',{id:$(this).data('id'),delete:0},function(response){
		if(response.code==1)
		{
			dustbin.reload();
		}
		spop({
		    template: response.message,
		    style: response.code==1?'success':'error',
		    autoclose: 3000,
		    position:'bottom-right',
		    icon:true,
		    group:false,
		});
	});
}).on('click','.delete',function(){
	$.post('<?=http::url('admin','article_delete')?>',{id:$(this).data('id')},function(response){
		if(response.code==1)
		{
			dustbin.reload();
		}
		spop({
		    template: response.message,
		    style: response.code==1?'success':'error',
		    autoclose: 3000,
		    position:'bottom-right',
		    icon:true,
		    group:false,
		});
	});
}).on('change','.multi_do',function(){
	var select = $(this);
	var table = $(this).parents('table');
	var id = [];
	$(this).parents('table').find('tbody input[type=checkbox]:checked').each(function(index,value){
		id.push($(value).val());
	});
	
	if(id.length==0)
	{
		spop({
		    template: '请选择文章',
		    style: 'error',
		    autoclose: 3000,
		    position:'bottom-right',
		    icon:true,
		    group:false,
		});
		select.val('');
		return false;
	}
	switch(select.val())
	{
		case 'delete':
			url = '<?=http::url('admin','article_delete')?>';
			data = {
				id:id,
			};
		break;
		case 'recovery':
			url = '<?=http::url('admin','article_update')?>';
			data = {
				id:id,
				delete:0,
			};
		break;
		case 'draft':
			url = '<?=http::url('admin','article_update')?>';
			data = {
				id:id,
				publish:0,
			};
		break;
		case 'publish':
			url = '<?=http::url('admin','article_update')?>';
			data = {
				id:id,
				publish:1,
			};
		break;
		case 'remove':
			url = '<?=http::url('admin','article_update')?>';
			data = {
				id:id,
				delete:1,
			};
		break;
		default:
			spop({
			    template: '请选择操作',
			    style: 'error',
			    autoclose: 3000,
			    position:'bottom-right',
			    icon:true,
			    group:false,
			});
			select.val('');
			return false;
	}
	select.val('');
	$.post(url,data,function(response){
		if(response.code==1)
		{
			table.trigger('flush');
		}
		spop({
		    template: response.message,
		    style: response.code==1?'success':'error',
		    autoclose: 3000,
		    position:'bottom-right',
		    icon:true,
		    group:false,
		});
		
	});
});
</script>
</body>
</html>