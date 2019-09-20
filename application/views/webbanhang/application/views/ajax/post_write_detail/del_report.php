<?php

$ar_del = $this->input->post('id_report');
if (!empty($ar_del)) {
    if (is_array($ar_del)) {
        foreach ($ar_del as $ar_del_item) {
            $report_row = $this->PostReportModel->get_row($ar_del_item);
            if ($report_row != false) {
                $post_row = $this->PostContentModel->get_row($report_row->m_id_post);
                if ($post_row != false) {
                    if ($post_row->m_id_user == $idname) {
                        $this->PostReportModel->del($report_row->id);
                    }
                }
            }
        }
        echo "<div class='padding bg_success stt_white margin_v'>Đã xóa " . count($ar_del) . " phản hồi bài viết</div>";
    }
}