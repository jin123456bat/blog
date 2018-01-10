$.extend({
	loading:function(target){
		target = target || $('body');
		var bg = $('<div class="loading-bg"></div>');
		target.append(bg);
		
		var loading_content = $('<div class="loading-content"></div>');
		bg.append(loading_content);
		
		var loading_item_1 = $('<div class="loading-item loading-item-1"></div>');
		var loading_item_2 = $('<div class="loading-item loading-item-2"></div>');
		var loading_item_3 = $('<div class="loading-item loading-item-3"></div>');
		var loading_item_4 = $('<div class="loading-item loading-item-4"></div>');
		
		loading_content.append(loading_item_1);
		loading_content.append(loading_item_2);
		loading_content.append(loading_item_3);
		loading_content.append(loading_item_4);
	},
	unloading:function(target){
		target = target || $('body');
		target.find('.loading-bg').remove();
	}
})(jQuery);