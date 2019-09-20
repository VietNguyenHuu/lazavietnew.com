//js for post write detail
function f_post_write_detail()
{
    self = this;
    this.selector = {
        commentlist: $('.postwrite_commentlist'),
        commentactionlist: $('.postwrite_commentaction_list'),
        commentactionresult: $('.postwrite_commentaction_result'),
        bnt_postcomment_action: $('.btn_postwrite_commentaction'),
        reportlist: $('.postwrite_reportlist'),
        reportactionlist: $('.postwrite_reportaction_list'),
        reportactionresult: $('.postwrite_reportaction_result'),
        bnt_postreport_action: $('.btn_postwrite_reportaction'),
        btn_checkall: $('.btn_checkall')
    };
    this.recent_id = $(".post_write_detail_id").attr("data-id-post");
    this.page_listcomment = 1;
    this.page_listreport = 1;

    this.load_listcomment = function (p) {
        if (p == undefined || p == "") {
            p = this.page_listcomment;
        } else {
            this.page_listcomment = p;
        }
        $.ajax({
            url: "ajax_center",
            type: "post",
            dateType: "json",
            data: {
                type: 'post_write_detail/load_list_comment',
                id: self.recent_id,
                page: p,

            },
            beforeSend: function () {
                self.selector.commentlist.html("<i class='fa fa-spinner fa-spin'></i> Đang tải danh sách bình luận, xin chờ...");
            },
            success: function (result) {
                self.selector.commentlist.html(result);

            },
            error: function () {
                self.selector.commentlist.html("Không tải được danh sách bình luận bài viết!");
            }
        });
    };
    this.del_comment = function ()
    {
        var c = this.selector.commentlist.find(".postwrite_commentlist_item_checkbox:checked");
        if (c) {
            var ar_del = [];
            $.each(c, function () {
                ar_del.push($(this).parents(".postwrite_commentlist_item").attr('data-id'));
            });
            if (ar_del.length > 0) {
                $.ajax({
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    beforeSend: function () {
                        self.selector.commentactionresult.html("<div class='padding'><i class='fa fa-spinner fa-spin'></i>Đang thực hiện tác vụ...</div>");
                    },
                    data: {
                        type: 'post_write_detail/del_comment',
                        id_comment: ar_del
                    },
                    success: function (result) {
                        self.selector.commentactionresult.html(result);
                        self.load_listcomment();
                    },
                    error: function () {
                        self.selector.commentactionresult.html("Không xóa được bình luận bài viết!");
                    }
                });
            }
        }
    };
    this.load_listreport = function (p) {
        if (p == undefined || p == "") {
            p = this.page_listreport;
        } else {
            this.page_listreport = p;
        }
        $.ajax({
            url: "ajax_center",
            type: "post",
            dataType: "html",
            data: {
                type: 'post_write_detail/load_list_report',
                id: self.recent_id,
                page: p
            },
            beforeSend: function () {
                self.selector.reportlist.html("<i class='fa fa-spinner fa-spin'></i> Đang tải danh sách phản hồi, xin chờ...");
            },
            success: function (result) {
                self.selector.reportlist.html(result);
            },
            error: function () {
                self.selector.reportlist.html("Không tải được danh sách phản hồi bài viết!");
            }
        });
    };
    this.del_report = function ()
    {
        var c = this.selector.reportlist.find(".postwrite_reportlist_item_checkbox:checked");
        if (c) {
            var ar_del = [];
            $.each(c, function () {
                ar_del.push($(this).parents(".postwrite_reportlist_item").attr('data-id'));
            });
            if (ar_del.length > 0) {
                $.ajax({
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    beforeSend: function () {
                        self.selector.reportactionresult.html("<div class='padding'><i class='fa fa-spinner fa-spin'></i>Đang thực hiện tác vụ...</div>");
                    },
                    data: {
                        type: 'post_write_detail/del_report',
                        id_report: ar_del
                    },
                    success: function (result) {
                        self.selector.reportactionresult.html(result);
                        self.load_listreport();
                    },
                    error: function () {
                        self.selector.reportactionresult.html("Không xóa được phản hồi bài viết!");
                    }
                });
            }
        }
    };
    this.selector.bnt_postcomment_action.click(function () {
        var action = self.selector.commentactionlist.find("option:checked");
        if (action) {
            if (action.val() === 'del') {
                self.del_comment();
            }
        }
    });
    this.selector.bnt_postreport_action.click(function () {
        var action = self.selector.reportactionlist.find("option:checked");
        if (action) {
            if (action.val() === 'del') {
                self.del_report();
            }
        }
    });
    this.selector.btn_checkall.mybindcheckall();
    this.load_listcomment();
    this.load_listreport();
}
post_write_detail = "";
$(window).ready(function ()
{
    post_write_detail = new f_post_write_detail();
});