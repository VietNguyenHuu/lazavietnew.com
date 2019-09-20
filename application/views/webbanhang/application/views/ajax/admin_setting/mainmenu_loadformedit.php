<?php

$id = $this->input->post('id');
$line = $this->StaticPageModel->get_row($id);
if ($line != false) {
    if ($this->UserModel->get($idname, 'm_level') > 3) {
        $typeitem = "";

        foreach ($this->StaticPageModel->label_type() as $key => $value) {
            $temp = "";
            if ($key == $this->StaticPageModel->get($id, 'm_type')) {
                $temp = "selected='selected'";
            }
            $typeitem .= "<option value='" . $key . "' " . $temp . ">" . $value . "</option>";
        }
        echo mystr()->get_from_template(
                $this->load->design('block/admin/setting/staticPage_form_edit.html'), [
            '{{title}}' => str_to_view($line->m_title),
            '{{title_shorcut}}' => str_to_view($line->m_title_shorcut),
            '{{typeitems}}' => $typeitem,
            '{{url}}' => $line->m_link,
            '{{avata}}' => $this->StaticPageModel->get_avata($id),
            '{{id}}' => $line->id,
            '{{content}}' => $line->m_content,
            '{{OptionShowheader}}' => ($line->m_option_showheader == 1) ? "checked" : '',
            '{{OptionShowinheader}}' => ($line->m_option_showinheader == 1) ? "checked" : '',
            '{{OptionShowinfooter}}' => ($line->m_option_showinfooter == 1) ? "checked" : '',
            '{{OptionShowfooter}}' => ($line->m_option_showfooter == 1) ? "checked" : '',
            '{{OptionShowbreakcump}}' => ($line->m_option_showbreakcump == 1) ? "checked" : '',
            '{{OptionShowfullshare}}' => ($line->m_option_showfullshare == 1) ? "checked" : '',
            '{{OptionShowquickmessage}}' => ($line->m_option_showquickmessage == 1) ? "checked" : '',
            '{{isprimary}}' => ($line->m_is_primary == 1) ? "checked" : '',
            '{{adding_css}}' => $line->m_adding_css,
            '{{adding_js}}' => $line->m_adding_js,
        ]);
    } else {
        echo "Cần quyền quản trị để sửa trang";
    }
} else {
    echo "Trang không tồn tại";
}