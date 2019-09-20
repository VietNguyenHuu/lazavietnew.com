function f_post()
{
    this.islike = false;
    this.isfollow = false;
    this.isfollowauthor = false;
    this.id = $("#post_recent_content_id").html();
    this.like = function (id)
    {
        if (this.islike == false)
        {
            this.islike = true;
            $.ajax(
                    {
                        url: "ajax_center",
                        type: "post",
                        dateType: "json",
                        data:
                                {
                                    type: 'post_like',
                                    id: id
                                },
                        success: function (result)
                        {
                            $("#post_content_like_count").html(result);
                        },
                        error: function ()
                        {
                            tooltip("Sự cố mạng", 2000);
                        }
                    });
            return true;
        }
        return false;
    }
    this.follow = function (id)
    {
        if (this.isfollow == false)
        {
            this.isfollow = true;
            var self = this;
            $.ajax(
                    {
                        url: "ajax_center",
                        type: "post",
                        dateType: "json",
                        data:
                                {
                                    type: 'post_follow',
                                    id: id
                                },
                        success: function (result)
                        {
                            $("#post_content_follow_count").html(result);
                        },
                        error: function ()
                        {
                            self.isfollow = false;
                            tooltip("Sự cố mạng", 2000);
                        }
                    });
            return true;
        }
        return false;
    }
    this.follow_author = function (id)
    {
        if (this.isfollowauthor == false)
        {
            this.isfollowauthor = true;
            var self = this;
            $.ajax(
                    {
                        url: "ajax_center",
                        type: "post",
                        dateType: "json",
                        data:
                                {
                                    type: 'post_follow_author',
                                    id: id
                                },
                        success: function (result)
                        {
                            $("#post_content_follow_author_count").html(result);
                        },
                        error: function ()
                        {
                            self.isfollowauthor = false;
                            tooltip("Sự cố mạng", 2000);
                        }
                    });
            return true;
        }
        return false;
    }
    this.rank = function (id, rank, reloadpage)
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'post_rank',
                                id: id,
                                rank: rank
                            },
                    success: function (result)
                    {
                        if (reloadpage == true)
                        {
                            window.location = location.href;
                        } else
                        {
                            //
                        }
                    },
                    error: function ()
                    {
                        tooltip("Sự cố mạng", 2000);
                    }
                });
    }
    this.rank_comment = function (id, rank, id_post)
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'post_rank_comment',
                                id: id,
                                rank: rank
                            },
                    success: function (result)
                    {
                        tooltip("<div class='stt_avaiable'>Bạn đã dánh giá " + rank + " sao</div>", 2000);
                        post.updatecomment(id_post);
                    },
                    error: function ()
                    {
                        tooltip("Sự cố mạng", 2000);
                    }
                });
    }
    this.sendcomment = function (id)
    {
        if ($("textarea[name='post_detailcontent_comment_form']").val() == "" || $("textarea[name='post_detailcontent_comment_form']").val() == undefined)
        {
            tooltip("<span class='mistake'>Hãy nhập vào phản hồi</span>", 2000);
            return false;
        }
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'post_sendcomment',
                                id: id,
                                content: $("textarea[name='post_detailcontent_comment_form']").val()
                            },
                    success: function (result)
                    {
                        tooltip(result, 2000);
                        $("textarea[name='post_detailcontent_comment_form']").val(null);
                        post.updatecomment(id);
                    },
                    error: function ()
                    {
                        tooltip("Sự cố mạng", 2000);
                    }
                });
    }
    this.updatecomment = function (id, comment_type)//comment_type hoặcc là "" hoặc là "by_rank" nếu muốn thứ tự theo xêp hạng
    {
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'post_updatecomment',
                                id: id,
                                comment_type: comment_type
                            },
                    success: function (result)
                    {
                        $(".post_detailcontent_comment>div.c").html(result);
                    },
                    error: function ()
                    {
                        tooltip("Sự cố mạng", 2000);
                    }
                });
    }
    this.del_comment = function (id)
    {
        dialog("Bạn chắc chắn muốn xóa bình luận này ?", "<div class='align_center padding' style='margin:2em 0px;'><span class='button padding' onclick='post.real_del_comment(" + id + ")'>Đồng ý xóa</span><span class='button padding red' onclick='uncaption()'>Không đồng ý</span>");
    }
    this.real_del_comment = function (id)
    {
        uncaption(-1);
        $.ajax(
                {
                    url: "ajax_center",
                    type: "post",
                    dateType: "json",
                    data:
                            {
                                type: 'post_delcomment',
                                id: id
                            },
                    success: function (result)
                    {
                        tooltip(result, 2000);
                        post.updatecomment(post.id);
                    },
                    error: function ()
                    {
                        tooltip("Sự cố mạng", 2000);
                    }
                });
    }
}
function post_startloadjs()
{
    post = new f_post();
    post.updatecomment(post.id);
    $("#search").attr('action', 'post/search');
    $("#search").attr('method', 'get');
    $("#search input[name='search_input']").attr('placeholder', 'Tìm bài viết...');

    $(".post_content_nd_item img[data-original]").lazyload();
    $("div.post_content_navi img[data-original]").lazyload();
    
}
post = "";
$(window).ready(function ()
{
    post_startloadjs();
});