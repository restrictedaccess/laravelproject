<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Brainsalvation - Dietary Program</title>
<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,600" rel="stylesheet"> 
<link href="/new/css/style.css" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js?ver=1.8.3"></script>
<script type="text/javascript" src="//malsup.github.io/jquery.form.js"></script>
<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
<script type="text/javascript" src="//js.stripe.com/v2/"></script>
<script type="text/javascript" src="/new/js/js.js"></script>
<script type="text/javascript" src="/plugin/sweetalert/sweetalert.min.js"></script>
<link rel="stylesheet" href="/plugin/sweetalert/sweetalert.css">
<script type="text/javascript" src="/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="/plugin/fancybox/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="/plugin/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="/plugin/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<link href="/plugin/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" media="all" />
<?php
if($display['alert']){
?>
<script type="text/javascript">
$(document).ready(function() { <?php echo $display['alert'];?> });
</script>
<?php
}
?>
<script type="text/javascript">
$(function() {
	$('.fancybox').fancybox();
});
function checkForm(){
	$(".errBox").each(function(i, elem) {
		$(elem).text("");
	});
	var $alert='';
	<?php $key='cardnumber';?>
	if(!$("#<?php echo $key ?>").val()){
		$("#<?php echo $key ?>_error").text('Required');
		$alert=$alert+'*Credit Card Number\n';
	}
	<?php $key='security';?>
	if(!$("#<?php echo $key ?>").val()){
		$("#<?php echo $key ?>_error").text('Required');
		$alert=$alert+'*Card Security Code\n';
	}
	if($alert){
		swal("Please enter the following", $alert, "error");
		return false;
	}
	return stripeSubmit();
}

function formValidationCheck(form) {
	// Checking form has passed the validation.
	if (!$(form).valid()) {
		return false;
	}
	$('.subscribe_process').show();
}

function stripeSubmit(){
	var form = $("#form1");
	// form validation
	formValidationCheck(form);
	if(!$(form).valid()){
		return false;
	}
	// Disable the submit button to prevent repeated clicks and form submit
	$('.submit-button').attr("disabled", "disabled");
	// createToken returns immediately - the supplied callback 
	// submits the form if there are no errors
	Stripe.createToken({
		number: $('.card-number').val(),
		cvc: $('.card-cvc').val(),
		exp_month: $('.card-expiry-month').val(),
		exp_year: $('.card-expiry-year').val()
	}, stripeResponseHandler);
	return false; // submit from callback
}


function stripeCoupon(){
	var $p='149.00';
	if(!$('#coupon_code').val()){
		swal("Coupon Error", "Please enter Coupon Code", "error");
		$('#price').html('<p>$'+$p+'</p>');
		return false;
	}
    requestData = {price:$p,coupon_id:$('#coupon_code').val()}
    $.ajax({
      type: "POST",
      url: "coupon.html",
      data: requestData,
      success: function(response){
        if (response) {
			var obj = JSON.parse(response);
			if(obj.err){
				swal("Coupon Error", obj.err, "error");
				$('#price').html('<p>$'+$p+'</p>');
			}else{
				swal("Coupon Sucsses", obj.coupon_alert, "success");
				$('#price').html('<dl class="red"><dt>$'+obj.coupon_price+'</dt><dd>'+obj.coupon_alert+'</dd></dl>');
				if(obj.coupon_price=='0.00'){
					$('#creditBox').hide();
					$('#couponBtnBox').show();
				}
			}
        } else {
			swal("Coupon Error", "Server error", "error");
			$('#price').html('<p>$'+$p+'</p>');
        }
      }
    });	
}

Stripe.setPublishableKey('<?php echo STRIPE_PK_KEY;?>');

<!-- It is better to have the below script as separate file.-->
// Setting the error class and error element for form validation.
jQuery.validator.setDefaults({
	errorClass: "text-danger",
	errorElement: "small"
});


