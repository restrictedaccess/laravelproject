<?php $m=new main();?>
<ul>
	<li class="icon1 dashboard<?php echo $m->ifActive($no,0)?>"><a href="index.html">Dashboard</a></li>
	<li class="icon4 dashboard<?php echo $m->ifActive($no,1)?>"><a href="client.html">client</a></li>
	<?php if($display['session']['user_role_id']=='1'){ ?>
	<li class="icon6 dashboard<?php echo $m->ifActive($no,2)?>"><a href="consultant.html">consultant / Health Coach</a></li>
	<li class="icon9 dashboard<?php echo $m->ifActive($no,3)?>"><a href="manager.html">manager</a></li>
	<?php } ?>
</ul>
