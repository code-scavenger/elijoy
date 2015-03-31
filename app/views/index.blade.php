<!DOCTYPE html>
<html>
<!--前端页面1-->
<head lang="en">
  <meta charset="UTF-8">
  <title>{{ $project->title }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta name="description" content="{{ $project->title }}" />
  <meta name="keywords" content="{{ $project->title }}"/>
  <link rel="stylesheet" href="../css/base.css" />
  <link rel="stylesheet" href="../css/index.css" />
</head>
<body>
<div class="wraper">
  <div class="head">
    <img class="logo" src="{{ $project->logo }}" alt=""/>
    <h1>{{ $project->title }}</h1>
  </div>
  <div class="content">
    <div class="list">
    @foreach ($classes as $key => $entry)
    <a class="list-cell clearfix" href="/list-article/{{ $entry->id }}">
      <div class="icon">
        <img src="{{ $project->icon }}" img="">
      </div>
      <div class="detail">
        <strong>{{ $entry->title }}</strong>
        <p>{{ $entry->intro }}</p>
      </div>
      <div class="go">
        <img src="../images/forward.png" alt="">
      </div>
    </a>
    @endforeach
    </div>
  </div>
  <div class="footer">
        <div class="footerWrap">
            <a href="../list-class/29894901273001427375214">
                <img src="../images/shouye.png" alt=""/>
                <span>首页</span>
            </a>
            <a href="../list-article/12138909628001427375214">
                <img src="../images/zuixinwenzhang.png" alt=""/>
                <span>最新文章</span>
            </a>
            <a href="/user-award">
                <img src="../images/mianfeilipin.png" alt=""/>
                <span>免费礼包</span>
            </a>
            <a href="/user-login">
                <img src="../images/denglu.png" alt=""/>
                <span>登陆</span>
            </a>
        </div>
    </div>
</div>
</body>
</html>