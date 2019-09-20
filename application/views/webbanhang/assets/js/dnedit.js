function dnedit(o)
{
    dnedit_0=this;
    this.option = {
        selector_box:$(o.selector_box),
        selector_btn:$(o.selector_btn),
        selector_temp:$(o.selector_temp)
    };
    this.init=function()
    {
        if(this.option.selector_btn==false||this.option.selector_btn==undefined)
        {
            return false;
        }
        if(this.option.selector_box==false||this.option.selector_box==undefined)
        {
            return false;
        }
        this.option.selector_btn.click(function()
        {
            dnedit_0.load_list_action();
        });
    }
    this.load_list_action=function()
    {
        var str="<div class='width_40 padding'><span class='button padding fontsize_d2' onclick='dnedit_0.load_table()'><i class='fa fa-table'></i> Bảng</span></div>";
        str+="<div class='width_40 padding'><span class='button padding fontsize_d2 red' onclick='dnedit_0.off_dialog()'><i class='fa fa-times'></i> Hủy</span></div>";
        str+="<div class='clear_both'></div>";
        this.dialog("Chức năng mở rộng","<div class='padding'>"+str+"</div>");
    }
    this.load_table=function()
    {
        var str="Số hàng <input type='number' value='2' id='dnedit_input_table_row'> Số cột <input type='number' value='2' id='dnedit_input_table_col'> <span class='button padding' onclick='dnedit_0.draw_table()'>Vẽ</span> <span class='button padding' onclick='dnedit_0.output_table()'>Hoàn tất</span> <span class='button padding red' onclick='dnedit_0.load_list_action()'>Hủy</span>";
        str+="<div class='clear_both'></div>";
        str+="<div class='margin_v' id='dnedit_input_table_data'><span class='stt_tip'>Chọn số hàng, số cột để vẽ bảng !</span></div>";
        str+="<div class='clear_both'></div>";
        this.dialog("Chức năng mở rộng / bảng","<div class='padding'>"+str+"</div>");
    }
    this.draw_table=function()
    {
        var dnedit_var_row=$("#dnedit_input_table_row").val();
        if(dnedit_var_row==undefined||dnedit_var_row==""||dnedit_var_row<1)
        {
            tooltip("<span class='stt_mistake fontsize_d2'>Nhập vào số hàng !</span>");
            return false;
        }
        var dnedit_var_col=$("#dnedit_input_table_col").val();
        if(dnedit_var_col==undefined||dnedit_var_col==""||dnedit_var_col<1)
        {
            tooltip("<span class='stt_mistake fontsize_d2'>Nhập vào số cột !</span>");
            return false;
        }
        var dnedit_var_str="<table class='table_basic'><tr>";
        for(var c=1;c<=dnedit_var_col;c++)
        {
            dnedit_var_str+="<th>tiêu đề "+c+"</th>";
        }
        dnedit_var_str+="</tr>";
        for(var r=1;r<=dnedit_var_row;r++)
        {
            dnedit_var_str+="<tr>";
            for(var c=1;c<=dnedit_var_col;c++)
            {
                dnedit_var_str+="<td>"+r+"_"+c+"</td>";
            }
            dnedit_var_str+="</tr>";
        }
        dnedit_var_str+="</table>";
        $("#dnedit_input_table_data").html(dnedit_var_str);
    }
    this.output_table=function()
    {
        this.option.selector_box.append($("#dnedit_input_table_data").html());
        this.load_list_action();
    }
    this.dialog=function(h,c)
    {
        this.option.selector_temp.html("<div class='padding'>"+h+"</div>"+"<div class='padding'>"+c+"</div>");
    }
    this.off_dialog=function()
    {
        this.option.selector_temp.html("");
    }
    this.init();
}