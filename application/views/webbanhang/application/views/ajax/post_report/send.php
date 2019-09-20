<?php
    //tiếp nhận phản hồi của người dùng báo cáo sai phạm về một bài viết cụ thể
    $post_row=$this->PostContentModel->get_row((int)$this->input->post("report_post"));
    if($post_row==false)//bài viết không tồn tại
    {
        echo "<div class='stt_mistake'>Bài viết không tồn tại !</div>";
    }
    else
    {
        $report_row=$this->PostReportPatternModel->get_row((int)$this->input->post("report_id"));
        if($report_row==false&&$this->input->post("report_id")!="-1")//Lý do báo cáo không khả dụng
        {
            echo "<div class='stt_mistake'>Lý do báo cáo không khả dụng !</div>";
        }
        else
        {
            if($report_row==false)
            {
                $report_row=-1;
            }
            else
            {
                $report_row=$report_row->id;
            }
            //cho phép ẩn danh hay không
            $user_report_id=-1;//ẩn danh
            if($this->input->post("report_user")!="-1")
            {
                $user_report_id=$idname;//tư cách thành viên
            }
            //lý do thêm
            $report_ex=$this->input->post("report_ex");
            //tiến hành thêm report
            $id_new=$this->PostReportModel->add(Array(
                'id_user'=>$user_report_id,
                'id_post'=>$post_row->id,
                'id_pattern'=>$report_row,
                'ex'=>$report_ex
           ));
           if($id_new==false)
           {
                echo "<div class='stt_mistake'>Không thêm được báo lỗi, hãy thực hiện lại sau !</div>";
           }
           else
           {
                echo "<div class='stt_avaiable'>Đã gởi báo lỗi, cám ơn bạn đã cho chúng tôi biết về điều này.<br>Chúng tôi sẽ xem xét và cải thiện trong thời gian sớm nhất có thể !</div>";
           }
        }
    }
?>