<?php
require_once("../../../new/data/common/init.php");
$m = new main();
if($_POST['ErrorCode']){
	$m->pLog('twilio_voice_err.log',$_POST);
	$title='[bs] Twilio Voice Error '.$_POST['To'];
	$body=$m->mailBody('twilio_voice_err',$_POST);
	$m->sendmail(MAIL,$title,$body,'pegara@mad2007.co.jp');
}
?>