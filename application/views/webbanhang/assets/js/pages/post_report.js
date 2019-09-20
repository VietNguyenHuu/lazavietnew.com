function f_post_report()
{
    this.sending=false;
    this.send=function()
    {
        if(!this.sending)
        {
            this.sending=true;
            var id_report=$("input[name='post_report_nd_type']:checked").val();
            if(id_report==undefined||id_report==null||id_report==false)
            {
                id_report="-1";
            }
            var ex_report=$("#post_report_nd_extra").val();
            if(ex_report==undefined||ex_report==null||ex_report==false)
            {
                ex_report="";
            }
            var report_post_id=$("#post_report_send_btn").attr("data-post-id");
            if(report_post_id==undefined||report_post_id==false||report_post_id==null)
            {
                report_post_id='-1';
            }
            var report_user=$("select[name='post_report_user_id']").val();
            if(report_user==undefined||report_user==false||report_user==null)
            {
                report_user="-1";
            }
            var s=this;
            $.ajax(
            {
                url : "ajax_center",
                type : "post",
                dateType:"json",
                data : 
                {
                    type:'post_report/send',
                    report_id:id_report,
                    report_ex:ex_report,
                    report_post:report_post_id,
                    report_user:report_user
                },
                success : function (result)
                {
                    dialog("Báo cáo bài viết","<div class='padding_v'>"+result+"</div>");
                    s.sending=false;
                },
                error:function()
                {
                    dialog("Báo cáo bài viết","<div class='padding_v stt_mistake'>Tác vụ thất bại, hãy thực hiện lại sau !</div>");
                    s.sending=false;
                }
            });
        }
    }
}
post_report="";
$(window).ready(function()
{
    post_report=new f_post_report();
});