<?php $m = new main();?>
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
		<?php $key='client_activity_level';?>
		if($("input[name='<?php echo $key ?>']:checked").length==0){
			$("#<?php echo $key ?>_error").text('Required');
			$alert=$alert+'*What is your current activity level?\n';
		}
		<?php $key='client_activity_choice';?>
		if($("input[name='<?php echo $key ?>[]']:checked").length==0){
			$("#<?php echo $key ?>_error").text('Required');
			$alert=$alert+'*What is your activity of choice? Select all that apply.\n';
		}
		if($("#<?php echo $key ?>99").prop('checked') && !$("#<?php echo $key ?>_other_value").val()){
			$("#<?php echo $key ?>_error").text('Required');
			$alert=$alert+'*What is your activity of choice? Select all that apply. Other\n';
		}
		/*
		<?php $key='client_expertise';?>
		if($("input[name='<?php echo $key ?>']:checked").length==0){
			$("#<?php echo $key ?>_error").text('Required');
			$alert=$alert+'*I prefer someone with more expertise in______?\n';
		}
		*/
		<?php $key='client_physical_level';?>
		if($("input[name='<?php echo $key ?>']:checked").length==0){
			$("#<?php echo $key ?>_error").text('Required');
			$alert=$alert+'*Would you like to increase your physical activity level?\n';
		}
		if($alert){
			swal("Please enter the following", $alert, "error");
			return false;
		}
		var form = $("#form1");
		form.attr("action","#004");
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
<input type="hidden" name="mode" id="mode" value="form4" />
<div class="content__padded">
<p><a onclick="backForm('form2','#002')">&lt;Back</a></p>
		<p class="readtxt">The following questions will help us choose the right nutrition coach to meet your needs. Don't worry! You can easily change selections (and coach) any time you like. </p>
		<dl class="form">
			<dt>What is your current activity level? <span class="red">*</span> </dt>
			<dd>
				<div id="client_activity_level_error" class="errBox"></div>
				<ul>
					<li>
						<input type="radio" name="client_activity_level" value="1" id="a01" <?php echo $m->Checked($display['session']['client_activity_level'],1)?> />
						<label for="a01" class="radio">Little to none </label>
						<div class="hosoku">Choose this answer if you get less than 2 1/2 hours of moderate activity per week OR if you get less an 75 minutes of vigorous activity per week.</div>
					</li>
					<li>
						<input type="radio" name="client_activity_level" value="2" id="a02" <?php echo $m->Checked($display['session']['client_activity_level'],2)?> />
						<label for="a02" class="radio">Moderate to high </label>
						<div class="hosoku">Choose this answer if you get at least 2 1/2 hours of moderate or 75 minutes of vigorous activity per week. </div>
					</li>
				</ul>
			</dd>
			<dt>What is your activity of choice? Select all that apply. <span class="red">*</span> </dt>
			<dd>
				<div id="client_activity_choice_error" class="errBox"></div>
				<ul>
					<?php
					$key='client_activity_choice';
					foreach($display['list'][$key] as $k => $v){
						echo '<li><input type="checkbox" name="'.$key.'[]" value="'.$k.'" id="'.$key.$k.'" '.$m->Checked($display['session'][$key],$k); 
						if($k==99){
							echo ' onclick="dispOther(this,\''.$key.'_other_value\')"';
						}
						echo '/><label for="'.$key.$k.'" class="check_css">'.$v.'</label>';
						if($k==99){
							echo '<input type="text" name="'.$key.'_other_value" id="'.$key.'_other_value" value="'.$display['session'][$key.'_other_value'].'" ';
							if(!in_array(99,$display['session'][$key])){
								echo 'style="display:none;"';
							}
							echo ' maxlength="255" />';
						}
						echo '</li>';
					}
					?>
				</ul>
			</dd>
			<!--dt>Which type of coach appeals to you most? <span class="red">*</span> </dt>
			<dd>
				<div id="client_activity_choice_error" class="errBox"></div>
				<ul>
					<li>
						<input type="radio" name="client_coach" value="1" id="a13" <?php echo $m->Checked($display['session']['client_coach'],1)?> />
						<label for="a13" class="radio">A drill sergeant</label>
						<div class="hosoku"> I need someone to be tough! </div>
					</li>
					<li>
						<input type="radio" name="client_coach" value="2" id="a14"  <?php echo $m->Checked($display['session']['client_coach'],2)?> />
						<label for="a14" class="radio">A middle-of-the-road coach</label>
						<div class="hosoku">I like a moderate amount of motivation and encouragement. </div>
					</li>
					<li>
						<input type="radio" name="client_coach" value="3" id="a15"  <?php echo $m->Checked($display['session']['client_coach'],3)?> />
						<label for="a15" class="radio">A cheerleader!</label>
						<div class="hosoku">A very encouraging, high energy coach. </div>
					</li>
				</ul>
			</dd>
			<dt>I prefer someone with more expertise in______? <span class="red">*</span></dt>
			<dd>
				<div id="client_expertise_error" class="errBox"></div>
				<ul>
					<li>
						<input type="radio" name="client_expertise" value="1" id="a16" <?php echo $m->Checked($display['session']['client_expertise'],1)?> />
						<label for="a16" class="radio">Motivation </label>
					</li>
					<li>
						<input type="radio" name="client_expertise" value="2" id="a17" <?php echo $m->Checked($display['session']['client_expertise'],2)?> />
						<label for="a17" class="radio">Nutrition</label>
					</li>
					<li>
						<input type="radio" name="client_expertise" value="3" id="a18" <?php echo $m->Checked($display['session']['client_expertise'],3)?> />
						<label for="a18" class="radio">A combination of both</label>
					</li>
				</ul>
			</dd-->
			<dt>Please take a moment to introduce yourself to your Health  coach. </dt>
			<dd>
				<textarea name="client_introduce" id="textfield2" maxlength="255"><?php echo $display['session']['client_introduce']?></textarea>
			</dd>
			<dt>Would you like to increase your physical activity level?<span class="red"> *</span></dt>
			<dd class="clearfix">
            <div class="circle_area">
				<div class="radio__circle measure__circle pr0">
					<input type="radio" class="radio__circle__input js-answer-key" id="Yes" name="client_physical_level" value="1" <?php echo $m->Checked($display['session']['client_physical_level'],1)?>  data-required="true">
					<label class="radio__circle__inner" for="Yes">Yes</label>
				</div>
				<div class="radio__circle measure__circle">
					<input type="radio" class="radio__circle__input js-answer-key" id="Not right now" name="client_physical_level" value="2"  <?php echo $m->Checked($display['session']['client_physical_level'],2)?>  data-required="true">
					<label class="long radio__circle__inner" for="Not right now">Not right now</label>
				</div>
				<div id="client_physical_level_error" class="errBox"></div>
                </div>
			</dd>
		</dl>
		<div class="nextarea">
			<button type="button" name="next-question" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-next-button btn-next btn_control" data-form="002" onclick="checkForm()">Next</button>
			<button type="button" name="prev-question" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-prev-button btn-prev btn_control" data-form="" onclick="backForm('form2','#002')">BACK</button>
		</div>
	</div>
</form>
<div class="copy"> Contact us if you have any questions or find more information on <a href="/diet/faq.html" target="_blank" class="fancybox fancybox.iframe">FAQ page</a>.
	Email: <a href="mailto:support@brainsalvation.com">support@brainsalvation.com</a></div>
</body>
</html>
