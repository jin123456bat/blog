jQuery.fn.extend({
	tags:function(options){
		var tpl = $('<div></div>');
		
		if(options.class)
		{
			tpl.addClass(options.class);
		}
		
		tpl.css({
			'display':'flex',
		});
		
		var input = $('<input type="text" placeholder="请输入标签">');
		input.append(tpl).css({
			width:'100%',
			height:'100%',
			border:'none',
			outline:'none',
			display:'inline-block',
		});
		
		var old_input = $(this).css('display','none').on('addValue',function(event,value){
			val = $(this).val();
			if(val == '' || val.length == 0)
			{
				val = '[]';
			}
			
			val = JSON.parse(val);
			val.push(value);
			$(this).val(JSON.stringify(val));
		}).on('delValue',function(event,value){
			val = $(this).val();
			if(val == '' || val.length == 0)
			{
				val = '[]';
			}
			
			val = JSON.parse(val);
			val.splice($.inArray(value,val),1);
			$(this).val(JSON.stringify(val));
		});
		
		tpl.insertAfter(old_input).append(input);
		
		var max_input_width = input.width();
		
		var checkValue = function(value){
			val = old_input.val();
			if(val == '' || val.length == 0)
			{
				val = '[]';
			}
			
			if($.inArray(value,JSON.parse(val)) != -1)
			{
				return false;
			}
			return true;
		}
		
		var createTags = function(value){
			var tpl = $('<div>'+value+'</div>').css({
				display:'inline',
			    backgroundColor: '#5bc0de',
			    color:'#fff',
			    marginRight:'2px',
			    padding: '.2em .6em .3em',
		    	fontSize: '75%',
		    	fontWeight: '700',
		    	lineHeight: 1,
		    	textAlign: 'center',
		    	whiteSpace: 'nowrap',
				verticalAlign: 'baseline',
		    	borderRadius: '.25em',
			});
			var remove = $('<a>x</a>').css({
				color:'#fff',
				cursor:'pointer',
				marginLeft:'10px',
			}).on('click',function(){
				tpl.trigger('remove',value);
				tpl.remove();
			});
			tpl.append(remove);
			return tpl;
		}
		
		input.on('focus',function(){
			tpl.addClass('active');
		}).on('blur',function(){
			tpl.removeClass('active');
		}).on('keydown',function(e){
			if(e.key == 'Backspace' && $(this).val().length==0)
			{
				//删除最后一个标签
				var removeBtn = tpl.find('div:last a');
				if(removeBtn)
				{
					removeBtn.trigger('click');
				}
			}
			else if($.inArray(e.key,options.seperator) != -1)
			{
				value = $(this).val();
				
				var cv = checkValue(value);
				if(cv)
				{
					tags = createTags(value);
					tags.on('remove',function(event,value){
						old_input.trigger('delValue',value);
					});
					old_input.trigger('addValue',value);
					tags.insertBefore(input);
				}
				$(this).val('');
				return false;
			}
		});
		
		//假如input中存在内容
		var old_val = $.trim(old_input.val());
		if(old_val.length>0)
		{
			old_val = JSON.parse(old_val);
			if(old_val.length>0)
			{
				$.each(old_val,function(index,value){
					tags = createTags(value);
					tags.on('remove',function(event,value){
						old_input.trigger('delValue',value);
					});
					tags.insertBefore(input);
				});
			}
		}
	}
});