<?php
header('Content-type: text/xml');

$callerId = "+13608136251";
 
$number   = "ProdActivity";
 
if (isset($_REQUEST['PhoneNumber'])) {
    $number = htmlspecialchars($_REQUEST['PhoneNumber']);
}

if (preg_match("/^[\d\+\-\(\) ]+$/", $number)) {
    $numberOrClient = "<Number>" . $number . "</Number>";
} else {
    $numberOrClient = "<Client>" . $number . "</Client>";
}

if(isset($_REQUEST['Contact'])) {
	$url = "http://testing6.itransition.com/prodactivity/web/call?Contact=".$_REQUEST['Contact'];
} else {
	$url = "";
}

?>
 
<Response>
    <Dial action="<?php echo $url ?>" callerId="<?php echo $callerId ?>" method="GET">
          <?php echo $numberOrClient ?>
    </Dial>
</Response>