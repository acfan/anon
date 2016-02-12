<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
		<style type="text/css">
			.post{
				width: 350px;
				
				margin-left: 30px;
				margin-top: 5px;
				margin-bottom:5px;  
				font-size: 16px;
				background-color: #FFFFEE;

			}
			.re{
				width: 350px;
				
				margin-left: 30px;
				margin-top: 5px;
				margin-bottom:5px;  
				font-size: 16px;
				background-color: #F0E0D6;
			}
		</style>
	</head>
	<body>	
<?php
	session_start();
	
	$sql=new mysqli("localhost","root","","cookie") or die("数据库连接失败");
	$sql->query("SET NAMES utf8");
	$user=$_POST["user"];
	$password=md5($_POST["pass"]);
	$as="SELECT * FROM admin WHERE user='$user' AND password='$password'";
	$ad=$sql->query($as);
	if($ad->num_rows){
		$_SESSION["sid"]=2;
		$_SESSION["user"]=$user;

		echo "欢迎".$_SESSION["user"]."登入";
		
	}
	if($_SESSION["sid"]!=2){
		?>
		<table>
			<form method="post" action="">
				<tr>
					<td>用户名</td><td><input type="text" name="user"></td>
				<tr>
				<tr>
					<td>密码</td><td><input type="password" name="pass"></td>
				</tr>
				<tr>
					<td colspan=2><input type="submit" value="登入"></td>
				</tr>		
			</form>
		</table>
<?php
	} 
	?>






	<?php
		if($_SESSION["sid"]==2){
	?>	
	<a href="exit.php">离开</a>
	<hr>被举报贴子
	<?php
		$jbt=$sql->query("SELECT * FROM post WHERE jb=1");
		echo $jbt->num_rows;
		$lx="post";
		while($jtt=$jbt->fetch_array()){
			static $i=1;
			$id=$jtt[0];
 			echo "<div id=\"$1\" class=post>#".$jtt[0]."  [".$jtt[3]." ".$jtt[4]."]<a href=\"del.php?lx=$lx&id=$id\">删除</a>  <a href=\"qx.php?lx=$lx&id=$id\">取消</a><br>".$jtt[5]."</div>";

		}
		?>
	<hr>被举报回复
		<?php
		$jbh=$sql->query("SELECT * FROM re WHERE jb=1");
		echo $jbh->num_rows;
		$lx="re";
		while($jhh=$jbh->fetch_array()){
			$id=$jhh[0];
			echo "<div class=re>#".$jhh[0]." [".$jhh[2]." ".$jhh[3]."]<a href=\"del.php?lx=$lx&id=$id\">删除</a>   <a href=\"qx.php?lx=$lx&id=$id\">取消</a><br><br>".$jhh[4]."</div>";

		}
	}


		?>
