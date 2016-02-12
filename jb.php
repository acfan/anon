<?php
	session_start();
	
	$sql=new mysqli("localhost","root","","cookie") or die("数据库连接失?");
	$sql->query("SET NAMES utf8");
	$jb=$_GET["jb"];
	$lx=$_GET["lx"];
	if($_SESSION["sid"]==1||$_SESSION["sid"]==2){
		if($lx=="post"){
			$jbs="UPDATE post SET jb=1 WHERE tid='$jb'";

		}else{
			$jbs="UPDATE re SET jb=1 WHERE rid='$jb'";

		}
		$sql->query($jbs);
		header("Location:$_SERVER[HTTP_REFERER] ");//返回当前页面前一页面

	}
	$sql->close();
?>
