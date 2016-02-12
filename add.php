<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
		<style type="text/css">
			body{
				background-color: #FFFFEE;
			}
			.ht{
				margin:30px; 
			}
			.hf{
				background-color: #F0E0D6;
				width: 500px;
				margin-left: 15px;
				padding:5px; 
				margin-top: 5px;
				margin-bottom:5px; 

			}
		</style>
	</head>
	<body>
<?php
	session_start();
	
	$sql=new mysqli("localhost","root","","cookie") or die("数据库连接失败");
	$sql->query("SET NAMES utf8");
	$tid=$_GET["tid"];

	if(($_SESSION["sid"]==1||$_SESSION["sid"]==2)&&$_SESSION["pt"]<time()){//判断SESSION是否为1或2

		$post=strip_tags($_POST["hui"]);
		if(strlen($post)>3&&strlen($post)<500){
		$user=$_SESSION["user"];
		$date=date("Y-m-d H:i:s");
		$hui="INSERT INTO re(tid,user,date,rr) VALUES ('$tid','$user','$date','$post')";
		$sql->query($hui);
		$timen=time()+10;
		$sql->query("UPDATE user SET pt='$timen'");
		$_SESSION["pt"]=$timen;
		}
	}
		$lx="re";
		$ssw="SELECT * FROM post WHERE tid='$tid'";
		$ssd="SELECT * FROM re WHERE tid='$tid'";
		$sswe=$sql->query($ssw);
		$ssde=$sql->query($ssd);
		$sswj=$sswe->fetch_row();
		?>
		<center><h1><?php echo "#".$tid ?></h1></center>
		<div class="ht">
			<b>#</b>
		<?php
		echo $sswj[0]." ".$sswj[4]." ".$sswj[3]."";
		if($sswj[3]!="admin"){
			echo "无名者";
		}else{
			echo "管理员";
		}
		echo "<br>".$sswj[5]."<br>";
		if($sswj[6]){
			echo "<img src=\"$sswj[6]\"><br>"; //如果纯在图片显示
		}
		while ($ssdj=$ssde->fetch_array()) {
			echo "<div class=\"hf\">#".$ssdj[0]." ".$ssdj[3];
			if ($ssdj[2]<>"admin"){
				echo " 无名氏 ";
				# code...
			}else{
				echo " 管理员 ";
			}
			echo "     <a href=\"jb.php?lx=$lx&jb=$ssdj[0]\">举报</a><br>";
			echo $ssdj[2]."<br>";
			echo $ssdj[4]."</div>";

			# code...
		}
	
	?>
	<hr>
	<div class="hui">
	<form action="" method="post">
		<textarea name="hui" cols="35" rows="5"></textarea>
		<br>
		<input type="submit" value="回复">
	</form>
	</div>
	</div>

</body>
</html>
