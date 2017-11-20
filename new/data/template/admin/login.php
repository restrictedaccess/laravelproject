<?php $p=new page() ?>
<?php $p->print_meta('login') ?>
</head>
<body id="login">
<div class="rap">
<h1>pegara</h1>
<h2>How does your lifestyle affect your Alzheimer's Risk?</h2>
<form action="?" method="post">
<input type="hidden" name="token" value="<?php echo $display['session']['token']?>">
<div class="loginTable">
<div><input type="text" name="login_id" class="login_id" placeholder="ID" /></div>
<div><input type="password" name="login_pass" class="login_pass" placeholder="PW" /></div>
<div style="padding:10px 20px 0 20px;">
<?php
foreach($display['list']['user_role_id'] as $k => $v){
echo '<label><input type="radio" name="user_role_id" value="'.$k.'">'.$v.'</label> ';
}
?>
</div>
<div class="btnArea"><input name="login" type="submit" class="btn" value="login" alt="login" /></div>
</div>
</form>
<?php
if($display['err']){
echo '<div class="err"><span>'.$display['err'].'</span></div>';
}
?>
<div style="text-align:center; padding:15px;">If the login error has occurred, please contact to <a href="mailto:info_diet@brainsalvation.com">info_diet@brainsalvation.com</a>.</div>
</div>
</body>
</html>