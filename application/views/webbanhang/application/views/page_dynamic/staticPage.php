<?php

$page_id = $data['id_page'];
$staticpage_row = $data['staticpage_row'];

$breakcump = "";
if ($staticpage_row->m_option_showbreakcump == 1) {
    $static_page = $this->StaticPageModel;
    $data = $static_page->getAll();
    if ($data != false) {

        function idtostt($in, $dt) {
            $maxdt = count($dt);
            for ($i = 0; $i < $maxdt; $i++) {
                if ($dt[$i]->id == $in) {
                    return $i;
                }
            }
            return -1;
        }

        $pr = $page_id;
        do {
            $stt = idtostt($pr, $data);
            if ($stt != -1) {
                if ($static_page->get($data[$stt]->id, 'm_type') == 'system') {
                    $act = $data[$stt]->m_link;
                } else {
                    $act = site_url('staticPage/index/' . $data[$stt]->id);
                }
                $breakcump = ""
                        . "<span class='stt_tip'>/</span> "
                        . "<a href='" . $act . "'>" . $data[$stt]->m_title . "</a>"
                        . $breakcump;
                $pr = $data[$stt]->m_id_parent;
            }
        } while ($pr != 1);

        $breakcump = mystr()->get_from_template(
                $this->load->design('block/staticPage/breakcump.html'), [
            '{{breakcump}}' => $breakcump
                ]
        );
    }
}

$fullshare = '';
if ($staticpage_row->m_option_showfullshare == 1) {
    $fullshare = get_str_like_full($page_fb_url);
}

echo mystr()->get_from_template(
        $this->load->design('block/staticPage/main.html'), [
    '{{breakcump}}' => $breakcump,
    '{{content}}' => $staticpage_row->m_content,
    '{{fullshare}}' => $fullshare
        ]
);
