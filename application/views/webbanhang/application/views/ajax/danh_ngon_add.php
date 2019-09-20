<?php
    $add_nd=$this->input->post("add_nd");
    $add_author=$this->input->post("add_author");
    $add_avata=$this->input->post("add_avata");
    if($add_nd=="")
    {
        echo "<div class='stt_mistake'>Hãy viết nội dung !</div>";
    }
    else
    {
        $add_id=$this->DanhNgonModel->add(Array(
            'content'=>$add_nd,
            'author'=>$add_author
       ));
       if($add_id==false)
       {
            echo "<div class='stt_mistake'>Không thêm được danh ngôn !</div>";
       }
       else
       {
            if($add_avata!=""&&$add_avata!="undefined")
            {
                $this->DanhNgonModel->set_avata($add_id,$add_avata);
            }
            echo "<div class='stt_avaiable'>Đã thêm danh ngôn <span class='stt_tip'>".trichdan($add_nd,200)."</span></div>";
            echo "<div class='stt_tip'>Danh ngôn của bạn sẽ được hiển thị sau khi qua kiểm duyệt !
                <br>Cám ơn bạn đã đóng góp !
            </div>";
            echo "<div class='align_center padding margin_t'><a href='".$this->DanhNgonModel->get_link_from_id($add_id)."' target='_blank'><span class='button padding gray'>Xem trước</span></a><span class='button red padding' onclick='uncaption()'>Đóng</span></div>";
       }
    }
?>