<script  type="text/javascript" language="javascript" src="<?php echo SITE::$root.'/resources/JQuery/jquery-3.1.1.min.js' ?>"></script>
<script  type="text/javascript" language="javascript" src="<?php echo SITE::$root.'/resources/bootstrap/js/bootstrap.min.js' ?>"></script>
<?php
if($status != null && isset($admin) && is_object($admin)){
	$admin->updateLastSeen(time());
}
?>