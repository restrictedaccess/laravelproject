// JavaScript Document
function sendForm($mode,$id,$this){
	if($id){
		id = document.getElementById('id');
		id.value=$id;
	}
	if($mode){
		mode = document.getElementById('mode');
		mode.value=$mode;
	}
	form=document.getElementById('form1');
	if($mode=='delete' || $mode=='consultant_delete' || $mode=='health_coach_delete'){
		if(confirm('Are you sure you want to delete?')){
			form.submit();
		}
	}else{
		form.submit();
	}
}
function sendForm2($mode,$key,$val,$conf){
	if($mode){
		mode = document.getElementById('mode');
		mode.value=$mode;
	}
	if($key){
		key = document.getElementById($key);
		key.value=$val;
	}
	form=document.getElementById('form1');
	if($conf){
		if(confirm('Are you sure you want to delete?')){
			form.submit();
		}
	}else{
		form.submit();
	}
	
}
function sendForm3($mode,$id){
	if($id){
		jQuery('#'+$id).removeAttr("onclick");
	}
	if($mode){
		mode = document.getElementById('mode');
		mode.value=$mode;
	}
	form=document.getElementById('form1');
	if($mode=='delete'){
		if(confirm('Are you sure you want to delete?')){
			form.submit();
		}
	}else{
		form.submit();
	}
}

function sendLocation($url,$id){
	if($id){
		location.href = $url+'?id='+$id;
	}else{
		location.href = $url;
	}
}
function selectValue(id,itemValue){
	var objSelect = document.getElementById(id);
	var m = objSelect.length;
	var i = 0;
	for(i=0;m>i;i++){
		if(objSelect.options[i].value == itemValue){
			objSelect.options[i].selected = true;
			break;
		}
	}
}

function dispBox(id){
	var obj = document.getElementById(id);
	obj.style.display="block";
}
function hideBox(id){
	var obj = document.getElementById(id);
	obj.style.display="none";
}

function toggleBox(h,id1,id2){
	var v = document.getElementById(h);
	var val = v.value;
	var obj1 = document.getElementById(id1);
	var obj2 = document.getElementById(id2);
	if(val>0){
		obj1.style.display="block";
		obj2.style.display="none";
		v.value = 0;
	}else{
		obj1.style.display="none";
		obj2.style.display="block";
		v.value = 1;
	}
}

function toggleClassBox(h,id,c){
	var v = document.getElementById(h);
	var val = v.value;
	var elms = document.getElementById(id).getElementsByClassName(c);
	for( var j=0; j<elms.length; j++ ) {
	if(val>0){
		elms.item(j).style.display="none";
		v.value = 0;
	}else{
		elms.item(j).style.display='';
		v.value = 1;
	}
	}
}

$(function() {
	//クリックしたときのファンクションをまとめて指定
	$('.tabBox .tab li').click(function(){
		//.index()を使いクリックされたタブが何番目かを調べ、
		//indexという変数に代入します。
		var index = $('.tabBox .tab li').index(this);

		//コンテンツを一度すべて非表示にし、
		$('.tabBox .content li').css('display','none');

		//クリックされたタブと同じ順番のコンテンツを表示します。
		$('.tabBox .content li').eq(index).css('display','block');

		//一度タブについているクラスselectを消し、
		$('.tabBox .tab li').removeClass('select');

		//クリックされたタブのみにクラスselectをつけます。
		$(this).addClass('select')
	});

	$('nav#menu-left2').mmenu({
	zposition : 'front',
	classes	: 'mm-light',
	slidingSubmenus: false,
	});

  var topBtn = $('#page-top');	
  topBtn.hide();
  //スクロールが100に達したらボタン表示
  $(window).scroll(function () {
　  if ($(this).scrollTop() > 100) {
    topBtn.fadeIn();}
    else { topBtn.fadeOut();
   }
});
  //スクロールしてトップ
  topBtn.click(function () {
  $('body,html').animate({
    scrollTop: 0}, 500);
    return false;
  });
});

