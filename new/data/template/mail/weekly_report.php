<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$title?></title>
<style>
body{
	font-size:0.8em;
}
.rap{
	background-color:#FFFFFF;
	padding:0 5px;
}
h1{
	color:#0072CF;
	font-size:small;
}
h1 img{
	text-align:left;
	vertical-align:middle;
	width:200px;
	max-width:50%;
	padding:0px 10px 10px 0;
}
h2{
	font-size:small;
	padding:5px;
	background:#EBEBEB;
}
.footer{
	color:#999999;
	padding:0px 15px;
}
.footer .copy{
	text-align:center;
	font-size:x-small;
}
.photoBox p img{
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	margin:0 5px 2px 0;
}
</style>

</head>

<body>
<div class="rap">
<h1><img src="https://www.brainsalvation.com/new/images/logo_savation.png" alt="Brainsalvation"><span>- Sustain the Brain</span></h1>

<p>Hi <?=$client_first_name?>,</p>
<p>
The pictures below contain all the meals you have submitted through Brainsalvation this week. It's a great time to reflect back over the week, noticing areas of progress and areas that need improvement. Keep up the hard work!
</p>
<p>
<strong>My Meal</strong>
</p>
<?=$activity_photo?>
<?=$activity_week_comment?>
<p>
Yours sincerely,
</p>
<p>
The Brainsalvation Team<br>
<a href="https://www.brainsalvation.com/diet">https://www.brainsalvation.com/diet</a><br>
<a href="mailto:info_diet@brainsalvation.com">info_diet@brainsalvation.com</a><br>
</p>
<p style="color:#999999; font-size:10px;">
You are receiving this email because you are a member of the Brainsalvation Dietary Program. While you are a member, we will occasionally send you important information regarding your account by e-mail until your membership
</p>
</div>
<div class="footer">
<div class="copy">Copyright &copy; 2015 Pegara, Inc. All Rights Reserved. </div>
</div>

</body>
</html>
