<?php

if ($this->UserModel->get($idname, 'm_level') > 3) {
    $data_type = $this->input->post('data_type');
    $temp_tg = TimeHelper();
    
    $temp_w = [];
    if ($data_type == 'year') {
        array_push($temp_w, 'm_year = ' . $temp_tg->_nam);
        
    } else if ($data_type == 'month') {
        array_push($temp_w, 'm_year = ' . $temp_tg->_nam);
        array_push($temp_w, 'm_month = ' . $temp_tg->_thang);
        
    } else if ($data_type == 'date') {
        array_push($temp_w, 'm_year = ' . $temp_tg->_nam);
        array_push($temp_w, 'm_month = ' . $temp_tg->_thang);
        array_push($temp_w, 'm_date = ' . $temp_tg->_ngay);
        
    } else if ($data_type == 'custom') {
        $data_y = $this->input->post('data_y');
        $data_m = $this->input->post('data_m');
        $data_d = $this->input->post('data_d');
        
        if ($data_y != 'all'){
            array_push($temp_w, 'm_year = ' . $data_y);
        }
        if ($data_m != 'all'){
            array_push($temp_w, 'm_month = ' . $data_m);
        }
        if ($data_d != 'all'){
            array_push($temp_w, 'm_date = ' . $data_d);
        }
    } 
    if (! empty($temp_w)){
        $temp_sql = "SELECT * FROM " . $this->StatisticAccessModel->get_table_name() . " WHERE ({{where}}) ORDER BY id ASC";
        $h_data = $this->db->query(mystr()->get_from_template($temp_sql, ['{{where}}' => implode(" AND ", $temp_w)]))->result();
    } else {
        $h_data = $this->StatisticAccessModel->getAll();
    }
    
    if ($h_data !== false) {
        $max = count($h_data);
        $str = "Date,Total_access\n";
        for ($i = 0; $i < $max; $i++) {
            $str .= $h_data[$i]->m_year . "/" . $h_data[$i]->m_month . "/" . $h_data[$i]->m_date . " " . $h_data[$i]->m_hour . ":00," . $h_data[$i]->m_total . "\n";
        }
        echo $str;
    }
}