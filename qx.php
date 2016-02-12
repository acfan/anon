<?php
	session_start();
	
	$sql=new mysqli("localhost","root","","cookie") or die("数据库连接失");
	$sql->query("SET NAMES utf8");
	$lx=$_GET["lx"];
	$id=$_GET["id"];
	if($_SESSION["sid"]==2){
		if($lx=="post"){
			$sql->query("UPDATE post SET jb=0 WHERE tid='$id'");
			
		
		}else{
			$sql->query("UPDATE re SET jb=0 WHERE rid='$id'");
			
		}
		header("Location:$_SERVER[HTTP_REFERER] ");//返回当前页面前一页面

	}
$sql->close();

?>

