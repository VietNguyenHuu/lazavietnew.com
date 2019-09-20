<?php
    //class phục vụ cho việc phân trang
    class page_separater
    {
        private $_recent_page=0;//trang hiện tại
        private $_item_per_page=0;//số mục trên một trang
        private $_total_item=0;//tổng số mục
        
        private $_total_page=0;//tổng số trang, bắt đầu là 1
        private $_prev_page=false;//trang trước
        private $_next_page=false;//trang sau
        private $_ar_page=Array();//danh sách trang sẽ đưa ra hiển thị
        private $_totalitem_in_ar_page=0;//tổng số mục trong danh sách trang đưa ra hiển thị
        private $_start=0;//vị trí mục bắt đầu hiển thị tính từ 0
        private $_limit=0;//tổng số mục lấy ra, bắt đầu từ 1
        private $_str_link='';//chuỗi liên kết phân trang

        public function process($total_item,$recent_page,$item_per_page,$option_link=Array('class_name'=>'page_seperator_item','strlink'=>'#[[pagenumber]]'))
        {
            //gán dữ liệu
            $this->_total_item=$total_item;
            $this->_item_per_page=$item_per_page;
            //tính tổng số trang
            $this->_total_page=chianguyen($this->_total_item,$this->_item_per_page);
            if($this->_total_item % $this->_item_per_page != 0)
            {
                $this->_total_page ++;
            }
            //fix và gán lại trang hiện tại
            if($recent_page<1)
            {
                $this->_recent_page=1;
            }
            else if($recent_page>$this->_total_page)
            {
                $this->_recent_page=$this->_total_page;
            }
            else
            {
                $this->_recent_page=$recent_page;
            }
            //xác định trang trước và sau
            if($this->_recent_page>1)
            {
                $this->_prev_page=$this->_recent_page-1;
            }
            else
            {
                $this->_prev_page=false;
            }
            if($this->_recent_page<$this->_total_page)
            {
                $this->_next_page=$this->_recent_page+1;
            }
            else
            {
                $this->_next_page=false;
            }
            //tính vị trí mục bắt đầu, dựa vào trang hiện tại, số sp trên 1 trang
            $this->_start=($this->_recent_page-1)*$this->_item_per_page;
            //tính tổng số mục lấy ra, dựa và mục bắt đầu, trang hiện tại, và tỏng số mục, tổng số trang
            if($this->_recent_page<$this->_total_page)
            {
                $this->_limit=$this->_item_per_page;
            }
            else
            {
                $this->_limit=$this->_total_item-$this->_start;
            }
            //tính danh sách trang đưa ra hiển thị
            //thêm 10 trang xung quanh trang hiện tại
            $l=$this->_recent_page-5;
            if($l<1)
            {
                $l=1;
            }
            $r=$l+10;
            if($r>$this->_total_page)
            {
                $r=$this->_total_page;
            }
            for($i=$l;$i<=$r;$i++)
            {
                array_push($this->_ar_page,$i);
            }
            //Thêm 10 chục trang xung quanh chục trang hiện tại
            $l=chianguyen($this->_recent_page,10)-50;
            if($l<1)
            {
                $l=0;
            }
            $r=$l+100;
            if($r>$this->_total_page)
            {
                $r=$this->_total_page;
            }
            for($i=$l;$i<=$r;$i=$i+10)
            {
                if($i==0)
                {
                    $temp=1;
                }   
                else
                {
                    $temp=$i;
                }
                if(!in_array($temp,$this->_ar_page))
                {
                    array_push($this->_ar_page,$temp);
                }
            }
            //Thêm 10 trăm trang xung quanh trăm trang hiện tại
            $l=chianguyen($this->_recent_page,100)-500;
            if($l<1)
            {
                $l=0;
            }
            $r=$l+1000;
            if($r>$this->_total_page)
            {
                $r=$this->_total_page;
            }
            for($i=$l;$i<=$r;$i=$i+100)
            {
                if($i==0)
                {
                    $temp=1;
                }   
                else
                {
                    $temp=$i;
                }
                if(!in_array($temp,$this->_ar_page))
                {
                    array_push($this->_ar_page,$temp);
                }
            }
            //Thêm 10 ngàn trang xung quanh ngàn trang hiện tại
            $l=chianguyen($this->_recent_page,1000)-5000;
            if($l<1)
            {
                $l=0;
            }
            $r=$l+10000;
            if($r>$this->_total_page)
            {
                $r=$this->_total_page;
            }
            for($i=$l;$i<=$r;$i=$i+1000)
            {
                if($i==0)
                {
                    $temp=1;
                }   
                else
                {
                    $temp=$i;
                }
                if(!in_array($temp,$this->_ar_page))
                {
                    array_push($this->_ar_page,$temp);
                }
            }
            //Thêm 10 trăm ngàn trang xung quanh trăm ngàn trang hiện tại
            $l=chianguyen($this->_recent_page,10000)-50000;
            if($l<1)
            {
                $l=0;
            }
            $r=$l+100000;
            if($r>$this->_total_page)
            {
                $r=$this->_total_page;
            }
            for($i=$l;$i<=$r;$i=$i+10000)
            {
                if($i==0)
                {
                    $temp=1;
                }   
                else
                {
                    $temp=$i;
                }
                if(!in_array($temp,$this->_ar_page))
                {
                    array_push($this->_ar_page,$temp);
                }
            }
            //Thêm 10 triệu trang xung quanh triệu trang hiện tại
            $l=chianguyen($this->_recent_page,100000)-500000;
            if($l<1)
            {
                $l=0;
            }
            $r=$l+1000000;
            if($r>$this->_total_page)
            {
                $r=$this->_total_page;
            }
            for($i=$l;$i<=$r;$i=$i+100000)
            {
                if($i==0)
                {
                    $temp=1;
                }   
                else
                {
                    $temp=$i;
                }
                if(!in_array($temp,$this->_ar_page))
                {
                    array_push($this->_ar_page,$temp);
                }
            }
            //Thêm 10 chục triệu trang xung quanh chục triệu trang hiện tại
            $l=chianguyen($this->_recent_page,1000000)-5000000;
            if($l<1)
            {
                $l=0;
            }
            $r=$l+10000000;
            if($r>$this->_total_page)
            {
                $r=$this->_total_page;
            }
            for($i=$l;$i<=$r;$i=$i+1000000)
            {
                if($i==0)
                {
                    $temp=1;
                }   
                else
                {
                    $temp=$i;
                }
                if(!in_array($temp,$this->_ar_page))
                {
                    array_push($this->_ar_page,$temp);
                }
            }
            //Thêm 10 chục triệu trang xung quanh chục triệu trang hiện tại
            $l=chianguyen($this->_recent_page,10000000)-50000000;
            if($l<1)
            {
                $l=0;
            }
            $r=$l+100000000;
            if($r>$this->_total_page)
            {
                $r=$this->_total_page;
            }
            for($i=$l;$i<=$r;$i=$i+10000000)
            {
                if($i==0)
                {
                    $temp=1;
                }   
                else
                {
                    $temp=$i;
                }
                if(!in_array($temp,$this->_ar_page))
                {
                    array_push($this->_ar_page,$temp);
                }
            }
            //them trang đầu và cuối
            if(!in_array(1,$this->_ar_page))
            {
                array_push($this->_ar_page,1);
            }
            if(!in_array($this->_total_page,$this->_ar_page))
            {
                array_push($this->_ar_page,$this->_total_page);
            }
            //sắp xếp lại theo thứ tự tăng dần
            sort($this->_ar_page, SORT_NUMERIC);
            //tính tổng số mục trong danh sách trang sẽ đưa ra hiển thị
            $this->_totalitem_in_ar_page=count($this->_ar_page);
            //tạo chuỗi liên kết
            if($this->_recent_page>1)
			{
				$this->_str_link.="<a class='".$option_link['class_name']."' href='".str_replace('[[pagenumber]]',$this->_recent_page-1,$option_link['strlink'])."'><i class='fa fa-chevron-left'></i></a>";
			}
            for($i=0;$i<$this->_totalitem_in_ar_page;$i++)
			{
				$add=($this->_ar_page[$i]==$this->_recent_page)?" selected":"";
                $this->_str_link.="<a class='".$option_link['class_name']."".$add."' href='".str_replace('[[pagenumber]]',$this->_ar_page[$i],$option_link['strlink'])."'>".$this->_ar_page[$i]."</a>";
            }
            if($this->_recent_page<$this->_total_page)
			{
				$this->_str_link.="<a class='".$option_link['class_name']."' href='".str_replace('[[pagenumber]]',$this->_recent_page+1,$option_link['strlink'])."'><i class='fa fa-chevron-right'></i></a>";
			}
            //xuất dữ liệu
            return $this->output();
        }
        private function output()
        {
            return array(
                'recent_page'=>$this->_recent_page,
                'item_per_page'=>$this->_item_per_page,
                'total_item'=>$this->_total_item,
                'total_page'=>$this->_total_page,
                'prev_page'=>$this->_prev_page,
                'next_page'=>$this->_next_page,
                'ar_page'=>$this->_ar_page,
                'totalitem_in_ar_page'=>$this->_totalitem_in_ar_page,
                'start'=>$this->_start,
                'limit'=>$this->_limit,
                'str_link'=>$this->_str_link
            );
        }
    }
    function page_seperator($total_item,$recent_page,$item_per_page,$option_link=Array('class_name'=>'page_seperator_item','strlink'=>'#[[pagenumber]]'))
    {
        $temp=new page_separater;
        return $temp->process($total_item,$recent_page,$item_per_page,Array('class_name'=>$option_link['class_name'],'strlink'=>$option_link['strlink']));
    }
    function chianguyen($a,$b)
    {
    	$t=$a/$b;
    	$t=$t."";
    	$t=explode(".",$t);
    	$t=$t[0]+0;
    	return $t;
    }
?>