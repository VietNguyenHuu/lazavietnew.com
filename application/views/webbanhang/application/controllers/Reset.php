<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reset extends MY_Controller {

    public function index() {
        $this->_data['page_title'] = "Reset website";
        $this->_data['page_keyword'] = "Reset website";
        $this->_data['page_description'] = "Reset website";
        $this->_data['page_fb_title'] = "";
        $this->_data['page_fb_description'] = "";
        $this->_data['page_fb_image'] = "";
        $this->_data['page_option_showanalytic'] = false;
        $this->_data['page_option_showpublicmessage'] = false;
        $this->_data['page_option_showheader'] = false;
        $this->_data['page_option_showfooter'] = false;
        $ar_model = [
            'AdvertimentModel',
            'CacheModel',
            'ContributeModel',
            'PostAuthorModel',
            'PostCommentModel',
            'PostContentModel',
            'PostFollowModel',
            'PostGroupModel',
            'PostReportModel',
            'PostReportPatternModel',
            'PostTagsModel',
            'PostTypeModel',
            'PostViewModel',
            'PublicMessageModel',
            'StaticPageModel',
            'StatisticAccessModel',
            'SystemModel',
            'SystemParamModel',
            'TinNhanModel',
            'UserModel',
        ];
        if (!empty($ar_model)) {
            foreach ($ar_model as $modelline) {
                $this->load->model($modelline);
            }
        }
        $this->_data['data'] = ['ar_model' => $ar_model];
        $this->autorenderview('reset/index');
    }

}
