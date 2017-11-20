<?php
$p = new page();
$m = new main();
if(!$display['post']['err']){
	exit();
}
$dbHelper = new DbHelper();
$dbHelper->open();

$param='';
$param['alert_err_utm_campaign']=$display['session']['utm_campaign'];
$param['alert_err_utm_medium']=$display['session']['utm_medium'];
$param['alert_err_utm_source']=$display['session']['utm_source'];
$param['alert_err_err']=$display['post']['err'];
$param['alert_err_create_time >']=date("Y-m-d H:i:s", strtotime("-1 day"));
$param['alert_err_ip']=$_SERVER["REMOTE_ADDR"];

if(!$dbHelper->sql_get_count('alert_err',$param)){
	$param['alert_err_create_time']=date('Y-m-d H:i:s');
	$dbHelper->sql_send('alert_err',$param);
}
exit();
?>