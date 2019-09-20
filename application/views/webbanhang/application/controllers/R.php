<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class R extends CI_Controller 
{
	public function index()
	{
        //config
        $ar_link=Array();
        //end config
        //dành cho quảng cáo
        $count=$this->db->query("SELECT id FROM ".$this->AdvertimentModel->get_table_name()." WHERE m_status='on'")->num_rows();
        $link=$this->db->query("SELECT m_link FROM ".$this->AdvertimentModel->get_table_name()." WHERE m_status='on' ORDER BY id DESC LIMIT ".rand(0,$count-1).",1")->result();
        if(count($link)>0)
        {
            array_push($ar_link,Array('prio'=>50,'link'=>$link[0]->m_link));
        }
        //end dành cho quảng cáo
        //trang chủ
        array_push($ar_link,Array('prio'=>8,'link'=>site_url('')));
        //end trang chủ
        //dành cho bài viết
        $count=$this->db->query("SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE m_id_user_check!=-1")->num_rows();
        $link=$this->db->query("SELECT id FROM ".$this->PostContentModel->get_table_name()." WHERE m_id_user_check!=-1 ORDER BY id DESC LIMIT ".rand(0,$count-1).",1")->result();
        if(count($link)>0)
        {
            array_push($ar_link,Array('prio'=>9,'link'=>$this->PostContentModel->get_link_from_id($link[0]->id)));
        }
        //end dành cho bài viết

        //dành cho loại bài viết
        $count=$this->db->query("SELECT id FROM ".$this->PostTypeModel->get_table_name())->num_rows();
        $link=$this->db->query("SELECT id FROM ".$this->PostTypeModel->get_table_name()." ORDER BY id DESC LIMIT ".rand(0,$count-1).",1")->result();
        if(count($link)>0)
        {
            array_push($ar_link,Array('prio'=>5,'link'=>$this->PostTypeModel->get_link_from_id($link[0]->id)));
        }
        $index_now=0;
        foreach($ar_link as $key=>$line)
        {
            $ar_link[$key]['index_start']=$index_now+1;
            $ar_link[$key]['index_end']=$ar_link[$key]['index_start']+$line['prio'];
            $index_now=$ar_link[$key]['index_end'];
        }
        $index_select=rand(1,$index_now);
        foreach($ar_link as $key=>$line)
        {
            if($line['index_start']<=$index_select&&$line['index_end']>=$index_select)
            {
                redirect($line['link']);
                echo "<a href='".$line['link']."'>nhấn để xem </a>";
            }
        }
    }
}