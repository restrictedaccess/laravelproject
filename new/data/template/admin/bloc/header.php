</head>
<body>
<div class="header clearfix">
<div class="container pc">
	<div class="headline"><a href="index.html"><h1><?php echo HOST_NAME ?></h1></a></div>
	<div class="box logout"><a href="login.html" class="btn2">Log Out</a></div>
	<?php if($display['session']['consultant_status']){ ?>
	<div class="box logout"><a href="index.html?st=<?php echo $display['session']['consultant_status']?>" class="btn2"><?php echo $display['list']['consultant_status_btn'][$display['session']['consultant_status']]?></a></div>
	<?php } ?>
	<div class="box loginname">
	<?php echo $display['session']['user_role']?> / <?php echo $display['session']['user_name']?><?php if($display['session']['consultant_status']){ ?> / <?php echo $display['list']['consultant_status'][$display['session']['consultant_status']]?><?php } ?>
	</div>
</div>
<div class="container sp">
	<div class="headline"><h1><a href="index.html"><?php echo HOST_NAME ?></a></h1></div>
	<div class="lmenu"><a href="#menu-left2">三</a></div>
	<div class="rmenu">
	<div class="menubt"><a href="#" onClick="dispBox('popBox1')">&or;</a></div>
	</div>
	<div id="popBox1" onClick="hideBox('popBox1')">
	<div class="rap">
	<div class="arrow"></div>
	<div class="head">
	<div class="loginname"><?php echo $display['session']['user_role']?> / <?php echo $display['session']['user_name']?></div>
	<div class="logout">
	<?php if($display['session']['consultant_status']){ ?>
	<?php echo $display['list']['consultant_status'][$display['session']['consultant_status']]?>
	<a href="index.html?st=<?php echo $display['session']['consultant_status']?>" class="btn2"><?php echo $display['list']['consultant_status_btn'][$display['session']['consultant_status']]?></a> | 
	<?php } ?>
	<a href="login.html" class="btn2">Log Out</a>
	</div>
	</div>
    </div>
	</div>
</div>

</div>
<div class="container">
<div class="wrapper clearfix">
	
<nav id="menu-left2">
<?php
	include(TPL_DIR."bloc/menu.php");
?>
</nav>
<div class="menu">
<?php
	include(TPL_DIR."bloc/menu.php");
?>
</div>

<div class="mainRap">
