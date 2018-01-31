<?php
namespace blog\control;
use framework\core\control;
use framework\core\request;
use framework\core\cookie;

class media extends control
{
	function add()
	{
		if(request::post('ckCsrfToken') == cookie::get('ckCsrfToken'))
		{
			$file = request::file('upload');
			$file = $file->move(APP_ROOT.'/upload/'.date('Y/m/d/'));
			$file = $file->rename(uniqid());
			$path = $file->path(false);
			$data = array(
				'filename' => $_FILES['upload']['name'],
				'type' => current(explode('/', $file->mimeType())),
				'extension' => $file->extension(),
				'mimetype' => $file->mimeType(),
				'size' => $file->size(),
				'location' => $path,
			);
			$CKEditorFuncNum = request::get('CKEditorFuncNum',0);
			$result = $this->model('media')->insert($data);
			if ($result)
			{
				return '<script type="text/javascript">
				window.parent.CKEDITOR.tools.callFunction("'.$CKEditorFuncNum.'", "'.$path.'", "");
				</script>';
			}
			else
			{
				return '<script type="text/javascript">
				alert("失败");
				</script>';
			}
		}
	}
	
	function __access()
	{
		
	}
}