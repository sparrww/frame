$(function(){
	//默认
	var winheight = $(window).height();
	var winwidth = $(window).width();
	//$("#menu").height(winheight-72);
	//$("#menu_con").height(winheight-140);
	$("#ifmain").height(winheight-72);
	$("#ifmain").width(winwidth-206);
	$("#closs_menu").click(function(){
		if($(this).attr("class")=="show"){
			//alert(1);
			$(".show").text("× 关闭左栏");
			$(".show").removeClass("show").addClass("hide");
			$('#menu').hide();
			$("#ifmain").width(winwidth);
		}else{
			$(".hide").text("√ 打开左栏");
			$(".hide").removeClass("hide").addClass("show");
			$('#menu').show();
			$("#ifmain").width(winwidth-206);
		}
	});

	$(window).resize(function(){
		var winheight = $(window).height();
		var winwidth = $(window).width();
		//$("#menu").height(winheight-72);
		//$("#menu_con").height(winheight-140);
		$("#ifmain").height(winheight-72);
		$("#ifmain").width(winwidth-206);
		$("#closs_menu").text("× 关闭左栏");
		$('#menu').show();
		$("#closs_menu").click(function(){
			if($(this).attr("class")=="show"){
				$(".show").text("× 关闭左栏");
				$(".show").removeClass("show").addClass("hide");
				$('#menu').hide();
				$("#ifmain").width(winwidth);
			}else{
				$(".hide").text("√ 打开左栏");
				$(".hide").removeClass("hide").addClass("show");
				$('#menu').show();
				$("#ifmain").width(winwidth-206);
			}
		});
	});
});