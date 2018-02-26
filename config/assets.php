<?php
return array(
	//这里可以配置全局的js和css 通过正则表达式实现
	'global' => array(
		'head' => array(
			'css' => array(),
			'js' => array(
				'adsbygoogle',
				'googleAdsense.js'
			)
		),
		'end' => array(
			'js' => array(
			)
		)
	),
	
	//下面的资源可以通过assets::css|js|image方法引用
	'css' => array(
		//css的路径
		'path' => array(
			'./assets/css'
		),
		
		'mapping' => array(
			'tagsinput' => 'https://cdn.bootcss.com/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css',
		)
	),
	'js' => array(
		//js文件的路径
		'path' => array(
			'./assets/js'
		),
		
		//映射 可以在这里配置一些cdn之类的   当然映射的优先级要比path的优先级要低
		'mapping' => array(
			'jquery' => 'https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js',
			'jquery-validate' => 'https://cdn.bootcss.com/jquery-validate/1.17.0/jquery.validate.min.js',
			
			'tagsinput' => 'https://cdn.bootcss.com/jquery-tagsinput/1.3.6/jquery.tagsinput.min.js',
			'ckeditor' => 'https://cdn.ckeditor.com/4.8.0/full/ckeditor.js',
			
			'adsbygoogle' => '//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js',
		)
	),
	'image' => array(
		//图像的路径
		'path' => array(
			'./assets/image'
		)
	)
);