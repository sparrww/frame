$(function(){

	data=$(".form").Validform({
		tiptype:2,
		callback:function(data){
			if(data.status=="y"){
				 location.href =	"/Admin/dbmanage/execution/re/1/message/"+data.message;
			}else if(data.status=="c"){
				alert(data.message);
			}else{
				 location.href =	"/Admin/dbmanage/execution/re/0/message/"+data.message;
			}
		}
	});


	//修复
	$("#repair").click(function(){

		var item = $('input[class="record"]:checked');
		if(item.length==0){
             alert("请选择数据表！");
        }else{
			data.ajaxPost(false,true,'/Admin/dbmanage/batch/method/repair');
			$.Hidemsg();
		}
	});
	//优化
	$("#optimize").click(function(){
		var item = $('input[class="record"]:checked');
		if(item.length==0){
             alert("请选择数据表！");
        }else{
			data.ajaxPost(false,true,'/Admin/dbmanage/batch/method/optimize');
			$.Hidemsg();
		}
	});
	//备份
	$("#backup").click(function(){
		var item = $('input[class="record"]:checked');
		if(item.length==0){
             alert("请选择数据表！");
        }else{
			data.ajaxPost(false,true,'/Admin/dbmanage/batch/method/backup');
			$.Hidemsg();
		}
	});

	//恢复
	$("#regain").click(function(){
		data.ajaxPost(false,true,'/Admin/dbmanage/regain');
		$.Hidemsg();
	});
})