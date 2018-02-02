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
<link rel="stylesheet" href="<?=assets::css('backend/admin/setting_article.css')?>" type="text/css" media="all" />
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
			<form action="<?=http::url('admin','setting_article')?>" method="post">
				<input type="hidden" name="<?=csrf::$_X_CSRF_TOKEN_NAME?>" value="<?=csrf::token()?>">
				<div class="white-block">
					<div class="panel center-block" style="width:50%;">
						<div class="panel-heading">
							<h4 class="panel-title">文章公共底部</h4>
						</div>
						<div class="panel-body">
							<textarea id="article_footer" name="article_footer"><?=$setting['article_footer']?></textarea>
						</div>
					</div>
				</div>
				<div class="foot">
				<input type="hidden" name="publish" value="1">
					<button type="submit" class="button">保存设置</button>
				</div>
			</form>
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
<script type="text/javascript" src="<?=assets::path('ckeditor/ckeditor.js')?>"></script>
<script type="text/javascript" src="<?=assets::path('ckfinder/ckfinder.js')?>"></script>
<script type="text/javascript" src="<?=assets::js('global.js')?>"></script>
<script type="text/javascript">
var editor = CKEDITOR.replace( 'article_footer' ,{
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
</script>
</body>
</html>