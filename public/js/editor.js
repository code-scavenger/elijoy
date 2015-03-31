function check() {
    var tmptitle = $("#new_article_title").val().toString();
    var tmpicon = $("#new_article_icon").val().toString();
    var tmpclassid = $("#new_article_classid").val().toString();

    if (tmptitle =="" || tmpicon =="" || tmpclassid=="")
        return false;
    else
        return true;
}
    

$(document).ready(function() {
    $('#summernote').summernote({
      height: 300,                 // set editor height

      minHeight: null,             // set minimum height of editor
      maxHeight: null,             // set maximum height of editor

      focus: true,                 // set focus to editable area after initializing summernote
    });

    // 编辑文章， 取消编辑
    $(".edit").click(function (target) {
        if ($(this).hasClass("cancle-edit")) {
            var articleIdNow = $("#articleId").attr("value").toString();
        } else {
            var articleIdNow = $(this).attr("value");
        }

        $.ajax({
            url: '/article',
            type: 'post',
            data: {articleid: articleIdNow},
            success: function(data) {
                var data = $.parseJSON(data);
                var articleId = data["id"];
                var articleTitle = data["title"];
                var articleText = data["text"];
                var articleIcon = data['icon'];
                $('#articleIconEditor').val(articleIcon);
                $("#articleTitleEditor").val(articleTitle);
                $(".note-editable").html(articleText);
                $("#articleId").val(articleId);
            }
        });
    });

    // 保存编辑
     $(".save-edit").click(function (target) {
        var data = new FormData();
        var projectid = $("#projectId").attr("value");
        var articleid = $("#articleId").attr("value");
        var newname = $("#articleTitleEditor").val();
        var content = $(".note-editable").html();
        var icon = $("#articleIconEditor").val();
        data.append('projectid', projectid);
        data.append('articleid', articleid);
        data.append('newname', newname);
        data.append('content', content);
        data.append('icon', icon)
        console.log('save edit test')
        console.log(projectid)
        console.log(articleid)
        console.log(newname)
        console.log(content)
        console.log(icon)

        // jQuery.each($('input[name^="icon"]')[0].files, function(i, file) {
        //     if (i == 0 ) {
        //         data.append('icon', file);
        //     }
        // });

        // console.log($('input[name^="icon"]')[0].files);
        $.ajax({
            url: '/save',
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            data: data,
            success: function(data) {
                console.log(data)
                //location.reload();
            }
        });
    });

    // 添加分类
    $(".add-class").click(function (target) {
        var claname = $('#newClass').val();
        var projectid = $("#projectId").attr("value").toString();
        var claintro = $("#newClaintro").val();

        $.ajax({
            url: '/addcla',
            type: 'post',
            data: {projectid: projectid, claname: claname, intro: claintro},
            success: function(data) {
                var data = $.parseJSON(data);
                var classid = data['classid'].toString();
                var classname = data['claname'].toString();
                var addit = '<tr class="class-detail"><td>' + classid + '</td><td>' + classname + '</td><td><button type="button" class="btn btn-default btn-xs edit" value="'+classid+'">编辑</button><button type="button" class="btn btn-default btn-xs delete" value="'+classid+'">删除</button></td></tr>';
                $(".class-detail").eq(0).before(addit);
                $("#newClass").val("");
                $("#newClaintro").val("");
            }
        });
    });

    //切换输入的方框和展示的div
    $(".class-edit").click(function (target) {
        var td = $(this).parent().parent().children().eq(1);
        var div = $(td).children().eq(0);
        var input = $(td).children().eq(1);
        $(div).css("display", "none");
        $(input).attr("type", "text");
    })

    //失去焦距的时候，更新信息
    // $(".edit-class-title").blur(function () {
    //     var div = $(this).prev();

    //     var projectid = $("#projectId").attr("value").toString();
    //     var newname = $(this).val().toString();
    //     var classid = $(this).parent().parent().children().eq(0).text().toString();
    //     $(div).text(newname);
    //     $(div).css("display", "block");
    //     $(this).attr("type", "hidden");
    //     $.ajax({
    //         url: '/elijoy/public/index.php/renamecla',
    //         type: 'post',
    //         data: {projectid: projectid, classid: classid, newname: newname},
    //         success: function(data) {

    //         }
    //     });
    // });

    //删除指定类的信息
    $(".class-delete").click(function (target) {
        var classid = $(this).val();
        var projectid = $("#projectId").attr("value").toString();
        var tr = $(this).parent().parent();
        $.ajax({
            url: '/delcla',
            type: 'post',
            data: {projectid: projectid, classid: classid},
            success: function(data) {
                $(tr).remove();
            }
        });
    });

    // 删除文章
    $(".delete").click(function (target){
        var articleid = $(this).val();
        //alert(articleid);
        //确定删除[]
        $(".queding-delete").click(function (target) {
            $.ajax({
            url: '/elijoy/public/index.php/remove',
            type: 'post',
            data: {articleid: articleid},
            success: function(data) {
                location.reload();
            }
        });
        });
    });

    // 返回刷新页面
    $("#return").click(function (target) {
        location.reload();
    });
});
