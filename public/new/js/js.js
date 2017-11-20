$(document).ready(function(){
$('.menu').click(function(e){
$('.drawer').toggleClass('active');
e.preventDefault();
});
}); 

function sendForm($mode,$id,$url){
	if($id){
		id = document.getElementById('id');
		id.value=$id;
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
function backForm($mode,$action){
	mode = document.getElementById('mode');
	mode.value=$mode;
	var form = $("#form1");
	if($action){
		form.attr("action",$action);
	}
	form.submit();
}

function showBox($id){
	var element = document.getElementById($id);
	$(element).slideToggle();
//	$(element).animate({ height: 'show' });
}

function dispOther($this,$id,$flg){
	var element = document.getElementById($id);
	if($this.checked){
		if(!$flg){
			$(element).animate({ width: 'show' });
		}else{
			$(element).animate({ height: 'show' });
		}
//		element.style.display = 'inline-block';
	}else{
		if(!$flg){
			$(element).animate({ width: 'hide' });
		}else{
			$(element).animate({ height: 'hide' });
		}
//		element.style.display = 'none';
	}
}
function hideOther($this,$id,$flg){
	var element = document.getElementById($id);
	if($this.checked){
		if(!$flg){
			$(element).animate({ width: 'hide' });
		}else{
			$(element).animate({ height: 'hide' });
		}
	}
}

function dispHeight($this,$id){
	var element1 = document.getElementById($id+'1');
	var element2 = document.getElementById($id+'2');
	if($this.value=='1'){
		$(element1).animate({ height: 'show' });
		$(element2).animate({ height: 'hide' });
	}else{
		$(element1).animate({ height: 'hide' });
		$(element2).animate({ height: 'show' });
	}
}
function dispBox($this,$id,$val){
	var element1 = document.getElementById($id);
	if($this.value==$val){
		$(element1).animate({ height: 'show' });
	}else{
		$(element1).animate({ height: 'hide' });
	}
}

function alertErr($err){
    requestData = {err:$err}
    $.ajax({
      type: "POST",
      url: "alert_err.html",
      data: requestData,
    });	
}
