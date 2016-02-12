<?php
	session_start();
	$sql=new mysqli("localhost","root","","cookie") or die("数据库连接失败");
	$sql->query("SET NAMES utf8");
	if($_SESSION["sid"]==2){

	}else{
	if(isset($_COOKIE["name"])){//判断COOKIE是否纯在
		$cookie=base64_decode($_COOKIE["name"]);//将COOKIE中保存的信息解码出来。
		//echo $cookie;
		$coa=explode(":",$cookie);//拆分
		//var_dump($coa);
		$name=$coa[0];//从COOKIE中读取id
		$pass=$coa[1];
		$cx=$sql->query("SELECT * FROM user WHERE name='$name' AND pass='$pass'");
		$jg=$cx->fetch_row(); //查询COOKIE中的ID是否在数据库中存在
		//var_dump($jg);
		if(time()<$jg[4]){//判断用户COOKIE的有效时间，如果成功的话将SESSION["sid"]设置成1
			$_SESSION["sid"]=1;
			$_SESSION["user"]=$name;
			$_SESSION["pt"]=$jg[5];
			//echo $_SESSION["user"]; //检测session的值
		}else{	//失败的话跳转到另一页面，提示COOKIE失效。***************
		}
	}else{
		function ranid($need){ //生成随机的ID函数
			$zfc="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
			for ($i=0; $i < $need; $i++) { 
				static $ii;
				$ii=$ii.$zfc[mt_rand(0,61)];				
				# code...
			}
			return $ii;
		}
		$id=ranid(8);//生成ID
		$ip=$_SERVER["REMOTE_ADDR"];//获取访问者的IP
		$tn=time(); //获取当前时间
		$te=$tn+86400*90;//cookie保存时间
		$pt=$tn+10;
		$pass=md5($id.$ip.$tn);
		$all=$id.":".$pass.":".$tn;
		$name=base64_encode($all);//生成COOKIE中的name值，此值用于验证数据库
		$sql->query("INSERT INTO user VALUES('$id','$pass','$ip','$tn','$te','$pt')");//插入数据库
		setcookie("name",$name,time()+86400*90);//设置COOKIE
		$_SESSION["sid"]=1;
		$_SESSION["user"]=$id;//此时为ID
		$_SESSION["pt"]=$pt;
	}
}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
		<style type="text/css">
			body{
				background-color: #FFFFEE;
			}
			#fabu{
				margin-top: 20px;
		
				text-align: center;
			}
			.hf{
				width: 500px;
				margin: 20px;
				font-size: 21px/23px;
				
				
			}
			.ht{
				width: 360px;
				
				margin-left: 30px;
				margin-top: 5px;
				margin-bottom:5px;  
				font-size: 16px;
				background-color: #F0E0D6;
			}
			#sm{
				width: 300px;
				float: right;
				color: #F011F0;
			}
			#head{
				text-align: center;
			}
			.tl{
				margin-left:60px; 
				color: #F01190;
			}
			.ye{
				margin-left: 40px;
			}
		</style>
		<script type="text/javascript">
			function showd(){
				var $ddd=document.getElementById("sm");
				$ddd.style.display="none";
			}

		</script>
	</head>
	<body>
		<div id="sm" style="display:block" onmouseover="showd(this)">
			1.每个登入Wauhu的同学，将自动获得一COOKIE【饼干】，保质期为90天，在此期间内可以直接发帖。COOKIE【饼干】过保质期后，可以重新登入获取一块新的饼干。<br>
			2.图片的格式为jpg/png/gif,大小要小于5MB。<br>
			3.发帖的文字限制是大于3个字符，小于2000个字符。<br>
			4.回帖的限制是大于3个字符，小于500个字符。<br>
			5.不支持html标签。<br>

		</div>	
		<div id="head">
			<h1> <?php echo $_GET["bname"] ?></h1>

		</div>
		<hr>
		<div id="fabu">
			
			<center>
			<table>
				<form action="" method="post" enctype="multipart/form-data">
					<tr>
						<td><b>用户名 <b></td><td><?php echo $user=$_SESSION["user"]?> </td><td><b>时间 <b></td><td><?php echo $date=date("Y-m-d H:i:s") ?> </td>
					</tr>
					<tr>
						<td colspan=4>
						<textarea name="text" cols=44 rows=6>

						</textarea>
						</td>
					</tr>
					<tr>
						<td colspan=4>
					<input type="file" name="file">	
						</td>
					</tr>
					<tr>
						<td colspan=2>
						<?php
							if($_SESSION["sid"]==1||$_SESSION["sid"]==2){//判断有权限发帖！
						?>
						<input type="submit" name="sub" value="提交">
						<?php 
							}
							$text=strip_tags($_POST["text"]);//去标记
							$bid=$_GET["bid"];
							$bname=$_GET["bname"];
						
					
							
						if($_SESSION["pt"]<time()){
							if(strlen(trim($text))>3&&strlen(trim($text))<2000){//对文字长度进行检测
								$files=$_FILES["file"];
								$ext=explode(".", $files["name"]);
								$ex=end($ext);
								if (($ex=="jpg"||$ex=="png"||$ex=="gif")&&($files["size"]<5000000)) {//对图片的格式和大小进行检测
									$name=md5_file($files["tmp_name"]);
									$fi=$name.".".$ex;
									
									move_uploaded_file($files["tmp_name"],"photo/$fi");
									$fn="photo/".$fi;
									
									# code...
									//插入POST
									$is="INSERT INTO post(bid,bname,user,date,nr,photo)VALUES('$bid','$bname','$user','$date','$text','$fn')";
									$sc=$sql->query($is);
								}else{
									$ist="INSERT INTO post(bid,bname,user,date,nr)VALUES('$bid','$bname','$user','$date','$text')";
									$sct=$sql->query($ist);
								}
								$timen=time()+10;
								$sql->query("UPDATE user SET pt='$timen'");
								$_SESSION["pt"]=$timen;



							}
						}

							
						?>
						
						</td>
						<td colspan=2>
						<center><input type="reset" name="res" value="重置"></center>
						</td>
					</tr>
			</table>
			</center>
		
		</div>
		<div class="tl">
			<p>*发文有时间间隔，间隔时间为10秒
			<br>*禁止污言辱骂、人身攻击、地域攻击、露点色情、民族政治、邪教犯罪、毒品自杀相关内容，禁止张贴他人隐私资料、造谣传谣。</P>
		</div>
		<hr>
		
		<div id="show">
			<?php
				$ss="SELECT * FROM post WHERE bid='$bid'"; //分页
				$sso=$sql->query($ss);
				$num=$sso->num_rows;
				$zys=ceil($num/5); 
				$page=$_GET["page"]; //获取页码
				if(!is_numeric($page)||$page==0||$page>$zys){//对页码判断
					$page=1;
				}
				$p=5*($page-1); 
				$fy="SELECT * FROM post WHERE bid='$bid' ORDER BY tid DESC LIMIT $p,5";//分页语句
				$ssj=$sql->query($fy);
				$lx="post";

				while ($sse=$ssj->fetch_array()) { //对获取的内容进行展示
					static $a=1;
					echo "<div class=hf id=\"$a\">";
					echo "<b>#".$sse[0]."</b>["." ".$sse[4]." ".$sse[3]."] ";
					if($sse[3]!="admin"){
						echo "无名氏";
					}else{
						echo "管理员";
					}
					echo   "<a href=\"jb.php?lx=$lx&jb=$sse[0]\">举报</a><br>"; //帖子div
					echo $sse["nr"]."<br>";
					
					if($sse[6]){  //如果存在图片
						echo "<img width=250 src=\"$sse[photo]\"><br>";
						$tid=$sse[0];
						$ht="SELECT * FROM re WHERE tid='$tid' LIMIT 5"; //回帖div
						$htj=$sql->query($ht);
						while ($hte=$htj->fetch_array()) {
							echo "<div class=ht>";
							echo "#".$hte[0]."[ ".$hte[3]." ".$hte[2];
							if($hte[2]!="admin"){
								echo "]无名氏";
							}else{
								echo "]管理员";
							}

							echo ":<br>".$hte[4];
							# code...
							echo "</div>";
						}
					

					}else{

						$tid=$sse[0];
						$ht="SELECT * FROM re WHERE tid='$tid' LIMIT 5"; //回帖div
						$htj=$sql->query($ht);
						while ($hte=$htj->fetch_array()) {
							echo "<div class=ht>";
							echo "#".$hte[0]."[ ".$hte[3]." ".$hte[2];
							if($hte[2]!="admin"){
								echo "]无名氏";
							}else{
								echo "]管理员";
							}
							echo ":<br>".$hte[4];
							# code...
							echo "</div>";
						}


					}
					$a++;
					echo "<br><a href=\"add.php?tid=$tid\">回复此贴</a></div><hr>";


				}

			echo "<br><div class=\"ye\">";   //页码

			echo "当前页面：第 $page 页<br>";
			echo "跳转到";

			$ye=1;
			while($ye<=$zys){ //页面跳转程序
				echo "<a href=\"show.php?page=$ye&bid=$bid&bname=$bname\">"." ".$ye." ";
				$ye++;
			}
			echo "</a>页</div>";


			?>


		</div>	
	</body>
</html>
<?php
	$sql->close();
?>
