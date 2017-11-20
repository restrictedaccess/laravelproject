<?php
$p = new page();
$m = new main();
if(!$display['post']['coupon_id'] || !$display['post']['price']){
	exit();
}
\Stripe\Stripe::setApiKey(STRIPE_SK_KEY);
try {
	$coupon = \Stripe\Coupon::retrieve($display['post']['coupon_id']);
} catch(\Stripe\Error\InvalidRequest $e) {
	$res['err']=$e->jsonBody['error']['message'];
	echo json_encode($res);
	exit();
}
if($coupon['percent_off']){
	$res['coupon_alert']=$coupon['percent_off'].'% OFF';
	$res['coupon_price']=number_format($display['post']['price']*((100-$coupon['percent_off'])*0.01),2);
}elseif($coupon['amount_off']){
	$res['coupon_alert']='$'.($coupon['amount_off']*0.01).' OFF';
	$res['coupon_price']=number_format((($display['post']['price']*100)-$coupon['amount_off'])*0.01,2);
}
echo json_encode($res);
exit();
?>