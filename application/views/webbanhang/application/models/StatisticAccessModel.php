<?php

defined('BASEPATH')or exit('no access script');
?>
<?php

class StatisticAccessModel extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'statistic_access';
        $this->_list_field = Array(
            'id', 'm_year', 'm_month', 'm_date', 'm_hour',
            'm_total'
        );
        $this->_primary_field = 'id';
    }

    public function add($data = Array(
        'year' => -1,
        'month' => -1,
        'date' => -1,
        'hour' => -1
    )) {
        $add = array(
            'id' => $this->SystemModel->get_id(),
            'm_year' => $data['year'],
            'm_month' => $data['month'],
            'm_date' => $data['date'],
            'm_hour' => $data['hour'],
            'm_total' => 1
        );
        parent::add($add);
        if ($this->check_exit($add['id'])) {
            return $add['id'];
        }
        return false;
    }

    public function access($y, $m, $d, $h) {
        $id = $this->get_id($y, $m, $d, $h);
        if ($id !== false) {
            $new = $this->get($id, 'm_total') + 1;
            $this->set($id, 'm_total', $new);
            return $new;
        } else {
            $status = $this->add(Array(
                'year' => $y,
                'month' => $m,
                'date' => $d,
                'hour' => $h
            ));

            if ($status == false) {
                return false;
            }
            return 1;
        }
    }

    public function get_id($y, $m, $d, $h) {
        $sql = "SELECT id FROM " . $this->get_table_name() . " WHERE (m_year=" . $y . " AND m_month=" . $m . " AND m_date=" . $d . " AND m_hour=" . $h . ")";
        $k = $this->db->query($sql);
        if ($k->num_rows() > 0) {
            return $k->result()[0]->id;
        } else {
            return false;
        }
    }

}
