<?php
	$p_id=(empty($_POST['id_type']))?"":$xldl->secure_input($_POST['id_type'],0);
	$word=(empty($_POST['word']))?"":mb_strtolower($xldl->secure_input(trichdan(bodau($_POST['word']),100,0),0),'utf8');
	$page=(empty($_POST['page']))?"":$xldl->secure_input($_POST['page'],0);
	if(!$page){$page=1;}
	//load mang chu de
	$ar_p=Array();//day la mang cac chu de
	$class_post_type->get_list_type($ar_p,$p_id);
	//load cau bai viet trong cac chu de do 
	$data=Array();
	$cd_max=count($ar_p);
	for($i=0;$i<$cd_max;$i++)//quet trong mang chu de
	{
		$sql="SELECT * FROM post_content WHERE m_id_type=".$ar_p[$i];
		$database->query($sql);
		if($database->num_rows()>0)
		{
			if(count($data)==0){$data=$database->fetchAll();}
			else
			{$data=array_merge($data,$database->fetchAll());}
		}
	}
	$m=count($data);
	if($m>0)
	{
		//quet trong mang de tinh phan tram match
		for($i=0;$i<$m;$i++)
		{
			$ar=Array("m_title");
			$data[$i]['phantrammatch']=0;
			for($j=0;$j<count($ar);$j++)
			{
				//$in2=mb_strtolower(bodau($data[$i][$ar[$j]]),'utf8');
				$in2=mb_strtolower($xldl->secure_input(trichdan(bodau(html_entity_decode($data[$i][$ar[$j]],ENT_QUOTES,'UTF-8')),100,0),0),'utf8');
				similar_text($word,$in2,$per1);
				$data[$i]['phantrammatch']=$per1;
			}
		}
		for($i=0;$i<$m-1;$i++)//sap xep lai theo match giam dan
		{
			for($j=$i;$j<$m;$j++)
			{
				if($data[$i]['phantrammatch']<$data[$j]['phantrammatch'])
				{
					$temp=$data[$i];
					$data[$i]=$data[$j];
					$data[$j]=$temp;
				}
			}
		}
		for($i=0;$i<$m;$i++)//chỉ lấy những kết quả match>50%
		{
			if($data[$i]['phantrammatch']<50){$m=$i;}
		}
		if($m<1)
		{
			$m=count($data);
			for($i=0;$i<$m;$i++)//chỉ lấy những kết quả match>30%
			{
				if($data[$i]['phantrammatch']<30){$m=$i;}
			}
			if($m<1)
			{
				$m=count($data);
				for($i=0;$i<$m;$i++)//chỉ lấy những kết quả match>10%
				{
					if($data[$i]['phantrammatch']<10){$m=$i;}
				}
			}
		}
		//thong so cho phan trang
		$num_page=chianguyen($m,MAX_PRODUCT_INPAGE)+1;
		$left=($page-1)*MAX_PRODUCT_INPAGE;
		$right=$left+MAX_PRODUCT_INPAGE;
		if($right>$m){$right=$m;}
		//end thong so cho phan trang
		echo "<div style='padding:3px 0px;font-size:16px;font-weight:normal;'><span class='button' style='float:right;font-size:16px;padding:3px 20px;border-radius:10px;cursor:pointer;' onclick='post.gobacklist()'><img src='img/system/back.png' style='height:16px;margin-right:10px;'>Quay lại</span><img src='img/system/search-glass.png' style='height:18px;margin-right:5px;'>Tìm kiếm với <b>".$word."</b></div><br>";
		echo "<div style='height:auto;'>";
		for($i=$left;$i<$right;$i++)
		{
			$temp="";
			$temp.="<div class='post_search_item' onclick='post.loadcontentdetail(".$data[$i]['id'].")'>";
				$temp.="<img src='".$class_post_content->get_avata($data[$i]['id'])."'>";
				$temp.="<div class='post_search_item_title'>".$data[$i]['m_title']."</div>";
				$temp.="<div class='post_search_item_date'><span class='tip add_timer'>".$data[$i]['m_date']."</span></div>";
			$temp.="</div>";
			echo $temp;
		}
		echo "</div>";
		//echo "<div class='clear_both'></div>";
		//phan trang
		$str="<div class='page_seperator_box'>";
		if($page>1)
		{
			$str.="<a class='page_seperator_item' href='javascript:post.sendsearch(".($page-1).")'> < </a>";
		}
		for($i=1;$i<=$num_page;$i++)
		{
			$add=($i==$page)?"selected='selected'":"";
			$str.="<a class='page_seperator_item' href='javascript:post.sendsearch(".($i).")' ".$add.">".$i."</a>";
		}
		if($page<$num_page)
		{
			$str.="<a class='page_seperator_item' href='javascript:post.sendsearch(".($page+1).")'> > </a>";
		}
		$str.="</div>";
		echo $str;
		//end phan trang
	}
	else
	{
		echo "không có bài viết nào trong danh mục này";
	}
?>