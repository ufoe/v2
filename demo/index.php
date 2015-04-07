<?php
	$id = 10;
	$file = "";
	$name = "";
	$html = "";
	$data = "";
	$more = "";
	$theme = "default";
	
	if(isset($_GET['p'])) {
		$id = (int)($_GET['p']);
	}
	if(isset($_GET['theme']))
		$theme = $_GET['theme'];
	
	include "../config.php";
	$link = mysql_connect(constant("DB_HOST"),constant("DB_USER"),constant("DB_PASS"));
	mysql_select_db(constant("DB_NAME"));
	mysql_query("set names utf8");
	$datas = mysql_query("select file,name,html,data,more,extra,extra_info,user_name,user_id,datetime from hc_demo where id = $id and status =0 and type = 0");
	
	if(mysql_num_rows($datas) !=1) {
		Header("location:/404.html");
		exit;
	}else {
		$row = mysql_fetch_row($datas);
		$file = $row[0];
		$name = $row[1];
		if($row[2]!="") 
			$html = $row[2];
		if($row[3]!="")
			$data = $row[3];
		if($row[4]!="")
			$more = $row[4];
	}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>在线演示平台 | Highcharts中文网 </title>
	<meta name="keywords" content="Highcharts,Highcharts中文网,Highcharts api文档,Highcharts教程,Highcharts资源下载" />
	<meta name="description" content="Highcharts中文网，一站式Highcharts学习资源。提供Highcharts中文论坛、Highcharts在线示例、Highcharts中文APi、Highcharts中文教程、Highcharts资源下载等" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" type="text/css" href="<?=constant("STATIC")?>css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=constant("STATIC")?>css/style.css">
