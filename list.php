<html>
<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
		<style type="text/css">
			#logo{
				margin: 30px;
			}
			#list{
				margin-top:20px;
				margin-left:20px;  
			}
		</style>
</head>
<body>
	<img src="timg.jpg" width=100>
	<div id="logo">
	
		<h2>wauhu</h2>

	</div>
<?php
	session_start();
	$sql=new mysqli("localhost","root","","cookie") or die("数据库连接失败");
	$sql->query("SET NAMES utf8");
?>
<div id="list">
<?php
	$li="SELECT DISTINCT bid,bname  FROM post ORDER BY bid";

	$lis=$sql->query($li);

	while($list=$lis->fetch_array()){
		echo "<a href=\"show.php?bid=$list[0]&bname=$list[1]\" target=\"list\">$list[1]</a><br><br>";
	}
?>	
</div>
</body>
</html>
