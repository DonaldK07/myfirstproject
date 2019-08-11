<!DOCTYPE html>
<html>
<?php
session_start();
$css_version = "0.2.0";
$js_version = "0.2.0";
$time = intval( time() );

//登录服务器
$db = mysqli_connect( 'localhost', 's8710956', 'gcES34mpWV', 's8710956' )or die( "无法连接至服务器" );
mysqli_query( $db, "SET NAMES UTF8" );
$sq = "SELECT * FROM tiezi";
$result = mysqli_query( $db, $sq );	
	
$sq2 = "SELECT * FROM hotworks";
$result2 = mysqli_query( $db, $sq2 );

//$str为要进行截取的字符串，$length为截取长度（汉字算一个字，字母算半个字）
function strCut( $str, $length ) {
	$length = $length * 3;
	//$str=ltrim($str,'<br>');
	$str = trim( $str );
	$string = "";
	if ( strlen( $str ) > $length ) {
		for ( $i = 0; $i < $length; $i++ ) {
			if ( ord( $str ) > 127 ) {
				$string .= $str[ $i ] . $str[ $i + 1 ] . $str[ $i + 2 ];
				$i = $i + 2;
			} else {
				$string .= $str[ $i ];
			}
		}
		$string .= "...";
		return $string;
	}
	return strip_tags( $str );
}

//文件计数
function ShuLiang( $url ) {
	$sl = 0;
	$arr = glob( $url );
	foreach ( $arr as $v ) {
		if ( is_file( $v ) ) {
			$sl++;
		} else {
			$sl += ShuLiang( $v . "/*" );
		}
	}
	return $sl;
}
$count_file = ShuLiang( "images/xc" );

function strip_html_tags( $tags, $str ) {
	$html = array();
	foreach ( $tags as $tag ) {
		$html[] = "/(<(?:\/" . $tag . "|" . $tag . ")[^>]*>)/i";
	}
	$data = preg_replace( $html, '', $str );
}
?>
<head>

	<!---------------------------------------->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=0"/>
	<link href="css/c1.css?<?php echo $time?>" rel="stylesheet" type="text/css"/>
	<link rel="icon" href="images/logos/DKlogo.jpg" type="image/x-icon"/>
	<title>DK</title>
</head>

<!---------------------------------------->

<style type="text/css">
	.input_out_r {
		position: absolute;
		top: 170px;
		right: 25px;
		width: 60px;
		height: 60px;
		background: url('images/icon/arrow_r0.png');
		border: 0px;
		z-index: 1;
		-webkit-border-radius: 100%;
		border-radius: 100%;
	}
	
	.input_move_r {
		position: absolute;
		top: 170px;
		right: 25px;
		width: 60px;
		height: 60px;
		background: url('images/icon/arrow_r1.png');
		border: 0px;
		box-shadow: 0px 0px 5px #000;
		z-index: 1;
		-webkit-border-radius: 100%;
		border-radius: 100%;
	}
	
	.input_out_l {
		position: absolute;
		top: 170px;
		left: 25px;
		width: 60px;
		height: 60px;
		background: url('images/icon/arrow_l0.png');
		border: 0px;
		z-index: 1;
		-webkit-border-radius: 100%;
		border-radius: 100%;
	}
	
	.input_move_l {
		position: absolute;
		top: 170px;
		left: 25px;
		width: 60px;
		height: 60px;
		background: url('images/icon/arrow_l1.png');
		border: 0px;
		box-shadow: 0px 0px 5px #000;
		z-index: 1;
		-webkit-border-radius: 100%;
		border-radius: 100%;
	}
</style>

<!---------------------------------------->

