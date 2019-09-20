<!DOCTYPE HTML>
<html lang="vi">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>{{page_title}}</title>

        <meta name="dc.language" content="VN"/>
        <meta name="dc.source" content="{{base_url}}"/>
        <meta name="dc.creator" content="{{page_slogend}}" />
        <meta name="distribution" content="Global" />
        <meta name="geo.placename" content="Vietnamese" />
        <meta name="geo.region" content="Vietnamese" />
        <meta name="title" content="{{page_title}}"/>
        <meta name="description" content="{{page_description}}"/>
        <meta name="keywords" content="{{page_keyword}}"/>
        <meta name="news_keywords" content="{{page_keyword}}"/>
        <meta name="author" content="{{page_author}}"/>
        <meta name="robots" content="index, follow"/>
        <meta name='revisit-after' content='1 days'/>
        <meta property="og:locale" content="vi_VN" />
        <meta property="og:site_name" content="{{page_slogend}}" />
        <meta property="og:url" content="{{page_fb_url}}" />
        <meta property="og:type"  content="{{page_fb_type}}" />
        <meta property="og:title"  content="{{page_fb_title}}" />
        <meta property="og:description" content="{{page_fb_description}}" />
        <meta property="og:image" content="{{page_fb_image}}" />

        <meta name='viewport' content="width=device-width,initial-scale=1" />
        <base href="{{base_url}}" />

        <link href='assets/img/system/favico.png' rel="shortcut icon" type="image/png" />
        {{page_css_head_end}}
        {{page_css_custom}}
        {{page_js_head_end}}
    </head>
    <body>
        {{page_js_body_start}}

        {{google_analytic}}
        {{facebook_sdk}}
        {{header_area}}
        <div id="main">
            {{main_dynamic_area}}
            <div class='clear_both'></div>
        </div>
        {{footer_area}}
        
        <div class="align_center align_middle stt_action" id='backtotop_button' onclick='backtotop.active()'>
            <i class="fa fa-chevron-up" title='Lên đầu trang'></i>
        </div>
        {{public_message}}
        <div id="caption"><div class='light_bg'></div><div class='content'></div></div>
        <div id='tooltip'><div class='light_bg'></div><div class='tooltip_content'></div></div>
        <div id='blur_bg'></div>

        <script>
            function get_user_level()
            {
                return {{user_level}}
            }
        </script>
        {{page_js_body_end}}
        {{page_js_custom}}
    </body>
</html>