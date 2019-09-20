<?php
class MY_Loader extends CI_Loader
{
    public function design($design = '', $debug = false)
    {
        if (empty($design)){
            return '';
        }
        
        if (file_exists(DESIGNPATH . $design)){
            return file_get_contents(DESIGNPATH . $design);
        } else if ($debug == true){
            return 'File does not exists !';
        }
    }
}