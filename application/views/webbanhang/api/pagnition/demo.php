<!DOCTYPE HTML>
<html lang="vi">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Page seperator demo</title>
<meta name="dc.language" content="VN"/>
<meta name="dc.source" content="songbut.com"/>
<meta name="dc.creator" content="songbut.com" />
<meta name="distribution" content="Global" />
<meta name="geo.placename" content="Vietnamese" />
<meta name="geo.region" content="Vietnamese" />
<meta name="title" content="Page seperator demo"/>
<meta name="description" content="Page seperator demo"/>
<meta name="keywords" content="Page seperator demo"/>
<meta name="news_keywords" content="Page seperator demo"/>
<meta name="author" content="songbut.com"/>
<meta name="robots" content="index, follow"/>
<meta name='revisit-after' content='1 days'/>
<meta name='viewport' content="width=device-width,initial-scale=1" />
<base href="" />
<link href='img/favico.png' rel="shortcut icon" type="image/png" />
<link rel="stylesheet" type="text/css" href="css/demo.css" />
</head>
<body>
	<h1>Page seperator demo</h1>
	<?php
		include_once("class/seperator.php");
		$total_item=1000000000; //1 t? item can phan trang
		$item_per_page=20; //20 item tren 1 trang
		if(isset($_GET['page']))
        {
            $recent_page=(int)$_GET['page'];//trang hi?n t?i du?c l?y t? bi?n $_GET('page')
        }
        else
        {
            $recent_page=1; //d?t trang hi?n t?i là 1 n?u get page chua có
        }
        
		
		//thuc hien phan trang
		$phantrang = page_seperator(
			$total_item, 
			$recent_page, 
			$item_per_page, 
			Array(
				'class_name'=>'page_seperator_item',
				'strlink'=>'?page=[[pagenumber]]'
			)
		);
		//hien thi du lieu
		for($i=0; $i<$phantrang['limit']; $i++)
		{
			echo "<div class='item'>Item ".($phantrang['start']+$i+1)."</div>";
		}
		echo "<div class='page_seperator_box'>".$phantrang['str_link']."</div>";
	?>
</body>
</html>