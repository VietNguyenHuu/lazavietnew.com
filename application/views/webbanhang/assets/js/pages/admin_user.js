function f_user()
{
    selt = this;
    this.para = {
        bonusing_score: false,
        bonusing_money: false,
        id_user_loaded: -1,
        page: 1
    };
    this.selector_list = $("#admin_user_list");
    this.loadlist = function (p)
    {
        if (p == undefined || p == "") {
            p = this.para.page;
        } else {
            this.para.page = p;
        }
        this.selector_list.html("Đang lấy danh sách thành viên<br><img src='assets/img/system/loading.gif' style='width:100%;'>");
        var order = $("select[name='admin_user_vieworder']").val();
        if (order == "" || order == undefined) {
            order = 'new';
        }
        var search = $("input[name='admin_user_viewsearch']").val();
        if (search == "" || search == undefined) {
            search = '';
        }
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_user_getlist',
                order: order,
                search: search,
                page: p
            },
            success: function (result) {
                selt.selector_list.html(result);
            },
            error: function () {
                selt.selector_list.html("không lấy được danh sách thành viên !");
            }
        });
    };
    this.selector_act = $("#admin_user_act");
    this.loadinfo = function (id)
    {
        this.para.id_user_loaded = id;
        this.selector_act.html("đang lấy thông tin thành viên<br><img src='assets/img/system/loading.gif' style='width:100%;'>");
        $.ajax({
            url: "index.php/ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_user_loadinfo',
                id: id
            },
            success: function (result) {
                selt.selector_act.html(result);
                window.location = location.href.replace("#userinfo", "") + "#userinfo";
            },
            error: function () {
                selt.selector_act("không lấy được thông tin thành viên !");
            }
        });
    };
    this.reloadinfo = function ()
    {
        if (this.para.id_user_loaded == -1)
        {
            off_tooltip(-1);
            tooltip("<span class='stt_mistake'>Chưa có thành viên được chọn</span>", 2000);
            return false;
        }
        return this.loadinfo(this.para.id_user_loaded);
    };
    this.del = function (id)
    {
        dialog("Bạn chắc chắn muốn xóa thành viên này ?", "<div class='align_center padding' style='margin:2em 0px;'><span class='button padding' onclick='user.real_del(" + id + ")'>Đồng ý xóa</span><span class='button padding red' onclick='uncaption()'>Không đồng ý</span>");
    };
    this.real_del = function (id)
    {
        $.ajax({
            url: "index.php/ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_user_del',
                id: id
            },
            success: function (result) {
                selt.selector_act.html(result);
                user.loadlist();
            },
            error: function () {
                alert("không hoàn thành tác vụ !");
            }
        });
    };
    this.setlevel = function (id, l)
    {
        $.ajax({
            url: "index.php/ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_user_setlevel',
                id: id,
                l: l
            },
            success: function (result) {
                tooltip(result, 2000);
                user.loadinfo(id);
            },
            error: function () {
                selt.selector_act("không hoàn thành tác vụ !");
            }
        });
    };
    this.lock = function (id)
    {
        $.ajax({
            url: "index.php/ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_user_lock',
                id: id
            },
            success: function (result) {
                tooltip(result, 2000);
                user.loadinfo(id);
            },
            error: function () {
                selt.selector_act("không hoàn thành tác vụ !");
            }
        });
    };
    this.unlock = function (id)
    {
        $.ajax({
            url: "index.php/ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'admin_user_unlock',
                id: id
            },
            success: function (result) {
                tooltip(result, 2000);
                user.loadinfo(id);
            },
            error: function () {
                selt.selector_act("không hoàn thành tác vụ !");
            }
        });
    };
    this.bonus_score = function ()
    {
        if (this.para.bonusing_score == false)
        {
            this.para.bonusing_score = true;
            var score = $("#admin_user_bonus_score_input").val();
            var id_user = $("#user_info_id").attr('data-id');
            if (score != undefined && score != "")
            {
                var score_note = $("#admin_user_bonus_score_inputcause").val();
                if (score_note == undefined || score_note == null || score_note == false)
                {
                    score_note = "";
                }
                $.ajax({
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data: {
                        type: 'admin_user_bonus_score',
                        score: score,
                        id_user: id_user,
                        score_note: score_note
                    },
                    beforeSend: function () {
                        off_tooltip(-1);
                        tooltip("<i class='fa fa-refresh fa-spin'></i> Đang tiến hành cộng điểm...", -1);
                    },
                    success: function (result) {
                        off_tooltip(-1);
                        tooltip(result, 2000);
                        selt.para.bonusing_score = false;
                        selt.loadinfo(id_user);
                    },
                    error: function () {
                        off_tooltip(-1);
                        selt.selector_act("Không hoàn thành tác vụ !");
                        selt.para.bonusing_score = false;
                    }
                });
            } else {
                off_tooltip(-1);
                tooltip("<span class='stt_mistake'>Dữ liệu nhập không hợp lệ</span>", 2000);
                selt.para.bonusing_score = false;
            }
        } else {
            off_tooltip(-1);
            tooltip("<span class='stt_mistake'>Hãy chờ tác vụ tương tự kết thúc</span>", 2000);
        }
    };
    this.bonus_money = function ()
    {
        if (this.para.bonusing_money == false)
        {
            this.para.bonusing_money = true;
            var score = $("#admin_user_bonus_money_input").val();
            var id_user = $("#user_info_id").attr('data-id');
            if (score != undefined && score != "")
            {
                $.ajax({
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data: {
                        type: 'admin_user_bonus_money',
                        score: score,
                        id_user: id_user
                    },
                    beforeSend: function () {
                        off_tooltip(-1);
                        tooltip("<i class='fa fa-refresh fa-spin'></i> Đang tiến hành cộng tiền...", -1);
                    },
                    success: function (result) {
                        off_tooltip(-1);
                        tooltip(result, 2000);
                        selt.para.bonusing_money = false;
                        selt.loadinfo(id_user);
                    },
                    error: function () {
                        off_tooltip(-1);
                        alert("Không hoàn thành tác vụ !");
                        selt.para.bonusing_money = false;
                    }
                });
            } else {
                off_tooltip(-1);
                tooltip("<span class='stt_mistake'>Dữ liệu nhập không hợp lệ</span>", 2000);
                selt.para.bonusing_money = false;
            }
        } else {
            off_tooltip(-1);
            tooltip("<span class='stt_mistake'>Hãy chờ tác vụ tương tự kết thúc</span>", 2000);
        }
    };
}
var user = "";
$(window).ready(function ()
{
    user = new f_user();
});