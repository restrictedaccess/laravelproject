<?php

	$year = date('Y');
	$month = date('m');

if($_POST['event']){
	echo json_encode(array(
	
		array(
			'id' => 111,
			'title' => "Event3",
			'start' => date("Y-m-d H:00:00"),
			'end' => date("Y-m-d 23:00:00"),
			'allDay' => false,
		),
		
		array(
			'id' => 222,
			'title' => "Event4",
			'start' => "$year-$month-20",
			'end' => "$year-$month-22",
		)
	
	));
}else{
	echo json_encode(array(
	
		array(
			'id' => 111,
			'title' => "Event1",
			'start' => date("Y-m-d H:00:00"),
			'end' => date("Y-m-d 23:00:00"),
			'allDay' => false,
		),
		
		array(
			'id' => 222,
			'title' => "Event2",
			'start' => "$year-$month-20",
			'end' => "$year-$month-22",
		)
	
	));
}
?>
