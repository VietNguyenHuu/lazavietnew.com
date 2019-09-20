<?php
    if($this->UserModel->check_exit($idname))
    {
        if($this->UserModel->get($idname,"m_level")>3)
        {
            $idmenu=$this->input->post('id');
            $num=$this->input->post('num');
            
            $id_parent=$this->StaticPageModel->get($idmenu,"m_id_parent");
            $ar_id=$this->StaticPageModel->filter("m_id_parent",$id_parent);
            if($ar_id!=false)
            {
                $max=count($ar_id);
                if($num==1)
                {
                    //tiến tới
                    $curent_index=$this->StaticPageModel->get($idmenu,"m_index");
                    if($curent_index<$max)
                    {
                        $idmenu_change=-1;
                        $change_index=-1;
                        for($i=0;$i<$max;$i++)
                        {
                            if($ar_id[$i]->m_index==$curent_index+1)
                            {
                                $idmenu_change=$ar_id[$i]->id;
                                $change_index=$this->StaticPageModel->get($idmenu_change,"m_index");
                                $i=$max;
                            }
                        }
                        $this->StaticPageModel->set($idmenu,"m_index",$change_index);
                        $this->StaticPageModel->set($idmenu_change,"m_index",$curent_index);
                        echo "<div class='stt_avaiable'>Đã di chuyển !</div>";
                    }
                    else
                    {
                        echo "<div class='stt_mistake'>Tác vụ thất bại !</div>";
                    }
                }
                else if($num==-1)
                {
                    //quay lui
                    $curent_index=$this->StaticPageModel->get($idmenu,"m_index");
                    if($curent_index>1)
                    {
                        $idmenu_change=-1;
                        $change_index=-1;
                        for($i=0;$i<$max;$i++)
                        {
                            if($ar_id[$i]->m_index==$curent_index-1)
                            {
                                $idmenu_change=$ar_id[$i]->id;
                                $change_index=$this->StaticPageModel->get($idmenu_change,"m_index");
                                $i=$max;
                            }
                        }
                        $this->StaticPageModel->set($idmenu,"m_index",$change_index);
                        $this->StaticPageModel->set($idmenu_change,"m_index",$curent_index);
                        echo "<div class='stt_avaiable'>Đã di chuyển !</div>";
                    }
                    else
                    {
                        echo "<div class='stt_mistake'>Tác vụ thất bại !</div>";
                    }
                }
                else
                {
                    echo "<div class='stt_mistake'>Tác vụ thất bại !</div>";
                }
            }
            else
            {
                echo "<div class='stt_mistake'>Tác vụ thất bại !</div>";
            }
        }
        else
        {
            echo "Tác vụ thất bại";
        }
    }
?>