<?php
require_once("/webapps/bs/app/new/data/common/init.php");
$dbHelper = new DbHelper();
$dbHelper->open();
$p = new page();
$m = new main();
$cust='';

for($i=7;$i<=11;$i++){
	$where='';
	$where['client_price_plan']=1;
	$where['client_terms_end']=date("Y-m-d", strtotime("+".$i." day"));
	$where['client_status < ']=7;
	if($list=$dbHelper->sql_get_select('client',$where)){
		$cust.="\n".'ends after '.$i.' days'."\n";
		foreach($list as $v){
			$cust.=$v['client_first_name'].' '.$v['client_last_name'].'('.$v['client_id'].')'."\n";
			$cust.=AHOST.'client.html?id='.$v['client_id']."\n";
			$cust.=STRIPE_URL.'customers/'.$v['client_stripe_customer_id']."\n\n";
		}
	}
}

for($i=4;$i>=1;$i--){
	$where='';
	$where['client_price_plan']=1;
	$where['client_terms_end']=date("Y-m-d", strtotime("+".$i." day"));
	$where['client_status < ']=7;
	if($list=$dbHelper->sql_get_select('client',$where)){
		$cust.="\n".'ends after '.$i.' days'."\n";
		foreach($list as $v){
			$cust.=$v['client_first_name'].' '.$v['client_last_name'].'('.$v['client_id'].')'."\n";
			$cust.=AHOST.'client.html?id='.$v['client_id']."\n";
			$cust.=STRIPE_URL.'customers/'.$v['client_stripe_customer_id']."\n\n";
		}
	}
}

$where='';
$where['client_price_plan']=1;
$where['client_terms_end <=']=date("Y-m-d");
$where['client_status < ']=7;
if($list=$dbHelper->sql_get_select('client',$where,'client_terms_end')){
	$cust.="\n".'Expiration date passed'."\n";
	foreach($list as $v){
		$cust.=$v['client_first_name'].' '.$v['client_last_name'].'('.$v['client_id'].') TermsEnd:'.$v['client_terms_end']."\n";
		$cust.=AHOST.'client.html?id='.$v['client_id']."\n";
		$cust.=STRIPE_URL.'customers/'.$v['client_stripe_customer_id']."\n\n";
	}
}


if($cust){
	$body=$m->mailBody('stripe_plan_update',array('list'=>$cust));
	$bcc='co.murata@gmail.com';
	$m->sendmail(MAIL,'[bs] Contract terms need update.',$body,$bcc);
}
?>