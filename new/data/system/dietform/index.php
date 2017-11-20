<?php
$p = new page();
$m = new main();
if($display['post']['mode']!='comp'){
	if($display['post']){
		foreach($display['post'] as $k => $v){
			$_SESSION['dietform'][$k]=$v;
		}
	}
}
$display['session']=$display['session']['dietform'];
if($display['post']['mode']=='top'){
$m->location('/diet/');
}elseif($display['post']['mode']=='form2'){
	if(!$display['session']['client_height_unit']){
		$display['session']['client_height_unit']=1;
	}
	if(!$display['session']['client_weight_unit']){
		$display['session']['client_weight_unit']=1;
	}
	if(!$display['session']['client_goal_weight_unit']){
		$display['session']['client_goal_weight_unit']=1;
	}
	if(!$display['session']['client_gender']){
		$display['session']['client_gender']=2;
	}
$p->gf_rendering("diet_form2.php");
}elseif($display['post']['mode']=='form3'){
if(!$display['session']['client_why_chose']){
	$m->location('/dietform/#001');
}
$p->gf_rendering("diet_form3.php");
}elseif($display['post']['mode']=='form4'){
if(!$display['session']['client_why_chose']){
	$m->location('/dietform/#001');
}
$p->gf_rendering("diet_form4.php");
}elseif($display['post']['mode']=='form5'){
if(!$display['session']['client_why_chose']){
	$m->location('/dietform/#001');
}
$p->gf_rendering("diet_form5.php");
}elseif($display['post']['mode']=='comp'){

if(!$display['session']['client_why_chose']){
	$m->location('/dietform/#001');
}

\Stripe\Stripe::setApiKey(STRIPE_SK_KEY);
if($display['post']['coupon_code']){
	$display['post']['coupon_code2']=$display['post']['coupon_code'];
}
if($display['post']['coupon_code2']){
	try {
		$coupon = \Stripe\Coupon::retrieve($display['post']['coupon_code2']);
	} catch(\Stripe\Error\InvalidRequest $e) {
		$display['alert']='swal("Coupon Error", "'.$e->jsonBody['error']['message'].'", "error");';
		$p->gf_rendering("diet_form5.php");
	}
}

$array='';
	$array=array(
	"description" => $display['session']['client_first_name']." ".$display['session']['client_last_name'],
	"email" => $display['session']['client_email'],
	"plan" => "1");
	if($display['post']['coupon_code2']){
		$array["coupon"]=$display['post']['coupon_code2'];
	}
	if($display['post']['client_stripe_token']){
		$array["source"]=$display['post']['client_stripe_token'];
	}
try {
  $customer = \Stripe\Customer::create($array);
} catch(\Stripe\Error\Card $e) {
  $display['alert']='swal("card error", "'.$e->jsonBody['error']['message'].'", "error");';
  $p->gf_rendering("diet_form5.php");
}
$res = $customer->__toArray(true);

$dbHelper = new DbHelper();
$dbHelper->open();

$display['session']['client_create_time']=date("Y-m-d H:i:s");
$display['session']['client_update_time']=date("Y-m-d H:i:s");
$display['session']['client_ip_address']=$_SERVER["REMOTE_ADDR"];
$display['session']['client_referer']=$_SESSION['referer'];
$display['session']['client_os']=$m->checkUserAgent(1);
$display['session']['client_browser']=$m->checkUserAgent(2);
$display['session']['client_device']=$m->checkUserAgent(3);
if($display['session']['client_height_unit']==1){
	$display['session']['client_height']=$display['session']['client_height_ft']."′".(int)$display['session']['client_height_in'];
}else{
	$display['session']['client_height']=$display['session']['client_height_cm'];
}
if($display['session']['client_weight_unit']==1){
	$display['session']['client_weight']=$display['session']['client_weight_lbs'];
}else{
	$display['session']['client_weight']=$display['session']['client_weight_kg'];
}
if($display['session']['client_goal_weight_unit']==1){
	$display['session']['client_goal_weight']=$display['session']['client_goal_weight_lbs'];
}else{
	$display['session']['client_goal_weight']=$display['session']['client_goal_weight_kg'];
}
$display['session']['client_why_chose']=implode('/',$display['session']['client_why_chose']);
$display['session']['client_health_concern']=implode('/',$display['session']['client_health_concern']);
$display['session']['client_type_of_diet']=implode('/',$display['session']['client_type_of_diet']);
$display['session']['client_activity_choice']=implode('/',$display['session']['client_activity_choice']);
$display['session']['client_time_zone']=$display['post']['hour']-date('H');
$display['session']['client_price_plan']=1;
$display['session']['client_terms']=90;
$display['session']['client_terms_start']=date('Y-m-d');
$display['session']['client_terms_end']=date("Y-m-d", strtotime("+3 month"));
$display['session']['client_stripe_token']=$display['post']['client_stripe_token'];
$display['session']['client_stripe_customer_id']=$res['id'];
$display['session']['client_status']=1;

$dbHelper->sql_send('client',$display['session']);

$title='Guidance of diet program [Bransalvation]';
$display['title']=$title;
$display['post']['price']=149.00;
if($coupon){
	if($coupon['percent_off']){
		$display['session']['coupon_price']='$'.number_format($display['post']['price']*((100-$coupon['percent_off'])*0.01),2).'('.$coupon['percent_off'].'% OFF)';
	}elseif($coupon['amount_off']){
		$display['session']['coupon_price']='$'.number_format((($display['post']['price']*100)-$coupon['amount_off'])*0.01,2).'($'.($coupon['amount_off']*0.01).' OFF)';
	}
}else{
	$display['session']['coupon_price']='$'.number_format($display['post']['price'],2);
}


$body=$m->mailBody('thanks',$display['session']);
$m->sendmailHtml($display['session']['client_email'],$title,$body,MAIL);

unset($_SESSION['dietform']);
$m->location('thanks.html');
}else{
$p->gf_rendering("diet_form1.php");
}
?>