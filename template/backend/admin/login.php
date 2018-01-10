<?php
use framework\core\assets;
use framework\core\http;
use framework\vendor\csrf;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?=$setting['site_title']?> | <?=$setting['site_desc']?></title>
</head>
<link href="<?=assets::css('backend/admin/login.css')?>" rel="stylesheet" />
<link href="<?=assets::css('backend/jquery.loading.css')?>" rel="stylesheet" />
<body>

	<div class="content">
		<form action="" method="post" id="registerForm">
			<div class="form-title">
				<h3>登录</h3>
			</div>
			<div class="form-group">
				<input type="text" name="username" autocomplete="off" placeholder="用户名/邮箱">
			</div>
			<div class="form-group">
				<input type="password" name="password" autocomplete="off" placeholder="密码">
			</div>
			<div class="form-row">
				<input type="checkbox" name="remember" id="remember" value="1"> <label for="remember">记住我</label>
				<div class="pull-right">
					<a href="#">忘记密码？</a>
				</div>
			</div>
			<div class="form-group">
				<input type="submit" name="submit" value="提交">
			</div>
			<div class="form-group">
				<div class="msg">
					还没账号？<a href="<?=http::url('admin','register')?>">注册</a>
				</div>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="<?=assets::js('jquery')?>" charset="utf-8"></script>
	<script type="text/javascript" src="<?=assets::js('jquery.md5.js')?>" charset="utf-8"></script>
	<script type="text/javascript" src="<?=assets::js('jquery-validate')?>" charset="utf-8"></script>
	<script type="text/javascript" src="<?=assets::js('jquery.loading.js')?>" charset="utf-8"></script>
	<script type="text/javascript">
	$('form').validate({
		rules:{
			username:{
				required:true,
			},
			password:{
				required:true,
				minlength: 6,
			}
		},
		messages:{
			username:{
				required:'请填写用户名',
			},
			password:{
				required:'请填写密码',
				minlength: '密码长度不得少于6个',
			}
		},
		submitHandler:function(form){
			var data = {
				username:$.trim($(form).find('input[name=username]').val()),
				password:$.md5($.trim($(form).find('input[name=password]').val())),
				remember:$(form).find('input[name=remember]').is(':checked'),
			}
	
			$.ajaxSetup({
				headers: {
			        '<?=csrf::$_X_CSRF_TOKEN_NAME?>': '<?=csrf::token()?>' ,
			    } ,
			});

			$.loading($('body'));
			
			$.post('<?=http::url('admin','login')?>',data,function(response){
				$.unloading($('body'));
				if(response.code==1)
				{
					window.location = response.data;
				}
				else
				{
					$.each(response.message,function(index,value){
						var error = '';
						$.each(value,function(i,v){
							error += v;
						});

						var tpl = '<label id="'+index+'-error" class="error" for="'+index+'">'+error+'</label>';
						
						var target = $(form).find('label#'+index+'-error');
						if(target.length == 1)
						{
							target.html(error).css('display','');
						}
						else
						{
							$(tpl).insertAfter($(form).find('input[name='+index+']'));
						}
					});
				}
			});
			return false;
		}
	});
</script>
</body>
</html>