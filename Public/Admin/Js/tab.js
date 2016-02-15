// JavaScript Document
function swap_tab(n)
{
 for(var i=1;i<=5;i++){
  var curC=document.getElementById("tab_"+i);
  var curB=document.getElementById("tab_t"+i);
  if(n==i){
   curC.style.display="block";
   curB.className="active"
  }else{
   curC.style.display="none";
   curB.className="normal"
  }
 }
} 

$(function(){
	
	
	var aHa=$(".h-menu a");
		
		for(var i=0;i<aHa.length;i++){
			
			aHa[i].onclick=function(){

                $(".menu-box a").css("background","none")
				
				this.style.background="red";
				
			}
			
		}
	
	
	
	
	
	
	
})


var screens=false;
function nonemenu(){
	
	function $(e){return document.getElementById(e);}
	
	var menu=$("menu");
	var main=$("ifmain");
	var topWin = window.top.document.getElementById("ifmain").contentWindow;



	if(screens==false){
		menu.style.display='none';
		main.style.left='0';
		topWin.document.getElementById("main").style.paddingRight = "0";
		screens=true;
		$('closs_menu').innerHTML = "√ 打开左栏"
	}else{
		menu.style.display='block';
		main.style.left='220px';
		topWin.document.getElementById("main").style.paddingRight = "220px";
		screens=false;
		$('closs_menu').innerHTML = "× 关闭左栏" 
	}
}

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


function load(url){
	$(function(){
		$("#body").load(url);
	});
}

function link(id){
	$(function(){
		load($(id).attr("url"));
	});
}

function Gotonew(url){
	window.location = url;   //url为你要跳转的页面的url
}
window.onerror=function(){return true;} 