// Call back function for stripe response.
function stripeResponseHandler(status, response) {
	if (response.error) {
		swal("card error", response.error.message, "error");
		$('.subscribe_process').hide();
	} else {
		var form = $("#form2");
		// Getting token from the response json.
		var token = response['id'];
		// insert the token into the form so it gets submitted to the server
		if ($("input[name='client_stripe_token']").length == 1) {
			$("input[name='client_stripe_token']").val(token);
		} else {
			form.append("<input type='hidden' name='client_stripe_token' value='" + token + "' />");
		}
		if ($("input[name='coupon_code']").length == 1) {
			form.append("<input type='hidden' name='coupon_code2' value='" + $("input[name='coupon_code']").val() + "' />");
		}
		DD = new Date();
		form.append("<input type='hidden' name='hour' value='" + DD.getHours() + "' />");
		form.submit();
		return false;
	}
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
	<input type="hidden" name="mode" id="mode" value="" />
	<div class="content__padded">
	<p><a onclick="backForm('form4','#004')">&lt;Back</a></p>
		<h2>Payment </h2>
		<div class="total clearfix">
			<dl class="heightLine">
				<dt>Brainsalvation DIET </dt>
				<dd>3 months <br />
					Dietary daily advise </dd>
			</dl>
			<div id="price" class="heightLine">
				<p>$149.00</p>
			</div>
		</div>
		<dl class="tbl clearfix mb30">
			<dt> Coupon</dt>
			<dd>
				<input class="input__profile js-answer-key" id="coupon_code" type="text" name="coupon_code" size="16" value="" maxlength="255">
			</dd>
			<dd>
				<button type="button" name="next-question" class="btn btn-block btn-inline-block btn__small btn__regular js-next-button btn-next btn_control" onclick="stripeCoupon()">APPLY</button>
			</dd>
			<dd id="coupon_res">
			</dd>
		</dl>
		<div id="couponBtnBox" class="nextarea" style="display:none;">
			<button type="button" name="next-question" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-next-button btn-next btn_control" data-form="" onclick="backForm('comp')">Submit </button>
			<button type="button" name="prev-question" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-prev-button btn-prev btn_control" data-form="" onclick="backForm('form4','#004')">BACK</button>
		</div>
	<div id="creditBox">
		<div class="question">Please tell us how you would like to pay:</div>
		<input type="radio" name="Reduce_my_risk_of_Alzheimers" value="Reduce my risk of Alzheimer's" checked="checked" id="a01" />
		<label for="a01" class="radio"> Reduce my risk of Alzheimer's. </label>
		<div class="cards mb30"><img src="/new/images/payment.png" /></div>
		<ul class="table_a nobdr">
			<li>
				<dl>
					<dt>Credit Card Number<span class="red">*</span></dt>
					<dd>
						<input class="input__profile js-answer-key card-number" id="cardnumber" type="tel" name="cardnumber" maxlength="16" value="">
					</dd>
				</dl>
			</li>
			<li>
				<dl>
					<dt>Expiration date<span class="red">*</span></dt>
					<dd>
					
						<select class="card-expiry-month input__profile js-answer-key" id="expiry_month" required data-msg-required="empty">
							<option selected>01</option>
							<option>02</option>
							<option>03</option>
							<option>04</option>
							<option>05</option>
							<option>06</option>
							<option>07</option>
							<option>08</option>
							<option>09</option>
							<option>10</option>
							<option>11</option>
							<option>12</option>
						</select>
						<select class="card-expiry-year input__profile js-answer-key" id="expiry_year" required data-msg-required="empty">
							<option>2013</option>
							<option>2014</option>
							<option>2015</option>
							<option>2016</option>
							<option>2017</option>
							<option>2018</option>
							<option>2019</option>
							<option selected="">2020</option>
							<option>2021</option>
							<option>2022</option>
							<option>2023</option>
						</select>
						
					</dd>
				</dl>
			</li>
			<li>
				<dl>
					<dt>Card Security Code<span class="red">*</span></dt>
					<dd>
						<input name="security" type="tel" class="input__profile js-answer-key card-cvc" id="security" value="" maxlength="10" size="4">
					</dd>
				</dl>
			</li>
		</ul>
		<div>By clicking the button below. I agree with the Pegara <a href="/terms" target="_blank" class="fancybox fancybox.iframe">Terms of Service</a> and <a href="/privacy" target="_blank" class="fancybox fancybox.iframe">Privacy Policy</a>. </div>
	<span class="subscribe_process process" style="display:none;">Processing&hellip;</span>
	<div class="nextarea">
		<button type="button" name="next-question" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-next-button btn-next btn_control" data-form="002" onclick="checkForm()">Submit </button>
		<button type="button" name="prev-question" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-prev-button btn-prev btn_control" data-form="" onclick="backForm('form4','#004')">BACK</button>
	</div>
	</div>
	</div>
	</div>
</form>
<form action="?" method="post" name="form2" id="form2">
<input type="hidden" name="mode" id="mode" value="comp" />
</form>
<div class="copy"> Contact us if you have any questions or find more information on <a href="/diet/faq.html" target="_blank" class="fancybox fancybox.iframe">FAQ page</a>.
	Email: <a href="mailto:support@brainsalvation.com">support@brainsalvation.com</a></div>
</body>
</html>
