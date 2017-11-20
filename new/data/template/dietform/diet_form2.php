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
<script type="text/javascript" src="/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="/plugin/fancybox/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="/plugin/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="/plugin/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<link href="/plugin/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="/plugin/jquery-ui/base/jquery.ui.all.css">
<script type="text/javascript" src="/plugin/jquery-ui/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="/plugin/jquery-ui/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/plugin/jquery-ui/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
$(function() {
	$('.fancybox').fancybox();
	$( ".date" ).datepicker({
		changeMonth: true,
		changeYear: true,
		defaultDate:"1970-01-01",
		yearRange: "1916:-15"
	});
});
</script>
<script type="text/javascript" src="/plugin/sweetalert/sweetalert.min.js"></script>
<link rel="stylesheet" href="/plugin/sweetalert/sweetalert.css">
<script type="text/javascript">

  $( function() {
	$("#client_birthday").on( "change", function() {
		if(calculateAge($("#client_birthday").val()) <= 20){
			alertErr(2);
      		swal("We’re sorry…", "We require that all participants in the program be 21 or older and less than 65.", "error");
			$("#client_birthday").val("")
		}else if(calculateAge($("#client_birthday").val()) >= 65){
			alertErr(3);
      		swal("We’re sorry…", "We require that all participants in the program be 21 or older and less than 65.", "error");
			$("#client_birthday").val("")
		}
	});
    $("input[name='client_gender']").on( "change", function() {
		if($("#client_gender1").prop('checked')){
			alertErr(4);
      		swal("We’re sorry…", "At the moment, this service is for women only.", "error");
			$("#client_gender1").prop('checked', false);
		}
    });
    $("#Out_of_United_States").on( "change", function() {
		if($("#Out_of_United_States").prop('checked')){
			alertErr(5);
      		swal("We’re sorry…", "We cannot provide service to individuals outside of the United States.", "error");
			$("#Out_of_United_States").prop('checked', false);
		}
    });
function calculateAge(birthday) {
// birth[0]→year, birth[1]→month, birth[2]→day
	var  birth = birthday.split('-');
	var _birth = parseInt("" + birth[0] + birth[1] + birth[2]);
	var  today = new Date();
	var _today = parseInt("" + today.getFullYear() + affixZero(today.getMonth() + 1) + affixZero(today.getDate()));
	return parseInt((_today - _birth) / 10000);
}

function affixZero(int) {
	if (int < 10) int = "0" + int;
	return "" + int;
}
  } );
  
	function checkForm(){
		$(".errBox").each(function(i, elem) {
			$(elem).text("");
		});
		var $alert='';
		var $alert2='';
		<?php $key='client_birthday';?>
		if(!$("#<?php echo $key ?>").val()){
			$("#<?php echo $key ?>_error").text('Required');
			$alert=$alert+'*Date of Birth\n';
		}
		<?php $key='client_height';?>
		if($("input[name='<?php echo $key ?>_unit']:checked").length==0){
			$("#<?php echo $key ?>_unit_error").text('Required');
			$alert=$alert+'*Height Unit\n';
		}else{
			if($("#<?php echo $key ?>_unit1").prop('checked')){
				if(!$("#<?php echo $key ?>_ft").val()){
					$("#<?php echo $key ?>_error").text('Required');
					$alert=$alert+'*Height\n';
				}else if(!$("#<?php echo $key ?>_ft").val().match(/^[0-9]+$/) || ($("#<?php echo $key ?>_in").val() && !$("#<?php echo $key ?>_in").val().match(/^[0-9]+$/))){
					$alert2=$alert2+'*Height\n';
				}
			}
			if($("#<?php echo $key ?>_unit2").prop('checked')){
				if(!$("#<?php echo $key ?>_cm").val()){
					$("#<?php echo $key ?>_error").text('Required');
					$alert=$alert+'*Height\n';
				}else if(!$("#<?php echo $key ?>_cm").val().match(/^[0-9]+$/)){
					$alert2=$alert2+'*Height\n';
				}
			}
		}
		<?php $key='client_weight';?>
		if($("input[name='<?php echo $key ?>_unit']:checked").length==0){
			$("#<?php echo $key ?>_unit_error").text('Required');
			$alert=$alert+'*Weight Unit\n';
		}else{
			if($("#<?php echo $key ?>_unit1").prop('checked')){
				if(!$("#<?php echo $key ?>_lbs").val()){
					$("#<?php echo $key ?>_error").text('Required');
					$alert=$alert+'*Weight\n';
				}else if(!$("#<?php echo $key ?>_lbs").val().match(/^[0-9]+$/)){
					$alert2=$alert2+'*Weight\n';
				}
			}
			if($("#<?php echo $key ?>_unit2").prop('checked')){
				if(!$("#<?php echo $key ?>_kg").val()){
					$("#<?php echo $key ?>_error").text('Required');
					$alert=$alert+'*Weight\n';
				}else if(!$("#<?php echo $key ?>_kg").val().match(/^[0-9]+$/)){
					$alert2=$alert2+'*Weight\n';
				}
			}
		}
		<?php $key='client_happy_weight'; ?>
		if($("input[name='<?php echo $key ?>']:checked").length==0){
			$("#<?php echo $key ?>_error").text('Required');
			$alert=$alert+'*Are you happy with your current weight?\n';
		}else{
			if($("#<?php echo $key ?>2").prop('checked')){
				<?php $key='client_goal_weight'; ?>
				if($("#<?php echo $key ?>_unit1").prop('checked')){
					if(!$("#<?php echo $key ?>_lbs").val()){
						$("#<?php echo $key ?>_error").text('Required');
						$alert=$alert+'*Your goal weight\n';
					}else if(!$("#<?php echo $key ?>_lbs").val().match(/^[0-9]+$/)){
						$alert2=$alert2+'*Your goal weight\n';
					}
				}
				if($("#<?php echo $key ?>_unit2").prop('checked')){
					if(!$("#<?php echo $key ?>_kg").val()){
						$("#<?php echo $key ?>_error").text('Required');
						$alert=$alert+'*Your goal weight\n';
					}else if(!$("#<?php echo $key ?>_kg").val().match(/^[0-9]+$/)){
						$alert2=$alert2+'*Your goal weight\n';
					}
				}
			}
		}
		<?php $key='client_gender'; ?>
		if($("input[name='<?php echo $key ?>']:checked").length==0){
			$("#<?php echo $key ?>_error").text('Required');
			$alert=$alert+'*Gender?\n';
		}
		<?php $key='client_zip_code';?>
		if(!$("#<?php echo $key ?>").val()){
			$("#<?php echo $key ?>_error").text('Required');
			$alert=$alert+'*Zip Code/ Postal Code\n';
		}else if(!$("#<?php echo $key ?>").val().match(/^[0-9]+$/)){
			$alert2=$alert2+'*Zip Code/ Postal Code\n';
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
		form.attr("action","#003");
		form.submit();
		
	}
</script>
<script>
$(function() {

$(document).ready( function() 
{
	$('#citybox').hide();
	$('#statebox').hide();
	
});

// OnKeyDown Function
$("#client_zip_code").keyup(function() {
	var zip_in = $(this);
	var zip_box = $('#zipbox');
	
	if (zip_in.val().length<5)
	{
		zip_box.removeClass('error success');
		$("#client_city").val("");
		$("#client_state").val("");
		$('#citybox').slideUp();
		$('#statebox').slideUp();
	}
	else if ( zip_in.val().length>5)
	{
		zip_box.addClass('error').removeClass('success');
		$("#client_city").val("");
		$("#client_state").val("");
		$('#citybox').slideUp();
		$('#statebox').slideUp();
	}
	else if ((zip_in.val().length == 5) ) 
	{
		
		// Make HTTP Request
		$.ajax({
			url: "https://api.zippopotam.us/us/" + zip_in.val(),
			cache: false,
			dataType: "json",
			type: "GET",
		  success: function(result, success) {
				// Make the city and state boxes visible
				$('#citybox').slideDown();
				$('#statebox').slideDown();
			
				// US Zip Code Records Officially Map to only 1 Primary Location
				places = result['places'][0];
				$("#client_city").val(places['place name']);
				$("#client_state").val(places['state']);
				zip_box.addClass('success').removeClass('error');
			},
			error: function(result, success) {
				$("#client_city").val("");
				$("#client_state").val("");
				$('#citybox').slideUp();
				$('#statebox').slideUp();
				zip_box.removeClass('success').addClass('error');
			}
		});
	}
});
});
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
<form action="" method="post" name="form1" id="form1">
<input type="hidden" name="mode" id="mode" value="form3" />
<div class="content__padded">
<p><a onclick="backForm('form1','#001')">&lt;Back</a></p>
		<ul class="table_a">
			<li>
				<dl>
					<dt>Date of Birth <span class="red">*</span></dt>
					<?php
					   $key='client_birthday';
					   echo '<dd><input class="input__profile js-answer-key date" id="'.$key.'" type="text" name="'.$key.'" value="'.$display['session'][$key].'" placeholder="yyyy-mm-dd" maxlength="10" readonly="readonly"><span id="'.$key.'_error" class="errBox"></span></dd>';
					?>
				</dl>
			</li>
			<li>
				<dl class="unit">
					<dt>Height <span class="red">*</span></dt>
					<dd class="u1">
						<?php $key='client_height_unit'; ?>
						<div id="<?php echo $key.'_box1'?>" <?php if($display['session'][$key]==2) echo 'style="display:none"'?>>
							<?php $key='client_height_ft'; ?>
							<input class="input__profile js-answer-key" id="<?php echo $key?>" type="tel" name="<?php echo $key?>" placeholder="ft" value="<?php echo $display['session'][$key];?>" maxlength="10">ft <br />
							<?php $key='client_height_in'; ?>
							<input class="input__profile js-answer-key" id="<?php echo $key?>" type="tel" name="<?php echo $key?>" placeholder="in" value="<?php echo $display['session'][$key];?>" maxlength="10">in
							<div id="<?php echo $key?>_error" class="errBox"></div>
						</div>
						<?php $key='client_height_unit'; ?>
						<div id="<?php echo $key.'_box2'?>" <?php if($display['session'][$key]!=2) echo 'style="display:none"'?>>
							<?php $key='client_height_cm'; ?>
							<input class="input__profile js-answer-key" id="<?php echo $key?>" type="tel" name="<?php echo $key?>" placeholder="cm" value="<?php echo $display['session'][$key];?>" maxlength="10">cm
							<div id="<?php echo $key?>_error" class="errBox"></div>
						</div>
					</dd>
					<dd>
                    
						<?php $key='client_height_unit'; ?>
						<div class="radio__circle measure__circle">
							<input type="radio" class="radio__circle__input js-answer-key" id="<?php echo $key?>1" name="<?php echo $key?>" value="1" <?php echo $m->Checked($display['session'][$key],1)?> onchange="dispHeight(this,'<?php echo $key?>_box')" data-required="true">
							<label class="radio__circle__inner" for="<?php echo $key?>1">feet</label>
						</div>
						<div class="radio__circle measure__circle">
							<input type="radio" class="radio__circle__input js-answer-key" id="<?php echo $key?>2" name="<?php echo $key?>" value="2" <?php echo $m->Checked($display['session'][$key],2)?> onchange="dispHeight(this,'<?php echo $key?>_box')" data-required="true">
							<label class="radio__circle__inner" for="<?php echo $key?>2">cm</label>
						</div>
						<div id="<?php echo $key?>_error" class="errBox"></div>
                       
					</dd>
				</dl>
			</li>
			<li>
				<dl class="unit">
					<dt>Weight <span class="red">*</span></dt>
					<dd class="u1">
						<?php $key='client_weight_unit'; ?>
						<div id="<?php echo $key.'_box1'?>" <?php if($display['session'][$key]==2) echo 'style="display:none"'?>>
						<?php $key='client_weight_lbs'; ?>
						<input class="input__profile js-answer-key" id="<?php echo $key?>" type="tel" name="<?php echo $key?>" placeholder="lbs" value="<?php echo $display['session'][$key];?>" maxlength="10">lbs
						</div>
						<?php $key='client_weight_unit'; ?>
						<div id="<?php echo $key.'_box2'?>" <?php if($display['session'][$key]!=2) echo 'style="display:none"'?>>
						<?php $key='client_weight_kg'; ?>
						<input class="input__profile js-answer-key" id="<?php echo $key?>" type="tel" name="<?php echo $key?>" placeholder="kg" value="<?php echo $display['session'][$key];?>" maxlength="10">kg
						</div>
						<div id="<?php echo $key?>_error" class="errBox"></div>
					</dd>
					<dd>
                    <div class="circle_area">
						<?php $key='client_weight_unit'; ?>
						<div class="radio__circle measure__circle">
							<input type="radio" class="radio__circle__input js-answer-key" id="<?php echo $key?>1" name="<?php echo $key?>" value="1" <?php echo $m->Checked($display['session'][$key],1)?> onchange="dispHeight(this,'<?php echo $key?>_box')" data-required="true">
							<label class="radio__circle__inner" for="<?php echo $key?>1">lbs</label>
						</div>
						<div class="radio__circle measure__circle">
							<input type="radio" class="radio__circle__input js-answer-key" id="<?php echo $key?>2" name="<?php echo $key?>" value="2" <?php echo $m->Checked($display['session'][$key],2)?> onchange="dispHeight(this,'<?php echo $key?>_box')" data-required="true">
							<label class="radio__circle__inner" for="<?php echo $key?>2">kg</label>
						</div>
						<div id="<?php echo $key?>_error" class="errBox"></div>
                        </div>
					</dd>
				</dl>
			</li>
			<li>
				<dl>
					<dt>Are you happy with your current weight? <span class="red">*</span></dt>
					<dd>
                    <div class="circle_area">
						<?php $key='client_happy_weight'; ?>
						<div class="radio__circle measure__circle">
							<input type="radio" class="radio__circle__input js-answer-key" id="<?php echo $key?>1" name="<?php echo $key?>" value="1" <?php echo $m->Checked($display['session'][$key],1)?> data-required="true" onchange="dispBox(this,'your_goal',2)">
							<label class="radio__circle__inner" for="<?php echo $key?>1">Yes</label>
						</div>
						<div class="radio__circle measure__circle">
							<input type="radio" class="radio__circle__input js-answer-key" id="<?php echo $key?>2" name="<?php echo $key?>" value="2" <?php echo $m->Checked($display['session'][$key],2)?> data-required="true" onchange="dispBox(this,'your_goal',2)">
							<label class="radio__circle__inner" for="<?php echo $key?>2">No</label>
						</div>
						<div id="<?php echo $key?>_error" class="errBox"></div>
                        </div>
					</dd>
				</dl>
			</li>
			</ul>
			<div id="your_goal" <?php if($display['session'][$key]!=2) echo 'style="display:none"'?>>
			<ul class="table_a">
			<li>
				<dl class="unit">
					<dt>Your goal</dt>
					<dd class="u1">
						<?php $key='client_goal_weight_unit'; ?>
						<div id="<?php echo $key.'_box1'?>" <?php if($display['session'][$key]==2) echo 'style="display:none"'?>>
						<?php $key='client_goal_weight_lbs'; ?>
						<input class="input__profile js-answer-key" id="<?php echo $key?>" type="tel" name="<?php echo $key?>" placeholder="lbs" value="<?php echo $display['session'][$key];?>" maxlength="10">lbs
						</div>
						<?php $key='client_goal_weight_unit'; ?>
						<div id="<?php echo $key.'_box2'?>" <?php if($display['session'][$key]!=2) echo 'style="display:none"'?>>
						<?php $key='client_goal_weight_kg'; ?>
						<input class="input__profile js-answer-key" id="<?php echo $key?>" type="tel" name="<?php echo $key?>" placeholder="kg" value="<?php echo $display['session'][$key];?>" maxlength="10">kg
						</div>
						<div id="<?php echo $key?>_error" class="errBox"></div>
					</dd>
					<dd>
                    <div class="circle_area">
						<?php $key='client_goal_weight_unit'; ?>
						<div class="radio__circle measure__circle">
							<input type="radio" class="radio__circle__input js-answer-key" id="<?php echo $key?>1" name="<?php echo $key?>" value="1" <?php echo $m->Checked($display['session'][$key],1)?> onchange="dispHeight(this,'<?php echo $key?>_box')" data-required="true">
							<label class="radio__circle__inner" for="<?php echo $key?>1">lbs</label>
						</div>
						<div class="radio__circle measure__circle">
							<input type="radio" class="radio__circle__input js-answer-key" id="<?php echo $key?>2" name="<?php echo $key?>" value="2" <?php echo $m->Checked($display['session'][$key],2)?> onchange="dispHeight(this,'<?php echo $key?>_box')" data-required="true">
							<label class="radio__circle__inner" for="<?php echo $key?>2">kg</label>
						</div>
						<div id="<?php echo $key?>_error" class="errBox"></div>
                        </div>
					</dd>
				</dl>
			</li>
			</ul>
			</div>
			<ul class="table_a">
			<li>
				<dl>
					<dt>Gender <span class="red">*</span></dt>
					<dd>
                    <div class="circle_area">
						<?php $key='client_gender'; ?>
						<div class="radio__circle measure__circle">
							<input type="radio" class="radio__circle__input js-answer-key" id="<?php echo $key?>1" name="<?php echo $key?>" value="1" <?php echo $m->Checked($display['session'][$key],1)?> data-required="true">
							<label class="radio__circle__inner" for="<?php echo $key?>1">Male</label>
						</div>
						<div class="radio__circle measure__circle">
							<input type="radio" class="radio__circle__input js-answer-key" id="<?php echo $key?>2" name="<?php echo $key?>" value="2" <?php echo $m->Checked($display['session'][$key],2)?> data-required="true">
							<label class="radio__circle__inner" for="<?php echo $key?>2">Female</label>
						</div>
						<div id="<?php echo $key?>_error" class="errBox"></div>
                        </div>
					</dd>
				</dl>
			</li>
			<li>
				<dl>
					<dt>Zip Code/ Postal Code <span class="red">*</span></dt>
					<dd id="zipbox">
						<?php $key='client_zip_code'; ?>
						<input class="input__profile" id="<?php echo $key?>" type="tel" name="<?php echo $key?>" value="<?php echo $display['session'][$key];?>" maxlength="5" />
						<span id="<?php echo $key?>_error" class="errBox"></span>
					</dd>
				</dl>
				<div class="c"></div>
				<dl id="citybox" class="control-group">
					<dt>City</dt>
					<dd><input type="text" name="client_city" id="client_city" placeholder="" /></dd>
				</dl>
				<div class="c"></div>
				<dl id="statebox" class="control-group">
					<dt>State</dt>
					<dd><input type="text" name="client_state" id="client_state" placeholder="" /></dd>
				</dl>
				<div class="c"></div>
				<input type="checkbox" value="1" id="Out_of_United_States"/>
				<label for="Out_of_United_States" class="check_css"> Out of United States</label>
			</li>
		</ul>
		<div class="nextarea">
			<button type="button" name="next-question" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-next-button btn-next btn_control" data-form="002" onclick="checkForm()">Next</button>
			<button type="button" name="prev-question" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-prev-button btn-prev btn_control" data-form="" onclick="backForm('form1','#001')">BACK</button>
		</div>
</div>
	</form>
<!-- / .content__padded -->
<div class="copy"> Contact us if you have any questions or find more information on <a href="/diet/faq.html" target="_blank" class="fancybox fancybox.iframe">FAQ page</a>.
	Email: <a href="mailto:support@brainsalvation.com">support@brainsalvation.com</a></div>
</body>
</html>
