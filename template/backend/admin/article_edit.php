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
						<div class="panel center-block" style="width: 50%;">
							<div class="panel-heading">
								<h4 class="panel-title">文章标题</h4>
							</div>
							<div class="panel-body">
								<input type="text" class="form-control" name="title" value="<?=$article['title']?>"> <label id="title-error" class="error" for="title"></label>
							</div>
						</div>
						<div class="panel center-block" style="width: 50%;">
							<div class="panel-heading">
								<h4 class="panel-title">文章内容</h4>
							</div>
							<div class="panel-body">
								<textarea id="content" name="content"><?=htmlspecialchars($article['content'])?></textarea>
								<label id="content-error" class="error" for="title"></label>
							</div>
						</div>
						<div class="panel center-block" style="width: 50%;">
							<div class="panel-heading">
								<h4 class="panel-title">其他信息</h4>
							</div>
							<div class="panel-body">
								<label>分类</label>
								<div id="category_select">
									<select style="display: none" multiple class="form-control" name="category[]" id="category" multiple placeholder="请选择分类">
										<?php foreach ($category as $cate){?>
										<option value="<?=$cate['id']?>" <?=in_array($cate['id'], explode(',', $article['article_category']))?'selected':''?>><?=$cate['name']?></option>
										<?php }?>
									</select>
								</div>
								<label>标签:</label>
								<input class="form-control" name="tags" id="tags" value="<?=htmlspecialchars(json_encode(array_unique(array_filter(explode(',', $article['tags']))),JSON_UNESCAPED_UNICODE))?>">
								<label>摘要:</label>
								<textarea id="summary" name="summary"><?=$article['summary']?></textarea>
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
				<a class="button" target="_blank" href="<?=http::url('article', 'index', array('id' => $article['id']))?>">预览</a>
					</div>
				</form>
			</div>


		</div>
	</div>

<?php include_once BACKEND.'common/footer.php';?>
<script type="text/javascript" src="<?=assets::js('jquery')?>"></script>
<script type="text/javascript" src="<?=assets::js('global.js')?>"></script>
<script type="text/javascript" src="<?=assets::path('ckeditor/ckeditor.js')?>"></script>
<script type="text/javascript" src="<?=assets::path('ckfinder/ckfinder.js')?>"></script>
<script type="text/javascript" src="<?=assets::js('jquery.tags.js')?>"></script>
<script type="text/javascript" src="<?=assets::js('jquery.dropdown.js')?>"></script>
<script type="text/javascript">
	var editor = CKEDITOR.replace( 'content' ,{
		// 是否使用完整的html编辑模式 如使用，其源码将包含：<html><body></body></html>等标签  
		fullPage: false,
		// 界面语言，默认为 'en'
		language:'zh-cn',
		// 编辑器样式，有三种：'kama'（默认）、'office2003'、'v2' 
		//skin:'v2',
		toolbar:'full',
		toolbar_full: 
			[  
			    { name: 'document', items : [ 'Source' ] },  
			    { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },  
			    { name: 'editing', items : [ 'Find','Replace'] },  
			    { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },  
			    { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CodeSnippet','Templates',  
			    '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },  
			    { name: 'links', items : [ 'Link','Unlink','Anchor' ] },  
			    { name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },  
			    { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },  
			    { name: 'colors', items : [ 'TextColor','BGColor' ] },  
			    { name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }  
			],
		extraPlugins: 'codesnippet,autogrow',
		codeSnippet_theme: 'default',
        autoGrow_minHeight:200,
		autoGrow_maxHeight:600,
		autoGrow_bottomSpace:50,
	});
	CKFinder.setupCKEditor(editor, '<?=assets::path('ckfinder')?>');

	var editor = CKEDITOR.replace( 'summary' ,{
		// 是否使用完整的html编辑模式 如使用，其源码将包含：<html><body></body></html>等标签  
		fullPage: false,
		// 界面语言，默认为 'en'
		language:'zh-cn',
		// 编辑器样式，有三种：'kama'（默认）、'office2003'、'v2' 
		//skin:'v2',
		toolbar:'full',
		toolbar_full: 
			[  
			    { name: 'document', items : [ 'Source' ] },  
			    { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },  
			    { name: 'editing', items : [ 'Find','Replace'] },  
			    { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },  
			    { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CodeSnippet','Templates',  
			    '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },  
			    { name: 'links', items : [ 'Link','Unlink','Anchor' ] },  
			    { name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },  
			    { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },  
			    { name: 'colors', items : [ 'TextColor','BGColor' ] },  
			    { name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }  
			],
		extraPlugins: 'codesnippet,autogrow',
		codeSnippet_theme: 'default',
        autoGrow_minHeight:200,
		autoGrow_maxHeight:200,
		autoGrow_bottomSpace:50,
	});
	CKFinder.setupCKEditor(editor, '<?=assets::path('ckfinder')?>');
	

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

    	var content = CKEDITOR.instances.content.getData();
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