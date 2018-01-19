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
<link rel="stylesheet" href="<?=assets::css('jquery.dropdown.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('backend/admin/article_create.css')?>" type="text/css" media="all" />
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
			<form action="<?=http::url('admin','article_edit')?>" method="post">
			<input type="hidden" name="<?=csrf::$_X_CSRF_TOKEN_NAME?>" value="<?=csrf::token()?>">
			<input type="hidden" name="id" value="<?=$article['id']?>">
			<div class="white-block">
				<div class="panel center-block" style="width:50%;">
					<div class="panel-heading">
						<h4 class="panel-title">文章标题</h4>
					</div>
					<div class="panel-body">
						<input type="text" class="form-control" name="title" value="<?=$article['title']?>">
						<label id="title-error" class="error" for="title"></label>
					</div>
				</div>
				<div class="panel center-block" style="width:50%;">
					<div class="panel-heading">
						<h4 class="panel-title">文章内容</h4>
					</div>
					<div class="panel-body">
						<script id="content" name="content" type="text/plain"><?=$article['content']?></script>
						<label id="content-error" class="error" for="title"></label>
					</div>
				</div>
				<div class="panel center-block" style="width:50%;">
					<div class="panel-heading">
						<h4 class="panel-title">其他信息</h4>
					</div>
					<div class="panel-body">
						<label>分类</label>
						<div id="category_select">
							<select style="display:none" multiple class="form-control" name="category[]" id="category" multiple placeholder="请选择分类">
								<?php foreach ($category as $cate){?>
								<option value="<?=$cate['id']?>" <?=in_array($cate['id'], explode(',', $article['article_category']))?'selected':''?>><?=$cate['name']?></option>
								<?php }?>
							</select>
						</div>
						<label>标签:</label>
						<input class="form-control" name="tags" id="tags" value="<?=htmlspecialchars(json_encode(array_unique(array_filter(explode(',', $article['tags']))),JSON_UNESCAPED_UNICODE))?>">
					</div>
				</div>
				<div class="line"></div>
			</div>
			<div class="foot">
				<input type="hidden" name="publish" value="<?=$article['publish']?>">
				<button type="submit" class="button">保存</button>
				<?php if ($article['publish']==0){?>
				<button type="submit" class="button" onClick="$('input[name=publish]').val(1);">发布</button>
				<?php }?>
				<a class="button" target="_blank" href="<?=http::url('article','index',array(
					'id' => $article['id']
				))?>">预览</a>
			</div>
			</form>
		</div>
	
	
	</div>
</div>

<?php include_once BACKEND.'common/footer.php';?>
<script type="text/javascript" src="<?=assets::js('jquery')?>"></script>
<script type="text/javascript" src="<?=assets::js('global.js')?>"></script>
<script type="text/javascript" src="<?=assets::js('ueditor.config.js')?>"></script>
<script type="text/javascript" src="<?=assets::js('ueditor.all.js')?>"></script>
<script type="text/javascript" src="<?=assets::js('jquery.tags.js')?>"></script>
<script type="text/javascript" src="<?=assets::js('jquery.dropdown.js')?>"></script>
<script type="text/javascript" src="<?=assets::js('jquery-validate')?>" charset="utf-8"></script>
<script type="text/javascript">
	var ueditor = UE.getEditor('content');
	$('#tags').tags({
		class:'form-control',
		seperator:[',','，',';','；','Enter',' '],
	});

	$('#category_select').dropdown({
      limitCount: 5,
      searchable: false,
      choice: function () {
        console.log('.dropdown-mul-2 picked')
      }
    });

    $('form').on('submit',function(){
        var title = $.trim($(this).find('input[name=title]').val());
    	if(title.length == 0)
    	{
        	$('#title-error').html('请填写文章标题');
        	return false;
        }
    	else
    	{
    		$('#title-error').html('');
    	}

    	var content = ueditor.getContent();
    	if(content.length == 0)
    	{
        	$('#content-error').html('请填写文章内容');
        	return false;
    	}
    	else
    	{
    		$('#content-error').html('');
    	}
    });
</script>
</body>
</html>