<script type="text/javascript" src="js/syjs.js?<?php echo $time?>"></script>
<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
<script>
	var pic = 0
	var click_xz_sy = 0
	var onmouse_xz_sy = 0
	var hotworks = []

	window.onload = function () {
		var ee = $( "img" ).toArray()
		for ( var i in ee ) {
			let e = ee[ i ].getAttribute( "data-realsrc" )
			ee[ i ].src = e
		}
		var e = $( ".sy_pic" ).toArray()
		$( e[0] ).fadeIn()
	}

	function change( mode ) {
		var ee = $( "img.sy_pic" ).toArray()
		console.log( ee )
		if ( !click_xz_sy ) {
			click_xz_sy=1
			for ( var i in ee ) {
				if ( i == pic ) {
					if ( mode == "left" ) {
						if ( pic != 0 ) {
							console.log( 'a1' )
							pic = pic - 1
							$( ee[ i ] ).fadeOut( 400, function () {
									$( ee[ pic ] ).fadeIn()
									click_xz_sy=0
								} )
							break
						} else {
							console.log( 'a2' )
							pic = ee.length - 1
							$( ee[ i ] ).fadeOut( 400, function () {
									$( ee[ pic ] ).fadeIn()
									click_xz_sy=0
								} )
							break
						}
					} else {
						if ( pic != ee.length - 1 ) {
							console.log( 'b1' )
							pic = pic + 1
							$( ee[ i ] ).fadeOut( 400, function () {
									$( ee[ pic ] ).fadeIn()
									click_xz_sy=0
								} )
							break
						} else {
							console.log( 'b2' )
							pic = 0
							$( ee[ i ] ).fadeOut( 400, function () {
									$( ee[ pic ] ).fadeIn()
									click_xz_sy=0
								} )
							break
						}
					}
				}
				console.log( i )
			}
		}
	}
	
	function rec_title_jq(mode){
		if(!onmouse_xz_sy){
			onmouse_xz_sy=1
			if(mode=="on"){
				$("#rec_title").animate({height:'120px'},400,function(){onmouse_xz_sy=0});
			}else if(mode=="out"){
				$("#rec_title").animate({height:'80px'},250,function(){onmouse_xz_sy=0});
			}
		}
	}

</script>

<!---------------------------------------->

<body>
	<div class="main">
		<?php include "dh.php";?>
		<div class="footer" style="line-height: 4">
			<p>Copyright ©2017-2019 Donald K | www.ae-studio.top All Rights Reserved</p>
		</div>
		<div class="bk_0">
			<div class="recommend">
				<a href="#" id="ac" onClick="" onMouseOver="rec_title_jq('on')" onMouseOut="rec_title_jq('out')">
					<?php			
					while ( $row2 = mysqli_fetch_assoc( $result2 ) ) {
					?>
					<script>
						hotworks.push( {
							id: "<?php echo $row2['id'];?>",
							title: "<?php echo $row2['title'];?>",
						} )
					</script>
					<?php
					echo "<img class='sy_pic' width='550px' height='auto' src='' data-realsrc='../images/xc/" . $row2[ 'pic_url' ] . "' alt=''>";
					};
					?>
					<div id="rec_title" style="width:100%;height:80px;background:rgba(3,3,3,0.4);position:absolute;bottom:0px">
						<p id="rec_title_p" style="font-size:23px;color:rgba(255,255,255,0.35);position:absolute;right:0;bottom:0"></p>
					</div>
				</a>
				<input name="goRight" type="button" class="input_out_r" onmousemove="this.className='input_move_r'" onmouseout="this.className='input_out_r'" onClick="change('right')">
				<input name="goLeft" type="button" class="input_out_l" onmousemove="this.className='input_move_l'" onmouseout="this.className='input_out_l'" onClick="change('left')">
			</div>
			<div class="sign">
				<h2 style="color: aliceblue">公告栏</h2>
				<span>
					居然被你发现了测试页面，那就好好体验下吧！数据与正式页面互通！
				</span>
				<span style="position:absolute;bottom:10px;right:10px;">-5月19日</span>
			</div>
		</div>

		<div class="bk_1">
			<div class="tj">
				<?php while($row=mysqli_fetch_assoc($result)){?>
				<a href="#" onClick="opentj(<?php echo $row['id']?>)">
					<span class="tj2">
						<h3 class="fleft"><?php echo $row["title"]?></h3>
						<p style="font-size:14px; position:absolute; right:40px" class="fright"><?php echo $row["time"]?></p>
						<br/><br/>		
						<p style="font-size:16px">
							<?php 
								if($row["text"]){
									echo strip_tags(strCut($row["text"],33));//strip_html_tags(array('br'),$row["text"])
								}else{
									echo "点击查看文档";
								};
							?>
                        </p>
					</span>  
				</a>
				<?php };?>
			</div>
			<div class="ly">
				<h2 style="color:#FFF">留言板：</h2>
				<form method="post" action="" target="_self">
					<?php 
						session_start();  
						if(!isset($_COOKIE["uid"])){
							echo "<p>未登录,<a href='admin/log.php'>登陆</a>后即可留言</p>";
    						exit();
						}	 else	{
							echo "<p style='position:absolute; top:5px; right:5px'>你好，".$_COOKIE['uid']."</p>";
							echo "<textarea rows='2' cols='30' style='border:solid 1px #000; position:absolute; bottom:5px; left:40px'></textarea>";
							echo "<input type='submit' value='发送' style='width:50px;border:solid 1px #000; position:absolute; bottom:5px; right:5px;-webkit-appearance : none;'>";	 
						}				
					?>
				</form>
			</div>
		</div>
	</div>
</body>
</html>