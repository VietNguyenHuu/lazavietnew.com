<?php
    if($this->UserModel->get($idname,"m_level")>3)
    {
        $idtype=$this->input->post('id');
        $num=$this->input->post('num');
        
        $id_parent=$this->PostTypeModel->get($idtype,"m_id_parent");
        $ar_id=$this->PostTypeModel->filter("m_id_parent",$id_parent);
        if($ar_id!=false)
        {
            $max=count($ar_id);
            if($num==1)
            {
                //tiến tới
                $curent_index=$this->PostTypeModel->get($idtype,"m_index");
                if($curent_index<$max)
                {
                    $idtype_change=-1;
                    $change_index=-1;
                    for($i=0;$i<$max;$i++)
                    {
                        if($ar_id[$i]->m_index==$curent_index+1)
                        {
                            $idtype_change=$ar_id[$i]->id;
                            $change_index=$this->PostTypeModel->get($idtype_change,"m_index");
                            $i=$max;
                        }
                    }
                    $this->PostTypeModel->set($idtype,"m_index",$change_index);
                    $this->PostTypeModel->set($idtype_change,"m_index",$curent_index);
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
                $curent_index=$this->PostTypeModel->get($idtype,"m_index");
                if($curent_index>1)
                {
                    $idtype_change=-1;
                    $change_index=-1;
                    for($i=0;$i<$max;$i++)
                    {
                        if($ar_id[$i]->m_index==$curent_index-1)
                        {
                            $idtype_change=$ar_id[$i]->id;
                            $change_index=$this->PostTypeModel->get($idtype_change,"m_index");
                            $i=$max;
                        }
                    }
                    $this->PostTypeModel->set($idtype,"m_index",$change_index);
                    $this->PostTypeModel->set($idtype_change,"m_index",$curent_index);
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
?>