<?php
	session_start();
	$_SESSION=array();
	header("Location:$_SERVER[HTTP_REFERER] ");//返回当前页面前一页面
?>