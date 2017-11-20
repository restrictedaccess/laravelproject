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
function checkForm(){
	$(".errBox").each(function(i, elem) {
		$(elem).text("");
	});
	var $alert='';
	var $alert2='';
	<?php $key='client_why_chose';?>
	if($("input[name='<?php echo $key ?>[]']:checked").length==0){
		$("#<?php echo $key ?>_error").text('Required');
		$alert=$alert+'*Tell us why you chose Brainsalvation?\n';
	}
	if($("#<?php echo $key ?>99").prop('checked') && !$("#<?php echo $key ?>_other_value").val()){
		$("#<?php echo $key ?>_error").text('Required');
		$alert2=$alert2+'*Tell us why you chose Brainsalvation? Other\n';
	}
	if($("#<?php echo $key ?>2").prop('checked')){
		<?php $key='client_health_concern';?>
		if($("input[name='<?php echo $key ?>[]']:checked").length==0){
			$("#<?php echo $key ?>_error").text('Required');
			$alert=$alert+'*Assistance with my current health concerns.\n';
		}
		if($("#<?php echo $key ?>99").prop('checked') && !$("#<?php echo $key ?>_other_value").val()){
			$("#<?php echo $key ?>_error").text('Required');
			$alert2=$alert2+'*Assistance with my current health concerns. Other\n';
		}
	}
	<?php $key='client_type_of_diet';?>
	if($("input[name='<?php echo $key ?>[]']:checked").length==0){
		$("#<?php echo $key ?>_error").text('Required');
		$alert=$alert+'*What type of diet do you currently follow?\n';
	}
	if($("#<?php echo $key ?>99").prop('checked') && !$("#<?php echo $key ?>_other_value").val()){
		$("#<?php echo $key ?>_error").text('Required');
		$alert2=$alert2+'*What type of diet do you currently follow? Other\n';
	}
	if(!$("#points").prop('checked')){
		$("#points_error").text('Required');
		$alert=$alert+'*Please confirm the points below\n';
	}
	<?php $key='following_foods'; ?>
	if($("input[name='<?php echo $key ?>']:checked").length==0){
		$("#<?php echo $key ?>_error").text('Required');
		$alert=$alert+'*Do you have any food allergies?\n';
	}

	if($("#<?php echo $key ?>2").prop('checked') && !$("#client_allergies").val()){
		$("#<?php echo $key ?>_error").text('Required');
		$alert=$alert+'*Please list all food allergies. \n';
	}
	
	
	if($alert){
		swal("Please enter the following", $alert, "error");
		return false;
	}
	if($alert2){
		swal("Please answer of other in detail of following", $alert2, "error");
		return false;
	}
	
	var form = $("#form1");
	form.attr("action","#002");
	form.submit();
}
</script>
<!-- Twitter single-event website tag code -->
<script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
<script type="text/javascript">twttr.conversion.trackPid('nvphm', { tw_sale_amount: 0, tw_order_quantity: 0 });</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=nvphm&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
<img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=nvphm&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
</noscript>
<!-- End Twitter single-event website tag code -->

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '1362810800412595'); 
fbq('track', 'ViewContent');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=1362810800412595&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->


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
<form action="" method="post" name="form1" id="form1">
<input type="hidden" name="mode" id="mode" value="form2" />
<div class="content__padded">
<p><a onclick="sendForm('top')">&lt;Back</a></p>
  <p class="readtxt">Please answer the questions below to make sure you are a good fit for our program.</p>
  <dl class="form">
    <dt>Tell us why you chose Brainsalvation? Please check all that apply. <span class="red">*</span> </dt>
    <dd>
	<?php $key='client_why_chose'; ?>
	<div id="<?php echo $key ?>_error" class="errBox"></div>
      <ul>
	  	<?php
		foreach($display['list'][$key] as $k => $v){
			echo '<li><input type="checkbox" name="'.$key.'[]" value="'.$k.'" id="'.$key.$k.'" '.$m->Checked($display['session'][$key],$k); 
			if($k==99){
				echo ' onclick="dispOther(this,\''.$key.'_other_value\')"';
			}elseif($k==2){
				echo ' onclick="dispOther(this,\'client_health_concern\',1)"';
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
	<div id="client_health_concern" <?php if(!in_array(2,$display['session'][$key])) echo 'style="display:none;"'?>>
    <dt>Assistance with my current health concerns. Allow them to check. <span class="red">*</span> </dt>
    <dd>
	<?php $key='client_health_concern'; ?>
	<div id="<?php echo $key ?>_error" class="errBox"></div>
      <ul>
	  	<?php
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
	</div>
    <dt>What type of diet do you currently follow? <span class="red">*</span> </dt>
    <dd>
	<?php $key='client_type_of_diet'; ?>
	<div id="<?php echo $key ?>_error" class="errBox"></div>
      <ul>
	  	<?php
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

   <dt>Please confirm the points below <span class="red">*</span></dt>
    <dd>
    <div class="mb20">
	-This program provides dietary counseling based on the MIND diet. This service does not provide medical care or a diagnosis.<br />
<br />
-Clients who are pregnant or have any questions regarding whether this program is appropriate, should consult with a physician before starting. If you fall within the following categories, you can not register for the Program: Alzheimer’s disease, food allergies, cardiovascular conditions such as congestive heart disease, coronary artery disease, heart attack or stroke, kidney disease, cancer. And if you require specialized nutrition recommendations due to other health conditions, this program is not appropriate for you.  Before starting any new diet program, it is recommended you consult with a physician. 
</div>
<div class="tac">
<div id="points_error" class="errBox"></div>
<input id="points" name="points" value="1" type="checkbox" <?php echo $m->Checked($display['session']['points'],1);?>>
<label class="check_css" for="points" style="font-weight:bold;">I confirmed.</label>
</div>
</dd>

<dt>Do you have any food allergies? <span class="red">*</span></dt>
    <dd class="clearfix">

<div class="circle_area_cntr clearfix">
<?php $key='following_foods'; ?>
<div class="radio__circle measure__circle">
<input type="radio" class="radio__circle__input js-answer-key" id="<?php echo $key?>1" name="<?php echo $key?>" value="1" <?php echo $m->Checked($display['session'][$key],1)?> data-required="true" onchange="hideOther(this,'client_allergies_Box',1)">
<label class="radio__circle__inner" for="<?php echo $key?>1">No</label>
</div>
<div class="radio__circle measure__circle">
<input type="radio" class="radio__circle__input js-answer-key" id="<?php echo $key?>2" name="<?php echo $key?>" value="2" <?php echo $m->Checked($display['session'][$key],2)?> data-required="true" onchange="dispOther(this,'client_allergies_Box',1)">
<label class="radio__circle__inner" for="<?php echo $key?>2">Yes</label>
</div>
<div style="float:left;" id="<?php echo $key?>_error" class="errBox"></div>
</div>
<div id="client_allergies_Box" style="clear:both; text-align:center;
<?php
if($display['session']['following_foods']!=2){
	echo ' display:none;';
}?>
"> 
Please list all food allergies.<span class="red">*</span><br clear="all" />
<textarea name="client_allergies" id="client_allergies" maxlength="255" rows="3" style="width:250px;">
<?php echo $display['session']['client_allergies']?>
</textarea>
</div>

</dd>
  </dl>
  <div class="nextarea">
    <button type="button" name="next-question" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-next-button btn-next btn_control" data-form="002" onclick="checkForm()">Next</button>
    <button type="button" name="prev-question" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-prev-button btn-prev btn_control" data-form="" onclick="sendForm('top')">BACK</button>
  </div>
</div>
</form>
<div class="copy"> Contact us if you have any questions or find more information on <a href="/diet/faq.html" target="_blank" class="fancybox fancybox.iframe">FAQ page</a>.
	Email: <a href="mailto:support@brainsalvation.com">support@brainsalvation.com</a></div>
</body>
</html>
