<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>后台管理编辑页面</title>

  <!--  改动 -->
  <link rel="stylesheet" href="../css/editor.css" >
  <script src="../js/jquery-2.1.1.min.js" ></script> 
  <link rel="stylesheet" href="../css/bootstrap.min.css" > 
  <script src="../js/bootstrap.min.js" ></script> 
  <link href="../css/font-awesome.css" rel="stylesheet">
  <link href="../css/summernote.css" rel="stylesheet">
  <script src="../js/summernote.js" ></script>
  <script type="text/javascript" src="../js/editor.js" ></script>
</head>
<body>
  <!-- 导航栏 -->
  <nav class="navbar navbar-inverse">
      <div class="container">
          <div class="navbar-header">
              <a href="#" class="navbar-brand">{{ $projects[0]->title }} </a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                  <li class="active">
                      <a href="#">攻略管理后台</a>
                  </li>
                  <li class="">
                      <a href="#数据统计">数据统计</a>
                  </li>
                  <li class="">
                      <a href='/admin' >返回</a>
                  </li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                  <li>
                      <a href='/logout' ?> >退出</a>
                  </li>
                  <li>
                      <a href="#">您好， <span id="username"><?php echo Auth::user()->name ?> </span></a>
                  </li>   
              </ul>
          </div>
      </div>
  </nav>

  <div id="editor-top-part" >
    <ul id="my-Tab" class="nav nav-tabs">
      <!-- 
          标签栏 
          每个标签中的 <a> 中的 href 与标签内容中的 id 相同
      -->
      @foreach ($classes as $key => $class)
        @if ($key == 0)
          <li class="active tab-part"><a href="#{{ $class->id }}" data-toggle="tab">{{ $class->title }}</a></li>
        @else
          <li class="tab-part"><a href="#{{ $class->id }}" data-toggle="tab">{{ $class->title }}</a></li>
        @endif
      @endforeach
      

      <div class="tab-button">
          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#edit-gonglue">修改攻略</button>
          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#edit-fenlei">编辑分类</button>
          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#tianjia-wenzhang">添加文章</button>
      </div>
    </ul>
  </div>

  <div id="editor-left-part">
      <!-- 每个标签栏的内容 -->
    <div id="my-Tab-Content" class="tab-content">
    @foreach ($classes as $outerkey => $class) 
      @if ($outerkey ==0)
        <div class="panel panel-default tab-pane active in fade" id="{{ $class->id }}">
      @else 
        <div class="panel panel-default tab-pane  fade" id="{{ $class->id }}">
      @endif
        <table class="table">
          <tr>
            <th>ID</th><th>文章题目</th><th>操作</th>
          </tr>
          @foreach ($articles[$outerkey] as $innerkey => $article)
            <tr>
              <td>{{ $article->id }}</td>
              <td>{{ $article->title }}</td>
              <td>
                <button type="button" class="btn btn-default btn-xs edit" value="{{ $article->id }}">编辑</button>
                <button type="button" class="btn btn-default btn-xs delete" value="{{ $article->id }}"data-toggle="modal" data-target="#delete-article">删除</button>
              </td>
            </tr>
          @endforeach
        </table>
        </div>
     @endforeach

      </div>
  </div>

  <!--编辑器-->
  <div id="editor-right-part">
      <div id="upload-icon">
          <form action="url" method="post" enctype="multipart/form-data">
          <div class="form-group left-part">
              <lable>标题</lable>
              <input type="text" name="newname" id="articleTitleEditor" class="form-control" value="">
          </div>
          <div class="form-group right-part">
              <lable>文章ICON</lable>
              <input type="text" name="icon" id="articleIconEditor" multiple>
          </div>
          <div class="btn-group">
            <select name="classid" id="new_article_classid" >
            @foreach ($classes as $key => $value)
              @if ($key == 0)
                <option value="{{ $value->id }}" selected >{{ $value->title }}</option>
              @else
                <option value="{{ $value->id }}">{{ $value->title }}</option>
              @endif
            @endforeach
               
            </select>
          </div>
          </form>
      </div>
      <div>
          <div id="summernote"></div>
      </div>
      <div>
          <button type="button" class="btn btn-default save-edit">保存添加</button>
          <button type="button" class="btn btn-default cancle-edit edit">取消</button>
      </div>
  </div>

  <input type="hidden" id="projectId" value="{{ $projects[0]->id }}" >
  <input type="hidden" id="articleId" >

  <!-- Modal 修改攻略-->
  <div class="modal fade" id="edit-gonglue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModeLabel">修改攻略</h4>
          </div>
      <div class="modal-body">
          <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="/update" >

              <div class="modal-top form-group">
                  <label for="input_name" class="col-sm-2 control-label">攻略名字</label>
                      <div class="col-sm-6">
                          <input class="form-control" name="newname" />
                      </div>
              </div>

              <div class="modal-center form-group">
                  <label class="col-sm-2 control-label">顶部图片</label>
                  <input type="text" name="logo" style="width: 200px"/>
              </div>

              <div class="modal-bottom form-group">
                  <label class="col-sm-2 control-label">ICON</label>
                  <input type="text" name="icon" style="width: 200px"/>
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
                  <button type="submit" class="btn btn-primary">确定添加</button>
              </div>
              <input type="hidden" name="projectid" value="{{ $projects[0]->id }}" >
          </form>
              </div>
          </div>
      </div>
  </div>

  <!-- Modal 编辑分类-->
  <div class="modal fade" id="edit-fenlei" tabindex="-1" role="dialog" aria-labelledby="fenlei" aria-hidden="true" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="fenlei">编辑分类</h4>
        </div>
        <div class="modal-body">
          <div class="form-horizontal" method="POST" enctype="multipart/form-data" action="/update" >

            <div class="modal-top form-group">
              <label for="input_name" class="col-sm-2 control-label">分类标题</label>
              <div class="col-sm-6">
                  <input type="text" class="form-control" id="newClass" value="">
              </div>
            </div>
            <div class="modal-top form-group">
              <label for="input_name" class="col-sm-2 control-label">分类简介</label>
              <div class="col-sm-6">
                  <input type="text" class="form-control" id="newClaintro" value="">
              </div>
              <button type="button" class="btn btn-default add-class">添加分类</button>
            </div>
            <div  class="tab-content">
              <div class="panel panel-default tab-pane active in fade">
                <table class="table">
                  <tr>
                    <th>标题</th>
                    <th>分类简介</th>
                    <th>操作</th>
                  </tr>
                  @foreach ($classes as $outerkey => $class)
                    <tr class="class-detail">
                      <!-- <td>{{ $class->id }}</td> -->
                      <td>
                        <div style="display:block">
                          <input id="class-title-{{ $class->id }}"type="text" value="{{ $class->title }}"class="edit-class-title">   
                        </div>
                      </td>
                      <td>
                        <div style="display:block">
                          <input id="class-intro-{{ $class->id }}" type="text" value="{{ $class->intro }}"class="edit-class-intro">

                        </div>
                      </td>
                     <td>
                        <button class="btn-save" id="btn-save-{{ $class->id }}" type="button" class="btn btn-default btn-xs class-edit" value="{{ $class->id }}">保存</button>
                        <button type="button" class="btn btn-default btn-xs class-delete" value="{{ $class->id }}">删除</button>
                     </td>
                   </tr>
                  @endforeach
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" id="return">返回</button>
            </div>
            <input type="hidden" name="projectid" value="{{ $projects[0]->id }}" >
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  function test() {
      return true;
  }
  </script>
  <!-- Modal 添加文章-->
  <div class="modal fade" id="tianjia-wenzhang" tabindex="-1" role="dialog" aria-labelledby="add-wenzhang" aria-hidden="true" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="add-wenzhang">添加文章</h4>
        </div>
        <div class="modal-body">
           <form class="form-horizontal" action="/new" method="POST" enctype="multipart/form-data" >
              <div class="modal-top form-group">
                <label for="input_name" class="col-sm-2 control-label">文章标题</label>
                  <div class="col-sm-6">
                    <input class="form-control" name="title" value="" id="new_article_title"/>
                  </div>
              </div>
              <div class="modal-center form-group">
                <label class="col-sm-2 control-label">文章ICON</label>
                <input type="text" name="icon" id="new_article_icon" />
              </div>
              <!-- Single button -->
              <div class="modal-bottom form-group">
                <label class="col-sm-2 control-label">所属分类</label>
                <div class="btn-group">
                  <select name="classid" id="new_article_classid" >
                  @foreach ($classes as $key => $value)
                    @if ($key == 0)
                      <option value="{{ $value->id }}" selected >{{ $value->title }}</option>
                    @else
                      <option value="{{ $value->id }}">{{ $value->title }}</option>
                    @endif
                  @endforeach
                     
                  </select>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
                <input type="submit" class="btn btn-primary queding-tianjia" onclick="return check()" value="确定添加"/>
              </div>
              <input type="hidden" name="projectid" value="{{ $projects[0]->id }}" >
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal   删除文章-->
  <div class="modal fade" id="delete-article" tabindex="-1" role="dialog" aria-hidden="true" >
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">确定删除文章吗？</h4>
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
                  <button type="submit" class="btn btn-primary queding-delete">确定删除</button>
              </div>
              <input type="hidden" name="projectid" value="{{ $projects[0]->id }}" >
          </div>
      </div>
  </div>

  <!--隐藏的数据区域-->
  <input type="hidden" id="static_project_id" value="{{ $projects[0]->id }}" >
</body>
<script type="text/javascript">
  $('.btn-save').click(function(){
    var btnId = $(this).attr('id');
    var id = btnId.substr(9).toString();
    var titleId = "class-title-" + id;
    var introId = "class-intro-" + id;
    var valueTitle = $("#"+titleId).val();
    console.log(valueTitle);
    var valueIntro = $("#"+introId).val()
    console.log(valueIntro);
    $.ajax({
        url: '/renamecla',
        type: 'post',
        data: {
          classid: id, 
          title: valueTitle,
          intro: valueIntro
        },
        success: function(data) {
          console.log(data);
        }
    }); 

  })


</script>
</html>