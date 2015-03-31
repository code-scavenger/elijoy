<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>article-page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="{{ $article[0]->title }}" />
    <meta name="keywords" content="{{ $article[0]->title }}" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/base.css" />
    <link rel="stylesheet" href="../css/article-page.css" />
</head>
<body>
<div class="wraper">
    <div class="head">
        <a class="back" href=<?php echo'/list-article/'.$article[0]->cla_id; ?> ><</a>

        <h1><?php echo $article[0]->title; ?></h1>
    </div>
    <div class="content">
        <div class="article">
            <p class="title"><?php echo $article[0]->title; ?></p>

            <p class="date">发布日期：<?php echo $article[0]->date; ?></p>

            <p class="writer">作者：大小姐写攻略</p>

            </br>

            <p><?php echo $article[0]->text; ?></p>
        </div>
    </div>
</div>
</body>
</html>