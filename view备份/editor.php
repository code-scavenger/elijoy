<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>后台管理编辑页面</title>

    <!-- Bootstrap -->
    <!--php脚本，Author：何衡-->
    <link href=<?php echo $dir."/../../public/css/bootstrap.min.css"; ?> rel="stylesheet">
    <link href=<?php echo $dir."/../../public/css/admin.css"; ?> rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!--编辑器链接文件，被注释掉的链接文件-->
  	<script src="http://cdn.gbtags.com/jquery/1.11.1/jquery.min.js"></script>
   	<script src="http://cdn.gbtags.com/twitter-bootstrap/3.2.0/js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href='http://cdn.gbtags.com/twitter-bootstrap/3.2.0/css/bootstrap.css'/>

	<!--保留的注释文件-->
	<script src="http://cdn.gbtags.com/summernote/0.5.2/summernote.min.js"></script>
	<link rel="stylesheet" type="text/css" href='http://cdn.gbtags.com/font-awesome/4.1.0/css/font-awesome.min.css'/>
	<link rel="stylesheet" type="text/css" href='http://cdn.gbtags.com/summernote/0.5.2/summernote.css'/>

  </head>
  <body>

  	<!-- 导航栏 -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container-fluid">
		  	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li class="active"><a href="#">攻略管理后台</a></li>
		        <li><a href="#">数据统计</a></li>
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		        <li><a href="#">退出</a></li>
		        <li>
		        	<a>
		        		您好，
								<span id="username">xxx</span>
		        	</a>
		        </li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div>
		</nav><!-- /导航栏 -->

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-body">
		      	<form class="form-horizontal">
		      		<div class="modal_top form-group">
		        		<label for="input_name" class="col-sm-2 control-label">攻略名字</label>
								<div class="col-sm-6">
								  <input class="form-control" id="input_name">
								</div>
			        </div>
			        <div class="modal_center form-group">
			        	<label class="col-sm-2 control-label">顶部图片</label>
			        	<input type="file" />
			        </div>
			        <div class="modal_bottom form-group">
			        	<label class="col-sm-2 control-label">ICON</label>
			        	<input type="file" />
			        </div>
		      	</form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
		        <button type="button" class="btn btn-primary">确定添加</button>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- 页面主要内容 -->
		<div class="main container">
			<div class="top clearfix">
				<button id="edit_class" class="btn btn-default pull-right" data-toggle="modal" data-target="#myModal1">编辑分类</button>
				<button id="edit_strategy" class="btn btn-default pull-right" data-toggle="modal" data-target="#myModal2">编辑攻略</button>
			</div>
			<div class="edit_content" role="tabpanel">
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			  
			   	<?php
			   		/**
			   		 * ---------------------------------------------------------
			   		 * 找出需要放在第一位的页眉，顺序放置页眉
			   		 * bug: 
			   		 * 		1、aid 太长了，导致排版好像出了一点问题！
			   		 * 		2、js事件，鼠标选定指定的文章，右边自动加载出内容
			   		 * ---------------------------------------------------------
			   		 */
			   		$projectname = null;
			   		for ($i = 0; $i < count($projects); $i++)
			   			if ($projects[$i]->id == $header) {
			   				$projectname = $projects[$i]->title;
			   				array_splice($projects, $i, 1);
			   				break;
			   			}

			   		echo "<li role=\"presentation\" class=\"active\">
			  				<a href=\"".$dir."/editor/".$header."\" aria-controls=\"tab1\" role=\"tab\" data-toggle=\"tab\">".$projectname."</a>
			    		 </li>";
			    	foreach ($projects as $entry) {
			    		echo "<li role=\"presentation\" class=\"active\"><a href=\""
			    		.$dir."/editor/"
			    		.$entry->id."\" aria-controls=\"tab1\" role=\"tab\" data-toggle=\"tab\">"
			    		.$entry->title."</a></li>";
			    	};
			   	?>
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="tab1">
			    	<div class="left col-sm-4">
			    		<div class="stragety_info">
			    			<span>ID</span>
			    			<span>文章题目</span>
			    			<span>操作</span>
			    		</div>

			    		<?php

				    		/**
				    		 * ---------------------------------------------------------------
				    		 * 1.这里需要为删除做一个链接，同时有一个js的监听，提示用户确认删除
				    		 * 2.这里需要为点击一个ariticle时自动填充内容的监听
				    		 * ---------------------------------------------------------------
				    		 */
				    		foreach ($info as $entry) {
					    		echo "<div class=\"stragety_item\">
					    			<span class=\"strategy_number\">".$entry->id."</span>
					    			<span class=\"strategy_name\">".$entry->title."</span>
					    			<button class=\"edit_item btn btn-default btn-sm\">编辑</button>
					    			<button class=\"delete_item btn btn-default btn-sm\">删除</button>
					    		</div>";
				    		}

			    		?>
			    	</div>
			    	<div class="right col-sm-8">

			    	</div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab2">2</div>
			    <div role="tabpanel" class="tab-pane" id="tab3">3</div>
			    <div role="tabpanel" class="tab-pane" id="tab4">4</div>
			    <div role="tabpanel" class="tab-pane" id="tab5">5</div>
			  </div>
			</div>
		</div><!-- /页面主要内容 -->

		<!-- just for debugging -->
		<!--<p>---------------测试获取article内容的接口/article----------------------</p>-->
		<!-- <form action=<?php echo $dir."/article" ?> method="POST" enctype="multipart/form-data">
			文章id：<input type="text" name="articleid" /><br />
			<input type="submit" name="submit" />
		</form> -->

		<!-- <p>-----------------------测试保存文章的接口/save------------------------</p> -->
		<!-- <form action=<?php echo $dir."/save" ?> method="POST" enctype="multipart/form-data">
			文章id：<input type="text" name="articleid" /><br />
			选择新的icon:<input type="file" name="icon" /><br />
			文章新名字；<input type="text" name="newname" /><br />
			文章新内容：<input type="text" name="content" /><br />
			<input type="submit" name="submit" />
		</form> -->

	<!--文本编辑器插件-->
	<div class="container-fluid">
		<div class="row">
			<div class="jumbotron">
				<h1>Hello World</h1>
				<!-- html代码，Author: 何衡-->
				策略名字：<input type="text" name="newname" id="articlename"/><br />
			</div>

			<!-- 定义一个div容器 -->
			<div id="editor">
			  
			</div>
			<div><button id="submit">提交</button></div>
			<script type="text/javascript">
			$('#editor').summernote({
				height: 200,                 // set editor height
  				minHeight: null,             // set minimum height of editor
  				maxHeight: null,             // set maximum height of editor
  				focus: false,                // set focus to editable area after initializing summernote

  				//可以重写图片上传句柄
  				/*onImageUpload: function(files, editor, $editable) {
    				console.log('image upload:', files, editor, $editable);
  				}*/
  			}) ;
			</script>
			<script type="text/javascript">
			$('#submit').click(function() {
				// body...
				
				var updatedcontent = $('#editor').code(); //调用code方法获取编辑器内容
				$(".show").html(updatedcontent);
				alert(updatedcontent);

				/********jquery 代码， Author：何衡*******/
				//获取图文章新的名字，把上传图片单独作为一个接口吧，目前这个接口js没有成功运行
				var articlename = $('#articlename').val();
				alert(articlename);
				/*********ajax请求  Author：何衡*********/
				/*($.ajax({
   					type: "POST",
					url: "http://localhost/elijoy/public/index.php/save",
					data: "content=" + updatedcontent +
						  "&articleid=" + "这个变量暂时不知道怎么获取" +
						  "$newname=" + articlename,
					dataType:'json',
					success: function(msg){
						alert( "Data Saved: " + msg );
					}
				});*/

			})
			</script>

			<div class="show"></div>
		</div>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!--php脚本，Author：何衡-->
    <script src=<?php echo $dir."/../../public/js/bootstrap.min.js"; ?>></script> 
  </body>
</html>