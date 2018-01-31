CKEDITOR.plugins.add('pretext', {
	icons : 'pretext',

	init : function(editor) {
		editor.addCommand( 'pretext', {
		    exec: function( editor ) {
//		    	var selection = editor.getSelection();
//		    	console.log(selection);
//		    	console.log(selection.getSelectedElement());
		    	/*var element = selection.getStartElement();
		    	console.log(element);*/
		    	//editor.insertHtml
		    	//var selection = editor.getSelectedHtml(true);
		    	//console.log(selection)
		    	
		    	/*var range = new CKEDITOR.dom.range( editor.document );
		    	range.selectNodeContents( editor.document.getBody() );
		    	console.log(range);*/
		    	var selection = editor.extractSelectedHtml(true,true);
		    	if(selection.length>0)
		    	{
		    		//去掉内部的pre标签
		    		selection = '<pre class="pre">'+selection+'</pre>';
		    		console.log(selection);
			    	editor.insertHtml(selection,'unfiltered_html');
			    }
		    }
		});
		/*
		editor.widgets.add('pretext', {
			// Widget code.
			button : '文本域'
		});		
		*/
		editor.ui.addButton( 'Pretext', {
            label: '文本域',
            command: 'pretext',
            toolbar: 'pretext'
        });
		
	}
});


