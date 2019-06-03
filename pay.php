<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
header('Content-Type:text/html;charset=utf8');
date_default_timezone_set('Asia/Shanghai');

include 'config.php';


$userip = $_SERVER['REMOTE_ADDR'];
$merchant_id = $config['merchant_id'];
$orderid = time() . mt_rand(1000000000, 9999999999);
$money = number_format($_POST['money'], 2, '.', '');
if ($money > 50000 || $money < 100) {
    die('充值金额需大于100元小于50000元');
}
$paytype = $_POST['paytype'];
$notifyurl = 'http://' . $_SERVER['HTTP_HOST'] . '/demo/notify.php';
$callbackurl = 'http://' . $_SERVER['HTTP_HOST'] . '/demo/return.php';
$key = $config['key'];

$data=$merchant_id . $orderid . $paytype . $notifyurl . $callbackurl . $money . $key;

$sign = md5($data);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf8">
    <title>正在转到付款页</title>
</head>
<body onLoad="document.pay.submit()">
<form name="pay" action="http://api.ponypay1.com/" method="post">
    <input type="hidden" name="merchant_id" value="<?php echo $merchant_id ?>">
    <input type="hidden" name="orderid" value="<?php echo $orderid ?>">
    <input type="hidden" name="paytype" value="<?php echo $paytype ?>">
    <input type="hidden" name="notifyurl" value="<?php echo $notifyurl ?>">
    <input type="hidden" name="callbackurl" value="<?php echo $callbackurl ?>">
    <input type="hidden" name="userip" value="<?php echo $userip ?>">
    <input type="hidden" name="money" value="<?php echo $money ?>">
    <input type="hidden" name="sign" value="<?php echo $sign ?>">
</form>
</body>
</html>
