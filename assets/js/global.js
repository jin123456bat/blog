setInterval(function(){
	var datetimeController = new Date();
	var date = datetimeController.getFullYear()+'-'+lpad(datetimeController.getMonth()+1,2)+'-'+lpad(datetimeController.getDate(),2);
	$('.date').text(date);

	var time = lpad(datetimeController.getHours(),2)+':'+lpad(datetimeController.getMinutes(),2);
	$('.time').text(time);

	var week = datetimeController.getDay();
	var weekArray = ['日','一','二','三','四','五','六'];
	var week = '星期'+weekArray[week];
	$('.week').text(week);
},1000);