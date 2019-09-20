<div class='navi_item' id='navi_item_follow'>
    <a class='navi_item_header' href='post/follow_manager' title='Quản lý theo dõi'>
        
        <span class='align_middle'>Đang theo dõi</span>
    </a>
    <div id='post_follow_content' class='navi_submenu padding_l'>
        <div class='padding_b'></div>
        
        <div class='width_30 noresize stt_highlight post_follow_content_label' 
             onclick="$('.post_follow_content_label').removeClass('stt_highlight'); $(this).addClass('stt_highlight'); $('.post_follow_content_item').addClass('hide'); $('#post_follow_content_item_post').removeClass('hide');" title='Nhấn để xem các bài viết bạn đang theo dõi'>Bài viết</div>
        <div class='width_30 noresize post_follow_content_label' 
             onclick="$('.post_follow_content_label').removeClass('stt_highlight'); $(this).addClass('stt_highlight'); $('.post_follow_content_item').addClass('hide'); $('#post_follow_content_item_author').removeClass('hide');" title='Nhấn để xem các tác giả bạn đang theo dõi'>Tác giả</div>
        <div class='width_30 noresize post_follow_content_label' 
             onclick="$('.post_follow_content_label').removeClass('stt_highlight'); $(this).addClass('stt_highlight'); $('.post_follow_content_item').addClass('hide'); $('#post_follow_content_item_type').removeClass('hide');" title='Nhấn để xem các chủ đề bạn đang theo dõi'>Chủ đề</div>
        
        <div class='clear_both'></div>
        
        <div class='post_follow_content_item' id='post_follow_content_item_post'>{{post}}</div>
        <div class='post_follow_content_item hide' id='post_follow_content_item_author'>{{author}}</div>
        <div class='post_follow_content_item hide' id='post_follow_content_item_type'>{{type}}</div>
    </div>
</div>