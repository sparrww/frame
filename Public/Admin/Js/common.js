$(function() {
	//设置编辑区的高度
	var winheighta = $(window).height();
	$("#main").height(winheighta-42);

	//根据宽度，赋予提示字段不同的展示形式
	var mainW = $("#main").width();
	$(".downlist_box").width(mainW-480);
	if(mainW >= 1100){
		$(".article_notes").removeClass("article_notes_fixed");
	}else{
		$(".article_notes").addClass("article_notes_fixed");
	}

	//当浏览器窗口变化时需要重新处理
	$(window).resize(function(){
		//当浏览器窗口变化时重新处理设置编辑区的高度
		var winheighta = $(window).height();
		$("#main").height(winheighta-42);
		//当浏览器窗口变化时重新根据宽度，赋予提示字段不同的展示形式
		var mainW = $("#main").width();
		$(".downlist_box").width(mainW-480);
		if(mainW >= 1100){
			$(".article_notes").removeClass("article_notes_fixed");
		}else{
			$(".article_notes").addClass("article_notes_fixed");
		}

	});
});
$(function() {
	//设置编辑器
	var K = KindEditor;
	var editor = K.editor({
			fileManagerJson : '/Public/Common/Editer/php/file_manager_json.php',
			allowFileManager : false
		});

		//加载编辑器
		K.create('textarea[name="content"]', {
		resizeType : 1,
		newlineTag : 'p',
		allowPreviewEmoticons : false,
		allowImageUpload : false,
		afterBlur:function(){
		   this.sync();
		}
		});


		//加载模板管理
		K("#filemanager").click(function(){
			editor.loadPlugin('filemanager', function() {
				editor.plugin.filemanagerDialog({
					viewType : 'VIEW',
					dirName : '',
					clickFn : function(url, title) {
						K('#channel_template').val(url);
						editor.hideDialog();
					}
				});
			});
		});

		//加载模板管理
		K("#filemanager2").click(function(){
			editor.loadPlugin('filemanager', function() {
				editor.plugin.filemanagerDialog({
					viewType : 'VIEW',
					dirName : '',
					clickFn : function(url, title) {
						K('#classify_template').val(url);
						editor.hideDialog();
					}
				});
			});
		});
		//加载模板管理2
		K('#filemanager3').click(function() {
			editor.loadPlugin('filemanager', function() {
				editor.plugin.filemanagerDialog({
					viewType : 'VIEW',
					dirName : '',
					clickFn : function(url, title) {
						K('#content_template').val(url);
						editor.hideDialog();
					}
				});
			});
		});
		//加载模板管理2
		K('#filemanage').click(function() {
			editor.loadPlugin('filemanager', function() {
				editor.plugin.filemanagerDialog({
					viewType : 'VIEW',
					dirName : '',
					clickFn : function(url, title) {
						K('#template_url').val(url);
						editor.hideDialog();
					}
				});
			});
		});
	});


var screensa=true;
function article_more_info(){
	
	function $(e){return document.getElementById(e);}
	
	var article_more_info=$("article_more_info");
	
	if(screensa==false){
		article_more_info.style.display='none';
		screensa=true;
		$('article_more').innerHTML = "<em class='up_jt'></em>更多控制选项"
	}else{
		article_more_info.style.display='block';
		screensa=false;
		$('article_more').innerHTML = "<em class='down_jt'></em>更多控制选项" 
	}
}

function gets(string,vals){
	var str=document.getElementById(string);
	if(string!="tags"){
		return str.value=vals.innerHTML;
	}else{
	if(str.value==""){
		return str.value+=vals.innerHTML;		
	}
		return str.value+=","+vals.innerHTML;
	}
}


function checkAll() {
for (var j = 1; j <= 1000; j++) {
box = eval("document.checkboxform.record" + j); 
if (box.checked == false) box.checked = true;
   }
}

function uncheckAll() {
for (var j = 1; j <= 1000; j++) {
box = eval("document.checkboxform.record" + j); 
if (box.checked == true) box.checked = false;
   }
}

function switchAll() {
for (var j = 1; j <= 1000; j++) {
box = eval("document.checkboxform.record" + j); 
box.checked = !box.checked;
   }
}

function killerrors() { return true; } window.onerror = killerrors;