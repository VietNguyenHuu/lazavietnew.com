<?php
    if(isset($type))
    {
        if(file_exists(VIEWPATH . "ajax/" . $type . ".php"))
        {
            $data=Array(
                'idname'=>$idname
           );
            $this->load->view('ajax/' . $type, $data);
        }
    }
?>