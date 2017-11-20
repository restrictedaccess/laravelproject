<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Brainsalvation - Dietary Program</title>
<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,600" rel="stylesheet"> 
<link href="/new/css/style.css" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js?ver=1.8.3"></script>
<script type="text/javascript" src="/new/js/js.js"></script>
<script type="text/javascript" src="/plugin/sweetalert/sweetalert.min.js"></script>
<link rel="stylesheet" href="/plugin/sweetalert/sweetalert.css">
<script type="text/javascript" src="/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="/plugin/fancybox/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="/plugin/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="/plugin/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<link href="/plugin/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript">
$(function() {
	$('.fancybox').fancybox();
});
function checkForm(){
	$(".errBox").each(function(i, elem) {
		$(elem).text("");
	});
	var $alert='';
	var $alert2='';
	<?php $key='client_first_name';?>
	if(!$("#<?php echo $key ?>").val()){
		$("#<?php echo $key ?>_error").text('Required');
		$alert=$alert+'*First Name\n';
	}
	<?php $key='client_last_name';?>
	if(!$("#<?php echo $key ?>").val()){
		$("#<?php echo $key ?>_error").text('Required');
		$alert=$alert+'*Last Name\n';
	}
	<?php $key='client_email';?>
	if(!$("#<?php echo $key ?>").val()){
		$("#<?php echo $key ?>_error").text('Required');
		$alert=$alert+'*Email\n';
	}
	<?php $key='client_mobile_no';?>
	if(!$("#<?php echo $key ?>").val()){
		$("#<?php echo $key ?>_error").text('Required');
		$alert=$alert+'*Mobile Phone\n';
	}else if(!$("#<?php echo $key ?>").val().match(/^[0-9]+$/)){
		$alert2=$alert2+'*Mobile Phone\n';
	}
	if($alert){
		swal("Please enter the following", $alert, "error");
		return false;
	}
	if($alert2){
		swal("Please enter a number", $alert2, "error");
		return false;
	}
	var form = $("#form1");
	form.attr("action","#005");
	form.submit();
}
</script>
</head>
<body class="form" ontouchstart="">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-76329406-1', 'auto');
  ga('send', 'pageview');
</script>
<h1 class="top_logo"><img src="../new/images/logo1.png"  /></h1>
<form action="?" method="post" name="form1" id="form1">
<input type="hidden" name="mode" id="mode" value="form5" />
	<div class="content__padded">
<p><a onclick="backForm('form3','#003')">&lt;Back</a></p>
		<h2 style="margin-bottom:0px;">Your Profile</h2>
		<div class="red mb20">*Indicates required field</div>
		<ul class="table_a">
			<li>
				<dl>
					<dt>First Name <span class="red">*</span></dt>
					<dd>
						<?php $key='client_first_name'; ?>
						<input class="input__profile js-answer-key" id="<?php echo $key?>" type="text" name="<?php echo $key?>" value="<?php echo $display['session'][$key]?>" maxlength="50" required="">
					</dd>
				</dl>
			</li>
			<li>
				<dl>
					<dt>Last Name <span class="red">*</span></dt>
					<dd>
						<?php $key='client_last_name'; ?>
						<input class="input__profile js-answer-key" id="<?php echo $key?>" type="text" name="<?php echo $key?>" value="<?php echo $display['session'][$key]?>" maxlength="50" required="">
					</dd>
				</dl>
			</li>
			<li>
				<dl>
					<dt>Email <span class="red">*</span></dt>
					<dd>
						<?php $key='client_email'; ?>
						<input class="input__profile js-answer-key email" id="<?php echo $key?>" type="email" name="<?php echo $key?>" value="<?php echo $display['session'][$key]?>" maxlength="255" required="">
					</dd>
				</dl>
			</li>
			<li>
				<dl>
					<dt>Mobile Phone <span class="red">*</span></dt>
					<dd>
						<?php $key='client_mobile_no'; ?>
						<input class="input__profile js-answer-key tel" id="<?php echo $key?>" type="tel" name="<?php echo $key?>" value="<?php echo $display['session'][$key]?>" maxlength="50" required="">
					</dd>
				</dl>
			</li>
		</ul>
		<div class="nextarea">
			<button type="button" name="next-question" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-next-button btn-next btn_control" data-form="002" onclick="checkForm()">Next</button>
			<button type="button" name="prev-question" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-prev-button btn-prev btn_control" data-form="" onclick="backForm('form3','#003')">BACK</button>
		</div>
	</div>
</form>
<div class="copy"> Contact us if you have any questions or find more information on <a href="/diet/faq.html" target="_blank" class="fancybox fancybox.iframe">FAQ page</a>.
	Email: <a href="mailto:support@brainsalvation.com">support@brainsalvation.com</a></div>
</body>
</html>
