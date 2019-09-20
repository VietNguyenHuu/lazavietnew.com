<?php
    $user_row=$this->UserModel->get_row($idname);
    if($user_row==false)
    {
        echo "<div class='stt_mistake'>Đăng nhập để thực hiện tác vụ</div>";
    }
    else
    {
        $score=(int)$this->input->post('score');
        if($score<0)
        {
            echo "<div class='stt_mistake'>Số điểm nhập vào để chuyển phải nhiều hơn 0 điểm</div>";
        }
        else if($score>$user_row->m_score)
        {
            echo "<div class='stt_mistake'>Số điểm nhập vào để chuyển phải ít hơn số điểm hiện tại (".valid_money($user_row->m_score).")</div>";
        }
        else
        {
            $new_money=$this->UserModel->bonus_money($idname,$score*10);
            if($new_money==false)
            {
                echo "<div class='stt_mistake'>Tác vụ thất bại, hãy thực hiện lại sau</div>";
            }
            else
            {
                $new_score=$this->UserModel->bonus_score($idname,(-1)*$score);
                echo "<div class='stt_avaible'>Đã thực hiện chuyển ".valid_money($score)." điểm thành ".valid_money($score*10)." vnđ cộng vào tài khoản</div>";
                echo "<div class='margin_t'>Tài khoản hiện có: ".valid_money($new_money)." vnđ, Điểm thưởng hiện có: ".valid_money($new_score)." điểm</div>";
                
            }
            
        }
    }
    echo "<div class='padding align_right margin'><span class='button padding red' onclick='uncaption()'>Đóng</span></div>";
?>