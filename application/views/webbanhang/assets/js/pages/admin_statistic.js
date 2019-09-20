/*js for statistic*/
function f_statistic()
{
    selt = this;
    this.selector = document.getElementById("admin_statistic_access");
    this.data = document.getElementById("admin_statistic_access_data").innerHTML;
    this.type = 'date';//all,year,month,date
    this.custom_confirm = false;
    this.custom_y = 'all';
    this.custom_m = 'all';
    this.custom_d = 'all';
    this.draw_access = function ()
    {
        var g = new Dygraph(this.selector, this.data);
        this.custom_confirm = false;
    };
    
    this.refresh = function (type){
        selt = this;
        if (type == 'custom' && this.custom_confirm == false) {
            this.loadform_custom();
            return;
        }
        if (type == 'all') {
            this.type = 'all';
        } else if (type == 'year') {
            this.type = 'year';
        } else if (type == 'month') {
            this.type = 'month';
        } else if (type == 'date') {
            this.type = 'date';
        } else if (type == 'custom') {
            this.type = 'custom';
        }
        
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            beforeSend: function ()
            {
                tooltip("<i class='fa fa-refresh fa-spin'></i> Đang cập nhật...", -1);
            },
            data: {
                type: 'admin_statistic_refresh',
                data_type: this.type,
                data_y : this.custom_y,
                data_m : this.custom_m,
                data_d : this.custom_d
            },
            success: function (result)
            {
                selt.data = result;
                selt.draw_access();
                off_tooltip(-1);
            },
            error: function ()
            {
                alert("Sự cố mạng, không tải được dữ liệu!");
                off_tooltip(-1);
            }
        });
    };
    
    this.loadform_custom = function(){
        var id = Math.floor(Date.now());
        var str = ''
        + '<div class="margin_v">'
        +       "<select class = 'y'></select>"
        + '</div>'
        + '<div class="margin_v">'
        +       "<select class = 'm'></select>"
        + '</div>'
        + '<div class="margin_v">'
        +       "<select class = 'd'></select>"
        + '</div>'
        + "<div class='margin_t1em padding_v'>"
        +       "<span class = 'button padding fontsize_d2 s'>Xem thống kê</span>"
        + '</div>'
        ;
        dialog("Chọn thời gian", "<div id='id_" + id + "'>" + str + "</div>");
        var di = $("#id_" + id);
        var y = di.find(".y");
        var m = di.find(".m");
        var d = di.find(".d");
        var s = di.find(".s");
        
        y.append("<option value='all'>All year</option>");
        m.append("<option value='all'>All month</option>");
        d.append("<option value='all'>All date</option>");
        
        var crd = new Date();
        for (var yr = crd.getFullYear(); yr > 2000; yr --){
            y.append("<option value='" + yr + "'>" + yr + "</option>");
        }
        
        for (var mr = 1; mr < 13; mr ++){
            m.append("<option value='" + mr + "'>" + mr + "</option>");
        }
        
        for (var dr = 1; dr < 32; dr ++){
            d.append("<option value='" + dr + "'>" + dr + "</option>");
        }
        var cseft = this;
        s.click(function(){
            cseft.custom_confirm = true;
            cseft.custom_y = y.find(":selected").val();
            cseft.custom_m = m.find(":selected").val();
            cseft.custom_d = d.find(":selected").val();
            cseft.refresh('custom');
        });
    };
    
    $('.admin_statistic_type').click(function ()
    {
        $('.admin_statistic_type').addClass('disable');
        $(this).removeClass('disable');
        selt.refresh($(this).attr('data-type'));
    });
    
    $("#admin_statistic_refresh_btn").click(function ()
    {
        selt.refresh();
    });
}
statistic = "";
$(window).ready(function () {
    $("#main .admin_statistic_user_new img.lazyload").lazyload();
    $("#main .admin_statistic_user_online img.lazyload").lazyload();
    $("#main .admin_statistic_post_new img.lazyload").lazyload();
    $("#main .admin_statistic_post_new_comment img.lazyload").lazyload();
    statistic = new f_statistic();
    statistic.refresh();
});