<?php
global $display;
class front {
	function class_check(){
		if($_SESSION['user']['user_class']){
			$display['user_class']=$_SESSION['user']['user_class'];
		}
	}
}

