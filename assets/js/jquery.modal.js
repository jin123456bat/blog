$.fn.extend({
	modal:function(options){
		//$(this).removeClass();
		var bg = $('<div></div>');
		bg.css({
			opacity: '.5',
			position: 'fixed',
		    top: 0,
		    right: 0,
		    bottom: 0,
		    left: 0,
		    zIndex: 1040,
		    backgroundColor: '#000',
		});
		$('body').append(bg);
	},
});