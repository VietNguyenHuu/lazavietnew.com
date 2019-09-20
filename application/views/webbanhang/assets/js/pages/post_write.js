function f_post_write()
{
    this.update_avata = "";

    this.add_reset = function () {
        $("input[name='post_add_title']").val("");
        $("#post_add_type").html("Chọn danh mục");
        $("#post_add_nd").html("Nội dung bài viết");

    };
    this.add = function () {
        var title = $("input[name='post_add_title']").val();
        if (title == "" || title == undefined || title == " ") {
            tooltip("<span class='mistake'>Hãy nhập tiêu đề</span>", 2000);
            return false;
        }
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'post_write_add',
                title: title,
            },
            success: function (result) {
                dialog("Thêm bài viết", result);
                post_write.add_reset();
            },
            error: function () {
                alert("Không thêm được bài viết!");
            }
        });
    };
    this.load_info = function (id) {
        dialog("Thông tin bài viết", "<div id='post_write_moreinfo'></div>");
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'post_write_load_info',
                id: id
            },
            success: function (result) {
                $("#post_write_moreinfo").html(result);
            },
            error: function () {
                alert("Không tải được thông tin bài viết!");
            }
        });
    };
    this.load_form_update = function (id) {
        dialog("Chỉnh sửa bài viết", "<div id='post_write_edit'></div>");
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'post_write_load_formedit',
                id: id
            },
            success: function (result) {
                $("#post_write_edit").html(result);
                CKEDITOR.replace('post_update_nd', {});
            },
            error: function () {
                alert("Không tải được bài viết!");
            }
        });
    };
    this.update_setavata = function (f) {
        var reader = new FileReader();
        reader.onload = function (e) {
            post_write.update_avata = e.target.result;
            $("img[name='post_update_avata']").attr('src', e.target.result);
        };
        reader.readAsDataURL(f.files[0]);
    };
    this.update_load_type = function ()
    {
        $("#post_update_type_choose").removeClass('hide');
        $("#post_update_type_choose").html('Đang tải danh mục bài viết, xin chờ...');
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'post_write_update_load_type',
                id_type: $("#post_update_type").attr('data-id')
            },
            success: function (result) {
                $("#post_update_type_choose").html(result);

            },
            error: function () {
                alert("Không tải được chuyên mục bài viết!");
            }
        });
    };
    this.update_select_type = function (selector) {
        var selector = $(selector);
        $("#post_update_type").html("Mục: " + selector.attr('data-title'));
        $("#post_update_type").attr('data-id', selector.attr('data-id'));
        $("#post_update_type_choose").addClass('hide');
    };
    this.update = function (id) {
        var title = $("input[name='post_update_title']").val();
        if (title == "" || title == undefined || title == " ") {
            tooltip("<span class='mistake'>Hãy nhập tiêu đề</span>", 2000);
            return false;
        }
        var c = CKEDITOR.instances.post_update_nd.getData();
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'post_write_update',
                id: id,
                id_type: $("#post_update_type").attr('data-id'),
                title: title,
                content: c,
                avata: this.update_avata,
                refreshurl: $(location).attr('href')
            },
            success: function (result) {
                dialog("Chỉnh sửa bài viết", result);
                post_write.update_avata = "";
            },
            error: function () {
                alert("Không chỉnh sửa được bài viết!");
            }
        });
    };
    this.del = function (id) {
        dialog("Bạn chắc chắn muốn xóa bài viết này ?", "<div class='align_center padding' style='margin:2em 0px;'><span class='button padding' onclick='post_write.real_del(" + id + ")'>Đồng ý xóa</span><span class='button padding red' onclick='uncaption()'>Không đồng ý</span>");
    };
    this.real_del = function (id) {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'post_write_del',
                del_id: id
            },
            success: function (result) {
                dialog("Thông báo xóa bài viết", result);
            },
            error: function () {
                alert("Không xóa được bài viết !");
            }
        });
    };
}
var post_write = "";
$(window).ready(function () {
    post_write = new f_post_write();
    var gets = get_method();
    if (gets.action !== undefined && gets.id !== undefined){
        if (gets.action === 'edit' && gets.id !== ''){
            post_write.load_form_update(gets.id);
        }
    }
});
