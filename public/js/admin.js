$(document).ready(function() {
	$("#confirm").click(function (target) {
		var flag;
		var name = $("#input_name").val().toString();
		var image = $("#top-image").val().toString();
		var icon = $("#icon").val().toString();

		if (name =="" || image =="" || icon=="") {
			flag = false;
		} else {
			flag = true;
		}
		if (flag) {
			   // 保存编辑
     		$("#confirm").click(function (target) {
		        var data = new FormData();
		        var styname = $("#input_name").val().toString();

		        data.append('styname', styname);

		        jQuery.each($('input[type^="file"]')[0].files, function(i, file) {      
		                data.append('logo', file);
		        });
		        jQuery.each($('input[type^="file"]')[1].files, function(i, file) {
		            	data.append('icon', file);
		        });
		        $.ajax({
		            url: '/elijoy/public/index.php/addstr',
		            cache: false,
		            contentType: false,
		            processData: false,
		            type: 'post',
		            data: data,
		            success: function(data) {
		                location.reload();
		            }
		        });
	    	});

		} else {
			//var tips = "<h>请填写完整信息</h>"
			//$(".modal-footer").after(tips);
			alert("请填写完整信息");
		}
	});
});