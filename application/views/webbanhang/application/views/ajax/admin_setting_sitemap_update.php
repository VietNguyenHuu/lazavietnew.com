<?php
    if($this->UserModel->get($idname,'m_level')<4)
    {
        echo "<div class='stt_mistake'></div>";
    }
    else
    {
        set_time_limit(300);
        ini_set('memory_limit',"500M");
        //main sitemap
        $partern=<<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">[[ar_item]]
</sitemapindex>
EOD;
        $partern_item=<<<EOD
\n<sitemap>
<loc>[[link]]</loc>
<lastmod>[[lastmod]]</lastmod>
</sitemap>
EOD;
        $str_lastmod=TimeHelper();
        $str_lastmod=$str_lastmod->_nam."-".$str_lastmod->_thang."-".$str_lastmod->_ngay."T".$str_lastmod->_gio.":".$str_lastmod->_phut.":".$str_lastmod->_giay."+07:00";
        $str="";
        $ar_post_type=$this->db->query("SELECT post_type.id as id, post_content.id as id2 FROM post_type,post_content WHERE post_type.id=post_content.m_id_type  AND post_content.m_id_user_check != -1 GROUP BY post_content.m_id_type ORDER BY post_type.id ASC")->result();
        if(count($ar_post_type)<1)
        {
            $ar_post_type=false;
        }
        //chủ đề bài viết, gom hết vào một file
        $str.=str_replace(Array('[[link]]','[[lastmod]]'),Array(site_url("sitemap/post_type.xml"),$str_lastmod),$partern_item);
        //bài viết theo các chủ đề, mỗi chủ đề là một file xml
        if($ar_post_type!=false)
        {
            foreach($ar_post_type as $ar_post_type_line)
            {
                $str.=str_replace(Array('[[link]]','[[lastmod]]'),Array(site_url("sitemap/post_content_".$ar_post_type_line->id.".xml"),$str_lastmod),$partern_item);
            }
        }
        //tag bài viết, gom hết vào một file
        $str.=str_replace(Array('[[link]]','[[lastmod]]'),Array(site_url("sitemap/post_tag.xml"),$str_lastmod),$partern_item);
        //tác giả bài viết, gom hết vào một file
        $str.=str_replace(Array('[[link]]','[[lastmod]]'),Array(site_url("sitemap/post_author.xml"),$str_lastmod),$partern_item);
        //quảng cáo, gom hết vào một file
        $str.=str_replace(Array('[[link]]','[[lastmod]]'),Array(site_url("sitemap/advertiment.xml"),$str_lastmod),$partern_item);
        
        
        file_put_contents("sitemap.xml",str_replace("[[ar_item]]",$str,$partern));
        $str="";
        //end mainsitemap
        
        
        //chủ đề bài viết
        $partern=<<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">[[ar_item]]
</urlset>
EOD;
            $partern_item=<<<EOD
\n<url>
<loc>[[linkbase]][[link]]</loc>
<lastmod>[[lastmod]]</lastmod>
<changefreq>daily</changefreq>
<priority>0.5</priority>
</url>
EOD;
        $partern_item=str_replace("[[linkbase]]", base_url(), $partern_item);
        $str="";
        if($ar_post_type!=false)
        {
            foreach($ar_post_type as $ar_post_type_line)
            {
                $str.=str_replace(Array('[[link]]','[[lastmod]]'),Array($this->PostTypeModel->get_link_from_id($ar_post_type_line->id),$str_lastmod),$partern_item);
            }
        }
        file_put_contents("sitemap/post_type.xml",str_replace("[[ar_item]]",$str,$partern));
        $str="";
        //end chủ đề bài viết
        //bài viết
        $partern=<<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" >[[ar_item]]
</urlset>
EOD;
        $partern_item=<<<EOD
\n<url>
<loc>[[linkbase]][[link]]</loc>
<image:image>
<image:loc>[[linkbase]][[image_link]]</image:loc>
<image:caption>[[image_caption]]</image:caption>
</image:image>
<lastmod>[[lastmod]]</lastmod>
<changefreq>daily</changefreq>
<priority>0.4</priority>
</url>
EOD;
        $partern_item=str_replace("[[linkbase]]", base_url(), $partern_item);
        if($ar_post_type!=false)
        {
            foreach($ar_post_type as $ar_post_type_line)
            {
                $str="";
                $ar_post_intype=$this->db->query("SELECT id,m_title FROM ".$this->PostContentModel->get_table_name()." WHERE (m_id_user_check != -1 AND m_id_type=".$ar_post_type_line->id.") ORDER BY m_militime DESC")->result();
                if(count($ar_post_intype)>0)
                {
                    foreach($ar_post_intype as $ar_post_intype_line)
                    {
                        $str.=str_replace(Array('[[link]]','[[lastmod]]','[[image_link]]','[[image_caption]]'),Array($this->PostContentModel->get_link_from_id($ar_post_intype_line->id),$str_lastmod,$this->PostContentModel->get_avata_original($ar_post_intype_line->id),str_to_view($ar_post_intype_line->m_title,false)),$partern_item);
                    }
                }
                $ar_post_intype="";
                file_put_contents("sitemap/post_content_".$ar_post_type_line->id.".xml",str_replace("[[ar_item]]",$str,$partern));
            }
        }
        //end bài viết
        //tag bài viết
        $partern=<<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">[[ar_item]]
</urlset>
EOD;
        $partern_item=<<<EOD
\n<url>
<loc>[[linkbase]][[link]]</loc>
<lastmod>[[lastmod]]</lastmod>
<changefreq>daily</changefreq>
<priority>0.4</priority>
</url>
EOD;
        $partern_item=str_replace("[[linkbase]]", base_url(), $partern_item);
        $str="";
        $ar_tag=$this->db->query("SELECT id,count(m_title) AS sl FROM ".$this->PostTagsModel->get_table_name()." GROUP BY m_title ORDER BY sl DESC")->result();
        if(count($ar_tag)>0)
        {
            foreach($ar_tag as $ar_tag_line)
            {
                $str.=str_replace(Array('[[link]]','[[lastmod]]'),Array($this->PostTagsModel->get_link_from_id($ar_tag_line->id),$str_lastmod),$partern_item);
            }
        }
        file_put_contents("sitemap/post_tag.xml",str_replace("[[ar_item]]",$str,$partern));
        $str="";
        $ar_tag="";
        //end tag bài viết
        //tác giả bài viết
        $partern=<<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">[[ar_item]]
</urlset>
EOD;
        $partern_item=<<<EOD
\n<url>
<loc>[[linkbase]][[link]]</loc>
<lastmod>[[lastmod]]</lastmod>
<changefreq>daily</changefreq>
<priority>0.4</priority>
</url>
EOD;
        $partern_item=str_replace("[[linkbase]]", base_url(), $partern_item);
        $str="";
        $ar_tag=$this->db->query("SELECT m_id_user,count(m_id_user) AS sl FROM ".$this->PostContentModel->get_table_name()." WHERE (m_id_user_check != -1) GROUP BY m_id_user ORDER BY sl DESC")->result();
        if(count($ar_tag)>0)
        {
            foreach($ar_tag as $ar_tag_line)
            {
                $str.=str_replace(Array('[[link]]','[[lastmod]]'),Array($this->PostAuthorModel->get_link_from_id($ar_tag_line->m_id_user),$str_lastmod),$partern_item);
            }
        }
        file_put_contents("sitemap/post_author.xml",str_replace("[[ar_item]]",$str,$partern));
        $str="";
        $ar_tag="";
        //end tác giả bài viết
        //quảng cáo
        $partern=<<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">[[ar_item]]
</urlset>
EOD;
        $partern_item=<<<EOD
\n<url>
<loc>[[linkbase]][[link]]</loc>
<lastmod>[[lastmod]]</lastmod>
<changefreq>daily</changefreq>
<priority>0.4</priority>
</url>
EOD;
        $partern_item=str_replace("[[linkbase]]", base_url(), $partern_item);
        $str="";
        $ar_tag=$this->db->query("SELECT m_link FROM ".$this->AdvertimentModel->get_table_name()." WHERE (m_status='on') ORDER BY id DESC")->result();
        if(count($ar_tag)>0)
        {
            foreach($ar_tag as $ar_tag_line)
            {
                $str.=str_replace(Array('[[link]]','[[lastmod]]'),Array($ar_tag_line->m_link,$str_lastmod),$partern_item);
            }
        }
        file_put_contents("sitemap/advertiment.xml",str_replace("[[ar_item]]",$str,$partern));
        $str="";
        $ar_tag="";
        //end quảng cáo
        echo "<span class='stt_avaiable fontsize_d2'>Đã cập nhật sitemap</span>";
    }
?>