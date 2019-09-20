<?php

class Visyntax
{
    private $_pa = [];
    private $_na = [];
    private $_pa2 = [];
    public function __construct() {
        $this->_pa = [
            'ngh' => '*',
            'gh' => '*',
            'nh' => '*',
            'ng' => '*',
            'ph' => '*',
            'th' => '*',
            'tr' => '*',
            'ch' => '*',
            'b' => '*',
            'c' => '*',
            'd' => '*',
            'đ' => '*',
            'đ' => '*',
            'g' => '*',
            'h' => '*',
            'k' => '*',
            'l' => '*',
            'm' => '*',
            'n' => '*',
            'p' => '*',
            'q' => '*',
            'r' => '*',
            's' => '*',
            't' => '*',
            'v' => '*',
            'x' => '*',
            'y' => '*'
            
        ];
        
        $this->_na = [
            'uyê' => '*',
            
            'ai' => '*',
            'ao' => '*',
            'au' => '*',
            'ay' => '*',
            
            'âu' => '*',
            'ây' => '*',
            
            'eo' => '*',
            
            'êu' => '*',
            
            'oa' => '*',
            'oi' => '*',
            
            'ôi' => '*',
            
            'ơi' => '*',
            
            'ia' => '*',
            'iê' => '*',
            'iu' => '*',
            
            'ua' => '*',
            'ui' => '*',
            'uy' => '*',
            
            'ưa' => '*',
            'ươ' => '*',
            'ưi' => '*',
            'ưu' => '*',
            
            'yê' => '*',
            
            'a' => '*',
            'ă' => '*',
            'â' => '*',
            
            'e' => '*',
            'ê' => '*',
            
            'o' => '*',
            'ô' => '*',
            'ơ' => '*',
            
            'i' => '*',
            
            'u' => '*',
            'ư' => '*',
            
            'y' => '*'
            
        ];
        
        $this->_pa2 = [
            'nh' => '*',
            'ng' => '*',
            'ch' => '*',
            'c' => '*',
            'm' => '*',
            'n' => '*',
            't' => '*',
            'p' => '*'          
        ];
    }
    
    public function parseWord($w = 'nguyễn'){
        $ar = [
            'pa' => '',
            'na' => '',
            'pa2' => ''
        ];
        foreach ($this->_pa as $key => $value){
            $patern = "/^" . $key . "/";
            $split = preg_split($patern, $w);
            if (count($split) > 1){
                $w = $split[1];
                $ar['pa'] = $key;
                break;
            }
        }
        foreach ($this->_pa2 as $key => $value){
            $patern = "/" . $key . "$/";
            $split = preg_split($patern, $w);
            if (count($split) > 1){
                $w = $split[0];
                $ar['pa2'] = $key;
                break;
            }
        }
        $ar['na'] = $w;
        return $ar;
    }
}