</head>
<body>
	<div id="navigater">
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<?php include("../navigater.php")?>
				</div>
			</div>
		</div>
	</div>
	
	<div id="demo">
		<div id="demo_menu">
			<?php include "demo_menu.html"?>
		</div>
		<div id="demo_content">
			<div class="page-header">
				<h1><?php echo $name;?></h1>
				<div class="subtitle">
					
					<?php if($row[5]!=0) {
						echo "<p>由 <a href='http://bbs.hcharts.cn/home.php?mod=space&uid=$row[8]' target='_blank' class='username'>$row[7]</a> 于 ".substr($row[9], 0,10)."提交，<a href='http://bbs.hcharts.cn/forum.php?mod=forumdisplay&fid=45' target='_blank'>去论坛提交你的代码</a> ？</p>";
						if($row[5]==1) {
							echo "<p class=\"tip\">提示：本例需要额外的".(($data == null)? '' : $data.'.js').(($more == null)? '' : $more.'.js')."文件，完整代码查看<a href='/test/index.php?from=demo&p=$id' target='_blank'>在线测试</a></p>";
						}else if($row[5]==2){
							echo "<p class=\"tip\">提示：更多插件信息请查看论坛 <a href='//bbs.hcharts.cn/forum.php?mod=viewthread&tid=$row[6]' target='_blank'>相关帖子</a></p>";
						} else if($row[5]==3) {
							echo "<p class=\"tip\">提示：该例子源自教程，<a href=\"docs/index.php?doc=$row[6]\">点击查看教材</a></p>";
						}
					} else {
						echo "<p class='single'>由 <a href='http://bbs.hcharts.cn/home.php?mod=space&uid=$row[8]' target='_blank' class='username'>$row[7]</a> 于 ".substr($row[9], 0,10)." 提交，<a href='http://bbs.hcharts.cn/forum.php?mod=forumdisplay&fid=45' target='_blank'>去论坛提交你的代码</a> ？</p>";
					}
					?>
					
				</div>
				<div class="clear"></div>
			</div>
			<p>
			图表主题：<button class="btn btn-primary" theme="default">默认</button><button class="btn" theme="grid">网格 (grid)</button><button class="btn" theme="grid-light">grid-light</button><button class="btn" theme="skies">天空 (skies)</button><button class="btn" theme="gray">灰色 (gray)</button><button class="btn" theme="dark-blue">深蓝 (dark-blue)</button><button class="btn" theme="dark-green">深绿 (dark-green)</button><button class="btn" theme="dark-unica">dark-unica</button><button class="btn" theme="sand-signika">sand-signika</button>
			</p>
			<div id="container" style="width: 1000px; height: 400px; margin: 0 auto"></div>
			<?php
				if($html != "") {
					if(file_exists("html/".$html.".html")) {
						include "html/".$html.".html";
					} else {
						echo "<script>window.location.href='/404.html';</script>";
					}
				}
			?>
			<p class="edit">
			<button class="btn btn-success" id="code"><i class="icon-eye-open icon-white"></i>&nbsp;查看源代码</button>
			<?php if($theme != "default") {?>
			<button class="btn btn-success" id="theme_code"><i class="icon-flag icon-white"></i>&nbsp;查看当前主题代码</button>
			<?php }?>
			<button class="btn btn-inverse" id="edit"><i class="icon-edit icon-white"></i>&nbsp;编辑代码</button>		
			</p>
		
			<div id="show_code" style="display:none">
				<h4>Javascript 代码</h4>
				<div class="code_space">
				</div>
			</div>
			<div id="demo_url">
					<p class="line"><span class="title">本例固定链接：</span>
					<input type="text" value="http://www.hcharts.cn/demo/index.php?p=<?php echo $id;?>">
					<span class="title">分享到：</span>
					<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_youdao" data-cmd="youdao" title="分享到有道云笔记"></a></div>
					
			</div>
			<div class="clear"></div>	
			<p style="width:760px;margin:0 auto">
				<center>
			<script type="text/javascript">
			var cpro_id = "u1522405";
			</script>
			<script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
			</center>
			</p>
			</div>
		<div class="clear"></div>
		
		
	</div>
	<?php include("../footer.php")?>
	<script type="text/javascript" src="js/highcharts.js"></script>
	<script type="text/javascript" src="js/exporting.js"></script>
	<?php if($more != "") { ?><script type="text/javascript" src="js/<?php echo $more;?>.js"></script><?php } ?>
	<?php if($data != "") { ?><script type="text/javascript" src="js/<?php echo $data;?>.js"></script><?php } ?>
	<?php if($theme != "default") { ?><script type="text/javascript" src="js/themes/<?php echo $theme;?>.js"></script><?php }?>
	<script type="text/javascript" src="demo/<?=$file;?>.js"></script>
	<script>
		String.prototype.replaceAll = function(s1,s2) { 
    		return this.replace(new RegExp(s1,"gm"),s2); 
		}
		
		$(document).ready(function(){
			
			<?php if($theme != "default") {?>
				$("button.btn-primary").removeClass("btn-primary");
				$("button[theme=<?php echo $theme?>]").addClass("btn-primary");
			<?php }?>
			
			$("#demo_menu li.cur").removeClass("cur");
			$("#demo_menu li[id='<?=$id?>']").addClass("cur");
			
			$("button.btn").click(function(){
					var theme = $(this).attr("theme");
					var id = $(this).attr("id");
				
					if(theme != null) {
						window.location.href="index.php?p=<?php echo $id;?>&theme="+theme;
					}
					else if(id != null) {
						if(id=="code") {
							$(".code_space").load("demo/<?=$file;?>.js",function(){
								$(this).html($(this).html().replaceAll('<','&lt;').replaceAll('>','&gt'));
								$("#show_code").show();
								setTimeout(autoSize,20);
							});
							
						}
						else if(id == "theme_code"){
							$.get("js/themes/<?php echo $theme;?>.js",function(result){
									$("#show_code").show();
									result = result.replaceAll("<","&lt;").replaceAll(">","&gt;");
									$(".code_space").html(result);
									$(".hi").show();
									setTimeout(autoSize,10);
							});
						}
						else if(id == "edit") {
							window.open("/test/index.php?from=demo&p=<?php echo $id;?>");
						}
					}
			});
			$("#demo_url").find("input").bind("click",function(){
					$(this).select();
			});
			
			function autoSize() {
				var contentHeight = $("#demo_content").outerHeight();
				var menuHeight = $("#demo_menu").outerHeight();
				if(menuHeight < contentHeight) {
					$("#demo_menu").height(contentHeight);
				} else {
					if(contentHeight < leftHeight)
						contentHeight = leftHeight;
					$("#demo_menu").height(contentHeight);
				}
			}
		});
		
	</script>
</body>
</html>
