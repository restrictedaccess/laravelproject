<?php
require_once("../../../new/data/common/init.php");
$m = new main();
$dbHelper = new DbHelper();
$dbHelper->open();

if($_POST['ErrorCode']){
	$m->pLog('twilio_err.log',$_POST);
	
	$where='';
	$where['client_twilio_no']=$display['post']['From'];
	$res=$dbHelper->sql_get_one2('*','client',$where);
	$client_id=$res['client_id'];

	$title='[bs] Twilio MMS Error '.$_POST['To'];
	$_POST['client_url']=AHOST.'/client.html?id='.$res['client_id'];
	$body=$m->mailBody('twilio_err',$_POST);
	$m->sendmail(MAIL,$title,$body,'pegara@mad2007.co.jp');

	$client_mobile_no=$res['client_mobile_no'];
	if(!$client_mobile_no){
		exit();
	}

	$where='';
	$where['consultant_mobile_no']=$display['post']['To'];
	$res2=$dbHelper->sql_get_one2('*','client',$where);
	if($res2['consultant_email']){
		$m->sendmail($res2['consultant_email'],$title,$body);
	}
	
}
?>