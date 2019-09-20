//js for admin config
function f_admin_config_logo()
{
    selt = this;
    this.loading = false;
    this.image = "";
    this.selector_previewImage = $("#admin_config_logo_preview");
    this.setImage = function (f)
    {
        if (this.loading == false)
        {
            this.loading = true;
            var reader = new FileReader();
            reader.onload = function (e)
            {
                selt.image = e.target.result;
                selt.selector_previewImage.attr('src', e.target.result);
                $("#admin_config_logo_savebtn").removeClass('hide');
                selt.loading = false;
            };
            reader.readAsDataURL(f.files[0]);
        }
    }
    this.save = function ()
    {
        if (this.loading == false)
        {
            this.loading = true;
            //todo
            if (this.image == "")
            {
                alert("Hãy chọn hình ảnh");
            } else
            {
                $.ajax(
                        {
                            url: "ajax_center",
                            type: "post",
                            dateType: "json",
                            data:
                                    {
                                        type: 'admin_config/logo_save',
                                        image: this.image
                                    },
                            beforeSend: function ()
                            {
                                tooltip("<i class='fa fa-refresh fa-spin'></i> Đang tải hình ảnh...", -1);
                            },
                            success: function (result)
                            {
                                off_tooltip(-1);
                                dialog("Cập nhật ảnh logo", "<div class='padding_v'>" + result + "</div>");
                                selt.loading = false;
                            },
                            error: function ()
                            {
                                off_tooltip(-1);
                                selt.loading = false;
                                alert("Không tải được hình ảnh !");
                            }
                        });
            }
            selt.loading = false;
        }
    }
}
admin_config = {};

(function ($) {
    var admin_systemParam = function ()
    {
        self = this;
        this.list = $("#admin_config_system_param_list");
        this.btnLoadlist = $('.button.admin_system_param_load');
        this.btnLoadadd = $('.admin_system_param_load_add');
        this.isloading = false;
        this.loadList = function () {
            if (self.isloading === false) {
                self.isloading = true;
                $.ajax({
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data: {
                        type: 'admin_config/systemParam_loadlist'
                    },
                    beforeSend: function ()
                    {
                        self.list.html("Loading, please wait...");
                    },
                    success: function (result)
                    {
                        self.list.html(result);
                        self.list.tooltip();
                        self.afterLoadList();
                        self.isloading = false;
                    },
                    error: function ()
                    {
                        self.list.html("Cannot load list !");
                        self.isloading = false;
                    }
                });
            }
            return;
        };
        this.afterLoadList = function ()
        {
            self.list.find(".fa.fa-send").click(function () {
                var c = $(this).parents(".item");
                var n = c.find('.item_name').attr('data-name');
                var v = c.find('.item_value').val();
                self.updateParam(n, v);
            });
        };
        this.updateParam = function (n, v)
        {
            if (self.isloading === false) {
                self.isloading = true;
                $.ajax({
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data: {
                        type: 'admin_config/systemParam_update',
                        paramName: n,
                        paramValue: v
                    },
                    beforeSend: function ()
                    {
                        self.list.html("Updating, please wait...");
                    },
                    success: function (result)
                    {
                        off_tooltip(-1);
                        tooltip(result, 2000);
                        self.isloading = false;
                        self.loadList();
                    },
                    error: function ()
                    {
                        self.list.html("Cannot update param !");
                        self.isloading = false;
                    }
                });
            }
        };
        this.loadFormAdd = function () {
            dialog("Thêm thông số hệ thống", "<div id='admin_system_param_form_add'></div>");
            var fa = $('#admin_system_param_form_add');
            $.ajax({
                url: "ajax_center",
                type: "post",
                dateType: "json",
                data: {
                    type: 'admin_config/systemParam_formAdd'
                },
                beforeSend: function ()
                {
                    fa.html("Loading, please wait...");
                },
                success: function (result)
                {
                    fa.html(result);
                    self.afterLoadFormAdd(fa);
                },
                error: function ()
                {
                    fa.html("Cannot load form add system param !");
                }
            });
        };
        this.afterLoadFormAdd = function(fa){
            fa.find(".name").css({'width' : '100%'});
            fa.find("textarea").css({'width' : '100%', 'height' : '200px'});
            fa.find('.button_submit').click(function(){
                self.add(fa);
            });
        };
        this.add = function(fa)
        {
            var n = fa.find(".name").val();
            var v = fa.find(".value").val();
            var c = fa.find(".comment").val();
            if (self.isloading === false) {
                self.isloading = true;
                $.ajax({
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data: {
                        type: 'admin_config/systemParam_add',
                        paramName: n,
                        paramValue: v,
                        paramComment: c
                    },
                    beforeSend: function ()
                    {
                        fa.html("Adding, please wait...");
                    },
                    success: function (result)
                    {
                        fa.html(result);
                        self.isloading = false;
                        self.loadList();
                    },
                    error: function ()
                    {
                        fa.html("Cannot update param !");
                        self.isloading = false;
                    }
                });
            }
        };
        this.btnLoadlist.on('click', function () {
            self.loadList();
        });
        this.btnLoadadd.on('click', function () {
            self.loadFormAdd();
        });
    };
    $(window).ready(function ()
    {
        new admin_systemParam();
    });
})($);

$(window).ready(function ()
{
    admin_config.logo = new f_admin_config_logo();
});