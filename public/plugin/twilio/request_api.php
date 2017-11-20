<?php
require_once("../../../new/data/common/init.php");
use Twilio\Rest\Client;
$m = new main();
$m->pLog('twilio.log',$_POST);

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
if($display['post']['NumMedia']){
	for($i=0;$i<$display['post']['NumMedia'];$i++){
		$media[]=$display['post']['MediaUrl'.$i];
	}
}

$where='';
$where['client_mobile_no']=$fromtel;
$where['client_twilio_no']=$display['post']['To'];
$client=$dbHelper->sql_get_col2('*','client',$where);

if($client){
	$post_array='';
	$post_array['activity_type']=1;
	$post_array['activity_create_time']=date('Y-m-d H:i:s');
	$post_array['activity_create_date']=date('Y-m-d');
	$post_array['activity_comment']=$display['post']['Body'];
	$post_array['activity_to']=$display['post']['To'];
	$post_array['activity_from']=$display['post']['From'];
	$post_array['activity_client_id']=$client['client_id'];
	$post_array['activity_message_sid']=$display['post']['MessageSid'];
	
	if($media){
		foreach($media as $k => $v){
			if($k){
				$post_array['activity_comment']='';
			}
			$post_array['activity_photo']=$v;
			$dbHelper->sql_send('activity',$post_array);
		}
	}else{
		$dbHelper->sql_send('activity',$post_array);
	}
	
	
	$where='';
	$where['consultant_id']=$client['client_health_coach_id'];
	if($to=$dbHelper->sql_get_one('consultant_mobile_no','consultant',$where)){
		messagesCreate($to,$display['post']['To'],$display['post']['Body'],$media);
	}else{
		$where='';
		$where['consultant_id']=$client['client_consultant_id'];
		if($to=$dbHelper->sql_get_one('consultant_mobile_no','consultant',$where)){
			messagesCreate($to,$display['post']['To'],$display['post']['Body'],$media);
		}
	}
}

$where='';
$where['consultant_mobile_no']=$fromtel;
$consultant=$dbHelper->sql_get_col2('*','consultant',$where);
if($consultant){
	$post_array='';
	$post_array['activity_type']=2;
	$post_array['activity_create_time']=date('Y-m-d H:i:s');
	$post_array['activity_comment']=$display['post']['Body'];
	$post_array['activity_to']=$display['post']['To'];
	$post_array['activity_from']=$display['post']['From'];
	$post_array['activity_client_id']=$client_id;
	$post_array['activity_consultant_id']=$consultant['consultant_id'];
	$post_array['activity_message_sid']=$display['post']['MessageSid'];

	if($media){
		foreach($media as $k => $v){
			if($k){
				$post_array['activity_comment']='';
			}
			$post_array['activity_photo']=$v;
			$dbHelper->sql_send('activity',$post_array);
		}
	}else{
		$dbHelper->sql_send('activity',$post_array);
	}
	messagesCreate((int)$client_mobile_no,$display['post']['To'],$display['post']['Body'],$media);
}

function messagesCreate($to,$from,$body,$mediaUrl){
	sleep(3);
	$sid = TWILIO_SID;
	$token = TWILIO_TOKEN;
	$client = new Client($sid, $token);
	$array='';
	$array['from']=$from;
	$array['body']=htmlspecialchars_decode($body);
	if($mediaUrl){
		$array['mediaUrl']=$mediaUrl;
	}
	$res=$client->messages->create('+1'.$to,$array);
}


?>