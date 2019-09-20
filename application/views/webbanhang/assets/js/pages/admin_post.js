function f_admin_post_type()
{
    selt = this;
    this.selector_status = $("#admin_post_type_status");
    this.selector_list = $("#admin_post_type_list");
    this.selecting_id = 1;
    this.loadlist = function (id_parent)
    {
        this.selecting_id = id_parent;
        selt = this;
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_post_gettype',
                id_parent: id_parent
            },
            beforeSend: function () {
                tooltip("<i class='fa fa-refresh fa-spin'></i> Đang tải danh mục...", -1);
                selt.selector_list.html("<i class='fa fa-refresh fa-spin'></i> Đang tải danh mục...");
            },
            success: function (result) {
                off_tooltip(-1);
                selt.selector_list.html(result);
            },
            error: function () {
                off_tooltip(-1);
                alert("không tải được danh mục !");
            }
        });
    };
    this.load_form_add = function ()
    {
        dialog("Thêm danh mục", "<div class='padding' id='admin_post_formaddtype'><img src='assets/img/system/loading2.gif' style='height:1em;margin-right:3px' alt='wait'>Đang tải dữ liệu...</div>");
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_post_loadformaddtype'
            },
            success: function (result) {
                $("#admin_post_formaddtype").html(result);
            },
            error: function () {
                alert("Không  tải được dữ liệu !");
            }
        });
    };
    this.add = function ()
    {
        var title = $("#admin_post_add_type_title").val();
        if (title == "")
        {
            dialog("Thông báo thêm danh mục", 'Hãy nhập vào tên danh mục');
            return false;
        }
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_post_addtype',
                id_parent: admin_post_type.selecting_id,
                title: title
            },
            success: function (result) {
                admin_post_type.loadlist(admin_post_type.selecting_id);
                tooltip(result, 2000);
            },
            error: function () {
                alert("tác vụ không hoàn thành !");
            }
        });
    };
    this.loadformedit = function (id_type)
    {
        dialog("Chỉnh sửa danh mục", "<div class='padding' id='admin_post_formedittype'><img src='assets/img/system/loading2.gif' style='height:1em;margin-right:3px' alt='wait'>Đang tải dữ liệu...</div>");
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_post_loadformedittype',
                edit_id: id_type
            },
            success: function (result) {
                $("#admin_post_formedittype").html(result);
            },
            error: function () {
                alert("Không  tải được dữ liệu !");
            }
        });
    };
    this.edit = function (id_type)
    {
        var ten_dm = $("#admin_post_edit_type_title").val();
        var index_dm = $("#admin_post_edit_type_index").val();
        var dm_seo_title = $("#admin_post_edit_type_seo_title").val();
        var dm_seo_keyword = $("#admin_post_edit_type_seo_keyword").val();
        var dm_seo_description = $("#admin_post_edit_type_seo_description").val();
        dialog("Thông báo sửa danh mục", "<div class='padding' id='admin_post_alert_type'><img src='assets/img/system/loading2.gif' style='height:1em;margin-right:3px' alt='wait'>Đang cập nhật dữ liệu...</div>");
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_post_edittype',
                edit_id: id_type,
                edit_title: ten_dm,
                edit_index: index_dm,
                edit_seo_title: dm_seo_title,
                edit_seo_keyword: dm_seo_keyword,
                edit_seo_description: dm_seo_description
            },
            success: function (result) {
                $("#admin_post_alert_type").html(result);
            },
            error: function () {
                dialog("Thông báo sửa danh mục", "Không  sửa được danh mục !");
            }
        });
    };
    this.del = function (id)
    {
        dialog("Bạn chắc chắn muốn xóa danh mục này ?", "<div class='align_center padding' style='margin:2em 0px;'><span class='button padding' onclick='admin_post_type.real_del(" + id + ")'>Đồng ý xóa</span><span class='button padding red' onclick='uncaption()'>Không đồng ý</span>");
    };
    this.real_del = function (id)
    {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_post_deltype',
                del_id: id
            },
            success: function (result) {
                admin_post_type.loadlist(admin_post_type.selecting_id);
                alert(result);
            },
            error: function () {
                alert("không xóa được danh mục !");
            }
        });
    };
    this.movies = function (idtype, num)//num=1 để chuyển ra sau, -1 chuyển về trước
    {
        selt = this;
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_post_type_movies',
                id: idtype,
                num: num
            },
            beforeSend: function () {
                tooltip("<i class='fa fa-refresh fa-spin'></i> Đang di chuyển danh mục...", -1);
            },
            success: function (result) {
                off_tooltip(-1);
                tooltip(result, 3000);
                setTimeout("selt.loadlist(selt.selecting_id)", 3000);
            },
            error: function () {
                off_tooltip(-1);
                tooltip("<span class='stt_mistake'>Sự cố mạng, <br>không thể di chuyển mục này, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    };
    this.load_form_change_parent = function ()
    {
        selt = this;
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_post/type_load_form_change_parent',
                id: this.selecting_id
            },
            beforeSend: function () {
                dialog("Thay đổi mục gốc danh mục", "<div id='admin_post_type_form_change_parent'></div>");
            },
            success: function (result) {
                $("#admin_post_type_form_change_parent").html(result);
            },
            error: function () {
                $("#admin_post_type_form_change_parent").html("<span class='stt_mistake'>Sự cố mạng, <br>không thể thay đổi mục gốc tại lúc này, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    };
    this.change_parent = function (id_type, id_parent)
    {
        selt = this;
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_post/type_change_parent',
                id_type: id_type,
                id_parent: id_parent
            },
            beforeSend: function () {
                dialog("Thay đổi mục gốc danh mục", "<div id='admin_post_type_change_parent'></div>");
            },
            success: function (result) {
                $("#admin_post_type_change_parent").html(result);
            },
            error: function () {
                $("#admin_post_type_change_parent").html("<span class='stt_mistake'>Sự cố mạng, <br>không thể thay đổi mục gốc tại lúc này, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    };
}

function f_admin_post_content()
{
    this.update_setavata = "";
    this.selector_list = $("#admin_post_content_list");
    this.loadlist = function (page)
    {
        selt = this;
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post_getcontent',
                                id_type: admin_post_type.selecting_id,
                                content_ischeck: $("#admin_post_content_ischeck").val(),
                                content_search: $('#admin_post_content_search_input').val(),
                                page: page
                            },
                    success: function (result)
                    {
                        selt.selector_list.html(result);
                        $("div.admin_content_item").css({'border': '1px solid #aaaaff', 'backgroundColor': '#ffffff', 'border-radius': '5px', 'padding': '5px', 'height': '200px', 'overflow': 'hidden'});
                        $("div.admin_content_item div.admin_content_item_avata>img").css({'width': '100%', 'height': '150px'});
                        $("div.admin_content_item>div.admin_content_item_title").css({'width': '100%', 'height': '50px'});
                    },
                    error: function ()
                    {
                        alert("Không tải được bài viết !");
                    }
                });
    }
    this.loadinfo = function (id)
    {
        dialog("Thông tin bài viết", "<div id='post_write_moreinfo'></div>");
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post_content_load_info',
                                id: id
                            },
                    success: function (result)
                    {
                        $("#post_write_moreinfo").html(result);
                    },
                    error: function ()
                    {
                        alert("Không tải được thông tin bài viết!");
                    }
                });
    }
    this.load_supinfo = function (id, page)
    {
        if (page == false || page < 1 || page == null)
        {
            page = 1;
        }
        if (page > 4)//tìm trong 4 trang đầu
        {
            return false;
        }
        if (page > 1)
        {
            $(".admin_post_content_supinfo .realcontent").append("<div class='admin_post_content_supinfo_wait'><i class='fa fa-spinner fa-spin'></i> Đang tải thông tin, xin chờ</div>");
        } else
        {
            $(".admin_post_content_supinfo .realcontent").html("<div class='admin_post_content_supinfo_wait'><i class='fa fa-spinner fa-spin'></i> Đang tải thông tin, xin chờ</div>");
        }
        var kw = $("#admin_post_content_supinfo_wordinput").val();
        alert(kw);
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/content_load_supinfo',
                                id: id,
                                page: page,
                                keyword: kw
                            },
                    success: function (result)
                    {
                        $(".admin_post_content_supinfo .realcontent").find(".admin_post_content_supinfo_wait").remove();
                        $(".admin_post_content_supinfo .realcontent").append(result);
                        setTimeout("admin_post_content.load_supinfo(" + id + "," + (page + 1) + ")", 5000);
                    },
                    error: function ()
                    {
                        alert("Không tải được thông tin nâng cao cho bài viết!");
                    }
                });
    }
    this.loadformedit = function (id_content)
    {
        dialog("Chỉnh sửa bài viết", "<div id='admin_post_content_update'><img src='assets/img/system/loading2.gif' style='height:1em;vertical-align:middle;margin-right:0.5em'>Đang tải dữ liệu</div>");
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post_loadeditformcontent',
                                id: id_content
                            },
                    success: function (result)
                    {
                        $("#admin_post_content_update").html(result);
                        
                        CKEDITOR.replace('admin_post_content_update_nd',{});
                        
                    },
                    error: function ()
                    {
                        alert("Không tải được bài viết !");
                    }
                });
    }
    this.update_setavata = function (f)
    {
        var reader = new FileReader();
        reader.onload = function (e)
        {
            admin_post_content.update_avata = e.target.result;
            $("img[name='admin_post_update_avata']").attr('src', e.target.result);
        };
        reader.readAsDataURL(f.files[0]);
    }
    this.update_load_type = function ()
    {
        $("#post_update_type_choose").removeClass('hide');
        $("#post_update_type_choose").html('Đang tải danh mục bài viết, xin chờ...');
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post_content_update_load_type',
                                id_type: $("#post_update_type").attr('data-id')
                            },
                    success: function (result)
                    {
                        $("#post_update_type_choose").html(result);

                    },
                    error: function ()
                    {
                        alert("Không tải được chuyên mục bài viết!");
                    }
                });
    }
    this.update_select_type = function (selector)
    {
        var selector = $(selector);
        $("#post_update_type").html("Mục: " + selector.attr('data-title'));
        $("#post_update_type").attr('data-id', selector.attr('data-id'));
        $("#post_update_type_choose").addClass('hide');
    }
    this.update = function (id)
    {
        if ($("input[name='admin_post_content_update_title']").val() != "" && $("input[name='admin_post_content_update_title']").val() != undefined)
        {
            var seo_title = $("#admin_post_content_update_seo_title").val();
            var seo_keyword = $("#admin_post_content_update_seo_keyword").val();
            var seo_description = $("#admin_post_content_update_seo_description").val();
            var avata_hide = $(".admin_post_content_hideavata").attr("data-hide");
            var change_time = $("#admin_post_content_update_changetime").prop("checked");
            if (change_time == false || change_time == undefined)
            {
                change_time = '0';
            } else
            {
                change_time = '1';
            }
            if (seo_title == undefined)
            {
                seo_title = "";
            }
            if (seo_keyword == undefined)
            {
                seo_keyword = "";
            }
            if (seo_description == undefined)
            {
                seo_description = "";
            }
            if (avata_hide == undefined)
            {
                avata_hide = "0";
            }
            var c = CKEDITOR.instances.admin_post_content_update_nd.getData();
            $.ajax(
                    {
                        url: "ajax_center",
                        type: "post",
                        dateType: "json",
                        data:
                                {
                                    type: 'admin_post_updatecontent',
                                    id: id,
                                    id_type: $("#post_update_type").attr('data-id'),
                                    title: $("input[name='admin_post_content_update_title']").val(),
                                    content: c,
                                    avata: this.update_avata,
                                    seo_title: seo_title,
                                    seo_keyword: seo_keyword,
                                    seo_description: seo_description,
                                    avata_hide: avata_hide,
                                    change_time: change_time
                                },
                        success: function (result)
                        {
                            tooltip(result, 2000);
                            admin_post_content.update_avata = "";
                            admin_post_content.loadlist();
                        },
                        error: function ()
                        {
                            alert("Không sửa được bài viết !");
                        }
                    });
        } else
        {
            tooltip("<span class='mistake'>Hãy nhập tiêu đề</span>", 2000);
        }
    }
    this.del = function (id)
    {
        dialog("Bạn chắc chắn muốn xóa bài viết này ?", "<div class='align_center padding' style='margin:2em 0px;'><span class='button padding' onclick='admin_post_content.real_del(" + id + ")'>Đồng ý xóa</span><span class='button padding red' onclick='uncaption()'>Không đồng ý</span>");
    }
    this.real_del = function (id)
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post_delcontent',
                                del_id: id
                            },
                    success: function (result)
                    {
                        dialog("Thông báo xóa bài viết", "<div class='padding'>" + result + "</div>");
                        admin_post_content.loadlist();
                    },
                    error: function ()
                    {
                        alert("Không xóa được bài viết !");
                    }
                });
    }
    this.penaty_del = function (id)
    {
        dialog("Bạn chắc chắn muốn <b class='stt_mistake'>xóa vĩnh viễn</b> bài viết này ?", "<div class='align_center padding' style='margin:2em 0px;'><span class='button padding' onclick='admin_post_content.real_penaty_del(" + id + ")'>Đồng ý xóa</span><span class='button padding red' onclick='uncaption()'>Không đồng ý</span>");
    }
    this.real_penaty_del = function (id)
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/content_delete_penaty',
                                del_id: id
                            },
                    success: function (result)
                    {
                        dialog("Xoá vĩnh viễn bài viết", "<div class='padding'>" + result + "</div>");
                        admin_post_content.loadlist();
                    },
                    error: function ()
                    {
                        alert("Không xóa được bài viết !");
                    }
                });
    }
    this.restore = function (id)
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/content_restore',
                                id: id
                            },
                    success: function (result)
                    {
                        dialog("Khôi phục bài viết", "<div class='padding'>" + result + "</div>");
                        admin_post_content.loadlist();
                    },
                    error: function ()
                    {
                        alert("Không khôi phục được bài viết !");
                    }
                });
    }
    this.pre_check = function (id_content)
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/content_precheck',
                                check_id: id_content
                            },
                    beforeSend: function ()
                    {
                        dialog("Duyệt bài viết", "<div class='padding' id='admin_post_content_precheck'>Đang tải nội dung, xin chờ...</div>");
                    },
                    success: function (result)
                    {
                        $("#admin_post_content_precheck").html(result);
                        //admin_post_content.loadlist();
                    },
                    error: function ()
                    {
                        alert("Không tải được nội dung từ máy chủ, vui lòng thực hiện lại sau !");
                    }
                });
    }
    this.check = function (id_content)
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post_check',
                                check_id: id_content,
                                add_score: $('#admin_post_content_check_addscore_input').val()
                            },
                    success: function (result)
                    {
                        dialog("Thông báo duyệt bài viết", "<div class='padding'>" + result + "</div>");
                        admin_post_content.loadlist();
                    },
                    error: function ()
                    {
                        alert("Không duyệt được bài viết !");
                    }
                });
    }
    this.uncheck = function (id_content)
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post_uncheck',
                                check_id: id_content
                            },
                    success: function (result)
                    {
                        dialog("Thông báo bỏ duyệt bài viết", "<div class='padding'>" + result + "</div>");
                        admin_post_content.loadlist();
                    },
                    error: function ()
                    {
                        alert("Không bỏ duyệt được bài viết !");
                    }
                });
    }
    this.reset_view = function ()
    {
        dialog("Bạn chắc chắn muốn cập nhật tất cả lượt xem bài viết ?", "<div class='align_center padding' style='margin:2em 0px;'><span class='button padding' onclick='admin_post_content.real_reset_view()'>Đồng ý cập nhật</span><span class='button padding red' onclick='uncaption()'>Không đồng ý</span>");
    }
    this.real_reset_view = function ()
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post_resetview'
                            },
                    success: function (result)
                    {
                        dialog("Thông báo cập nhật lượt xem bài viết", "<div class='padding'>" + result + "</div>");
                    },
                    error: function ()
                    {
                        alert("Không cập nhật được lượt xem bài viết !");
                    }
                });
    }
    this.loadtags = function (id)
    {
        dialog("Tags bài viết", "<div id='admin_post_tags'></div>");
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/content_load_tags',
                                id: id
                            },
                    success: function (result)
                    {
                        $("#admin_post_tags").html(result);
                    },
                    error: function ()
                    {
                        alert("Không tải được tags bài viết!");
                    }
                });
    }
    this.addtags_search = function ()
    {
        var title = $(".admin_post_tags_add_input").val();
        if (title == "" || title == undefined)
        {
            tooltip("<span class='stt_mistake fontsize_d2'>Hãy nhập tên tags để tìm</span>", 2000);
            return false;
        }
        selt = this;
        $(".admin_post_tags_add_search_result").html("Đang tìm...");
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/content_tags_add_search',
                                title: title
                            },
                    success: function (result)
                    {
                        $(".admin_post_tags_add_search_result").html(result);
                    },
                    error: function ()
                    {
                        alert("Không tìm được tags bài viết!");
                    }
                });
    }
    this.addtags_assign_search = function (w)
    {
        if (w == "" || w == undefined)
        {
            tooltip("<span class='stt_mistake fontsize_d2'>Không có tags được chọn</span>", 2000);
            return false;
        }
        $(".admin_post_tags_add_input").val(w);
    }
    this.addtags = function (id_post)
    {
        var title = $(".admin_post_tags_add_input").val();
        if (title == "" || title == undefined)
        {
            tooltip("<span class='stt_mistake fontsize_d2'>Hãy nhập tên tags</span>", 2000);
            return false;
        }
        selt = this;
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/content_tags_add',
                                id_post: id_post,
                                title: title
                            },
                    success: function (result)
                    {
                        tooltip("<div class='fontsize_d2'>" + result + "</div>", 2000);
                        selt.loadtags(id_post);
                    },
                    error: function ()
                    {
                        alert("Không thêm được tags bài viết!");
                    }
                });
    }
    this.deltags = function (id_post, id_tags)
    {
        selt = this;
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/content_tags_del',
                                id_tags: id_tags
                            },
                    success: function (result)
                    {
                        tooltip("<div class='fontsize_d2'>" + result + "</div>", 2000);
                        selt.loadtags(id_post);
                    },
                    error: function ()
                    {
                        alert("Không xóa được tags bài viết!");
                    }
                });
    }
}
function f_admin_post_alert()
{
    this.selector = $("#admin_post_alert");
    this.para_realtime_checking = false;
    this.para_realtime_checknum = 0;
    this.update = function ()
    {
        selt = this;
        this.selector.html("Đang cập nhật...");
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_post_loadalert'
            },
            success: function (result) {
                selt.selector.html(result);
            },
            error: function () {
                alert("Không cập nhật được thông báo !");
            }
        });
    }
    this.realtime_check = function ()
    {
        selt = this;
        if (this.para_realtime_checking == false)
        {
            this.para_realtime_checking = true;
            $.ajax({
                url: "ajax_center",
                type: "post",
                dateType: "json",
                data: {
                    type: 'admin_post_alert_realtime_check'
                },
                beforeSend: function () {
                    $('.admin_post_alert_real_time').addClass('fa-spin');
                },
                success: function (result) {
                    $('.admin_post_alert_real_time').removeClass('fa-spin');
                    selt.para_realtime_checknum = 0;
                    selt.para_realtime_checking = false;
                    if (result == '-1') {
                        $('.admin_post_alert_real_time').removeClass('stt_mistake');
                        $('.admin_post_alert_real_time').addClass('stt_tip');

                    } else {
                        $('.admin_post_alert_real_time').removeClass('stt_tip');
                        $('.admin_post_alert_real_time').addClass('stt_mistake');
                    }
                    $('.admin_post_alert_real_time').attr('data-detail', result);
                    //setTimeout("admin_post_alert.realtime_check()",60000);
                },
                error: function ()
                {
                    $('.admin_post_alert_real_time').removeClass('fa-spin');
                    if (selt.para_realtime_checknum < 10)
                    {
                        selt.para_realtime_checknum++;
                        selt.para_realtime_checking = false;
                        //selt.realtime_check();
                    }
                }
            });
        }
    }
    this.realtime_detail = function ()
    {
        dialog("Thông báo", $('.admin_post_alert_real_time').attr('data-detail'));
    }
    this.realtime_check();
}
function f_admin_post_author()
{
    this.selector_list = $("#admin_post_author_list");
    this.loadlist = function (page)
    {
        selt = this;
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post_author_getlist',
                                page: page
                            },
                    beforeSend: function ()
                    {
                        selt.selector_list.html("Đang tải danh sách, xin chờ...");
                    },
                    success: function (result)
                    {
                        selt.selector_list.html(result);
                    },
                    error: function ()
                    {
                        alert("Không tải được tác giả !");
                    }
                });
    }
    this.loadinfo = function (id)
    {
        dialog("Tác giả bài viết", "<div id='admin_post_author_moreinfo'></div>");
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post_author_load_info',
                                id: id
                            },
                    success: function (result)
                    {
                        $("#admin_post_author_moreinfo").html(result);
                    },
                    error: function ()
                    {
                        alert("Không tải được thông tin tác giả!");
                    }
                });
    }
    this.load_form_add = function ()
    {
        dialog("Thêm tác giả bài viết", "<div id='admin_post_author_formadd'></div>");
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/author_load_formadd'
                            },
                    success: function (result)
                    {
                        $("#admin_post_author_formadd").html(result);
                    },
                    error: function ()
                    {
                        alert("Không tải được form thêm tác giả!");
                    }
                });
    }
    this.add = function ()
    {
        var add_id_user = $(".admin_post_author_formadd_iduser").val();
        if (add_id_user == "" || add_id_user == undefined)
        {
            tootip("<span class='stt_mistake fontsize_d2'>Hãy nhập id user</span>", 2000);
            return false;
        }
        var add_score = $(".admin_post_author_formadd_score").val();
        if (add_score == "" || add_score == undefined)
        {
            add_score = 0;
        }
        dialog("Thêm tác giả bài viết", "<div id='admin_post_author_formadd'>Đang tiến hành thêm tác giả bài viết, xin chờ</div>");
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/author_add',
                                id_user: add_id_user,
                                score: add_score
                            },
                    success: function (result)
                    {
                        $("#admin_post_author_formadd").html(result);
                        admin_post_author.loadlist(1);
                    },
                    error: function ()
                    {
                        alert("Không thêm được tác giả!");
                    }
                });
    }
    this.update_score = function (id_author)
    {
        var score = $(".admin_post_author_editform_score").val();
        dialog("Sửa tác giả bài viết", "<div id='admin_post_author_formedit'>Đang tiến hành sửa tác giả bài viết, xin chờ</div>");
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/author_update_score',
                                id_author: id_author,
                                score: score
                            },
                    success: function (result)
                    {
                        $("#admin_post_author_formedit").html(result);
                        admin_post_author.loadinfo(id_author);
                    },
                    error: function ()
                    {
                        alert("Không sửa được thông tin tác giả!");
                    }
                });
    }
}
function f_admin_post_report_pattern()
{
    this.selector_list = $("#admin_post_report_pattern_list");
    this.loadlist = function (page)
    {
        selt = this;
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/report_pattern_getlist',
                                page: page
                            },
                    beforeSend: function ()
                    {
                        selt.selector_list.html("Đang tải danh sách, xin chờ...");
                    },
                    success: function (result)
                    {
                        selt.selector_list.html(result);
                    },
                    error: function ()
                    {
                        alert("Không tải được mẫu phản hồi !");
                    }
                });
    }
    this.loadinfo = function (id)
    {
        dialog("Mẫu phản hồi bài viết", "<div id='admin_post_report_pattern_moreinfo'></div>");
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/report_pattern_load_info',
                                id: id
                            },
                    success: function (result)
                    {
                        $("#admin_post_report_pattern_moreinfo").html(result);
                    },
                    error: function ()
                    {
                        alert("Không tải được thông tin mẫu phản hồi!");
                    }
                });
    }
    this.load_form_add = function ()
    {
        dialog("Thêm mẫu phản hồi bài viết", "<div id='admin_post_report_pattern_formadd'></div>");
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/report_pattern_load_formadd'
                            },
                    success: function (result)
                    {
                        $("#admin_post_report_pattern_formadd").html(result);
                    },
                    error: function ()
                    {
                        alert("Không tải được form thêm mẫu phản hồi bài viết!");
                    }
                });
    }
    this.add = function ()
    {
        var title = $("#admin_post_report_pattern_formadd_title").val();
        if (title == undefined || title == '' || title == false)
        {
            tooltip("<span class='stt_mistake'>Hãy nhập tên mẫu phản hồi</span>", 2000);
            return false;
        }
        dialog("Thêm mẫu phản hồi bài viết", "<div id='admin_post_report_pattern_formadd'>Đang tiến hành thêm mẫu phản hồi bài viết, xin chờ</div>");
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/report_pattern_add',
                                title: title
                            },
                    success: function (result)
                    {
                        $("#admin_post_report_pattern_formadd").html(result);
                        admin_post_report_pattern.loadlist(1);
                    },
                    error: function ()
                    {
                        alert("Không thêm được mẫu phản hồi bài viết!");
                    }
                });
    }
    this.update_title = function (id_pattern)
    {
        if (id_pattern == false || id_pattern == null)
        {
            return false;
        }
        var title = $("#admin_post_report_pattern_edit_title").val();
        if (title == undefined || title == '' || title == false)
        {
            tooltip("<span class='stt_mistake'>Hãy nhập tên mẫu phản hồi</span>", 2000);
            return false;
        }
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/report_pattern_update_title',
                                id: id_pattern,
                                title: title
                            },
                    success: function (result)
                    {
                        tooltip(result, 2000);
                        admin_post_report_pattern.loadlist(1);
                        uncaption();
                    },
                    error: function ()
                    {
                        tooltip("<span class='stt_mistake'>Không cập nhật được mẫu</span>", 2000);
                    }
                });
    }
    this.update_index = function (id_pattern)
    {
        if (id_pattern == false || id_pattern == null)
        {
            return false;
        }
        var index = $("select[name='admin_post_report_pattern_edit_index']").val();
        if (index == undefined || index == '' || index == false || index == 0)
        {
            tooltip("<span class='stt_mistake'>Hãy chọn thứ tự mẫu phản hồi</span>", 2000);
            return false;
        }
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/report_pattern_update_index',
                                id: id_pattern,
                                index: index
                            },
                    success: function (result)
                    {
                        tooltip(result, 2000);
                        admin_post_report_pattern.loadlist(1);
                        uncaption();
                    },
                    error: function ()
                    {
                        tooltip("<span class='stt_mistake'>Không cập nhật được mẫu</span>", 2000);
                    }
                });
    }
}
function f_admin_post_report_content()
{
    this.selector_list = $("#admin_post_report_content_list");
    this.loadlist = function (page)
    {
        selt = this;
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/report_content_getlist',
                                page: page
                            },
                    beforeSend: function ()
                    {
                        selt.selector_list.html("Đang tải danh sách, xin chờ...");
                    },
                    success: function (result)
                    {
                        selt.selector_list.html(result);
                    },
                    error: function ()
                    {
                        alert("Không tải được phản hồi !");
                    }
                });
    }
    this.del = function (id)
    {
        dialog("Bạn chắc chắn muốn xóa phản hồi này ?", "<div class='align_center padding' style='margin:2em 0px;'><span class='button padding' onclick='admin_post_report_content.real_del(" + id + ")'>Đồng ý xóa</span><span class='button padding red' onclick='uncaption()'>Không đồng ý</span>");
    }
    this.real_del = function (id)
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_post/report_content_del',
                                del_id: id
                            },
                    success: function (result)
                    {
                        dialog("Thông báo xóa phản hồi bài viết", "<div class='padding'>" + result + "</div>");
                        admin_post_report_content.loadlist(1);
                    },
                    error: function ()
                    {
                        alert("Không xóa được phản hồi bài viết !");
                    }
                });
    }
}
function f_admin_post_group()
{
    this.loadinglist = false;
    this.loadlist = function ()
    {
        if (this.loadinglist == false)
        {
            this.loadinglist = true;
            var self = this;
            $.ajax({
                url: "ajax_center",
                type: "post",
                dateType: "json",
                data: {
                    type: "admin_post/group_loadlist"
                },
                beforeSend: function () {
                    $("#admin_post_group_list").html("Đang tải danh sách, xin chờ...");
                },
                success: function (result) {
                    $("#admin_post_group_list").html(result);
                    self.loadinglist = false;
                },
                error: function () {
                    $("#admin_post_group_list").html("<div class='stt_mistake'>Không tải được danh sách</div>");
                    self.loadinglist = false;
                }
            });
        }
    };
    this.load_form_add = function ()
    {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: "admin_post/group_loadformadd"
            },
            beforeSend: function () {
                dialog("Thêm nhóm bài viết", "<div class='admin_post_group_form_add'>Đang tải dữ liệu...</div>");
            },
            success: function (result) {
                $(".admin_post_group_form_add").html(result);

                CKEDITOR.replace('admin_post_group_formadd_nd', {});

                $("#admin_post_group_formadd_nd").css({'background-color': '#ffffff', 'padding': '0.5em', 'border': '1px solid #aaaaaa', 'min-height': '250px', 'max-width': '100%', 'max-height': '500px', 'overflow-y': 'auto'});
            },
            error: function () {
                alert("Không tải được dữ liệu !");
            }
        });
    };
    this.adding = false;
    this.add = function ()
    {
        if (this.adding === true) {
            return false;
        }
        this.adding = true;
        var title = $("#admin_post_group_formadd_title").val();
        if (title == "" || title == undefined) {
            tooltip("<span class='stt_mistake'>Hãy nhập vào tên nhóm bài viết</span>", 2000);
            this.adding = false;
            return false;
        }
        var note = CKEDITOR.instances.admin_post_group_formadd_nd.getData();
        var self = this;
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: "admin_post/group_add",
                title: title,
                description: note
            },
            beforeSend: function () {
                dialog("Thêm nhóm bài viết", "<div class='admin_post_group_adding'>Đang tải dữ liệu...</div>");
            },
            success: function (result) {
                $(".admin_post_group_adding").html(result);
                self.adding = false;
            },
            error: function () {
                alert("Không thêm được nhóm bài viết !");
                self.adding = false;
            }
        });
    };
    this.del = function (id)
    {
        dialog("Bạn chắc chắn muốn xóa nhóm bài viết này ?", "<div class='align_center padding' style='margin:2em 0px;'><span class='button padding' onclick='admin_post_group.real_del(" + id + ")'>Đồng ý xóa</span><span class='button padding red' onclick='uncaption()'>Không đồng ý</span>");
    };
    this.real_del = function (id)
    {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_post/group_del',
                del_id: id
            },
            success: function (result) {
                admin_post_group.loadlist();
                dialog("Xoá nhóm bài viết", result);
            },
            error: function () {
                alert("Không xoá được nhóm bài viết !");
            }
        });
    };
    this.del_penaty = function (id)
    {
        dialog("Bạn chắc chắn muốn <span class='stt_mistake'>xóa vĩnh viễn</span> nhóm bài viết này ?", "<div class='align_center padding' style='margin:2em 0px;'><span class='button padding' onclick='admin_post_group.real_del_penaty(" + id + ")'>Đồng ý xóa</span><span class='button padding red' onclick='uncaption()'>Không đồng ý</span>");
    };
    this.real_del_penaty = function (id)
    {
        uncaption();
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_post/group_del_penaty',
                del_id: id
            },
            success: function (result) {
                admin_post_group.loadlist();
                dialog("Xoá nhóm bài viết", result);
            },
            error: function () {
                alert("Không xoá được nhóm bài viết !");
            }
        });
    };
    this.loadformedit = function (id)
    {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: "admin_post/group_loadformedit",
                id: id
            },
            beforeSend: function () {
                dialog("Chỉnh sửa nhóm bài viết", "<div class='admin_post_group_form_edit'>Đang tải dữ liệu...</div>");
            },
            success: function (result) {
                $(".admin_post_group_form_edit").html(result);
                CKEDITOR.replace('admin_post_group_formadd_nd', {});
                $("#admin_post_group_formadd_nd").css({'background-color': '#ffffff', 'padding': '0.5em', 'border': '1px solid #aaaaaa', 'min-height': '250px', 'max-width': '100%', 'max-height': '500px', 'overflow-y': 'auto'});
            },
            error: function () {
                alert("Không tải được dữ liệu !");
            }
        });
    };
    this.edit_avata = '';
    this.edit_setavata = function (f)
    {
        var reader = new FileReader();
        reader.onload = function (e)
        {
            admin_post_group.edit_avata = e.target.result;
            $("#admin_post_group_formadd_avata").attr('src', e.target.result);
        };
        reader.readAsDataURL(f.files[0]);
    };
    this.edit = function (id)
    {
        if (this.adding === true) {
            return false;
        }
        this.adding = true;
        var title = $("#admin_post_group_formadd_title").val();
        if (title == "" || title == undefined) {
            tooltip("<span class='stt_mistake'>Hãy nhập vào tên nhóm bài viết</span>", 2000);
            this.adding = false;
            return false;
        }
        var note = CKEDITOR.instances.admin_post_group_formadd_nd.getData();
        var self = this;
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: "admin_post/group_edit",
                id: id,
                title: title,
                description: note,
                avata: this.edit_avata
            },
            beforeSend: function () {
                dialog("Chỉnh sửa nhóm bài viết", "<div class='admin_post_group_adding'>Đang thực hiện...</div>");
            },
            success: function (result) {
                $(".admin_post_group_adding").html(result);
                self.adding = false;
            },
            error: function () {
                alert("Không chỉnh sửa được nhóm bài viết !");
                self.adding = false;
            }
        });
    };
    this.loaddetail = function (id)
    {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: "admin_post/group_loaddetail",
                id: id
            },
            beforeSend: function () {
                dialog("Quản lí nhóm bài viết", "<div class='admin_post_group_detail'>Đang tải dữ liệu...</div>");
            },
            success: function (result) {
                $(".admin_post_group_detail").html(result);
            },
            error: function () {
                $(".admin_post_group_detail").html("<div class='stt_mistake'>Không tải được dữ liệu</div>");
            }
        });
    };
    this.addpost_search = function (idgroup)
    {
        var result_box = $("#admin_post_group_detail_addpost_search_result");
        var s = $("#admin_post_group_detail_addpost_searchinput").val();
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: "admin_post/group_detail_addpost_search",
                idgroup: idgroup,
                word: s
            },
            beforeSend: function () {
                result_box.html("Đang tìm bài viết...");
            },
            success: function (result) {
                result_box.html(result);
            },
            error: function () {
                result_box.html("<p class='stt_mistake'>Lỗi tạm thời, hãy thực hiện lại sau !</p>");
            }
        });
    };
    this.addpost = function (idgroup, idpost)
    {
        var result_box = $(".admin_post_group_addpost_item_" + idpost + " .alert");
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: "admin_post/group_detail_addpost",
                idgroup: idgroup,
                idpost: idpost
            },
            beforeSend: function () {
                result_box.html("Đang thêm bài viết vào nhóm...");
            },
            success: function (result) {
                result_box.html(result);
            },
            error: function () {
                result_box.html("<p class='stt_mistake'>Lỗi tạm thời, hãy thực hiện lại sau !</p>");
            }
        });
    };
    this.delpost = function (idpost)
    {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: "admin_post/group_detail_delpost",
                idpost: idpost
            },
            success: function (result) {
                if (result == "1") {
                    $('.admin_post_in_group_' + idpost).css({'opacity': '0.3'});
                } else {
                    tooltip("<span class='stt_mistake fontsize_d2'>" + result + "</span>", 2000);
                }
            },
            error: function () {
                tooltip("<span class='stt_mistake fontsize_d2'>Không xoá được bài viết khỏi nhóm</span>", 2000);
            }
        });
    };
}
admin_post_type = "";
admin_post_content = "";
admin_post_alert = "";
admin_post_author = "";
admin_post_report_pattern = "";
admin_post_report_content = "";
admin_post_group = "";
$(window).ready(function ()
{
    admin_post_type = new f_admin_post_type();
    admin_post_content = new f_admin_post_content();
    admin_post_alert = new f_admin_post_alert();
    admin_post_author = new f_admin_post_author();
    admin_post_report_pattern = new f_admin_post_report_pattern();
    admin_post_report_content = new f_admin_post_report_content();
    admin_post_group = new f_admin_post_group();
});

