<?php

$post_row = $this->PostContentModel->get_row((int) $this->input->post('id'));
if ($post_row == false) {
    echo "<div class='stt_mistake'>Bài viết không khả dụng</div>";
} else {
    if ($post_row->m_id_user != $idname) {
        echo "<div class='stt_mistake'>Tác vụ không được phép</div>";
    } else {
        $num_report = $this->db->query("SELECT id FROM " . $this->PostReportModel->get_table_name() . " WHERE (m_id_post=" . $post_row->id . ")")->num_rows();
        if ($num_report < 1) {
            echo "<div class='stt_tip padding'>Chưa có phản hồi nào được gởi trong bài viết này</div>";
        } else {
            $page = (int) $this->input->post('page');
            if ($page < 1) {
                $page = 1;
            }
            $phantrang = page_seperator($num_report, $page, 40, Array('class_name' => 'page_seperator_item', 'strlink' => 'javascript:post_write_detail.load_listreport([[pagenumber]])'));
            $list_report = $this->db->query("SELECT * FROM " . $this->PostReportModel->get_table_name() . " WHERE (m_id_post=" . $post_row->id . ") ORDER BY id DESC LIMIT " . $phantrang['start'] . "," . $phantrang['limit'])->result();
            if (count($list_report) < 1) {
                echo "<div class='stt_tip padding'>Chưa có phản hồi nào được gởi trong phân trang này</div>";
            } else {
                echo "<div class='list'>";
                $item_temp = $this->load->design('block/post/write_detail/report_list_item.html');
                foreach ($list_report as $list_report_item) {
                    if ($list_report_item->m_id_user == '-1' || empty($list_report_item->m_id_user)) {
                        $user_realname = 'Khách / Ản danh';
                        $user_link = 'javascript:void(0)';
                    } else {
                        $user_realname = $this->UserModel->get($list_report_item->m_id_user, 'm_realname');
                        $user_link = $this->UserModel->get_link_from_id($list_report_item->m_id_user);
                    }
                    $temp_patern_row = $this->PostReportPatternModel->get_row($list_report_item->m_id_pattern);
                    if ($temp_patern_row == false) {
                        $report_content = '';
                    } else {
                        $report_content = $temp_patern_row->m_title;
                    }
                    if (!empty($list_report_item->m_ex)) {
                        $report_content .= "<span class='stt_tip'> (" . trichdan($list_report_item->m_ex, 50) . ") </span>";
                    }

                    echo mystr()->get_from_template($item_temp, [
                        '{{report_id}}' => $list_report_item->id,
                        '{{report_user_realname}}' => $user_realname,
                        '{{report_user_link}}' => $user_link,
                        '{{report_content}}' => $report_content
                    ]);
                }
                echo "</div>";
                echo "<div class='page_seperator_box align_left'>" . $phantrang['str_link'] . "</div>";
            }
        }
    }
}
?>