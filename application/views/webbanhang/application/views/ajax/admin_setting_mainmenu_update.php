<?php

$id = $this->input->post('id');
if ($this->StaticPageModel->check_exit($id)) {
    if ($this->UserModel->get($idname, 'm_level') > 3) {
        $type2 = $this->input->post('type2');
        $title = $this->input->post('title');
        $title_shorcut = $this->input->post('title_shorcut');
        $link = $this->input->post('link');
        $content = $this->input->post('content');
        $data = $this->input->post('avata');
        $optionshowheader = (int)$this->input->post('optionshowheader');
        $optionshowinheader = (int)$this->input->post('optionshowinheader');
        $optionshowfooter = (int)$this->input->post('optionshowfooter');
        $optionshowinfooter = (int)$this->input->post('optionshowinfooter');
        $optionshowbreakcump = (int)$this->input->post('optionshowbreakcump');
        $optionshowfullshare = (int)$this->input->post('optionshowfullshare');
        $optionshowquickmessage = (int)$this->input->post('optionshowquickmessage');
        $isprimary = (int)$this->input->post('isprimary');
        $adding_css = $this->input->post('adding_css');
        $adding_js = $this->input->post('adding_js');
        

        //ghi vào cơ sở dữ liệu
        $this->StaticPageModel->set($id, 'm_type', $type2);
        $this->StaticPageModel->set($id, 'm_title', $title);
        $this->StaticPageModel->set($id, 'm_title_shorcut', $title_shorcut);
        $this->StaticPageModel->set($id, 'm_link', $link);
        $this->StaticPageModel->set($id, 'm_content', $content);
        $this->StaticPageModel->set($id, 'm_option_showheader', $optionshowheader);
        $this->StaticPageModel->set($id, 'm_option_showinheader', $optionshowinheader);
        $this->StaticPageModel->set($id, 'm_option_showfooter', $optionshowfooter);
        $this->StaticPageModel->set($id, 'm_option_showinfooter', $optionshowinfooter);
        $this->StaticPageModel->set($id, 'm_option_showbreakcump', $optionshowbreakcump);
        $this->StaticPageModel->set($id, 'm_option_showfullshare', $optionshowfullshare);
        $this->StaticPageModel->set($id, 'm_option_showquickmessage', $optionshowquickmessage);
        $this->StaticPageModel->set($id, 'm_adding_css', $adding_css);
        $this->StaticPageModel->set($id, 'm_adding_js', $adding_js);
        if ($isprimary == 1){
            $ar_indexed=$this->StaticPageModel->filter("m_is_primary",1);
            if($ar_indexed!=false)
            {
                $max=count($ar_indexed);
                for($i=0;$i<$max;$i++)
                {
                    $this->StaticPageModel->set($ar_indexed[$i]->id,"m_is_primary",0);
                }
            }
            
            $this->StaticPageModel->set($id,"m_is_primary",1);
        } else {
            
            $this->StaticPageModel->set($id,"m_is_primary",0);
        }
        //ghi file avata
        if ($data != "" && $data != 'undefined') {
            $this->StaticPageModel->set_avata($id, $data);
        }
        echo "Đã cập nhật menu";
    } else {
        echo "Cần quyền quản trị để sửa";
    }
} else {
    echo "Trang không tồn tại để sửa";
}