function f_top_advertiment() {
    this.add_avata = "";
    this.update_avata = "";
    this.loadlist = function () {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_setting_topadvertiment_loadlist'
            },
            success: function (result) {
                $("div[name='top_advertiment_list']").html(result);
            },
            error: function () {
                tooltip("<span class='mistake'>Sự cố mạng, <br>không thể cập nhật danh sách quảng cáo chính, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    };
    this.add_setavata = function (f) {
        var reader = new FileReader();
        reader.onload = function (e)
        {
            top_advertiment.add_avata = e.target.result;
            $("img[name='top_advertiment_add_avata']").attr('src', e.target.result);
        };
        reader.readAsDataURL(f.files[0]);
    };
    this.add = function () {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_setting_topadvertiment_add',
                title: $("fieldset[name='top_advertiment_add'] input[name='title']").val(),
                link: $("fieldset[name='top_advertiment_add'] input[name='link']").val(),
                adstype: $("fieldset[name='top_advertiment_add'] select[name='adstype'] :selected").val(),
                avata: this.add_avata
            },
            success: function (result) {
                alert(result);
                top_advertiment.loadlist();
                $("fieldset[name='top_advertiment_add'] input[name='title']").val(null);
                $("fieldset[name='top_advertiment_add'] input[name='link']").val(null);
                content:$("#top_advertiment_add_content").html("Nội dung quảng cáo");
                $("img[name='top_advertiment_add_avata']").attr('src', "");
            },
            error: function () {
                tooltip("<span class='mistake'>Sự cố mạng, <br>không thể thêm quảng cáo chính, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    };
    this.del = function (id) {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_setting_topadvertiment_del',
                id: id
            },
            success: function (result) {
                alert(result);
                top_advertiment.loadlist();
            },
            error: function () {
                tooltip("<span class='mistake'>Sự cố mạng, <br>không thể xóa mục trong quảng cáo chính, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    };
    this.show = function (id) {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_setting_topadvertiment_show',
                id: id
            },
            success: function (result) {
                alert(result);
                top_advertiment.loadlist();
            },
            error: function () {
                tooltip("<span class='mistake'>Sự cố mạng, <br>không thể hiện mục trong quảng cáo chính, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    };
    this.hide = function (id) {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_setting_topadvertiment_hide',
                id: id
            },
            success: function (result) {
                alert(result);
                top_advertiment.loadlist();
            },
            error: function () {
                tooltip("<span class='mistake'>Sự cố mạng, <br>không thể ẩn mục trong quảng cáo chính, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    };
    this.load_form_edit = function (id) {
        dialog("Chỉnh sửa quảng cáo", "<div id='admin_avertiment_edit'></div>");
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_advertiment/load_form_edit',
                id: id
            },
            success: function (result) {
                $("#admin_avertiment_edit").html(result);
            },
            error: function () {
                uncaption();
                tooltip("<span class='mistake'>Sự cố mạng, <br>Không thể sửa quảng cáo, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    };
    this.update_setavata = function (f) {
        var reader = new FileReader();
        reader.onload = function (e) {
            top_advertiment.update_avata = e.target.result;
            $("img[name='top_advertiment_update_avata']").attr('src', e.target.result);
        };
        reader.readAsDataURL(f.files[0]);
    };
    this.update = function (id) {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_advertiment/update',
                id: id,
                title: $("#admin_avertiment_edit input[name='title']").val(),
                link: $("#admin_avertiment_edit input[name='link']").val(),
                adstype: $("#admin_avertiment_edit select[name='adstype'] :selected").val(),
                avata: this.update_avata
            },
            success: function (result) {
                dialog("Chỉnh sửa quảng cáo", result);
            },
            error: function () {
                tooltip("<span class='stt_mistake'>Sự cố mạng, <br>Không thể cập nhật quảng cáo, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    };
}

function f_main_menu()
{
    this.current_id_parent = 1;
    this.add_avata = "";
    this.update_avata = "";
    this.formAdd = false;
    var self = this;
    this.load_list = function (id_parent) {
        this.current_id_parent = id_parent;
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_setting_mainmenu_loadlist',
                id_parent: this.current_id_parent
            },
            success: function (result) {
                $("div[name='main_menu_list']").html(result);
            },
            error: function () {
                tooltip("<span class='mistake'>Sự cố mạng, <br>không thể cập nhật danh sách menu, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    };
    this.load_form_add = function () {
        if (this.formAdd === false) {
            $.ajax({
                url: "ajax_center",
                type: "post",
                dateType: "json",
                beforeSend: function () {
                    dialog("Thêm trang menu", "<div id='main_menu_add'><i class='fa fa-spin fa-spinner'></i> Vui lòng đợi...</div>");
                },
                data: {
                    type: 'admin_setting/mainmenu_loadformadd'
                },
                success: function (result) {
                    self.formAdd = result;
                    $("#main_menu_add").html(result);
                },
                error: function () {
                    tooltip("<span class='mistake'>Sự cố mạng, <br>không thể cập nhật form thêm dữ liệu, <br>hãy thực hiện lại sau vài giây</span>", 3000);
                }
            });
        } else {
            dialog("Thêm trang menu", "<div id='main_menu_add'>" + this.formAdd + "</div>");
        }

    };
    this.add = function ()
    {
        var title = $("input[name='main_menu_add_title']").val();
        if (title == "" || title == undefined)
        {
            tooltip("<span class='stt_mistake'>Hãy nhập vào tiêu đề trang</span>", 2000);
            return false;
        }
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_setting_mainmenu_add',
                id_parent: this.current_id_parent,
                type2: $("select[name='main_menu_add_type']").val(),
                title: title,
                link: $("input[name='main_menu_add_link']").val()
            },
            success: function (result) {
                tooltip(result, 3000);
                main_menu.load_list(main_menu.current_id_parent);
            },
            error: function () {
                tooltip("<span class='mistake'>Sự cố mạng, <br>không thể thêm danh mục vào menu, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    }
    this.del = function (id)
    {
        dialog("Bạn chắc chắn muốn xóa menu này ?", "<div class='align_center padding' style='margin:2em 0px;'><span class='button padding' onclick='main_menu.real_del(" + id + ")'>Đồng ý xóa</span><span class='button padding red' onclick='uncaption()'>Không đồng ý</span>");
    }
    this.real_del = function (id)
    {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_setting_mainmenu_del',
                id: id
            },
            success: function (result) {
                alert(result);
                main_menu.load_list(main_menu.current_id_parent);
            },
            error: function () {
                tooltip("<span class='mistake'>Sự cố mạng, <br>không thể xóa mục trong menu, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    }
    this.show = function (id)
    {
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_setting_mainmenu_show',
                id: id
            },
            success: function (result) {
                alert(result);
                main_menu.load_list(main_menu.current_id_parent);
            },
            error: function () {
                tooltip("<span class='mistake'>Sự cố mạng, <br>không thể hiện mục trong menu, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    }
    this.hide = function (id)
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_setting_mainmenu_hide',
                                id: id
                            },
                    success: function (result)
                    {
                        alert(result);
                        main_menu.load_list(main_menu.current_id_parent);
                    },
                    error: function ()
                    {
                        tooltip("<span class='mistake'>Sự cố mạng, <br>không thể ẩn mục trong menu, <br>hãy thực hiện lại sau vài giây</span>", 3000);
                    }
                });
    }
    this.load_form_edit = function (id)
    {
        dialog("Chỉnh sửa trang menu", "<div id='main_menu_edit'></div>");
        $("#main_menu_edit").append("<form action='javascript:main_menu.update()'></form>");
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_setting/mainmenu_loadformedit',
                id: id
            },
            success: function (result) {
                $("#main_menu_edit form").append(result);
                CKEDITOR.replace('main_menu_update_content', {});
            },
            error: function () {
                tooltip("<span class='mistake'>Sự cố mạng, <br>không thể sửa mục trong menu, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    }
    this.update_setavata = function (f)
    {
        var reader = new FileReader();
        reader.onload = function (e)
        {
            main_menu.update_avata = e.target.result;
            $("img[name='main_menu_update_avata']").attr('src', e.target.result);
        };
        reader.readAsDataURL(f.files[0]);
    }
    this.update = function (id)
    {
        var c = CKEDITOR.instances.main_menu_update_content.getData();
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_setting_mainmenu_update',
                id: id,
                type2: $("select[name='main_menu_update_type']").val(),
                title: $("input[name='main_menu_update_title']").val(),
                title_shorcut: $("input[name='main_menu_update_title_shorcut']").val(),
                link: $("input[name='main_menu_update_link']").val(),
                content: c,
                avata: this.update_avata,
                optionshowheader: ($('#staticPageOptionShowheader').prop('checked')) ? '1' : '0',
                optionshowinheader: ($('#staticPageOptionShowinheader').prop('checked')) ? '1' : '0',
                optionshowfooter: ($('#staticPageOptionShowfooter').prop('checked')) ? '1' : '0',
                optionshowinfooter: ($('#staticPageOptionShowinfooter').prop('checked')) ? '1' : '0',
                optionshowbreakcump: ($('#staticPageOptionShowbreakcump').prop('checked')) ? '1' : '0',
                optionshowfullshare: ($('#staticPageOptionShowfullshare').prop('checked')) ? '1' : '0',
                optionshowquickmessage: ($('#staticPageOptionShowquickmessage').prop('checked')) ? '1' : '0',
                isprimary: ($('#staticPageisprimary').prop('checked')) ? '1' : '0',
                adding_css: $('#main_menu_update_adding_css').val(),
                adding_js: $('#main_menu_update_adding_js').val()
            },
            success: function (result) {
                tooltip(result, 3000);
                $("fieldset[name='main_menu_edit_fieldset']").css({'display': 'none'});
                main_menu.load_list(main_menu.current_id_parent);
            },
            error: function () {
                tooltip("<span class='mistake'>Sự cố mạng, <br>không thể sửa mục trong menu, <br>hãy thực hiện lại sau vài giây</span>", 3000);
            }
        });
    };
    this.setindex = function (idmenu)
    {
        var selt = this;
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_setting_mainmenu_setindex',
                                id: idmenu
                            },
                    success: function (result)
                    {
                        tooltip(result, 3000);
                        main_menu.load_list(main_menu.current_id_parent);
                    },
                    error: function ()
                    {
                        tooltip("<span class='mistake'>Sự cố mạng, <br>không thể đặt mục này là mục chính, <br>hãy thực hiện lại sau vài giây</span>", 3000);
                    }
                });
    }
    this.movies = function (idmenu, num)//num=1 để chuyển ra sau, -1 chuyển về trước
    {
        var selt = this;
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_setting_mainmenu_movies',
                                id: idmenu,
                                num: num
                            },
                    success: function (result)
                    {
                        tooltip(result, 3000);
                        main_menu.load_list(main_menu.current_id_parent);
                    },
                    error: function ()
                    {
                        tooltip("<span class='mistake'>Sự cố mạng, <br>không thể di chuyển mục này, <br>hãy thực hiện lại sau vài giây</span>", 3000);
                    }
                });
    }
}
function f_contribute()
{
    this.loadlist = function ()
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_setting_contribute_loadlist',
                                id_parent: this.current_id_parent
                            },
                    success: function (result)
                    {
                        $("div[name='contribute_list']").html(result);
                    },
                    error: function ()
                    {
                        tooltip("<span class='mistake'>Sự cố mạng, <br>không thể cập nhật ý kiến phản hồi, <br>hãy thực hiện lại sau vài giây</span>", 3000);
                    }
                });
    }
    this.del = function (id)
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_setting_contribute_del',
                                id: id
                            },
                    success: function (result)
                    {
                        alert(result);
                        contribute.loadlist();
                    },
                    error: function ()
                    {
                        tooltip("<span class='mistake'>Sự cố mạng, <br>không thể xóa mục trong ý kiến người dùng, <br>hãy thực hiện lại sau vài giây</span>", 3000);
                    }
                });
    }
}
function f_admin_message()
{
    this.loadlist = function ()
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_setting_message_loadlist',
                                id_parent: this.current_id_parent
                            },
                    success: function (result)
                    {
                        $("div[name='admin_message_list']").html(result);
                    },
                    error: function ()
                    {
                        tooltip("<span class='mistake'>Sự cố mạng, <br>không thể cập nhật tin nhắn, <br>hãy thực hiện lại sau vài giây</span>", 3000);
                    }
                });
    }
    this.delall = function ()
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_setting_message_delall'
                            },
                    success: function (result)
                    {
                        alert(result);
                        admin_message.loadlist();
                    },
                    error: function ()
                    {
                        tooltip("<span class='mistake'>Sự cố mạng, <br>không thể xóa tin nhắn người dùng, <br>hãy thực hiện lại sau vài giây</span>", 3000);
                    }
                });
    }
}
function f_admin_support()
{
    this.add = function ()
    {
        if ($("input[name='admin_support_add_title']").val() != "" && ($("input[name='admin_support_add_phone']").val() != "" || $("input[name='admin_support_add_email']").val() != "" || $("input[name='admin_support_add_facebook']").val() != ""))
        {
            $.ajax(
                    {
                        url: "ajax_center",
                        type: "post",
                        dateType: "json",
                        data:
                                {
                                    type: 'admin_setting_support_add',
                                    title: $("input[name='admin_support_add_title']").val(),
                                    phone: $("input[name='admin_support_add_phone']").val(),
                                    email: $("input[name='admin_support_add_email']").val(),
                                    facebook: $("input[name='admin_support_add_facebook']").val()
                                },
                        success: function (result)
                        {
                            tooltip(result, 2000);
                            admin_support.loadlist();
                        },
                        error: function ()
                        {
                            tooltip("<span class='mistake'>Sự cố mạng, <br>không thể thêm hỗ trợ trực tuyến, <br>hãy thực hiện lại sau vài giây</span>", 3000);
                        }
                    });
        } else
        {
            tooltip("<span class='mistake'>Thiếu thông tin hỗ trợ</span>", 2000);
        }
    }
    this.loadlist = function ()
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_setting_support_loadlist'
                            },
                    success: function (result)
                    {
                        $("div[name='admin_support_list']").html(result);
                    },
                    error: function ()
                    {
                        tooltip("<span class='mistake'>Sự cố mạng, <br>không thể cập nhật các hỗ trợ trực tuyến, <br>hãy thực hiện lại sau vài giây</span>", 3000);
                    }
                });
    }
    this.del = function (id)
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_setting_support_del',
                                id: id
                            },
                    success: function (result)
                    {
                        alert(result);
                        admin_support.loadlist();
                    },
                    error: function ()
                    {
                        tooltip("<span class='mistake'>Sự cố mạng, <br>không thể xóa hỗ trợ trực tuyến, <br>hãy thực hiện lại sau vài giây</span>", 3000);
                    }
                });
    }
}
function f_admin_sitemap()
{
    this.para_update_page = 'admin_setting_sitemap_update';
    this.update = function ()
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    beforeSend: function ()
                    {
                        tooltip("<i class='fa fa-refresh fa-spin'></i> Đang cập nhật...", -1);
                    },
                    data:
                            {
                                type: this.para_update_page,
                                data_type: this.type
                            },
                    success: function (result)
                    {
                        off_tooltip(-1);
                        tooltip(result, 2000);
                    },
                    error: function ()
                    {
                        alert("Sự cố mạng, không cập nhật được sitemap!");
                        off_tooltip(-1);
                    }
                });
    }
}
function admin_setting_cache_f()
{
    this.page = 1;
    this.selector_list = $("#admin_setting_cache_list");
    this.loadlist = function (p)
    {
        if (p == undefined || p == "" || p == false)
        {
            p = this.page;
        } else
        {
            this.page = p;
        }
        if (p < 1)
        {
            p = 1;
        }
        this.selector_list.html("<i class='fa fa-spinner fa-spin'></i> Đang tải danh sách, xin chờ...");
        selt_setting_cache_loadlist = this;
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: "admin_setting/cache_loadlist",
                                page: p
                            },
                    success: function (result)
                    {
                        selt_setting_cache_loadlist.selector_list.html(result);
                    },
                    error: function ()
                    {
                        selt_setting_cache_loadlist.selector_list.html("Sự cố mạng, không cập nhật được danh sách cache!");
                    }
                });
    }
    this.loadinfo = function (n)
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: "admin_setting/cache_loadinfo",
                                cache_name: n
                            },
                    beforeSend: function ()
                    {
                        dialog("Cache / Chi tiết / <span class='stt_tip fontsize_d2'>" + n + "</span>", "<div id='admin_setting_cache_info'><i class='fa fa-spinner fa-spin'></i> Đang tải dữ liệu, xin chờ...</div>");
                    },
                    success: function (result)
                    {
                        $("#admin_setting_cache_info").html(result);
                    },
                    error: function ()
                    {
                        $("#admin_setting_cache_info").html("<div class='stt_mistake'>Không tải được thông tin, hãy thử lại sau.</div>");
                    }
                });
    }
    this.del = function (id)
    {
        dialog("Bạn chắc chắn muốn xóa cache này ?", "<div class='align_center padding' style='margin:2em 0px;'><span class='button padding' onclick=\"admin_setting_cache.real_del('" + id + "')\">Đồng ý xóa</span><span class='button padding red' onclick='uncaption()'>Không đồng ý</span>");
    }
    this.real_del = function (id)
    {
        selt_admin_setting_cache_del = this;
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'admin_setting/cache_del',
                                id: id
                            },
                    success: function (result)
                    {
                        dialog("Xóa cache / " + id, "<div>" + result + "</div>");
                        selt_admin_setting_cache_del.loadlist();
                    },
                    error: function ()
                    {
                        tooltip("<span class='mistake'>Sự cố mạng, <br>không thể xóa cache, <br>hãy thực hiện lại sau vài giây</span>", 3000);
                    }
                });
    }
}
function startloadjs()
{
    top_advertiment = new f_top_advertiment();
    main_menu = new f_main_menu();
    contribute = new f_contribute();
    admin_message = new f_admin_message();
    admin_support = new f_admin_support();
    admin_sitemap = new f_admin_sitemap();
    admin_setting_cache = new admin_setting_cache_f();
}
var top_advertiment = "";
var main_menu = "";
var contribute = "";
var admin_message = "";
var admin_support = "";
var admin_sitemap = "";
var admin_setting_cache = "";
$("document").ready(startloadjs());