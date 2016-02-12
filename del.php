<?php
	session_start();
	
	$sql=new mysqli("localhost","root","","cookie") or die("数据库连接失");
	$sql->query("SET NAMES utf8");
	$lx=$_GET["lx"];
	$id=$_GET["id"];
	if($_SESSION["sid"]==2){
		if($lx=="post"){
			$sql->query("DELETE FROM post WHERE tid='$id'");
			$sql->query("DELETE FROM re WHERE tid='$id'");
		
		}else{
			$sql->query("DELETE FROM re WHERE rid='$id'");
			
		}
		header("Location:$_SERVER[HTTP_REFERER] ");//返回当前页面前一页面

	}
	$sql->close();
?>
