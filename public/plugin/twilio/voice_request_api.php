<?php
require_once("../../../new/data/common/init.php");
$m = new main();
$m->pLog('twilio_voice.log',$_POST);

if($display['post']['FromCountry']=='JP'){
	$fromtel='0'.str_replace('+81','',$display['post']['From']);
}else{
	$fromtel=str_replace('+1','',$display['post']['From']);
}
$dbHelper = new DbHelper();
$dbHelper->open();

$where='';
$where['client_twilio_no']=$display['post']['To'];
$res=$dbHelper->sql_get_one2('client_id,client_mobile_no','client',$where);
$client_id=$res['client_id'];
$client_mobile_no=$res['client_mobile_no'];
if(!$client_mobile_no){
	exit();
}

$where='';
$where['client_mobile_no']=$fromtel;
$where['client_twilio_no']=$display['post']['To'];
$client=$dbHelper->sql_get_col2('*','client',$where);

if($client){
	$where='';
	$where['consultant_id']=$client['client_health_coach_id'];
	if($to=$dbHelper->sql_get_one('consultant_mobile_no','consultant',$where)){
		messagesCreate($to,$display['post']['To']);
	}else{
		$where='';
		$where['consultant_id']=$client['client_consultant_id'];
		if($to=$dbHelper->sql_get_one('consultant_mobile_no','consultant',$where)){
			messagesCreate($to,$display['post']['To']);
		}
	}
}

$where='';
$where['consultant_mobile_no']=$fromtel;
$consultant=$dbHelper->sql_get_col2('*','consultant',$where);
if($consultant){
	messagesCreate((int)$client_mobile_no,$display['post']['To']);
}

function messagesCreate($to,$from,$body,$mediaUrl){
	$response = new Twilio\Twiml();
	//$response->say('Hello');
	$dial=$response->dial(array('callerId'=>$from));
	$dial->number('+1'.(int)$to);
	print $response;
	exit();
}
?>