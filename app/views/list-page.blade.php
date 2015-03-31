<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>list-page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta name="description" content="{{ $class[0]->title }}" />
  <meta name="keywords" content="{{ $class[0]->title }}" />
  <link rel="stylesheet" href="../css/base.css" />
  <link rel="stylesheet" href="../css/list-page.css" />
</head>
<body>
<div class="wraper">
  <div class="head">
    <a class="back" href="/list-class/{{ $class[0]->pro_id }}" > < </a>
    <strong>
        最新文章
    </strong>

    <h1>{{ $class[0]->title }}</h1>
  </div>
  <div class="content">
    <div class="list">
    @foreach ($articles as $key => $value)
      <a class="list-cell clearfix" href="/article-page/{{ $value->id }}" >
        <div class="detail">
          <strong>{{ $value->title }}</strong>
          <p><!-- {{ $value->text }} --></p>
        </div>
        <div class="icon">
          <img src="{{ $value->icon }}" alt="">
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