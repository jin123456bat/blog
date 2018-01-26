<?php
use framework\core\assets;
use framework\core\http;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?=$setting['site_title']?> | <?=$setting['site_desc']?></title>
<link rel="stylesheet" href="<?=assets::css('front/main.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('front/article/index.css')?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?=assets::css('iconfont.css')?>" type="text/css" media="all">
<link rel="stylesheet" href="<?=assets::path('ueditor/third-party/SyntaxHighlighter/shCoreDefault.css')?>" type="text/css" media="all">
</head>
<body>

<?php include_once FRONT.'common/header.php';?>

<div class="container">
		<div class="article">
			<div class="item">
				<div class="title">
					<a href="<?=http::url('article','index',array('id'=>$article['id']))?>"><?=$article['title']?></a>
				</div>
				<div class="info">
					<div class="info-item">
						<i class="iconfont icon-riliriqi2"></i>
					<?=date('Y年m月d日',strtotime($article['createtime']))?>
				</div>
					<div class="info-item">
						<i class="iconfont icon-person-fill"></i>
					<?=$article['uname']?>
				</div>
					<div class="info-item">
						<i class="iconfont icon-chat"></i>
					<?=$article['comment_num']?>个评论
				</div>
					<div class="info-item">
						<i class="iconfont icon-read"></i>
					浏览<?=$article['read_num']?>次
				</div>

				</div>
				<div class="content">
					<style>
					table{
						border: 1px solid #DDD;
					}
					td{
						border: 1px solid #DDD;
					}
					</style>
					<?=$article['content']?>
				</div>
			</div>
		</div>
	<?php include_once FRONT.'common/sidebar.php';?>
</div>


<?php include_once FRONT.'common/footer.php';?>
<script type="text/javascript" src="<?=assets::js('jquery')?>"></script>
<script type="text/javascript" src="<?=assets::path('ueditor/third-party/SyntaxHighlighter/shCore.js')?>"></script>
<script type="text/javascript">
SyntaxHighlighter.config.stringBrs = true;
SyntaxHighlighter.config.bloggerMode = true;//博客模式，假如有br或者\n的问题请关闭这个
SyntaxHighlighter.defaults['smart-tabs'] = true;
SyntaxHighlighter.defaults['tab-size'] = 4;
SyntaxHighlighter.defaults['gutter'] = true;
SyntaxHighlighter.defaults['toolbar'] = false;
SyntaxHighlighter.defaults['quick-code'] = false;
SyntaxHighlighter.defaults['collapse'] = false;
SyntaxHighlighter.defaults['auto-links'] = true;
SyntaxHighlighter.all();
</script>
</body>
</html>