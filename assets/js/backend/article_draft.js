var draft = datatables({
	table:$('#article_draft table'),
	ajax:{
		data:{
			isdelete:0,
			publish:0,
		},
	},
	columns:[{
		data:'id',
		name:'article.id',
		pk:true,
	},{
		data:'id',
		name:'article.id',
	},{
		data:'title',
		name:'article.title',
	},{
		data:'createtime',
		name:'article.createtime',
	},{
		data:'publish',
		name:'article.publish',
	},{
		data:'readnum',
		name:'(SELECT count(DISTINCT ip) FROM `read_history` where aid=article.id)',
	},{
		data:'category',
		name:'(SELECT GROUP_CONCAT(name) FROM `article_category` left join category on category.id=cid where aid=article.id)',
	},{
		data:'id',
		name:'article.id',
	}],
	columnDefs:[{
		targets:0,
		render:function(data,full){
			return '<input type="checkbox" name="id[]" value="'+data+'">';
		}
	},{
		targets:4,
		render:function(data,full){
			return data==1?'已发布':'未发布';
		}
	},{
		targets:6,
		render:function(data,full){
			if(data==null)
			{
				return '';
			}
			return data;
		}
	},{
		targets:7,
		render:function(data,full){
			content = '';
			content += '<a class="button button-xs look" data-id="'+full.id+'">查看</a>';
			content += '<a class="button button-xs edit" data-id="'+full.id+'">编辑</a>';
			if(full.publish==1)
			{
				content += '<a class="button button-xs draft" data-id="'+full.id+'">草稿</a>';
			}
			else
			{
				content += '<a class="button button-xs publish" data-id="'+full.id+'">发布</a>';
			}
			
			if(full.isdelete==1)
			{
				content += '<a class="button button-xs draft" data-id="'+full.id+'">草稿</a>';
			}
			else
			{
				content += '<a class="button button-xs delete" data-id="'+full.id+'">删除</a>';
			}
			return content;
		}
	}],
	pagesize:10,
	onRowLoaded:function(row){
		
	}
});

/*$('#all_search').on('submit',function(){
	all.addAjaxParameter('status',$(this).find('select').val());
	all.search($(this).find('input').val());
	return false;
});
*/
//批量操作
/*$('#all #multipleBtn').on('click',function(){
	var id = getSelectedCheckbox($('#all'));
	if($('#all #multipleSelect').val() == '')
	{
		return false;
	}
	if(id.length == 0)
	{
		bootbox.alert('请选择商品');
		return false;
	}
	if($('#all #multipleSelect').val() == 'unshelf')
	{
		bootbox.confirm({
			message:'确认下架这些商品?',
			buttons:{
				cancel:{
					label: '<i class="fa fa-times"></i> 取消',
				},
				confirm:{
					label:'<i class="fa fa-check"></i> 确定',
				}
			},
			callback: function(result,a) {
				if(result) {
					all.addAjaxParameter('customActionType','group_action');
					all.addAjaxParameter('id',id);
					all.addAjaxParameter('customActionName','unshelf');
					all.reload();
				}
			},
		});
	}
	if($('#all #multipleSelect').val() == 'sale')
	{
		bootbox.confirm({
			message:'确认上架这些商品?',
			buttons:{
				cancel:{
					label: '<i class="fa fa-times"></i> 取消',
				},
				confirm:{
					label:'<i class="fa fa-check"></i> 确定',
				}
			},
			callback: function(result,a) {
				if(result) {
					all.addAjaxParameter('customActionType','group_action');
					all.addAjaxParameter('id',id);
					all.addAjaxParameter('customActionName','sale');
					all.reload();
				}
			},
		});
	}
	return false;
});

$('#all table').on('click','.look',function(){
	window.open('./index.php?c=index&a=product&id='+$(this).data('id'));
	return false;
}).on('click','.edit',function(){
	if($_edit_product == 0)
	{
		return false;
	}
	var id = $(this).data('id');
	window.location = './index.php?c=html&a=product_edit&type=unshelf&id='+id;
	return false;
}).on('click','.unshelf',function(){
	var tr = $(this).parents('tr');
	var id = $(this).data('id');
	$.post('./index.php?m=ajax&c=product&a=unshelf',{id:id},function(response){
		if(response.code==1)
		{
			tr.trigger('flush.datatables');
		}
		else
		{
			bootbox.alert(response.result);
		}
	});
	return false;
}).on('click','.sale',function(){
	var tr = $(this).parents('tr');
	var id = $(this).data('id');
	$.post('./index.php?m=ajax&c=product&a=sale',{id:id},function(response){
		if(response.code==1)
		{
			tr.trigger('flush.datatables');
		}
		else
		{
			bootbox.alert(response.result);
		}
	});
	return false;
});*/