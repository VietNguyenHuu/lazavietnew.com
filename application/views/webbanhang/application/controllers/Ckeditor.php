<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ckeditor extends CI_Controller 
{
	public function index($page=1)
	{
       echo "{url:'return.png'}";
    }
    public function imageUpload()
    {
        $data=$this->input->post('filedata');
    	$data=explode(";base64,",$data);
        if(count($data)>1)
        {
            $data=$data[1];
        	$data=base64_decode($data);
        	$str="";
        	if($data!=""&&$data!='undefined')
        	{
                $unique=uniqid();
                $temp="assets/img/ckeditor/".$unique;
                file_put_contents($temp,$data);
                
                if(file_exists($temp))
                {
                    $image=image_helper()->get_image_data($temp);
                    if($image['type']!=false)
                    {
                        $name=strtolower($this->input->post('filename'));
                        $name_ar=explode(".",$name);
                        if(count($name_ar)>1)
                        {
                            $name=str_replace(".".$name_ar[1],"",$name);
                        }
                        $name=dn_urlencode($name,100);
                        
                        $save="assets/img/ckeditor/".$name."_".$unique.".".$image['type'];
                        rename($temp,$save);
                        $str.=str_to_view($save,false);
                    }
                    else
                    {
                        unlink($temp);
                    }
                }
        	}
        	echo $str;
        }
    }
    public function embed_provider()
    {
        echo 1;
    }
}