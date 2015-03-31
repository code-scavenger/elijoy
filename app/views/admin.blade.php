<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>后台管理</title>

    <!-- Bootstrap -->
    <!--php脚本，Author：何衡-->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/admin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
		      <li><a href="/logout">退出</a></li>
		        <li>
		        	<a>
		        		您好，
							<span id="username"><?php echo Auth::user()->name; ?></span>
		        	</a>
		        </li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div>
		</nav><!-- /导航栏 -->

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-body">

		      	<!--php脚本，Author：何衡-->
		      	<form class="form-horizontal" action="/admin/add-project" method="POST" enctype="multipart/form-data" >
		      		<div class="modal_top form-group">
		        		<label for="input_name" class="col-sm-2 control-label">攻略名字</label>
								<div class="col-sm-6">
								  <input class="form-control" id="input_name" name="styname" value="" />
								</div>
			        </div>
			        <div class="modal_center form-group">
			        	<label class="col-sm-2 control-label">顶部图片</label>
			        	<input type="text" name="logo" id="top-image"/>
			        </div>
			        <div class="modal_bottom form-group">
			        	<label class="col-sm-2 control-label">ICON</label>
			        	<input type="text" name="icon" id="icon"/>
			        </div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
			        	<button type="submit" class="btn btn-primary" id="confirm">确定添加</button>
			      	</div>
		      	</form>
		      </div>
		    </div>
		  </div>
		</div>
		<!-- 页面主要内容 -->
		<div class="main container">
			<div class="top clearfix">
				<span class="pull-left">选择需要编辑的攻略</span>
				<button id="add_button" class="btn btn-default pull-right" data-toggle="modal" data-target="#myModal">添加攻略</button>
			</div>
			<div class="bottom">
			<!-- @foreach ($info as $i)
				<div class="strategy col-md-3" style="height: 200px;">
					<a href="#"> <div class="strategy_img" style="height: 80%; width: 80%; margin-left: 10%; margin-right: 10%;"><img src="{{ $i->logo }}" /></div>
					<p class="strategy_name">
						<a href="/editor/{{ $i->id }}">{{ $i->title}}</a>
					</p>
				</div> 
			@endforeach-->
			@foreach ($projects as $p)
				<div class="strategy col-md-3" style="height: 200px;">
					<a href="#"> <div class="strategy_img" style="height: 80%; width: 80%; margin-left: 10%; margin-right: 10%;"><img src="{{ $p->logo }}" /></div>
					<p class="strategy_name">
						<a href="/editor/{{ $p->id }}">{{ $p->title}}</a>
					</p>
				</div>
			@endforeach
				<!--php脚本，Author：何衡-->	
			</div>
		</div><!-- /页面主要内容 -->
		<!--for debuging, Author: 何衡-->
		<!--在不加验证的时候，可以获得这个变量-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!--php脚本，Author：何衡-->
    <script src="../js/bootstrap.min.js"; ?>></script>
    <script src="../js/admin.js"></script> 

  </body>
</html>