<?php
    $user_row=$this->UserModel->get_row($idname);
    if($user_row==false)
    {
        echo "Đăng nhập để thực hiện tác vụ";
    }
    else
    {
        echo "<div class='margin_t padding_v'>Chuyển điểm sang tài khoản là hình thức đổi từ điểm sang tài khoản của bạn. Với 1000 điểm bạn sẽ đổi được 10.000vnđ tài khoản.</div>";
        echo "Điểm hiện có : ".valid_money($user_row->m_score)." điểm";
        echo "<div class='margin_t padding_v'>Nhập vào điểm muốn đổi: <input type='number' value='0' min='0' max='".$user_row->m_score."' id='score_into_money_input'><span class='button padding margin_h' onclick='user_action.score_into_money()'>Thực hiện chuyển</span></div>";
    }
?>