<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=1" />
<meta name="format-detection" content="telephone=no">
<title><?php echo $title?> | <?php echo HOST_NAME?></title>
<meta http-equiv="content-script-type" content="text/javascript" /> 
<meta http-equiv="content-style-type" content="text/css" />
<link href="<?php echo AHOST?>css/import.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery.min.js"></script>
<link href="/plugin/mmenu/css/jquery.mmenu.all.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="/plugin/mmenu/js/jquery.mmenu.min.all.js"></script>
<script type="text/javascript" src="<?php echo AHOST?>js/js.js"></script>
<?php
if(strlen($display['err']['alert'])>1){
	echo $display['err']['alert'];
}
?>
