<?php
define("DEBUG_MODE", 0);

define("HOST_NAME", "Brainsalvation admin system");
define("COPYRIGHT", "Copyright &copy; 2015 Pegara Inc. All rights Reserved.");

define("MAX_PAGE", 30);

$display['list']['user_role_id']=array(1=>'Manager',2=>'Consultant',3=>'Health Coach');

$display['list']['manager_role']=array(1=>'Admin',2=>'Operator',3=>'Manager');
$display['list']['manager_status']=array(1=>'Active',2=>'Away');

$display['list']['client_status']=array(1=>'Waiting assign Nutrition Consultant',2=>'Waiting scheduling consultation (Manager)',3=>'Waiting Consultation (Consultant)',4=>'Waiting assign Health Coach (Manager)',5=>'Waiting start program (Health Coach)',6=>'On going (Health Coach)',7=>'End of a contract (Admin)',8=>'Other (Admin)');
$display['list']['client_gender']=array(2=>'female',1=>'male');
$display['list']['client_height_unit']=array(1=>'feet&inc',2=>'cm');
$display['list']['client_weight_unit']=array(1=>'Pounds',2=>'kg');
$display['list']['client_why_chose']=array(1=>'Reduce my risk of Alzheimer’s',2=>'Assistance with my current health concerns',3=>'Personalized motivation from health',99=>'Other');
$display['list']['client_health_concern']=array('1'=>'Overall Diet Quality','2'=>'Blood Sugar','3'=>'Energy Levels','99'=>'Other');
$display['list']['client_type_of_diet']=array('1'=>'I don’t follow any special diet','2'=>'Vegetarian','3'=>'Vegan','4'=>'Gluten Free','5'=>'Paleo','99'=>'Other');
$display['list']['client_happy_weight']=array(1=>'Yes',2=>'No');
$display['list']['client_activity_level']=array('1'=>'Little to none','2'=>'Moderate to high');
$display['list']['client_activity_choice']=array('1'=>'Yard_work','2'=>'Walking','3'=>'Jogging','4'=>'Running','5'=>'Biking','6'=>'Swimming','7'=>'Elliptical','8'=>'Aerobics','9'=>'Yoga','99'=>'Other');
$display['list']['client_coach']=array(1=>'A drill sergeant',2=>'A middle-of-the-road coach',3=>'A cheerleader!');
$display['list']['client_expertise']=array(1=>'Motivation',2=>'Nutrition',3=>'A combination of both');
$display['list']['client_physical_level']=array(1=>'Yes',2=>'Not right now');
$display['list']['client_alert_check']=array(1=>'true',0=>'false');
$display['list']['client_price_plan']=array(1=>'3 month 149$',2=>'1 month 45$');

$display['list']['consultant_role']=array(1=>'Consultant',2=>'Health Coach');
$display['list']['consultant_status']=array(1=>'Active',2=>'Away');
$display['list']['consultant_status_btn']=array(2=>'Active',1=>'Away');
$display['list']['consultant_copy_submitted']=array(1=>'not received',2=>'received');

$display['list']['memo_class']=array(1=>'memo1(for admin)',2=>'memo2(for consultant and health coach)',3=>'Goal',4=>'Feedback from Consultant');
$display['list']['memo_type']=array(1=>'Goal',2=>'Result');

$display['list']['alert_err']=array(1=>'someone has specific allergies',2=>'21 or less',3=>'65 or older',4=>'male',5=>'outside of the United States');
?>